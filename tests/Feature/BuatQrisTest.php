<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BuatQrisTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Category $category;
    protected Product $product;
    protected Order $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'role' => 'customer',
            'name' => 'Buyer Tester',
            'email' => 'buyer@example.com',
            'phone' => '081234567890',
        ]);

        $this->category = Category::create([
            'name' => 'Mobile Legends',
            'slug' => 'mobile-legends',
            'icon' => 'gamepad',
            'is_active' => true,
        ]);

        $this->product = Product::create([
            'category_id' => $this->category->id,
            'title' => 'Akun Sultan MLBB Mythic 100 Stars',
            'slug' => 'akun-sultan-mlbb-mythic-100-stars',
            'price' => 250000,
            'status' => 'available',
            'description' => 'Akun sultan full skin collector & legend.',
            'account_details' => 'Level 80, Winrate 68%, Hero 120, Skin 350.',
            'account_username' => 'mlbb_secret_user',
            'account_password' => 'mlbb_secret_pass',
            'login_method' => 'Moonton',
        ]);

        $this->order = Order::create([
            'order_number' => 'JB-TEST-BQ-' . time(),
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'buyer_name' => $this->user->name,
            'buyer_email' => $this->user->email,
            'buyer_phone' => $this->user->phone,
            'total_amount' => $this->product->price,
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'payment_gateway' => 'buatqris',
        ]);
    }

    public function test_order_show_generates_preview_qris_when_unconfigured(): void
    {
        config(['buatqris.account_id' => '']);
        config(['buatqris.secret_token' => '']);

        $response = $this->actingAs($this->user)->get('/orders/' . $this->order->order_number);

        $response->assertStatus(200);
        $response->assertSee('Scan QRIS untuk Bayar');
        $response->assertSee($this->order->formatted_total);

        $this->order->refresh();
        $this->assertNotEmpty($this->order->qris_url);
        $this->assertStringStartsWith('BQ-PREVIEW-', (string) $this->order->qris_transaction_id);
    }

    public function test_order_show_calls_buatqris_api_when_credentials_present(): void
    {
        config(['buatqris.account_id' => 'ACC-12345']);
        config(['buatqris.secret_token' => 'SEC-TOKEN-67890']);

        Http::fake([
            'https://api.buatqris.site*' => Http::response([
                'success' => true,
                'data' => [
                    'transaction_id' => '100887766',
                    'qr_url' => 'https://app.buatqris.site/poto/qris/100887766.png',
                    'payment_url' => 'https://app.buatqris.site/trx/100887766',
                    'amount' => 250000,
                    'status' => 'pending',
                ]
            ], 200),
        ]);

        $response = $this->actingAs($this->user)->get('/orders/' . $this->order->order_number);

        $response->assertStatus(200);
        $this->order->refresh();

        $this->assertEquals('100887766', $this->order->qris_transaction_id);
        $this->assertEquals('https://app.buatqris.site/poto/qris/100887766.png', $this->order->qris_url);
    }

    public function test_buatqris_webhook_marks_order_as_paid_and_product_as_sold(): void
    {
        $this->order->update([
            'qris_transaction_id' => 'BQ-TX-998877',
        ]);

        $payload = [
            'event' => 'payment.success',
            'transaction_id' => 'BQ-TX-998877',
            'status' => 'success',
            'amount' => 250000,
            'is_test' => false,
        ];

        $response = $this->postJson('/buatqris/webhook', $payload);

        $response->assertStatus(200);
        $this->order->refresh();
        $this->product->refresh();

        $this->assertEquals('paid', $this->order->payment_status);
        $this->assertEquals('completed', $this->order->order_status);
        $this->assertEquals('sold', $this->product->status);
    }

    public function test_simulate_pay_marks_order_as_paid_and_reveals_credentials(): void
    {
        $response = $this->actingAs($this->user)->post('/orders/' . $this->order->order_number . '/simulate-pay');

        $response->assertRedirect('/orders/' . $this->order->order_number);

        $this->order->refresh();
        $this->assertEquals('paid', $this->order->payment_status);
        $this->assertEquals('completed', $this->order->order_status);

        $showResponse = $this->actingAs($this->user)->get('/orders/' . $this->order->order_number);
        $showResponse->assertStatus(200);
        $showResponse->assertSee($this->product->account_username);
    }

    public function test_checkout_process_creates_order_and_redirects_to_order_show(): void
    {
        $newProduct = Product::create([
            'category_id' => $this->category->id,
            'title' => 'Akun Genshin Impact AR 60 C6 Raiden',
            'slug' => 'akun-genshin-impact-ar-60',
            'price' => 500000,
            'status' => 'available',
        ]);

        $response = $this->actingAs($this->user)->post('/checkout/' . $newProduct->slug, [
            'buyer_name' => 'Budi Gamer',
            'buyer_email' => 'budi@example.com',
            'buyer_phone' => '081234567899',
            'notes' => 'Tolong proses cepat ya',
        ]);

        $newOrder = Order::where('product_id', $newProduct->id)->first();
        $this->assertNotNull($newOrder);
        $this->assertEquals('pending', $newOrder->payment_status);

        $response->assertRedirect('/orders/' . $newOrder->order_number);
        $response->assertSessionHas('success');
    }

    public function test_user_can_cancel_pending_order_and_product_remains_available(): void
    {
        $response = $this->actingAs($this->user)->post('/orders/' . $this->order->order_number . '/cancel');

        $response->assertRedirect('/orders/' . $this->order->order_number);
        $response->assertSessionHas('info');

        $this->order->refresh();
        $this->assertEquals('cancelled', $this->order->order_status);
        $this->assertEquals('failed', $this->order->payment_status);

        $this->product->refresh();
        $this->assertEquals('available', $this->product->status);

        // Order view now shows cancelled state
        $showResponse = $this->actingAs($this->user)->get('/orders/' . $this->order->order_number);
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Pesanan Telah Dibatalkan');
    }

    public function test_user_cannot_cancel_already_paid_order(): void
    {
        $this->order->update([
            'payment_status' => 'paid',
            'order_status' => 'completed',
        ]);

        $response = $this->actingAs($this->user)->post('/orders/' . $this->order->order_number . '/cancel');

        $response->assertRedirect('/orders/' . $this->order->order_number);
        $response->assertSessionHas('error');

        $this->order->refresh();
        $this->assertEquals('completed', $this->order->order_status);
    }
}
