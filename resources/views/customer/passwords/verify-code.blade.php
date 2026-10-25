@extends('layouts.app')

@section('title', 'Verifikasi Kode 6 Digit — enzo')

@section('content')

<!-- ========================================================
     STAGE 1: VERIFY 6-DIGIT EMAIL CODE
========================================================= -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden py-24 sm:py-32">
    <!-- Clean Architectural Twilight Background -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/ptmkp_hero_clean.jpg') }}"
             alt="Enzo Password Verification"
             class="w-full h-full object-cover object-center filter brightness-50">
        <div class="absolute inset-0 bg-slate-950/75"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1d] via-slate-950/50 to-[#0a0f1d]"></div>
    </div>

    <!-- Verification Container -->
    <div class="relative z-10 w-full max-w-lg mx-auto px-4 sm:px-6">
        
        <!-- Header Branding -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#1a2332]/90 border border-[#c29b53]/40 text-[#c29b53] text-xs font-bold uppercase tracking-wider mb-4 shadow-lg backdrop-blur-md">
                <i data-lucide="shield-check" class="w-4 h-4 text-[#c29b53]"></i>
                <span>Tahap 1 dari 2: Verifikasi Kode</span>
            </div>
            <h1 class="font-sans text-2xl sm:text-3xl font-extrabold text-white uppercase tracking-wider">
                Verifikasi <span class="text-[#c29b53]">Kode Email</span>
            </h1>
            <p class="text-xs text-slate-300 mt-1 font-light leading-relaxed">
                Silakan masukkan 6 digit kode keamanan yang telah dikirimkan ke email Anda untuk melanjutkan ke pembuatan kata sandi baru.
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

            <!-- Verify Code Form -->
            <form action="{{ route('password.verify.submit') }}" method="POST" class="space-y-5 text-xs">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">
                        Alamat Email Akun <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </div>
                        <input type="email" name="email" id="email" required
                               value="{{ old('email', $email) }}"
                               placeholder="nama@email.com"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs font-medium focus:bg-white focus:outline-none focus:border-[#c29b53] focus:ring-1 focus:ring-[#c29b53] transition">
                    </div>
                </div>

                <!-- 6-Digit Code Input Box (Distinct 6 Centered Boxes) -->
                <div class="bg-slate-50/90 p-5 rounded-2xl border border-slate-200 text-center"
                     x-data="{
                         digits: ['', '', '', '', '', ''],
                         init() {
                             const oldCode = '{{ old('code') }}';
                             if (oldCode && oldCode.length === 6) {
                                 for (let i = 0; i < 6; i++) {
                                     this.digits[i] = oldCode[i];
                                 }
                             }
                             this.$nextTick(() => {
                                 const first = document.getElementById('digit-0');
                                 if (first) first.focus();
                             });
                         },
                         get fullCode() {
                             return this.digits.join('');
                         },
                         handleInput(e, idx) {
                             const val = e.target.value.replace(/[^0-9]/g, '');
                             if (val.length > 1) {
                                 this.pasteCode(val, idx);
                                 return;
                             }
                             this.digits[idx] = val;
                             if (val && idx < 5) {
                                 const next = document.getElementById('digit-' + (idx + 1));
                                 if (next) next.focus();
                             }
                         },
                         handleKeydown(e, idx) {
                             if (e.key === 'Backspace') {
                                 if (!this.digits[idx] && idx > 0) {
                                     const prev = document.getElementById('digit-' + (idx - 1));
                                     if (prev) {
                                         prev.focus();
                                         this.digits[idx - 1] = '';
                                     }
                                 } else {
                                     this.digits[idx] = '';
                                 }
                             } else if (e.key === 'ArrowLeft' && idx > 0) {
                                 const prev = document.getElementById('digit-' + (idx - 1));
                                 if (prev) prev.focus();
                             } else if (e.key === 'ArrowRight' && idx < 5) {
                                 const next = document.getElementById('digit-' + (idx + 1));
                                 if (next) next.focus();
                             }
                         },
                         handlePaste(e) {
                             e.preventDefault();
                             const text = (e.clipboardData || window.clipboardData).getData('text');
                             this.pasteCode(text, 0);
                         },
                         pasteCode(text, startIdx) {
                             const cleaned = text.replace(/[^0-9]/g, '');
                             for (let i = 0; i < cleaned.length && (startIdx + i) < 6; i++) {
                                 this.digits[startIdx + i] = cleaned[i];
                             }
                             const nextFocus = Math.min(startIdx + cleaned.length, 5);
                             const target = document.getElementById('digit-' + nextFocus);
                             if (target) target.focus();
                         }
                     }">
                    <label for="digit-0" class="block font-bold text-slate-800 uppercase tracking-widest text-[11px] mb-1">
                        KODE VERIFIKASI EMAIL (6 DIGIT) <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-[11px] text-slate-500 mb-4">
                        Masukkan 6 digit angka yang dikirimkan ke email Anda
                    </p>

                    <!-- Hidden input that carries the full 6-digit string on submit -->
                    <input type="hidden" name="code" id="code" :value="fullCode" required>

                    <!-- Centered 6-Box Row -->
                    <div class="flex items-center justify-center gap-2 sm:gap-2.5 max-w-sm mx-auto" @paste="handlePaste">
                        @for($i = 0; $i < 6; $i++)
                            <input type="text"
                                   id="digit-{{ $i }}"
                                   inputmode="numeric"
                                   maxlength="1"
                                   :value="digits[{{ $i }}]"
                                   @input="handleInput($event, {{ $i }})"
                                   @keydown="handleKeydown($event, {{ $i }})"
                                   class="w-10 h-14 sm:w-12 sm:h-16 text-center text-2xl sm:text-3xl font-extrabold font-mono rounded-xl border-2 transition shadow-sm select-all focus:outline-none focus:ring-2 focus:ring-[#c29b53]/40 placeholder:text-slate-300"
                                   :class="digits[{{ $i }}] ? 'border-[#c29b53] bg-amber-50/50 text-slate-900 ring-1 ring-[#c29b53]/40' : 'border-slate-300 bg-white text-slate-800 hover:border-slate-400 focus:border-[#c29b53]'"
                                   placeholder="{{ $i + 1 }}">
                        @endfor
                    </div>

                    <p class="text-[10px] text-slate-400 mt-3 font-mono">
                        Kode berlaku 15 menit &bull; Anda juga dapat menempelkan (paste) kode langsung
                    </p>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full mt-2 py-3.5 bg-[#1a2332] hover:bg-[#233044] text-[#c29b53] hover:text-white font-bold uppercase tracking-wider text-xs rounded-xl transition duration-200 shadow-lg flex items-center justify-center gap-2 border border-[#c29b53]/40">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                    <span>Verifikasi Kode &amp; Lanjutkan &rarr;</span>
                </button>
            </form>

            <!-- Resend Link -->
            <div class="mt-6 pt-5 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600">
                <span>Belum menerima kode verifikasi?</span>
                <a href="{{ route('password.request') }}" class="font-bold text-[#c29b53] hover:underline">
                    Kirim Ulang Kode &rarr;
                </a>
            </div>

        </div>

        <!-- Back Link -->
        <div class="mt-6 text-center">
            <a href="{{ route('customer.login') }}"
               class="text-xs text-slate-300 hover:text-[#c29b53] transition font-medium inline-flex items-center gap-1.5">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Kembali ke Halaman Masuk</span>
            </a>
        </div>

    </div>
</section>

@endsection
