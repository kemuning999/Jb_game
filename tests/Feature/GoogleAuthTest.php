<?php

namespace Tests\Feature;

use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery;
use Tests\TestCase;

class GoogleAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_redirect_to_google_shows_friendly_error_when_unconfigured(): void
    {
        config(['services.google.client_id' => '']);
        config(['services.google.client_secret' => '']);

        $response = $this->get('/auth/google');
        $response->assertRedirect('/login');
        $response->assertSessionHas('error');
    }

    public function test_redirect_to_google_redirects_when_configured(): void
    {
        config(['services.google.client_id' => 'dummy-client-id']);
        config(['services.google.client_secret' => 'dummy-client-secret']);

        $response = $this->get('/auth/google');
        $response->assertRedirect();
        $this->assertStringContainsString('accounts.google.com', $response->headers->get('Location'));
    }

    public function test_google_callback_creates_new_customer_and_logs_in(): void
    {
        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('google-unique-998877');
        $abstractUser->shouldReceive('getName')->andReturn('Ihsan Buyer');
        $abstractUser->shouldReceive('getNickname')->andReturn('ihsan');
        $abstractUser->shouldReceive('getEmail')->andReturn('ihsan.buyer@gmail.com');
        $abstractUser->shouldReceive('getAvatar')->andReturn('https://lh3.googleusercontent.com/avatar.jpg');

        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect('/');
        $this->assertAuthenticated();

        $user = User::where('email', 'ihsan.buyer@gmail.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('google-unique-998877', $user->google_id);
        $this->assertEquals('customer', $user->role);
        $this->assertEquals('https://lh3.googleusercontent.com/avatar.jpg', $user->avatar);
    }

    public function test_google_callback_for_admin_user_redirects_to_admin_panel(): void
    {
        // User 2B: Admin logging in via Google gets redirected to /admin
        $admin = User::factory()->create([
            'name' => 'Owner Admin',
            'email' => 'admin.google@jbgame.com',
            'role' => 'admin',
        ]);

        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('google-admin-123');
        $abstractUser->shouldReceive('getName')->andReturn('Owner Admin');
        $abstractUser->shouldReceive('getNickname')->andReturn('owner');
        $abstractUser->shouldReceive('getEmail')->andReturn('admin.google@jbgame.com');
        $abstractUser->shouldReceive('getAvatar')->andReturn(null);

        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($admin);

        $admin->refresh();
        $this->assertEquals('google-admin-123', $admin->google_id);
    }

    public function test_google_callback_handles_exception_gracefully(): void
    {
        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andThrow(new Exception('Access denied by user'));

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect('/login');
        $response->assertSessionHas('error');
        $this->assertGuest();
    }
}
