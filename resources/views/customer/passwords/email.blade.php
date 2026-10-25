@extends('layouts.app')

@section('title', 'Pembaruan Kata Sandi — enzo')

@section('content')

<!-- ========================================================
     PASSWORD RESET REQUEST (EMAIL VERIFICATION CODE)
========================================================= -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden py-24 sm:py-32">
    <!-- Clean Architectural Twilight Background -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/ptmkp_hero_clean.jpg') }}"
             alt="Enzo Password Recovery"
             class="w-full h-full object-cover object-center filter brightness-50">
        <div class="absolute inset-0 bg-slate-950/75"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1d] via-slate-950/50 to-[#0a0f1d]"></div>
    </div>

    <!-- Request Container -->
    <div class="relative z-10 w-full max-w-md mx-auto px-4 sm:px-6">
        
        <!-- Header Branding -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#1a2332]/90 border border-[#c29b53]/40 text-[#c29b53] text-xs font-bold uppercase tracking-wider mb-4 shadow-lg backdrop-blur-md">
                <i data-lucide="key-round" class="w-4 h-4 text-[#c29b53]"></i>
                <span>Verifikasi Email Mandiri</span>
            </div>
            <h1 class="font-sans text-2xl sm:text-3xl font-extrabold text-white uppercase tracking-wider">
                Pembaruan <span class="text-[#c29b53]">Kata Sandi</span>
            </h1>
            <p class="text-xs text-slate-300 mt-1 font-light leading-relaxed">
                Masukkan alamat email terdaftar akun ENZO Anda. Kode verifikasi 6 digit akan dikirimkan langsung ke email Anda.
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

            <!-- Request Code Form -->
            <form action="{{ route('password.email') }}" method="POST" class="space-y-4 text-xs">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">
                        Alamat Email Akun Terdaftar <span class="text-rose-500">*</span>
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
                    <p class="text-[11px] text-slate-500 mt-1.5 leading-relaxed">
                        Sistem keamanan kami akan menerbitkan kode verifikasi 6 digit yang berlaku selama 15 menit.
                    </p>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full mt-4 py-3.5 bg-[#1a2332] hover:bg-[#233044] text-[#c29b53] hover:text-white font-bold uppercase tracking-wider text-xs rounded-xl transition duration-200 shadow-lg flex items-center justify-center gap-2 border border-[#c29b53]/40">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    <span>Kirim Kode Verifikasi ke Email</span>
                </button>
            </form>

            <!-- Already have code? -->
            <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-600">
                    Sudah memiliki kode verifikasi dari email?
                    <a href="{{ route('password.verify') }}" class="font-bold text-[#c29b53] hover:underline ml-1">
                        Masukkan Kode &rarr;
                    </a>
                </p>
            </div>

        </div>

        <!-- Back to Login -->
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
