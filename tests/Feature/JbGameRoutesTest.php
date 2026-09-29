<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JbGameRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Category $category;
    protected Product $product;
    protected Order $paidOrder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'role' => 'customer',
            'name' => 'Test Customer',
            'email' => 'customer@jbgame.com',
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
            'title' => 'Akun MLBB Mythic Glory 100 Stars',
            'slug' => 'akun-mlbb-mythic-glory-100-stars',
            'price' => 500000,
            'status' => 'available',
            'description' => 'Akun sultan full skin collector & legend.',
            'account_details' => 'Level 80, Winrate 68%, Hero 120, Skin 350.',
            'account_username' => 'mlbb_secret_user',
            'account_password' => 'mlbb_secret_pass',
            'login_method' => 'Moonton',
        ]);

        $this->paidOrder = Order::create([
            'order_number' => 'JB-TEST-PAID-001',
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'buyer_name' => $this->user->name,
            'buyer_email' => $this->user->email,
            'buyer_phone' => $this->user->phone,
            'total_amount' => $this->product->price,
            'payment_status' => 'paid',
            'order_status' => 'completed',
        ]);
    }

    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('JB GAME');
        $response->assertSee('Kategori');
    }

    public function test_products_catalog_loads_successfully(): void
    {
        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertSee('Katalog Akun Game');
    }

    public function test_product_detail_page_loads_and_does_not_leak_credentials(): void
    {
        $response = $this->get('/products/' . $this->product->slug);
        $response->assertStatus(200);
        $response->assertSee($this->product->title);
        $response->assertSee('Beli Sekarang');

        // Verify sensitive credentials are NOT rendered in the public view
        $response->assertDontSee($this->product->account_password);
        $response->assertDontSee($this->product->account_username);
    }

    public function test_guest_is_redirected_when_accessing_checkout(): void
    {
        $response = $this->get('/checkout/' . $this->product->slug);
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_checkout(): void
    {
        $response = $this->actingAs($this->user)->get('/checkout/' . $this->product->slug);
        $response->assertStatus(200);
        $response->assertSee('Checkout Pesanan');
        $response->assertSee($this->product->title);
    }

    public function test_paid_order_reveals_credentials_to_owner(): void
    {
        $response = $this->actingAs($this->user)->get('/orders/' . $this->paidOrder->order_number);
        $response->assertStatus(200);
        $response->assertSee('Data Kredensial Akun Game');
        $response->assertSee('Username / ID / Email Login:');
        $response->assertSee($this->product->account_username);
    }

    public function test_other_user_cannot_access_order(): void
    {
        $otherUser = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($otherUser)->get('/orders/' . $this->paidOrder->order_number);
        $response->assertStatus(403);
    }

    public function test_midtrans_webhook_marks_order_as_paid_and_product_as_sold(): void
    {
        $order = Order::create([
            'order_number' => 'JB-TEST-' . time(),
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'buyer_name' => $this->user->name,
            'buyer_email' => $this->user->email,
            'buyer_phone' => '081234567890',
            'total_amount' => $this->product->price,
            'payment_status' => 'pending',
            'order_status' => 'pending',
        ]);

        $payload = [
            'order_id' => $order->order_number,
            'status_code' => '200',
            'gross_amount' => (string) (int) $order->total_amount,
            'transaction_status' => 'settlement',
            'payment_type' => 'qris',
            'transaction_id' => 'midtrans-test-' . time(),
            'transaction_time' => now()->toDateTimeString(),
        ];

        $response = $this->postJson('/midtrans/webhook', $payload);
        $response->assertStatus(200);

        $order->refresh();
        $this->product->refresh();

        $this->assertEquals('paid', $order->payment_status);
        $this->assertEquals('completed', $order->order_status);
        $this->assertEquals('sold', $this->product->status);
    }
}
