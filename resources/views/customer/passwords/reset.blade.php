@extends('layouts.app')

@section('title', 'Buat Kata Sandi Baru — enzo')

@section('content')

<!-- ========================================================
     STAGE 2: SET NEW PASSWORD (AFTER VERIFICATION)
========================================================= -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden py-24 sm:py-32">
    <!-- Clean Architectural Twilight Background -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/ptmkp_hero_clean.jpg') }}"
             alt="Enzo Set New Password"
             class="w-full h-full object-cover object-center filter brightness-50">
        <div class="absolute inset-0 bg-slate-950/75"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1d] via-slate-950/50 to-[#0a0f1d]"></div>
    </div>

    <!-- Container -->
    <div class="relative z-10 w-full max-w-lg mx-auto px-4 sm:px-6">
        
        <!-- Header Branding -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#1a2332]/90 border border-[#c29b53]/40 text-[#c29b53] text-xs font-bold uppercase tracking-wider mb-4 shadow-lg backdrop-blur-md">
                <i data-lucide="key" class="w-4 h-4 text-[#c29b53]"></i>
                <span>Tahap 2 dari 2: Kata Sandi Baru</span>
            </div>
            <h1 class="font-sans text-2xl sm:text-3xl font-extrabold text-white uppercase tracking-wider">
                Buat <span class="text-[#c29b53]">Kata Sandi Baru</span>
            </h1>
            <p class="text-xs text-slate-300 mt-1 font-light leading-relaxed">
                Kode keamanan Anda telah terverifikasi. Silakan tentukan kata sandi baru untuk akun Anda.
            </p>
        </div>

        <!-- Floating White Card -->
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 p-8 sm:p-10">
            
            <!-- Session Alerts -->
            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-300 text-rose-800 text-xs flex items-start gap-2.5 shadow-sm">
                    <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600 shrink-0 mt-0.5"></i>
                    <span class="font-medium leading-relaxed">{{ session('error') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-300 text-emerald-800 text-xs flex items-start gap-2.5 shadow-sm">
                    <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
                    <span class="font-medium leading-relaxed">{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-300 text-rose-800 text-xs shadow-sm">
                    <div class="font-bold flex items-center gap-1.5 mb-1 text-rose-900">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600"></i>
                        <span>Mohon Periksa Isian Anda:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 font-medium">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Verified Email Ribbon -->
            <div class="mb-5 p-3.5 rounded-2xl bg-emerald-50/80 border border-emerald-200 text-emerald-900 text-xs flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                        <i data-lucide="check" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <span class="text-[10px] text-emerald-700 font-bold uppercase tracking-wider block">Email Terverifikasi</span>
                        <span class="font-mono font-bold text-slate-800 text-xs">{{ $email }}</span>
                    </div>
                </div>
                <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full bg-emerald-200/80 text-emerald-800">
                    Lolos OTP
                </span>
            </div>

            <!-- Set Password Form with Live Steam-Style Password Checklist -->
            <form action="{{ route('password.update') }}" method="POST" class="space-y-4 text-xs"
                  x-data="{
                      password: '',
                      passwordConfirm: '',
                      get hasLength() { return this.password.length >= 8; },
                      get hasNumber() { return /\d/.test(this.password); },
                      get hasSymbol() { return /[\W_]/.test(this.password); },
                      get isMatched() { return this.password.length > 0 && this.password === this.passwordConfirm; },
                      get isValid() { return this.hasLength && this.hasNumber && this.hasSymbol && this.isMatched; }
                  }">
                @csrf

                <input type="hidden" name="email" value="{{ $email }}">

                <!-- New Password -->
                <div>
                    <label for="password" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">
                        Kata Sandi Baru <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </div>
                        <input type="password" name="password" id="password" required autofocus
                               x-model="password"
                               placeholder="Minimal 8 karakter unik"
                               class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs font-medium focus:bg-white focus:outline-none focus:border-[#c29b53] focus:ring-1 focus:ring-[#c29b53] transition">
                    </div>
                </div>

                <!-- Confirm New Password -->
                <div>
                    <label for="password_confirmation" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">
                        Konfirmasi Kata Sandi Baru <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                        </div>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               x-model="passwordConfirm"
                               placeholder="Ulangi kata sandi baru"
                               class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs font-medium focus:bg-white focus:outline-none focus:border-[#c29b53] focus:ring-1 focus:ring-[#c29b53] transition">
                    </div>
                </div>

                <!-- Live Security Checklist (Steam Standard) -->
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-[11px] space-y-1.5">
                    <span class="font-bold text-slate-700 uppercase tracking-wider text-[10px] block mb-1">Standar Keamanan Kata Sandi:</span>
                    
                    <div class="flex items-center gap-2" :class="hasLength ? 'text-emerald-700 font-semibold' : 'text-slate-500'">
                        <i data-lucide="check" class="w-3.5 h-3.5" x-show="hasLength"></i>
                        <span class="w-3.5 h-3.5 inline-block text-center text-slate-400 font-mono" x-show="!hasLength">&bull;</span>
                        <span>Minimal 8 karakter</span>
                    </div>

                    <div class="flex items-center gap-2" :class="hasNumber ? 'text-emerald-700 font-semibold' : 'text-slate-500'">
                        <i data-lucide="check" class="w-3.5 h-3.5" x-show="hasNumber"></i>
                        <span class="w-3.5 h-3.5 inline-block text-center text-slate-400 font-mono" x-show="!hasNumber">&bull;</span>
                        <span>Mengandung setidaknya 1 angka (0-9)</span>
                    </div>

                    <div class="flex items-center gap-2" :class="hasSymbol ? 'text-emerald-700 font-semibold' : 'text-slate-500'">
                        <i data-lucide="check" class="w-3.5 h-3.5" x-show="hasSymbol"></i>
                        <span class="w-3.5 h-3.5 inline-block text-center text-slate-400 font-mono" x-show="!hasSymbol">&bull;</span>
                        <span>Mengandung simbol unik (!, @, #, $, %, ?, dll)</span>
                    </div>

                    <div class="flex items-center gap-2" :class="isMatched ? 'text-emerald-700 font-semibold' : 'text-slate-500'" x-show="password.length > 0">
                        <i data-lucide="check" class="w-3.5 h-3.5" x-show="isMatched"></i>
                        <span class="w-3.5 h-3.5 inline-block text-center text-rose-500 font-mono" x-show="!isMatched">&times;</span>
                        <span x-text="isMatched ? 'Konfirmasi kata sandi cocok' : 'Konfirmasi kata sandi belum sama'"></span>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        :disabled="!isValid"
                        :class="!isValid ? 'opacity-50 cursor-not-allowed bg-slate-300 text-slate-500 border-slate-300 shadow-none' : 'bg-[#1a2332] hover:bg-[#233044] text-[#c29b53] hover:text-white border-[#c29b53]/40 shadow-lg cursor-pointer'"
                        class="w-full mt-3 py-3.5 font-bold uppercase tracking-wider text-xs rounded-xl transition duration-200 flex items-center justify-center gap-2 border">
                    <i data-lucide="lock" class="w-4 h-4"></i>
                    <span x-text="isValid ? 'Simpan Kata Sandi Baru' : (password.length > 0 && !hasSymbol ? 'Wajib Tambahkan Simbol Unik' : 'Lengkapi Syarat Kata Sandi Baru')"></span>
                </button>
            </form>

            <!-- Back to Step 1 -->
            <div class="mt-6 pt-5 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600">
                <a href="{{ route('password.verify', ['email' => $email]) }}" class="text-slate-500 hover:text-slate-800">
                    &larr; Verifikasi Ulang Kode
                </a>
                <a href="{{ route('customer.login') }}" class="font-bold text-[#c29b53] hover:underline">
                    Kembali Masuk &rarr;
                </a>
            </div>

        </div>

    </div>
</section>

@endsection
