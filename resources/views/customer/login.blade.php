@extends('layouts.app')

@section('title', 'Masuk Akun — enzo building construction and interior')

@section('content')

<!-- ========================================================
     CUSTOMER LOGIN (PT MKP Mockup Style)
========================================================= -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden py-24 sm:py-32">
    <!-- Clean Architectural Twilight Background -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/ptmkp_hero_clean.jpg') }}"
             alt="Enzo Customer Portal"
             class="w-full h-full object-cover object-center filter brightness-50">
        <div class="absolute inset-0 bg-slate-950/75"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1d] via-slate-950/50 to-[#0a0f1d]"></div>
    </div>

    <!-- Login Container -->
    <div class="relative z-10 w-full max-w-md mx-auto px-4 sm:px-6">
        
        <!-- Header Branding -->
        <div class="text-center mb-8">
            <h1 class="font-sans text-2xl sm:text-3xl font-extrabold text-white uppercase tracking-wider">
                Masuk <span class="text-[#c29b53]">Akun</span>
            </h1>
            <p class="text-xs text-slate-300 mt-2 font-light">
                Pantau progres pembangunan, riwayat tender, dan dokumen proyek Anda
            </p>
        </div>

        <!-- Floating White Card -->
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 p-8 sm:p-10">
            
            <!-- Switcher Tabs (Masuk vs Daftar) -->
            <div class="flex items-center rounded-xl bg-slate-100 p-1 mb-6 border border-slate-200">
                <a href="{{ route('customer.login') }}"
                   class="w-1/2 py-2 text-center text-xs font-bold rounded-lg bg-[#c29b53] text-white shadow-sm transition">
                    Masuk
                </a>
                <a href="{{ route('customer.register') }}"
                   class="w-1/2 py-2 text-center text-xs font-bold rounded-lg text-slate-600 hover:text-slate-900 transition">
                    Daftar
                </a>
            </div>

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

            <!-- Google Sign-In Button -->
            <a href="{{ route('auth.google.redirect') }}"
               class="w-full py-3 px-4 bg-white hover:bg-slate-50 border border-slate-300 hover:border-slate-400 text-slate-700 font-bold text-xs rounded-xl shadow-sm hover:shadow transition duration-200 flex items-center justify-center gap-3 group mb-5">
                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
                <span class="tracking-wide">Lanjutkan dengan Google</span>
            </a>

            <!-- Divider -->
            <div class="relative flex items-center justify-center mb-5">
                <div class="border-t border-slate-200 w-full"></div>
                <span class="bg-white px-3 text-[10px] uppercase tracking-widest font-bold text-slate-400 select-none whitespace-nowrap">Atau Masuk Dengan Email</span>
                <div class="border-t border-slate-200 w-full"></div>
            </div>

            <!-- Login Form -->
            <form action="{{ route('customer.login.submit') }}" method="POST" class="space-y-4 text-xs">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">
                        Alamat Email Terdaftar <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </div>
                        <input type="email" name="email" id="email" required autofocus
                               value="{{ old('email') }}"
                               placeholder="nama@email.com"
                               class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs font-medium focus:bg-white focus:outline-none focus:border-[#c29b53] focus:ring-1 focus:ring-[#c29b53] transition">
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">
                        Kata Sandi (Password) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </div>
                        <input type="password" name="password" id="password" required
                               placeholder="••••••••••••"
                               class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs font-medium focus:bg-white focus:outline-none focus:border-[#c29b53] focus:ring-1 focus:ring-[#c29b53] transition">
                    </div>
                </div>

                <!-- Remember Me & Forgot Password Link -->
                <div class="flex items-center justify-between text-[11px] pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600 font-medium select-none">
                        <input type="checkbox" name="remember" value="1"
                               class="rounded border-slate-300 text-[#c29b53] focus:ring-[#c29b53]">
                        <span>Ingat sesi saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-[#c29b53] hover:text-[#ad8741] font-bold hover:underline transition">
                        Lupa Kata Sandi?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full mt-2 py-3.5 bg-[#1a2332] hover:bg-[#233044] text-[#c29b53] hover:text-white font-bold uppercase tracking-wider text-xs rounded-xl transition duration-200 shadow-lg flex items-center justify-center gap-2 border border-[#c29b53]/40">
                    <i data-lucide="log-in" class="w-4 h-4"></i>
                    <span>Masuk</span>
                </button>
            </form>

            <!-- Registration Callout -->
            <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-600">
                    Belum memiliki akun klien ENZO?
                    <a href="{{ route('customer.register') }}" class="font-bold text-[#c29b53] hover:underline ml-1">
                        Daftar Akun Baru &rarr;
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
