<?php

namespace App\Http\Controllers;

use App\Models\InquiryRfp;
use App\Models\User;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;
use Throwable;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google OAuth authentication page.
     */
    public function redirectToGoogle(): RedirectResponse|SymfonyRedirectResponse
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        if (empty($clientId) || empty($clientSecret)) {
            return redirect()->route('customer.login')
                ->with('error', 'Integrasi Google OAuth belum dikonfigurasi. Silakan tambahkan GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET pada berkas .env.');
        }

        $driver = Socialite::driver('google');
        $this->configureDriverHttpClient($driver);

        if (method_exists($driver, 'with')) {
            $driver->with(['prompt' => 'select_account']);
        }

        return $driver->redirect();
    }

    /**
     * Obtain the user information from Google and authenticate the session.
     */
    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        try {
            $driver = Socialite::driver('google');
            $this->configureDriverHttpClient($driver);

            $googleUser = $driver->user();
        } catch (Throwable $e) {
            return redirect()->route('customer.login')
                ->with('error', 'Otentikasi dengan akun Google dibatalkan atau terjadi kesalahan: '.$e->getMessage());
        }

        $email = strtolower(trim((string) $googleUser->getEmail()));

        if (empty($email)) {
            return redirect()->route('customer.login')
                ->with('error', 'Akun Google Anda tidak menyediakan alamat email yang valid.');
        }

        $googleId = (string) $googleUser->getId();
        $avatar = $googleUser->getAvatar();

        $user = User::where('google_id', $googleId)->first();

        if (! $user) {
            $user = User::where('email', $email)->first();

            if ($user) {
                $user->update([
                    'google_id' => $googleId,
                    'avatar' => $avatar ?? $user->avatar,
                ]);
            }
        }

        if (! $user) {
            $user = User::create([
                'name' => strip_tags(trim((string) $googleUser->getName())) ?: 'Klien Google',
                'email' => $email,
                'google_id' => $googleId,
                'avatar' => $avatar,
                'password' => Hash::make(Str::random(32)),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]);
        }

        InquiryRfp::whereNull('user_id')
            ->where('email', $user->email)
            ->update(['user_id' => $user->id]);

        Auth::login($user, true);
        $request->session()->regenerate();

        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang di Panel Manajemen Admin, '.$user->name.'.');
        }

        return redirect()->intended(route('customer.dashboard'))
            ->with('success', 'Berhasil masuk dengan akun Google. Selamat datang, '.$user->name.'!');
    }

    /**
     * Configure a secure HTTP client with explicit CA certificates for Windows / local environments.
     */
    protected function configureDriverHttpClient(mixed $driver): void
    {
        if (! is_object($driver) || ! method_exists($driver, 'setHttpClient')) {
            return;
        }

        $certPath = storage_path('certs/cacert.pem');
        $verify = file_exists($certPath)
            ? $certPath
            : (file_exists('C:\\php\\cacert.pem') ? 'C:\\php\\cacert.pem' : true);

        $client = new GuzzleClient([
            'verify' => $verify,
            'timeout' => 15,
        ]);

        $driver->setHttpClient($client);
    }
}
