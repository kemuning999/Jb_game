<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\BuatQrisService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected BuatQrisService $buatQrisService;

    public function __construct(BuatQrisService $buatQrisService)
    {
        $this->buatQrisService = $buatQrisService;
    }

    public function show($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();

        if ($product->status === 'sold') {
            return redirect()->route('products.show', $product->slug)
                ->with('error', 'Mohon maaf, akun ini sudah terjual dan tidak dapat dibeli lagi.');
        }

        $user = Auth::user();

        return view('checkout.show', compact('product', 'user'));
    }

    public function process(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        if ($product->status === 'sold') {
            return redirect()->route('products.show', $product->slug)
                ->with('error', 'Mohon maaf, akun game ini sudah terjual.');
        }

        $validated = $request->validate([
            'buyer_name' => ['required', 'string', 'max:255'],
            'buyer_email' => ['required', 'email', 'max:255'],
            'buyer_phone' => ['required', 'string', 'min:9', 'max:20'],
            'notes' => ['nullable', 'string', 'max:500'],
        ], [
            'buyer_name.required' => 'Nama lengkap wajib diisi.',
            'buyer_email.required' => 'Email aktif wajib diisi.',
            'buyer_email.email' => 'Format email tidak valid.',
            'buyer_phone.required' => 'Nomor WhatsApp wajib diisi.',
            'buyer_phone.min' => 'Nomor WhatsApp minimal 9 digit.',
        ]);

        $user = Auth::user();

        // Update phone in user profile if not set yet
        if (empty($user->phone)) {
            $user->update(['phone' => $validated['buyer_phone']]);
        }

        // Check if there is an existing pending order by this user for this product
        $existingOrder = Order::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->where('payment_status', 'pending')
            ->latest()
            ->first();

        if ($existingOrder && !empty($existingOrder->qris_url)) {
            return redirect()->route('orders.show', $existingOrder->order_number);
        }

        // Generate unique order number (e.g. AJB-20260929-A1B2C)
        $orderNumber = 'AJB-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        $order = DB::transaction(function () use ($user, $product, $validated, $orderNumber) {
            return Order::create([
                'order_number' => $orderNumber,
                'user_id' => $user->id,
                'product_id' => $product->id,
                'buyer_name' => $validated['buyer_name'],
                'buyer_email' => $validated['buyer_email'],
                'buyer_phone' => $validated['buyer_phone'],
                'total_amount' => $product->price,
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'notes' => $validated['notes'] ?? null,
            ]);
        });

        // Initialize dynamic QRIS via BuatQris
        try {
            $this->buatQrisService->createQris($order);
        } catch (Exception $e) {
            // Handled gracefully, order view will display QR or instructions
        }

        return redirect()->route('orders.show', $order->order_number)
            ->with('success', 'Pesanan berhasil dibuat! Silakan scan kode QRIS untuk menyelesaikan pembayaran.');
    }
}
