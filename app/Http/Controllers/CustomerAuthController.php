<?php

namespace App\Http\Controllers;

use App\Models\InquiryRfp;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class CustomerAuthController extends Controller
{
    /**
     * Show the Customer Sign In (Login) page.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('customer.dashboard');
        }

        return view('customer.login');
    }

    /**
     * Show the Customer Sign Up (Register) page.
     */
    public function showRegisterForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('customer.dashboard');
        }

        return view('customer.register');
    }

    /**
     * Handle Customer Registration (Sign Up) with mandatory Email & Phone Number.
     */
    public function register(Request $request): RedirectResponse
    {
        // 1. Anti-Bot Honeypot verification
        if ($request->filled('website_hp')) {
            return redirect()->route('home');
        }

        // 2. Validate input: Email, Phone Number, and Steam-style Password (symbols & numbers required)
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['required', 'string', 'min:9', 'max:30'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ],
        ], [
            'name.required' => 'Nama lengkap penanggung jawab wajib diisi.',
            'email.required' => 'Alamat email aktif wajib disertakan.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email ini sudah terdaftar. Silakan login langsung.',
            'phone_number.required' => 'Nomor telepon / WhatsApp aktif wajib disertakan.',
            'phone_number.min' => 'Nomor telepon minimal 9 digit.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter demi keamanan.',
            'password.numbers' => 'Kata sandi wajib mengandung setidaknya satu angka (0-9).',
            'password.symbols' => 'Kata sandi wajib mengandung setidaknya satu simbol unik (seperti ?, !, @, #, $, dll) seperti standar Steam.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // Clean phone number
        $cleanPhone = preg_replace('/[^0-9+]/', '', $validated['phone_number']);

        // 3. Create Customer User
        $user = User::create([
            'name' => strip_tags(trim($validated['name'])),
            'email' => strtolower(trim($validated['email'])),
            'phone_number' => $cleanPhone,
            'company_name' => ! empty($validated['company_name']) ? strip_tags(trim($validated['company_name'])) : null,
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
        ]);

        // 4. Automatically link any existing RFPs that match this email or phone number
        InquiryRfp::whereNull('user_id')
            ->where(function ($q) use ($user, $cleanPhone) {
                $q->where('email', $user->email)
                    ->orWhere('phone_number', 'like', "%{$cleanPhone}%");
            })
            ->update(['user_id' => $user->id]);

        // 5. Authenticate and regenerate session
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('customer.dashboard')
            ->with('success', 'Selamat datang di ENZO Construction, '.$user->name.'! Akun klien Anda berhasil dibuat.');
    }

    /**
     * Handle Customer Sign In (Login) with Email and Password verification.
     */
    public function login(Request $request): RedirectResponse
    {
        $throttleKey = Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());

        // 1. Rate Limiting Check (Anti-Brute Force: 5 attempts per minute)
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withErrors([
                'email' => "Terlalu banyak percobaan masuk yang gagal. Silakan tunggu {$seconds} detik demi keamanan akun Anda.",
            ])->onlyInput('email');
        }

        // 2. Validate Credentials (Email and Password only)
        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'password.required' => 'Kata sandi akun wajib diisi.',
        ]);

        $loginIdentifier = trim((string) $request->input('email'));
        $password = (string) $request->input('password');
        $remember = (bool) $request->boolean('remember');

        // 3. Find User by Email (or phone number fallback if entered in identifier)
        $user = User::where('email', strtolower($loginIdentifier))
            ->orWhere('phone_number', preg_replace('/[^0-9+]/', '', $loginIdentifier))
            ->first();

        // 4. Verify Password & Role
        if ($user && Hash::check($password, $user->password)) {
            RateLimiter::clear($throttleKey);

            Auth::login($user, $remember);
            $request->session()->regenerate();

            // Link any pending RFPs if not linked yet
            InquiryRfp::whereNull('user_id')
                ->where('email', $user->email)
                ->update(['user_id' => $user->id]);

            // Route based on role
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang di Panel Manajemen Admin, '.$user->name.'.');
            }

            return redirect()->intended(route('customer.dashboard'))
                ->with('success', 'Selamat datang kembali, '.$user->name.'!');
        }

        // Increment rate limit attempts
        RateLimiter::hit($throttleKey, 60);

        return back()->withErrors([
            'email' => 'Alamat email atau kata sandi yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email');
    }

    /**
     * Securely terminate Customer session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.login')
            ->with('success', 'Anda telah berhasil keluar dari akun klien dengan aman.');
    }
}
