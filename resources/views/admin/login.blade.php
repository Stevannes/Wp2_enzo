<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Portal Admin & Executive Security Gateway — enzo</title>
    <meta name="robots" content="noindex, nofollow">

    <!-- Google Fonts: Montserrat & Plus Jakarta Sans (Matching Home Landing Page) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ptmkp: {
                            gold: '#c29b53',
                            goldHover: '#ad8741',
                            darkCard: '#1a2332',
                            darkCardHover: '#233044',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', '"Montserrat"', 'sans-serif'],
                        serif: ['"Plus Jakarta Sans"', '"Montserrat"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-[#0a0f1d] text-slate-100 font-sans antialiased min-h-screen flex flex-col justify-center items-center relative overflow-x-hidden selection:bg-[#c29b53] selection:text-white">

    <!-- Clean Architectural Twilight Background (Identical to Home Landing Page Hero) -->
    <div class="fixed inset-0 z-0">
        <img src="{{ asset('images/ptmkp_hero_clean.jpg') }}"
             alt="Enzo Security Gateway Background"
             class="w-full h-full object-cover object-center filter brightness-40">
        <div class="absolute inset-0 bg-[#0a0f1d]/85"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1d] via-[#0a0f1d]/60 to-[#0a0f1d]"></div>
    </div>

    <!-- Main Gateway Container -->
    <div class="relative z-10 w-full max-w-md mx-auto px-4 sm:px-6 py-12">
        
        <!-- Header Brand Badge & Title -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center group mb-5">
                <img src="{{ asset('images/enzo_full_logo.png') }}" alt="enzo — building construction and interior"
                     class="h-12 sm:h-14 w-auto object-contain transition-transform duration-200 group-hover:scale-105 filter drop-shadow">
                <span class="sr-only">enzo — building construction and interior</span>
            </a>

            <div>
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#1a2332]/95 border border-[#c29b53]/40 text-[#c29b53] text-xs font-bold uppercase tracking-wider mb-3 shadow-lg backdrop-blur-md">
                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                    <span>Executive Security Gateway</span>
                </div>
            </div>

            <h1 class="font-sans text-2xl sm:text-3xl font-extrabold text-white tracking-wider lowercase">
                Portal Admin <span class="text-[#c29b53]">enzo</span>
            </h1>
            <p class="text-xs text-slate-300 mt-1.5 font-light">
                Akses terbatas khusus Administrator & Direksi berwenang
            </p>
        </div>

        <!-- Floating Card (Matching Home Floating Container Aesthetic) -->
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 p-8 sm:p-10 text-slate-900">
            
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
                        <i data-lucide="shield-alert" class="w-4 h-4 text-rose-600"></i>
                        <span>Peringatan Keamanan</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 font-medium">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5 text-xs">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">
                        Alamat Email Resmi Admin
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </div>
                        <input type="email" name="email" id="email" required autofocus
                               value="{{ old('email') }}"
                               placeholder="enzo.ng7786@gmail.com"
                               autocomplete="email"
                               class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs font-medium focus:bg-white focus:outline-none focus:border-[#c29b53] focus:ring-1 focus:ring-[#c29b53] transition">
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">
                        Kata Sandi (Password)
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </div>
                        <input type="password" name="password" id="password" required
                               placeholder="••••••••••••"
                               autocomplete="current-password"
                               class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs font-medium focus:bg-white focus:outline-none focus:border-[#c29b53] focus:ring-1 focus:ring-[#c29b53] transition">
                    </div>
                </div>

                <!-- Remember Me & Security Policy Note -->
                <div class="flex items-center justify-between text-[11px]">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600 font-medium select-none">
                        <input type="checkbox" name="remember" value="1"
                               class="rounded border-slate-300 text-[#c29b53] focus:ring-[#c29b53]">
                        <span>Ingat sesi browser ini</span>
                    </label>
                    <span class="text-slate-400 font-mono text-[10px]">Anti-Brute Force (5x)</span>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full py-3.5 bg-[#1a2332] hover:bg-[#233044] text-[#c29b53] hover:text-white font-bold uppercase tracking-wider text-xs rounded-xl transition duration-200 shadow-lg flex items-center justify-center gap-2 border border-[#c29b53]/40">
                    <i data-lucide="key" class="w-4 h-4"></i>
                    <span>Verifikasi & Masuk Dashboard</span>
                </button>
            </form>

            <!-- Security Trust Badges -->
            <div class="mt-8 pt-6 border-t border-slate-100 grid grid-cols-2 gap-3 text-[10px] text-slate-500 font-medium text-center">
                <div class="flex items-center justify-center gap-1.5 bg-slate-50 p-2 rounded-lg border border-slate-200">
                    <i data-lucide="shield" class="w-3.5 h-3.5 text-[#c29b53]"></i>
                    <span>256-Bit SSL Secured</span>
                </div>
                <div class="flex items-center justify-center gap-1.5 bg-slate-50 p-2 rounded-lg border border-slate-200">
                    <i data-lucide="activity" class="w-3.5 h-3.5 text-emerald-600"></i>
                    <span>Real-Time Audit Log</span>
                </div>
            </div>

        </div>

        <!-- Back to Home Link -->
        <div class="mt-6 text-center">
            <a href="{{ route('home') }}"
               class="text-xs text-slate-300 hover:text-[#c29b53] transition font-medium inline-flex items-center gap-1.5">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Kembali ke Beranda Publik ENZO</span>
            </a>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>
