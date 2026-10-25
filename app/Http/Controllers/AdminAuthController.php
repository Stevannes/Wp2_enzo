<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    /**
     * Display the secure Admin Login portal.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Handle Admin Authentication with brute-force rate limiting and session fixation defense.
     */
    public function login(Request $request): RedirectResponse
    {
        // 1. Check Rate Limiter (Max 5 attempts per minute per IP to prevent brute-force)
        $throttleKey = Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login yang gagal. Akun dikunci sementara demi keamanan. Coba lagi dalam {$seconds} detik.",
            ])->onlyInput('email');
        }

        // 2. Validate Credentials
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = (bool) $request->boolean('remember');

        // 3. Attempt Authentication
        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Strict Role Authorization: Only Admin role can access
            if ($user->role !== 'admin') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                RateLimiter::hit($throttleKey, 300);

                return back()->withErrors([
                    'email' => 'Akses ditolak: Akun Anda tidak memiliki hak akses Administrator.',
                ])->onlyInput('email');
            }

            // Clear Rate Limiter on success
            RateLimiter::clear($throttleKey);

            // Prevent Session Fixation attack
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang kembali, '.Auth::user()->name.'. Sesi portal terenkripsi aktif.');
        }

        // Record failed attempt
        RateLimiter::hit($throttleKey, 60);

        return back()->withErrors([
            'email' => 'Kombinasi email administrator dan kata sandi tidak cocok.',
        ])->onlyInput('email');
    }

    /**
     * Securely terminate Admin session and clear tokens.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Anda telah berhasil keluar (logout) dari portal Admin CMS dengan aman.');
    }
}
