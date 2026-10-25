@extends('layouts.app')

@section('title', 'Daftar Akun Klien Baru — enzo building construction and interior')

@section('content')

<!-- ========================================================
     CUSTOMER REGISTRATION (PT MKP Mockup Style)
========================================================= -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden py-24 sm:py-32">
    <!-- Clean Architectural Twilight Background -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/ptmkp_hero_clean.jpg') }}"
             alt="Enzo Customer Registration"
             class="w-full h-full object-cover object-center filter brightness-50">
        <div class="absolute inset-0 bg-slate-950/75"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1d] via-slate-950/50 to-[#0a0f1d]"></div>
    </div>

    <!-- Register Container -->
    <div class="relative z-10 w-full max-w-lg mx-auto px-4 sm:px-6">
        
        <!-- Header Branding -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#1a2332]/90 border border-[#c29b53]/40 text-[#c29b53] text-xs font-bold uppercase tracking-wider mb-4 shadow-lg backdrop-blur-md">
                <i data-lucide="user-plus" class="w-4 h-4 text-[#c29b53]"></i>
                <span>Registrasi Akun Klien Baru</span>
            </div>
            <h1 class="font-sans text-2xl sm:text-3xl font-extrabold text-white uppercase tracking-wider">
                Daftar <span class="text-[#c29b53]">Akun Klien</span>
            </h1>
            <p class="text-xs text-slate-300 mt-1 font-light">
                Kelola tender konstruksi, koordinasi survey lapangan, dan pantau progres mandor secara terpusat
            </p>
        </div>

        <!-- Floating White Card -->
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 p-8 sm:p-10">
            
            <!-- Switcher Tabs (Masuk vs Daftar) -->
            <div class="flex items-center rounded-xl bg-slate-100 p-1 mb-6 border border-slate-200">
                <a href="{{ route('customer.login') }}"
                   class="w-1/2 py-2 text-center text-xs font-bold rounded-lg text-slate-600 hover:text-slate-900 transition">
                    Masuk
                </a>
                <a href="{{ route('customer.register') }}"
                   class="w-1/2 py-2 text-center text-xs font-bold rounded-lg bg-[#c29b53] text-white shadow-sm transition">
                    Daftar
                </a>
            </div>

            <!-- Errors Alert -->
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

            <!-- Google Sign-Up Button -->
            <a href="{{ route('auth.google.redirect') }}"
               class="w-full py-3 px-4 bg-white hover:bg-slate-50 border border-slate-300 hover:border-slate-400 text-slate-700 font-bold text-xs rounded-xl shadow-sm hover:shadow transition duration-200 flex items-center justify-center gap-3 group mb-5">
                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
                <span class="tracking-wide">Daftar Lebih Cepat dengan Google</span>
            </a>

            <!-- Divider -->
            <div class="relative flex items-center justify-center mb-5">
                <div class="border-t border-slate-200 w-full"></div>
                <span class="bg-white px-3 text-[10px] uppercase tracking-widest font-bold text-slate-400 select-none whitespace-nowrap">Atau Daftar Dengan Data Lengkap</span>
                <div class="border-t border-slate-200 w-full"></div>
            </div>

            <!-- Registration Form with Live Steam-Style Password Checklist -->
            <form action="{{ route('customer.register.submit') }}" method="POST" class="space-y-4 text-xs"
                  x-data="{
                      password: '',
                      passwordConfirm: '',
                      get hasLength() { return this.password.length >= 8; },
                      get hasNumber() { return /\d/.test(this.password); },
                      get hasSymbol() { return /[\W_]/.test(this.password); },
                      get isMatched() { return this.password.length > 0 && this.password === this.passwordConfirm; },
                      get canSubmit() { return this.hasLength && this.hasNumber && this.hasSymbol && this.isMatched; }
                  }"
                  @submit="if (!canSubmit) { $event.preventDefault(); return false; }">
                @csrf

                <!-- Anti-Bot Security Honeypot (Hidden) -->
                <div class="hidden" aria-hidden="true" style="display:none !important; position:absolute; left:-9999px;">
                    <label for="website_hp">Leave empty</label>
                    <input type="text" name="website_hp" id="website_hp" value="" tabindex="-1" autocomplete="off">
                </div>

                <!-- Full Name -->
                <div>
                    <label for="name" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">
                        Nama Lengkap Pemilik / PIC <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </div>
                        <input type="text" name="name" id="name" required autofocus
                               value="{{ old('name') }}"
                               placeholder="Contoh: Budi Santoso"
                               class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs font-medium focus:bg-white focus:outline-none focus:border-[#c29b53] focus:ring-1 focus:ring-[#c29b53] transition">
                    </div>
                </div>

                <!-- Email & Phone Number Grid (Mandatory Dual Identifiers) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">
                            Alamat Email Aktif <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="mail" class="w-4 h-4"></i>
                            </div>
                            <input type="email" name="email" id="email" required
                                   value="{{ old('email') }}"
                                   placeholder="nama@email.com"
                                   autocomplete="email"
                                   class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs font-medium focus:bg-white focus:outline-none focus:border-[#c29b53] focus:ring-1 focus:ring-[#c29b53] transition">
                        </div>
                    </div>

                    <!-- Phone Number Input -->
                    <div>
                        <label for="phone_number" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">
                            Nomor WhatsApp / HP <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="phone" class="w-4 h-4"></i>
                            </div>
                            <input type="tel" name="phone_number" id="phone_number" required
                                   value="{{ old('phone_number') }}"
                                   placeholder="081234567890"
                                   inputmode="numeric"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                   class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs font-medium focus:bg-white focus:outline-none focus:border-[#c29b53] focus:ring-1 focus:ring-[#c29b53] transition">
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1">Cukup masukkan angka saja tanpa tanda hubung (-)</p>
                    </div>
                </div>

                <!-- Company Name (Optional) -->
                <div>
                    <label for="company_name" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">
                        Nama Perusahaan / Instansi <span class="text-slate-400 font-normal">(Opsional)</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="building" class="w-4 h-4"></i>
                        </div>
                        <input type="text" name="company_name" id="company_name"
                               value="{{ old('company_name') }}"
                               placeholder="Contoh: PT Graha Konstruksi Abadi (jika proyek instansi)"
                               class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs font-medium focus:bg-white focus:outline-none focus:border-[#c29b53] focus:ring-1 focus:ring-[#c29b53] transition">
                    </div>
                </div>

                <!-- Password & Confirmation Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">
                            Kata Sandi <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="lock" class="w-4 h-4"></i>
                            </div>
                            <input type="password" name="password" id="password" required
                                   x-model="password"
                                   placeholder="Min. 8 karakter, angka & simbol"
                                   class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs font-medium focus:bg-white focus:outline-none focus:border-[#c29b53] focus:ring-1 focus:ring-[#c29b53] transition">
                        </div>
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">
                            Ulangi Kata Sandi <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="shield-check" class="w-4 h-4"></i>
                            </div>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                   x-model="passwordConfirm"
                                   placeholder="Ulangi kata sandi"
                                   class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs font-medium focus:bg-white focus:outline-none focus:border-[#c29b53] focus:ring-1 focus:ring-[#c29b53] transition">
                        </div>
                    </div>
                </div>

                <!-- Steam-Style Password Checklist -->
                <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 space-y-2 text-[11px]">
                    <div class="font-bold text-slate-700 flex items-center justify-between">
                        <span class="flex items-center gap-1.5">
                            <i data-lucide="shield" class="w-3.5 h-3.5 text-[#c29b53]"></i>
                            <span>Standar Keamanan Kata Sandi (Kuat Seperti Steam):</span>
                        </span>
                        <span class="font-mono text-[10px] text-slate-400">Standar Proteksi Maksimal</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 pt-1 font-medium">
                        <div class="flex items-center gap-1.5" :class="hasLength ? 'text-emerald-600 font-bold' : 'text-slate-500'">
                            <span class="w-4 h-4 rounded-full flex items-center justify-center text-[10px] shrink-0"
                                  :class="hasLength ? 'bg-emerald-100 text-emerald-700 font-bold' : 'bg-slate-200 text-slate-500'">✓</span>
                            <span>Min. 8 Karakter</span>
                        </div>
                        <div class="flex items-center gap-1.5" :class="hasNumber ? 'text-emerald-600 font-bold' : 'text-slate-500'">
                            <span class="w-4 h-4 rounded-full flex items-center justify-center text-[10px] shrink-0"
                                  :class="hasNumber ? 'bg-emerald-100 text-emerald-700 font-bold' : 'bg-slate-200 text-slate-500'">✓</span>
                            <span>Ada Angka (0-9)</span>
                        </div>
                        <div class="flex items-center gap-1.5" :class="hasSymbol ? 'text-emerald-600 font-bold' : 'text-slate-500'">
                            <span class="w-4 h-4 rounded-full flex items-center justify-center text-[10px] shrink-0"
                                  :class="hasSymbol ? 'bg-emerald-100 text-emerald-700 font-bold' : 'bg-slate-200 text-slate-500'">✓</span>
                            <span>Simbol Unik (?, !, @, #, $)</span>
                        </div>
                    </div>

                    <!-- Live Dynamic Warning when symbol or match is missing -->
                    <div x-show="password.length > 0 && !hasSymbol" x-cloak class="pt-1 text-[11px] text-amber-700 font-semibold flex items-center gap-1.5">
                        <i data-lucide="alert-circle" class="w-3.5 h-3.5 text-amber-600 shrink-0"></i>
                        <span>Kata sandi belum memiliki simbol unik. Wajib sertakan salah satu simbol seperti: ! @ # $ % ? & *</span>
                    </div>

                    <div x-show="passwordConfirm.length > 0 && !isMatched" x-cloak class="pt-0.5 text-[11px] text-rose-600 font-semibold flex items-center gap-1.5">
                        <i data-lucide="alert-triangle" class="w-3.5 h-3.5 text-rose-600 shrink-0"></i>
                        <span>Ulangi kata sandi belum sama dengan kata sandi di atas.</span>
                    </div>
                </div>

                <!-- Terms and Privacy Note -->
                <div class="text-[11px] text-slate-500 pt-1 leading-relaxed">
                    Dengan mendaftar, Anda menyetujui standar kerahasiaan data tender & kebijakan privasi perlindungan hunian enzo building construction and interior.
                </div>

                <!-- Submit Button (Locked until all requirements are met) -->
                <button type="submit"
                        :disabled="!canSubmit"
                        :class="!canSubmit ? 'opacity-50 cursor-not-allowed bg-slate-300 text-slate-500 border-slate-300 shadow-none' : 'bg-[#1a2332] hover:bg-[#233044] text-[#c29b53] hover:text-white border-[#c29b53]/40 shadow-lg cursor-pointer'"
                        class="w-full mt-2 py-3.5 font-bold uppercase tracking-wider text-xs rounded-xl transition duration-200 flex items-center justify-center gap-2 border">
                    <i data-lucide="user-check" class="w-4 h-4"></i>
                    <span x-text="canSubmit ? 'Daftar Akun Klien Sekarang' : (password.length > 0 && !hasSymbol ? 'Wajib Tambahkan Simbol Unik' : 'Lengkapi Syarat Kata Sandi Dahulu')"></span>
                </button>
            </form>

            <!-- Already have an account callout -->
            <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-600">
                    Sudah memiliki akun klien sebelumnya?
                    <a href="{{ route('customer.login') }}" class="font-bold text-[#c29b53] hover:underline ml-1">
                        Masuk di Sini &rarr;
                    </a>
                </p>
            </div>

        </div>

        <!-- Back Link -->
        <div class="mt-6 text-center">
            <a href="{{ route('home') }}"
               class="text-xs text-slate-300 hover:text-[#c29b53] transition font-medium inline-flex items-center gap-1.5">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Kembali ke Beranda ENZO</span>
            </a>
        </div>

    </div>
</section>

@endsection
