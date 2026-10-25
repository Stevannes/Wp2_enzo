<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetCodeMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class PasswordResetController extends Controller
{
    /**
     * Show the form to request a password reset verification code.
     */
    public function showRequestForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('customer.dashboard');
        }

        return view('customer.passwords.email');
    }

    /**
     * Generate a 6-digit verification code and send it to the user's email.
     */
    public function sendResetCode(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
        ]);

        $email = strtolower(trim($validated['email']));
        $user = User::where('email', $email)->first();

        if (! $user) {
            return back()->withErrors([
                'email' => 'Alamat email ini tidak terdaftar dalam sistem kami.',
            ])->onlyInput('email');
        }

        // Generate a 6-digit verification code
        $code = (string) random_int(100000, 999999);

        // Store or update in password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $code,
                'created_at' => now(),
            ]
        );

        // Send Email
        Mail::to($email)->send(new PasswordResetCodeMail($code, $user->name));

        $successMsg = 'Kode verifikasi 6 digit telah dikirimkan ke email '.$email.'. Silakan periksa kotak masuk atau folder spam Anda.';
        if (config('mail.default') === 'log') {
            $successMsg .= ' (Pengembangan Lokal: Driver email saat ini adalah "log". Kode OTP Anda: '.$code.')';
        }

        return redirect()->route('password.verify', ['email' => $email])
            ->with('success', $successMsg);
    }

    /**
     * Step 1: Show the form to input the 6-digit verification code.
     */
    public function showVerifyForm(Request $request): View
    {
        $email = (string) $request->query('email', old('email', session('password_reset_email', '')));

        return view('customer.passwords.verify-code', compact('email'));
    }

    /**
     * Step 1 Submit: Verify the 6-digit verification code.
     */
    public function verifyCode(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email'],
            'code' => ['required', 'string', 'digits:6'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'code.required' => 'Kode verifikasi 6 digit wajib diisi.',
            'code.digits' => 'Kode verifikasi harus berupa 6 digit angka.',
        ]);

        $email = strtolower(trim($validated['email']));
        $code = trim($validated['code']);

        $tokenRecord = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $code)
            ->first();

        if (! $tokenRecord) {
            return back()->withErrors([
                'code' => 'Kode verifikasi yang Anda masukkan tidak sesuai. Mohon periksa kembali email Anda.',
            ])->withInput($request->only('email'));
        }

        // Check 15-minute expiration window
        if (Carbon::parse($tokenRecord->created_at)->addMinutes(15)->isPast()) {
            return back()->withErrors([
                'code' => 'Kode verifikasi ini telah kedaluwarsa (hanya berlaku 15 menit). Silakan minta kode verifikasi baru.',
            ])->withInput($request->only('email'));
        }

        // Save verified status in session to unlock Step 2 (Reset Password)
        session([
            'password_reset_verified_email' => $email,
            'password_reset_verified_code' => $code,
        ]);

        return redirect()->route('password.reset')
            ->with('success', 'Kode verifikasi 6 digit berhasil diverifikasi! Silakan buat kata sandi baru akun Anda.');
    }

    /**
     * Step 2: Show the form to set a new password (only after code is verified).
     */
    public function showResetForm(Request $request): View|RedirectResponse
    {
        $email = (string) (session('password_reset_verified_email') ?? $request->query('email', ''));
        $code = (string) (session('password_reset_verified_code') ?? $request->query('code', ''));

        if (empty($email) || empty($code)) {
            $params = ! empty($email) ? ['email' => $email] : [];

            return redirect()->route('password.verify', $params)
                ->withErrors(['code' => 'Silakan masukkan dan verifikasi kode 6 digit Anda terlebih dahulu.']);
        }

        // Verify token still exists in database and is not expired
        $tokenRecord = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $code)
            ->first();

        if (! $tokenRecord || Carbon::parse($tokenRecord->created_at)->addMinutes(15)->isPast()) {
            $params = ! empty($email) ? ['email' => $email] : [];

            return redirect()->route('password.verify', $params)
                ->withErrors(['code' => 'Sesi verifikasi kode Anda telah kedaluwarsa. Silakan masukkan kembali kode verifikasi.']);
        }

        return view('customer.passwords.reset', compact('email'));
    }

    /**
     * Step 2 Submit: Update the user's password with the new password.
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $email = strtolower(trim((string) $request->input('email', session('password_reset_verified_email', ''))));
        $code = trim((string) $request->input('code', session('password_reset_verified_code', '')));

        $validated = $request->validate([
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
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal 8 karakter demi keamanan.',
            'password.numbers' => 'Kata sandi baru wajib mengandung setidaknya satu angka (0-9).',
            'password.symbols' => 'Kata sandi baru wajib mengandung setidaknya satu simbol unik (seperti ?, !, @, #, $, dll) seperti standar Steam.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        if (empty($email) || empty($code)) {
            return redirect()->route('password.verify')
                ->withErrors(['code' => 'Silakan verifikasi kode 6 digit Anda terlebih dahulu.']);
        }

        $tokenRecord = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $code)
            ->first();

        if (! $tokenRecord) {
            return redirect()->route('password.verify', ['email' => $email])
                ->withErrors(['code' => 'Kode verifikasi tidak valid. Mohon lakukan verifikasi ulang.']);
        }

        if (Carbon::parse($tokenRecord->created_at)->addMinutes(15)->isPast()) {
            return redirect()->route('password.verify', ['email' => $email])
                ->withErrors(['code' => 'Kode verifikasi telah kedaluwarsa. Silakan minta kode baru.']);
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            return redirect()->route('customer.login')
                ->withErrors(['email' => 'Akun pengguna untuk email ini tidak ditemukan.']);
        }

        // Update password and revoke token
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        DB::table('password_reset_tokens')->where('email', $email)->delete();
        session()->forget(['password_reset_verified_email', 'password_reset_verified_code']);

        return redirect()->route('customer.login')
            ->with('success', 'Kata sandi akun Anda berhasil diperbarui! Silakan masuk menggunakan kata sandi baru Anda.');
    }

    /**
     * Send verification code for logged-in user in Dashboard.
     */
    public function sendDashboardVerificationCode(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $code = (string) random_int(100000, 999999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => $code,
                'created_at' => now(),
            ]
        );

        Mail::to($user->email)->send(new PasswordResetCodeMail($code, $user->name));

        $msg = 'Kode verifikasi 6 digit telah dikirimkan ke email Anda ('.$user->email.'). Masukkan kode tersebut pada form di bawah untuk mengonfirmasi kata sandi baru.';
        if (config('mail.default') === 'log') {
            $msg .= ' (Pengembangan Lokal: Driver email saat ini adalah "log". Kode OTP Anda: '.$code.')';
        }

        return back()->with('success', $msg);
    }
}
