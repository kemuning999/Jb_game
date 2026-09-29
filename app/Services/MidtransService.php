<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = (bool) config('midtrans.is_production', false);
        Config::$isSanitized = (bool) config('midtrans.is_sanitized', true);
        Config::$is3ds = (bool) config('midtrans.is_3ds', true);
    }

    /**
     * Generate Snap Token for order
     */
    public function createSnapToken(Order $order): string
    {
        // If Snap token already exists and order is still pending, reuse it
        if (!empty($order->snap_token)) {
            return $order->snap_token;
        }

        $serverKey = config('midtrans.server_key');

        // Fallback placeholder token for local testing if Server Key is not set yet
        if (empty($serverKey)) {
            $dummyToken = 'mock_snap_token_' . md5($order->order_number . time());
            $order->update(['snap_token' => $dummyToken]);
            return $dummyToken;
        }

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => $order->buyer_name,
                'email' => $order->buyer_email,
                'phone' => $order->buyer_phone,
            ],
            'item_details' => [
                [
                    'id' => (string) $order->product_id,
                    'price' => (int) $order->total_amount,
                    'quantity' => 1,
                    'name' => mb_strimwidth($order->product->title, 0, 45, '...'),
                ]
            ],
            'enabled_payments' => [
                'qris', 'gopay', 'shopeepay', 'bca_va', 'bni_va', 'bri_va', 'mandiri_clickpay', 'indomaret', 'alfamart'
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $order->update(['snap_token' => $snapToken]);
            return $snapToken;
        } catch (Exception $e) {
            Log::error('Midtrans Snap Error: ' . $e->getMessage(), ['order' => $order->order_number]);
            throw $e;
        }
    }

    /**
     * Handle webhook notification from Midtrans
     */
    public function handleNotification(array $payload): array
    {
        $serverKey = config('midtrans.server_key');
        $orderNumber = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $paymentType = $payload['payment_type'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;
        $transactionId = $payload['transaction_id'] ?? null;
        $transactionTime = $payload['transaction_time'] ?? null;

        if (!$orderNumber) {
            return ['status' => 'error', 'message' => 'Order ID is missing'];
        }

        // Verify signature if server key is configured
        if (!empty($serverKey) && $signatureKey) {
            $expectedSignature = hash('sha512', $orderNumber . $statusCode . $grossAmount . $serverKey);
            if ($signatureKey !== $expectedSignature) {
                Log::warning('Midtrans Invalid Signature', ['order_id' => $orderNumber]);
                return ['status' => 'error', 'message' => 'Invalid signature'];
            }
        }

        $order = Order::with('product')->where('order_number', $orderNumber)->first();

        if (!$order) {
            return ['status' => 'error', 'message' => 'Order not found'];
        }

        DB::transaction(function () use ($order, $payload, $transactionStatus, $paymentType, $fraudStatus, $transactionId, $grossAmount, $transactionTime) {
            $paymentStatus = $order->payment_status;
            $orderStatus = $order->order_status;
            $paidAt = $order->paid_at;

            if ($transactionStatus === 'capture') {
                if ($fraudStatus === 'accept') {
                    $paymentStatus = 'paid';
                    $orderStatus = 'completed';
                    $paidAt = now();
                }
            } elseif ($transactionStatus === 'settlement') {
                $paymentStatus = 'paid';
                $orderStatus = 'completed';
                $paidAt = now();
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $paymentStatus = ($transactionStatus === 'expire') ? 'expired' : 'failed';
                $orderStatus = 'cancelled';
            } elseif ($transactionStatus === 'pending') {
                $paymentStatus = 'pending';
                $orderStatus = 'pending';
            }

            // Update order
            $order->update([
                'payment_status' => $paymentStatus,
                'order_status' => $orderStatus,
                'payment_type' => $paymentType,
                'paid_at' => $paidAt,
            ]);

            // If paid, mark product as sold out
            if ($paymentStatus === 'paid' && $order->product) {
                $order->product->update(['status' => 'sold']);
            }

            // If order cancelled/expired and product was reserved/sold, reset product status if necessary
            if (in_array($paymentStatus, ['failed', 'expired']) && $order->product && $order->product->status === 'sold') {
                // If no other paid order exists for this product, restore available
                $hasPaidOrder = Order::where('product_id', $order->product_id)
                    ->where('id', '!=', $order->id)
                    ->where('payment_status', 'paid')
                    ->exists();

                if (!$hasPaidOrder) {
                    $order->product->update(['status' => 'available']);
                }
            }

            // Record payment log
            Payment::create([
                'order_id' => $order->id,
                'transaction_id' => $transactionId,
                'payment_type' => $paymentType,
                'gross_amount' => $grossAmount ?? $order->total_amount,
                'transaction_status' => $transactionStatus ?? 'unknown',
                'fraud_status' => $fraudStatus,
                'transaction_time' => $transactionTime ? date('Y-m-d H:i:s', strtotime($transactionTime)) : now(),
                'raw_payload' => $payload,
            ]);
        });

        return ['status' => 'success', 'message' => 'Notification handled successfully'];
    }
}
