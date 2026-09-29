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
        $product = Product::where('status', 'available')->first();
        $this->assertNotNull($product);

        $response = $this->get('/products/' . $product->slug);
        $response->assertStatus(200);
        $response->assertSee($product->title);
        $response->assertSee('Beli Sekarang');

        // Verify sensitive credentials are NOT rendered in the public view
        $response->assertDontSee($product->account_password);
        $response->assertDontSee($product->account_username);
    }

    public function test_guest_is_redirected_when_accessing_checkout(): void
    {
        $product = Product::where('status', 'available')->first();
        $response = $this->get('/checkout/' . $product->slug);
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_checkout(): void
    {
        $user = User::where('role', 'customer')->first();
        $product = Product::where('status', 'available')->first();

        $response = $this->actingAs($user)->get('/checkout/' . $product->slug);
        $response->assertStatus(200);
        $response->assertSee('Checkout Pesanan');
        $response->assertSee($product->title);
    }

    public function test_paid_order_reveals_credentials_to_owner(): void
    {
        $order = Order::where('payment_status', 'paid')->first();
        $this->assertNotNull($order);

        $owner = $order->user;
        $response = $this->actingAs($owner)->get('/orders/' . $order->order_number);
        $response->assertStatus(200);
        $response->assertSee('Data Kredensial Akun Game');
        $response->assertSee('Username / ID / Email Login:');
        $response->assertSee($order->product->account_username);
    }

    public function test_other_user_cannot_access_order(): void
    {
        $order = Order::where('payment_status', 'paid')->first();
        $otherUser = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($otherUser)->get('/orders/' . $order->order_number);
        $response->assertStatus(403);
    }

    public function test_midtrans_webhook_marks_order_as_paid_and_product_as_sold(): void
    {
        $user = User::where('role', 'customer')->first();
        $product = Product::where('status', 'available')->first();

        $order = Order::create([
            'order_number' => 'JB-TEST-' . time(),
            'user_id' => $user->id,
            'product_id' => $product->id,
            'buyer_name' => $user->name,
            'buyer_email' => $user->email,
            'buyer_phone' => '081234567890',
            'total_amount' => $product->price,
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
        $product->refresh();

        $this->assertEquals('paid', $order->payment_status);
        $this->assertEquals('completed', $order->order_status);
        $this->assertEquals('sold', $product->status);
    }
}
