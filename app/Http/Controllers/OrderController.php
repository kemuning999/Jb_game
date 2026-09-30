<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\BuatQrisService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected BuatQrisService $buatQrisService;

    public function __construct(BuatQrisService $buatQrisService)
    {
        $this->buatQrisService = $buatQrisService;
    }

    /**
     * List user orders
     */
    public function index()
    {
        $user = Auth::user();

        $orders = Order::with('product.category')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show order details with secure credential reveal on payment completed
     */
    public function show($order_number)
    {
        $user = Auth::user();

        $order = Order::with(['product.category', 'payments'])
            ->where('order_number', $order_number)
            ->firstOrFail();

        // Security check: Only the buyer or an admin can view this order
        if ($order->user_id !== $user->id && $user->role !== 'admin') {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat pesanan ini.');
        }

        // Initialize QRIS via BuatQris if order is pending
        if ($order->payment_status === 'pending') {
            try {
                $this->buatQrisService->createQris($order);
                $order->refresh();
            } catch (Exception $e) {
                // Handled gracefully, order view will display instructions
            }
        }

        // Retrieve credentials safely ONLY if payment is paid
        $accountDetails = null;
        if ($order->isPaid() && $order->product) {
            // Explicitly retrieve sensitive fields from product
            $accountDetails = [
                'username' => $order->product->account_username,
                'password' => $order->product->account_password,
                'additional_info' => $order->product->account_additional_info,
            ];
        }

        return view('orders.show', compact('order', 'accountDetails'));
    }

    /**
     * Endpoint for client-side Snap callback (e.g. after user completes payment in Midtrans popup)
     */
    public function checkStatus($order_number)
    {
        $user = Auth::user();

        $order = Order::where('order_number', $order_number)->firstOrFail();

        if ($user && $order->user_id !== $user->id && $user->role !== 'admin') {
            abort(403);
        }

        // Auto-check live status with BuatQris if pending
        if ($order->payment_status === 'pending') {
            $this->buatQrisService->checkStatus($order);
            $order->refresh();
        }

        return response()->json([
            'payment_status' => $order->payment_status,
            'order_status' => $order->order_status,
            'is_paid' => $order->isPaid(),
        ]);
    }

    /**
     * Cancel an unpaid pending order
     */
    public function cancel(Request $request, $order_number)
    {
        $user = Auth::user();

        $order = Order::with('product')->where('order_number', $order_number)->firstOrFail();

        // Security check: Only the buyer or an admin can cancel this order
        if ($order->user_id !== $user->id && $user->role !== 'admin') {
            abort(403, 'Anda tidak memiliki hak akses untuk membatalkan pesanan ini.');
        }

        // Do not allow cancellation if order is already paid
        if ($order->isPaid()) {
            return redirect()->route('orders.show', $order->order_number)
                ->with('error', 'Pesanan yang sudah lunas tidak dapat dibatalkan.');
        }

        // Update status to cancelled
        $order->update([
            'order_status' => 'cancelled',
            'payment_status' => 'failed',
        ]);

        // Ensure product remains available for other buyers
        if ($order->product && $order->product->status !== 'sold') {
            $order->product->update(['status' => 'available']);
        }

        return redirect()->route('orders.show', $order->order_number)
            ->with('info', 'Pesanan #' . $order->order_number . ' telah berhasil dibatalkan.');
    }
}
