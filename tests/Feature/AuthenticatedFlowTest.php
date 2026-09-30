<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticatedFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_browse_entire_site_without_errors(): void
    {
        $category = Category::create([
            'name' => 'Mobile Legends',
            'slug' => 'mobile-legends',
            'is_active' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'title' => 'Akun Test ML',
            'slug' => 'akun-test-ml',
            'price' => 50000,
            'status' => 'available',
            'account_username' => 'testuser',
            'account_password' => 'secret123',
        ]);

        $customer = User::factory()->create([
            'role' => 'customer',
            'email' => 'customer@test.com',
        ]);

        $response = $this->actingAs($customer)->get('/');
        $response->assertStatus(200);

        $response = $this->actingAs($customer)->get('/orders');
        $response->assertStatus(200);

        $response = $this->actingAs($customer)->get('/dashboard');
        $response->assertRedirect('/orders');

        $response = $this->actingAs($customer)->get('/profile');
        $response->assertStatus(200);

        $response = $this->actingAs($customer)->get('/products/' . $product->slug);
        $response->assertStatus(200);

        $response = $this->actingAs($customer)->get('/checkout/' . $product->slug);
        $response->assertStatus(200);
    }

    public function test_admin_can_browse_entire_site_and_admin_panel(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@test.com',
        ]);

        $response = $this->actingAs($admin)->get('/');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/admin/products');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/admin/orders');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/admin/categories');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/admin/users');
        $response->assertStatus(200);
    }
}
