<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'enzo — building construction and interior')</title>
    <meta name="description" content="@yield('meta_description', 'Your premier partner for building construction and interior architectural excellence across sectors.')">

    <!-- Google Fonts: Montserrat & Plus Jakarta Sans for crisp modern luxury typography (matching Home) -->
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
                        cinzel: ['"Plus Jakarta Sans"', '"Montserrat"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        [x-cloak] { display: none !important; }
        .gold-color { color: #c29b53; }
        .bg-gold { background-color: #c29b53; }
        .border-gold { border-color: #c29b53; }
        .font-cinzel { font-family: 'Plus Jakarta Sans', 'Montserrat', sans-serif; }
        
        /* Smooth transitions */
        .card-shadow {
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.12);
        }

        .glass-panel {
            background-color: rgba(11, 18, 32, 0.82);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(51, 65, 85, 0.7);
        }

        .gold-gradient-text {
            background: linear-gradient(135deg, #fcd34d 0%, #c29b53 50%, #b45309 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Elegant Construction Table Styling */
        .table-elegant th {
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-size: 0.72rem;
            font-weight: 700;
            color: #cbd5e1;
            padding: 1rem 1.25rem;
            background: rgba(10, 16, 28, 0.95);
            border-bottom: 1px solid rgba(71, 85, 105, 0.8);
        }
        .table-elegant td {
            padding: 1rem 1.25rem;
            font-size: 0.8rem;
            border-bottom: 1px solid rgba(51, 65, 85, 0.4);
            color: #e2e8f0;
        }
        .table-elegant tr:hover td {
            background: rgba(30, 41, 59, 0.5);
        }
    </style>
    @stack('styles')
</head>
<body class="@yield('body_class', 'bg-slate-50 text-slate-800') font-sans antialiased selection:bg-[#c29b53] selection:text-white min-h-screen flex flex-col">

    <!-- Main Navigation Bar (PT MKP Mockup Style Enhanced) -->
    <header x-data="{ mobileOpen: false, scrolled: false }"
            @scroll.window="scrolled = (window.pageYOffset > 30)"
            :class="scrolled ? 'bg-[#0f172a]/95 backdrop-blur-md shadow-xl py-3.5' : 'bg-[#0a0f1d]/85 backdrop-blur-sm py-5'"
            class="fixed top-0 inset-x-0 z-50 transition-all duration-300 border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                
                <!-- Logo & Brand (Official Logo persis sesuai gambar user) -->
                <a href="{{ route('home') }}" class="flex items-center group">
                    <img src="{{ asset('images/enzo_full_logo.png') }}" alt="enzo — building construction and interior"
                         class="h-9 sm:h-10 w-auto object-contain transition-transform duration-200 group-hover:scale-105 filter drop-shadow">
                    <span class="sr-only">enzo — building construction and interior</span>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden lg:flex items-center space-x-7 text-xs font-semibold tracking-wider uppercase">
                    <!-- HOME -->
                    <a href="{{ route('home') }}"
                       class="relative py-1 transition {{ request()->routeIs('home') ? 'text-[#c29b53] font-bold' : 'text-slate-200 hover:text-[#c29b53]' }}">
                        <span>HOME</span>
                        @if(request()->routeIs('home'))
                            <span class="w-1.5 h-1.5 rounded-full bg-[#c29b53] mt-1 absolute -bottom-1 left-1/2 -translate-x-1/2"></span>
                        @endif
                    </a>

                    <!-- PROJECTS -->
                    <a href="{{ route('projects.index') }}"
                       class="relative py-1 transition {{ request()->routeIs('projects.*') ? 'text-[#c29b53] font-bold' : 'text-slate-200 hover:text-[#c29b53]' }}">
                        <span>PROJECTS</span>
                        @if(request()->routeIs('projects.*'))
                            <span class="w-1.5 h-1.5 rounded-full bg-[#c29b53] mt-1 absolute -bottom-1 left-1/2 -translate-x-1/2"></span>
                        @endif
                    </a>

                    <!-- DESIGNS (Poin 2: Referensi Denah & Layout) -->
                    <a href="{{ route('layouts.index') }}"
                       class="relative py-1 transition {{ request()->routeIs('layouts.*') ? 'text-[#c29b53] font-bold' : 'text-slate-200 hover:text-[#c29b53]' }}">
                        <span>DESIGNS</span>
                        @if(request()->routeIs('layouts.*'))
                            <span class="w-1.5 h-1.5 rounded-full bg-[#c29b53] mt-1 absolute -bottom-1 left-1/2 -translate-x-1/2"></span>
                        @endif
                    </a>

                    <!-- SPECS (Poin 3: Spesifikasi Material Komparatif) -->
                    <a href="{{ route('specifications.index') }}"
                       class="relative py-1 transition {{ request()->routeIs('specifications.*') ? 'text-[#c29b53] font-bold' : 'text-slate-200 hover:text-[#c29b53]' }}">
                        <span>SPECS</span>
                        @if(request()->routeIs('specifications.*'))
                            <span class="w-1.5 h-1.5 rounded-full bg-[#c29b53] mt-1 absolute -bottom-1 left-1/2 -translate-x-1/2"></span>
                        @endif
                    </a>

                    <!-- ESTIMATOR (RAB Calculator) -->
                    <a href="{{ route('estimator.index') }}"
                       class="relative py-1 transition {{ request()->routeIs('estimator.*') ? 'text-[#c29b53] font-bold' : 'text-slate-200 hover:text-[#c29b53]' }}">
                        <span>CALCULATOR</span>
                        @if(request()->routeIs('estimator.*'))
                            <span class="w-1.5 h-1.5 rounded-full bg-[#c29b53] mt-1 absolute -bottom-1 left-1/2 -translate-x-1/2"></span>
                        @endif
                    </a>

                    @auth
                    <!-- RFP TENDER (Khusus Pengguna Terdaftar/Login) -->
                    <a href="{{ route('rfp.create') }}"
                       class="relative py-1 transition {{ request()->routeIs('rfp.create') ? 'text-[#c29b53] font-bold' : 'text-slate-200 hover:text-[#c29b53]' }}">
                        <span>RFP TENDER</span>
                        @if(request()->routeIs('rfp.create'))
                            <span class="w-1.5 h-1.5 rounded-full bg-[#c29b53] mt-1 absolute -bottom-1 left-1/2 -translate-x-1/2"></span>
                        @endif
                    </a>

                    {{-- Fitur Tracking dinonaktifkan sementara --}}
                    @endauth

                    <!-- Customer / Admin Account Actions -->
                    @if(Auth::check())
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" title="Admin CMS Portal"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#c29b53] hover:bg-[#ad8741] text-white text-xs font-bold transition shadow-sm">
                                <i data-lucide="shield" class="w-3.5 h-3.5"></i>
                                <span>ADMIN CMS</span>
                            </a>
                        @else
                            <a href="{{ route('customer.dashboard') }}" title="Dashboard Klien"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#1a2332] hover:bg-[#233044] text-[#c29b53] hover:text-white border border-[#c29b53]/40 text-xs font-bold transition shadow-sm">
                                <i data-lucide="user-check" class="w-3.5 h-3.5"></i>
                                <span>KLIEN: {{ Str::limit(Auth::user()->name, 12) }}</span>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('customer.login') }}" title="Masuk atau Daftar Akun Klien"
                           class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-white/10 hover:bg-[#c29b53] text-slate-200 hover:text-white border border-slate-700 hover:border-[#c29b53] text-xs font-bold transition backdrop-blur-sm shadow-sm">
                            <i data-lucide="user" class="w-3.5 h-3.5"></i>
                            <span>MASUK / DAFTAR</span>
                        </a>
                    @endif
                </nav>

                <!-- Mobile Hamburger Button -->
                <div class="flex lg:hidden items-center gap-2">
                    <button @click="mobileOpen = !mobileOpen" type="button" class="p-2 text-white hover:text-[#c29b53] focus:outline-none">
                        <i x-show="!mobileOpen" data-lucide="menu" class="w-6 h-6"></i>
                        <i x-show="mobileOpen" x-cloak data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileOpen" x-cloak x-transition
             class="lg:hidden bg-[#0f172a] border-b border-slate-800 px-6 py-6 space-y-4 text-center">
            <a href="{{ route('home') }}" class="block text-xs font-bold tracking-widest uppercase text-[#c29b53]">HOME</a>
            <a href="{{ route('projects.index') }}" class="block text-xs font-semibold tracking-widest uppercase text-white hover:text-[#c29b53]">PROJECTS</a>
            <a href="{{ route('layouts.index') }}" class="block text-xs font-semibold tracking-widest uppercase text-white hover:text-[#c29b53]">DESIGNS (LAYOUT DENAH)</a>
            <a href="{{ route('specifications.index') }}" class="block text-xs font-semibold tracking-widest uppercase text-white hover:text-[#c29b53]">SPECS MATERIAL RINCI</a>
            <a href="{{ route('estimator.index') }}" class="block text-xs font-semibold tracking-widest uppercase text-white hover:text-[#c29b53]">CALCULATOR RAB</a>
            @auth
            <a href="{{ route('rfp.create') }}" class="block text-xs font-semibold tracking-widest uppercase text-white hover:text-[#c29b53]">RFP TENDER</a>
            {{-- Fitur Tracking dinonaktifkan sementara --}}
            @endauth
            
            @if(Auth::check())
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block text-xs font-bold tracking-widest uppercase text-[#c29b53]">ADMIN CMS PORTAL</a>
                    <form action="{{ route('admin.logout') }}" method="POST" class="block pt-2">
                        @csrf
                        <button type="submit" class="text-xs font-bold uppercase text-rose-400 hover:text-rose-300">KELUAR ADMIN (LOGOUT)</button>
                    </form>
                @else
                    <a href="{{ route('customer.dashboard') }}" class="block text-xs font-bold tracking-widest uppercase text-[#c29b53]">DASHBOARD KLIEN ({{ Auth::user()->name }})</a>
                    <form action="{{ route('customer.logout') }}" method="POST" class="block pt-2">
                        @csrf
                        <button type="submit" class="text-xs font-bold uppercase text-rose-400 hover:text-rose-300">KELUAR KLIEN (LOGOUT)</button>
                    </form>
                @endif
            @else
                <div class="pt-2 border-t border-slate-800">
                    <a href="{{ route('customer.login') }}" class="block text-xs font-bold tracking-widest uppercase text-[#c29b53] py-2 bg-slate-900 rounded-lg">MASUK / DAFTAR AKUN KLIEN</a>
                </div>
            @endif
        </div>
    </header>

    <!-- Global Toast Alert (Flash Message) -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition class="fixed top-24 right-4 z-50 max-w-md bg-emerald-950/95 border border-emerald-500/50 backdrop-blur-md p-4 rounded-lg shadow-2xl text-emerald-200 flex items-start gap-3">
            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-400 shrink-0 mt-0.5"></i>
            <div class="flex-1 text-xs font-medium">{{ session('success') }}</div>
            <button @click="show = false" class="text-emerald-400 hover:text-white"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
    @endif

    <!-- Main Page Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Floating WhatsApp Fast-Response Widget -->
    <div class="fixed bottom-6 right-6 z-40 flex items-center group">
        <a href="https://wa.me/6281348593725?text=Halo%20Tim%20enzo%20building%20construction%20and%20interior,%20saya%20ingin%20berkonsultasi%20mengenai%20rencana%20proyek."
           target="_blank"
           rel="noopener noreferrer"
           aria-label="Konsultasi WhatsApp Fast Response"
           class="relative flex items-center justify-center w-14 h-14 rounded-full bg-emerald-500 hover:bg-emerald-400 text-white shadow-2xl shadow-emerald-500/40 hover:scale-110 active:scale-95 transition-all duration-300">
            <span class="absolute -top-1 -right-1 flex h-4 w-4">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-300 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-4 w-4 bg-emerald-400 text-[9px] font-bold text-slate-900 items-center justify-center">1</span>
            </span>
            <svg class="w-7 h-7 fill-current" viewBox="0 0 24 24">
                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
            </svg>
        </a>
    </div>

    <!-- Global Footer -->
    <footer class="bg-[#0f172a] text-slate-400 pt-16 pb-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                
                <!-- Col 1: Brand -->
                <div class="space-y-4">
                    <a href="{{ route('home') }}" class="inline-block group">
                        <img src="{{ asset('images/enzo_full_logo.png') }}" alt="enzo — building construction and interior"
                             class="h-8 sm:h-9 w-auto object-contain opacity-95 transition-transform duration-200 group-hover:scale-105">
                        <span class="sr-only">enzo — building construction and interior</span>
                    </a>
                    <p class="text-xs text-slate-400 leading-relaxed font-light">
                        Perusahaan kontraktor umum premium spesialis gedung komersial, residensial mewah, struktur baja industri, dan arsitektur berstandar ISO 9001:2015.
                    </p>
                </div>

                <!-- Col 2: Services -->
                <div>
                    <h3 class="text-xs font-bold text-white uppercase tracking-widest mb-4">Layanan</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('projects.index', ['category' => 'commercial']) }}" class="hover:text-[#c29b53] transition">Civil Work & Gedung</a></li>
                        <li><a href="{{ route('projects.index', ['category' => 'residential']) }}" class="hover:text-[#c29b53] transition">Design & Build Residensial</a></li>
                        <li><a href="{{ route('projects.index', ['category' => 'industrial']) }}" class="hover:text-[#c29b53] transition">Industrial Steel & Gudang</a></li>
                        <li><a href="{{ route('projects.index') }}" class="hover:text-[#c29b53] transition">Commercial Interior & Fit-Out</a></li>
                    </ul>
                </div>

                <!-- Col 3: Links -->
                <div>
                    <h3 class="text-xs font-bold text-white uppercase tracking-widest mb-4">Fitur Portal</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('estimator.index') }}" class="text-[#c29b53] hover:underline font-medium">Kalkulator Biaya (RAB)</a></li>
                        <li><a href="{{ route('layouts.index') }}" class="hover:text-white transition">Katalog Desain & Denah</a></li>
                        <li><a href="{{ route('specifications.index') }}" class="hover:text-white transition">Spesifikasi Material</a></li>
                        @auth
                        <li><a href="{{ route('rfp.create') }}" class="hover:text-white transition">Formulir Tender (RFP)</a></li>
                        {{-- Fitur Tracking dinonaktifkan sementara --}}
                        @endauth
                    </ul>
                </div>

                <!-- Col 4: Contact -->
                <div>
                    <h3 class="text-xs font-bold text-white uppercase tracking-widest mb-4">Kontak Resmi</h3>
                    <div class="space-y-2 text-xs text-slate-400 font-light">
                        <p>Jalan Karya Baru No. 56A, Parit Tokaya, Pontianak Selatan</p>
                        <p class="text-white font-medium">Telp: 081348593725</p>
                        <p>Email: enzo.ng7786@gmail.com</p>
                    </div>
                </div>

            </div>

            <div class="pt-8 border-t border-slate-800 text-center text-xs text-slate-500 font-light">
                &copy; {{ date('Y') }} enzo — building construction and interior. All Rights Reserved.
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
