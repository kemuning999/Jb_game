<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\BuatQrisService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuatQrisController extends Controller
{
    protected BuatQrisService $buatQrisService;

    public function __construct(BuatQrisService $buatQrisService)
    {
        $this->buatQrisService = $buatQrisService;
    }

    /**
     * Webhook endpoint called by BuatQris server
     */
    public function handleWebhook(Request $request): JsonResponse
    {
        $signature = $request->header('X-BuatQris-Signature') ?: $request->header('x-buatqris-signature');
        $payload = $request->all();

        $result = $this->buatQrisService->handleWebhook($payload, $signature);

        return response()->json($result);
    }

    /**
     * Polling endpoint to check if order is paid
     */
    public function checkStatus($order_number): JsonResponse
    {
        $user = Auth::user();

        $order = Order::where('order_number', $order_number)->firstOrFail();

        if ($user && $order->user_id !== $user->id && $user->role !== 'admin') {
            abort(403);
        }

        $result = $this->buatQrisService->checkStatus($order);

        return response()->json([
            'order_number' => $order->order_number,
            'payment_status' => $order->payment_status,
            'is_paid' => $order->isPaid(),
            'status' => $result['status'] ?? $order->payment_status,
        ]);
    }

    /**
     * Test simulation: quickly mark order as paid in local development
     */
    public function simulatePay($order_number): RedirectResponse
    {
        $user = Auth::user();
        $order = Order::where('order_number', $order_number)->firstOrFail();

        if ($user && $order->user_id !== $user->id && $user->role !== 'admin') {
            abort(403);
        }

        $this->buatQrisService->simulateTestPayment($order);

        return redirect()->route('orders.show', $order->order_number)->with('success', 'Simulasi pembayaran QRIS berhasil! Kredensial akun game Anda kini telah terbuka.');
    }
}
