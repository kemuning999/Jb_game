<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        if (empty($clientId) || empty($clientSecret)) {
            return redirect()->route('login')->with(
                'error',
                'Login Google memerlukan GOOGLE_CLIENT_ID & GOOGLE_CLIENT_SECRET di file .env. Silakan isi kredensial Google Console Anda atau masuk menggunakan formulir di bawah.'
            );
        }

        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            /** @var \Laravel\Socialite\Two\User $googleUser */
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (Exception $e) {
            try {
                $googleUser = Socialite::driver('google')->user();
            } catch (Exception $fallbackEx) {
                return redirect()->route('login')->with(
                    'error',
                    'Proses login dengan Google dibatalkan atau terjadi kesalahan. Silakan coba kembali.'
                );
            }
        }

        if (empty($googleUser->getEmail())) {
            return redirect()->route('login')->with(
                'error',
                'Akun Google Anda tidak memiliki akses email publik.'
            );
        }

        // Check if user already exists with this google_id or email
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($user) {
            // Update existing user with google_id and avatar if missing
            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar' => $user->avatar ?: $googleUser->getAvatar(),
            ]);
        } else {
            // Create a brand new user
            $user = User::create([
                'name' => $googleUser->getName() ?: ($googleUser->getNickname() ?: 'Pengguna Google'),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]);
        }

        Auth::login($user, remember: true);

        // If user is admin (Answer 2B), redirect directly to Filament Admin Dashboard
        if ($user->role === 'admin') {
            return redirect()->intended('/admin');
        }

        // Ensure customer never gets dumped into an admin URL stored in session
        $intended = session()->get('url.intended');
        if ($intended && str_contains($intended, '/admin')) {
            session()->forget('url.intended');
            return redirect()->route('home')->with('success', 'Selamat datang, ' . $user->name . '!');
        }

        return redirect()->intended(route('home'))->with('success', 'Selamat datang, ' . $user->name . '!');
    }
}
