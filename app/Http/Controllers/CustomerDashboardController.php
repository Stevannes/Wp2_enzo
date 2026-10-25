<?php

namespace App\Http\Controllers;

use App\Models\InquiryRfp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerDashboardController extends Controller
{
    /**
     * Display Customer Portal & Tender Tracking Workspace.
     */
    public function index(): View
    {
        $user = Auth::user();

        // Fetch all RFPs submitted by this customer (by user_id or matching email)
        $rfps = InquiryRfp::query()
            ->with(['attachments', 'designLayout', 'progressLogs', 'complaints', 'negotiationLogs'])
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere('email', $user->email);
            })
            ->latest()
            ->get();

        $stats = [
            'total' => $rfps->count(),
            'active' => $rfps->whereNotIn('status', ['deal', 'rejected'])->count(),
            'deals' => $rfps->where('status', 'deal')->count(),
            'total_budget' => (float) $rfps->sum('estimated_budget_idr'),
        ];

        return view('customer.dashboard', compact('user', 'rfps', 'stats'));
    }

    /**
     * Update Customer Profile (Phone number, company name, or password).
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'min:9', 'max:30'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'current_password' => ['nullable', 'string'],
            'verification_code' => ['nullable', 'string', 'digits:6'],
            'new_password' => [
                'nullable',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone_number.required' => 'Nomor WhatsApp / telepon wajib disertakan.',
            'verification_code.digits' => 'Kode verifikasi email harus berupa 6 digit angka.',
            'new_password.min' => 'Kata sandi baru minimal 8 karakter.',
            'new_password.numbers' => 'Kata sandi baru wajib mengandung setidaknya satu angka (0-9).',
            'new_password.symbols' => 'Kata sandi baru wajib mengandung setidaknya satu simbol unik (seperti ?, !, @, #, dll) seperti standar Steam.',
            'new_password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $cleanPhone = preg_replace('/[^0-9+]/', '', $validated['phone_number']);

        // If changing password, verify via verification code OR current password
        if (! empty($validated['new_password'])) {
            $isVerified = false;

            // Option A: Verification code from Email
            if (! empty($validated['verification_code'])) {
                $code = trim($validated['verification_code']);
                $tokenRecord = DB::table('password_reset_tokens')
                    ->where('email', $user->email)
                    ->where('token', $code)
                    ->first();

                if (! $tokenRecord) {
                    return back()->withErrors(['verification_code' => 'Kode verifikasi email tidak valid atau salah.'])->withInput();
                }

                if (Carbon::parse($tokenRecord->created_at)->addMinutes(15)->isPast()) {
                    return back()->withErrors(['verification_code' => 'Kode verifikasi email telah kedaluwarsa (berlaku 15 menit). Silakan minta kode baru.'])->withInput();
                }

                DB::table('password_reset_tokens')->where('email', $user->email)->delete();
                $isVerified = true;
            } elseif (! empty($validated['current_password'])) {
                // Option B: Current password
                if (! Hash::check($validated['current_password'], $user->password)) {
                    return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak sesuai.'])->withInput();
                }
                $isVerified = true;
            } else {
                return back()->withErrors([
                    'verification_code' => 'Untuk mengubah kata sandi, masukkan kode verifikasi yang dikirim ke email Anda, atau isi kata sandi saat ini.',
                ])->withInput();
            }

            if ($isVerified) {
                $user->password = Hash::make($validated['new_password']);
            }
        }

        $user->name = strip_tags(trim($validated['name']));
        $user->phone_number = $cleanPhone;
        $user->company_name = ! empty($validated['company_name']) ? strip_tags(trim($validated['company_name'])) : null;
        $user->save();

        // Automatically link any unlinked RFPs that match this updated email or phone number
        InquiryRfp::whereNull('user_id')
            ->where(function ($q) use ($user, $cleanPhone) {
                $q->where('email', $user->email)
                    ->orWhere('phone_number', 'like', "%{$cleanPhone}%");
            })
            ->update(['user_id' => $user->id]);

        return back()->with('success', 'Profil dan data kontak Anda berhasil diperbarui!');
    }
}
