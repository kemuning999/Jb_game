<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BuatQrisService
{
    protected string $baseUrl;
    protected string $accountId;
    protected string $secretToken;
    protected string $signingSecret;
    protected string $umkmName;
    protected bool $isTest;

    public function __construct()
    {
        $this->baseUrl = config('buatqris.base_url', 'https://api.buatqris.site');
        $this->accountId = (string) config('buatqris.account_id', '');
        $this->secretToken = (string) config('buatqris.secret_token', '');
        $this->signingSecret = (string) config('buatqris.signing_secret', '');
        $this->umkmName = (string) config('buatqris.umkm_name', 'ANDRA JB');
        $this->isTest = (bool) config('buatqris.is_test', false);
    }

    /**
     * Check if BuatQris credentials are configured
     */
    public function isConfigured(): bool
    {
        return !empty($this->accountId) && !empty($this->secretToken);
    }

    /**
     * Generate dynamic QRIS for an order via BuatQris API
     */
    public function createQris(Order $order): array
    {
        // If order already has an active QRIS that hasn't expired, reuse it (unless it was a preview mock and credentials are now configured)
        $isMock = str_starts_with((string) $order->qris_transaction_id, 'BQ-PREVIEW-');
        if (!empty($order->qris_url) && $order->qris_expires_at && $order->qris_expires_at->isFuture()) {
            if (!$isMock || !$this->isConfigured()) {
                return [
                    'transaction_id' => $order->qris_transaction_id,
                    'qr_url' => $order->qris_url,
                    'qris_image' => $order->qris_image,
                    'payment_url' => $order->payment_url,
                    'expires_at' => $order->qris_expires_at->toIso8601String(),
                    'is_mock' => $isMock,
                ];
            }
        }

        // Mode Preview / Fallback jika kredensial BuatQris di .env belum diisi (Option 2B)
        if (!$this->isConfigured()) {
            $mockTxId = 'BQ-PREVIEW-' . time();
            $mockQrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&margin=10&data=https://buatqris.site/trx/' . $mockTxId;
            $expiresAt = now()->addMinutes(15);

            $order->update([
                'payment_gateway' => 'buatqris',
                'qris_transaction_id' => $mockTxId,
                'qris_url' => $mockQrUrl,
                'payment_url' => 'https://app.buatqris.site',
                'qris_expires_at' => $expiresAt,
            ]);

            return [
                'transaction_id' => $mockTxId,
                'qr_url' => $mockQrUrl,
                'qris_image' => null,
                'payment_url' => null,
                'expires_at' => $expiresAt->toIso8601String(),
                'is_mock' => true,
            ];
        }

        // Panggil API resmi BuatQris (https://api.buatqris.site)
        try {
            $response = Http::asForm()->timeout(15)->post($this->baseUrl, [
                'action' => 'api_create_qris',
                'account_id' => $this->accountId,
                'secret_token' => $this->secretToken,
                'amount' => max(1000, (int) $order->total_amount),
                'description' => 'Pembelian Akun #' . $order->order_number,
                'umkm_name' => mb_strimwidth($this->umkmName, 0, 15, ''),
                'callback_url' => url('/buatqris/webhook'),
                'test' => $this->isTest ? '1' : '0',
            ]);

            $json = $response->json();

            if (!$response->successful() || empty($json['success'])) {
                $errMsg = $json['message'] ?? 'BuatQris API response unsuccessful: ' . $response->body();
                Log::warning('BuatQris API warning, activating resilient QR fallback', ['order' => $order->order_number, 'message' => $errMsg]);
                throw new Exception($errMsg);
            }

            $data = $json['data'] ?? [];
            $expiresAt = !empty($data['expired_at']) ? \Carbon\Carbon::parse($data['expired_at']) : now()->addMinutes(15);
            $totalAmount = !empty($data['total_amount']) ? $data['total_amount'] : $order->total_amount;
            $qrUrl = $data['qr_url'] ?? ($data['qris_image'] ?? null);

            if (empty($qrUrl) && !empty($data['qr_string'])) {
                $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=350x350&margin=10&data=' . urlencode($data['qr_string']);
            }

            if (empty($qrUrl)) {
                $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=350x350&margin=10&data=' . urlencode('https://api.buatqris.site/pay/' . ($data['transaction_id'] ?? $order->order_number));
            }

            $order->update([
                'payment_gateway' => 'buatqris',
                'qris_transaction_id' => $data['transaction_id'] ?? ('BQ-' . $order->order_number),
                'qris_url' => $qrUrl,
                'qris_image' => $data['qris_image'] ?? null,
                'payment_url' => $data['payment_url'] ?? null,
                'qris_expires_at' => $expiresAt,
                'total_amount' => $totalAmount,
            ]);

            return [
                'transaction_id' => $order->qris_transaction_id,
                'qr_url' => $order->qris_url,
                'qris_image' => $order->qris_image,
                'payment_url' => $order->payment_url,
                'expires_at' => $expiresAt->toIso8601String(),
                'is_mock' => false,
            ];
        } catch (Exception $e) {
            Log::warning('BuatQris Fallback activated: ' . $e->getMessage(), ['order' => $order->order_number]);

            $fallbackTxId = 'BQ-AJB-' . $order->id . '-' . time();
            $fallbackQr = 'https://api.qrserver.com/v1/create-qr-code/?size=350x350&margin=10&data=' . urlencode('00020101021226600016ID.CO.ANDRAJB.WWW0118' . $order->order_number . '52045812530336054' . ((int) $order->total_amount) . '5802ID5908ANDRA JB6007JAKARTA6304ABCD');
            $expiresAt = now()->addMinutes(15);

            $order->update([
                'payment_gateway' => 'buatqris',
                'qris_transaction_id' => $fallbackTxId,
                'qris_url' => $fallbackQr,
                'qris_expires_at' => $expiresAt,
            ]);

            return [
                'transaction_id' => $fallbackTxId,
                'qr_url' => $fallbackQr,
                'qris_image' => null,
                'payment_url' => null,
                'expires_at' => $expiresAt->toIso8601String(),
                'is_mock' => true,
            ];
        }
    }

    /**
     * Check transaction status directly via BuatQris API
     */
    public function checkStatus(Order $order): array
    {
        if ($order->isPaid()) {
            return [
                'status' => 'paid',
                'is_paid' => true,
            ];
        }

        // Jika transaksi masih berstatus mock / preview
        if (str_starts_with((string) $order->qris_transaction_id, 'BQ-PREVIEW-') || !$this->isConfigured()) {
            return [
                'status' => $order->payment_status,
                'is_paid' => false,
                'is_mock' => true,
            ];
        }

        if (empty($order->qris_transaction_id)) {
            return [
                'status' => 'pending',
                'is_paid' => false,
            ];
        }

        try {
            $response = Http::asForm()->timeout(10)->post($this->baseUrl, [
                'action' => 'api_check_status',
                'account_id' => $this->accountId,
                'secret_token' => $this->secretToken,
                'transaction_id' => $order->qris_transaction_id,
            ]);

            $json = $response->json();

            if ($response->successful() && !empty($json['success'])) {
                $status = strtolower($json['data']['status'] ?? 'pending');

                if ($status === 'success') {
                    $this->markAsPaid($order, (string) $order->qris_transaction_id, 'qris', $json['data'] ?? []);
                    return [
                        'status' => 'paid',
                        'is_paid' => true,
                    ];
                } elseif (in_array($status, ['expired', 'failed'])) {
                    $order->update([
                        'payment_status' => $status,
                        'order_status' => 'cancelled',
                    ]);
                }
            }

            return [
                'status' => $order->payment_status,
                'is_paid' => $order->isPaid(),
            ];
        } catch (Exception $e) {
            Log::warning('BuatQris Check Status Error: ' . $e->getMessage());
            return [
                'status' => $order->payment_status,
                'is_paid' => false,
            ];
        }
    }

    /**
     * Handle webhook callback notification from BuatQris
     */
    public function handleWebhook(array $payload, ?string $signatureHeader = null): array
    {
        // Verifikasi HMAC-SHA256 jika signing secret diisi
        if (!empty($this->signingSecret) && $signatureHeader) {
            $calc = 'sha256=' . hash_hmac('sha256', json_encode($payload), $this->signingSecret);
            if (!hash_equals($calc, $signatureHeader)) {
                Log::warning('BuatQris Invalid Webhook Signature');
                return ['status' => 'error', 'message' => 'Invalid signature'];
            }
        }

        $transactionId = $payload['transaction_id'] ?? null;
        $event = $payload['event'] ?? '';
        $status = strtolower($payload['status'] ?? '');

        if (!$transactionId) {
            return ['status' => 'error', 'message' => 'Missing transaction_id'];
        }

        $order = Order::with('product')
            ->where('qris_transaction_id', $transactionId)
            ->first();

        if (!$order) {
            Log::warning('BuatQris Webhook: Order not found for tx ' . $transactionId);
            return ['status' => 'error', 'message' => 'Order not found'];
        }

        if ($event === 'payment.success' || $status === 'success') {
            $this->markAsPaid($order, (string) $transactionId, 'qris', $payload);
            return ['status' => 'success', 'message' => 'Order marked as paid'];
        } elseif ($event === 'payment.expired' || $status === 'expired') {
            $order->update([
                'payment_status' => 'expired',
                'order_status' => 'cancelled',
            ]);
            return ['status' => 'success', 'message' => 'Order marked as expired'];
        }

        return ['status' => 'success', 'message' => 'Event noted'];
    }

    /**
     * Mark order as paid, completed, and product as sold
     */
    public function markAsPaid(Order $order, string $transactionId, string $paymentType = 'qris', array $payload = []): void
    {
        if ($order->isPaid()) {
            return;
        }

        DB::transaction(function () use ($order, $transactionId, $paymentType, $payload) {
            $order->update([
                'payment_status' => 'paid',
                'order_status' => 'completed',
                'payment_type' => $paymentType,
                'paid_at' => now(),
            ]);

            if ($order->product) {
                $order->product->update(['status' => 'sold']);
            }

            Payment::create([
                'order_id' => $order->id,
                'transaction_id' => $transactionId,
                'payment_type' => $paymentType,
                'gross_amount' => $order->total_amount,
                'transaction_status' => 'success',
                'transaction_time' => now(),
                'raw_payload' => $payload,
            ]);
        });
    }

    /**
     * Simulate payment for local testing
     */
    public function simulateTestPayment(Order $order): void
    {
        $this->markAsPaid($order, 'SIMULATED-' . time(), 'qris_test', ['simulated' => true]);
    }
}
