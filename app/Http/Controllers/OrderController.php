<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected MidtransService $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
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

        // If order is still pending and has no snap token, generate one
        if ($order->payment_status === 'pending' && empty($order->snap_token)) {
            try {
                $this->midtransService->createSnapToken($order);
                $order->refresh();
            } catch (Exception $e) {
                // Keep token null, display error in view
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

        if ($order->user_id !== $user->id && $user->role !== 'admin') {
            abort(403);
        }

        return response()->json([
            'payment_status' => $order->payment_status,
            'order_status' => $order->order_status,
            'is_paid' => $order->isPaid(),
        ]);
    }
}
