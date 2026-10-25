<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin CMS — ENZO Executive Lead Engine')</title>
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

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        [x-cloak] { display: none !important; }
        .gold-color { color: #c29b53; }
        .bg-gold { background-color: #c29b53; }
        .border-gold { border-color: #c29b53; }
        
        /* Custom scrollbar for admin panels */
        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }
        ::-webkit-scrollbar-track {
            background: #0a0f1d;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #c29b53;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-[#0a0f1d] text-slate-100 font-sans antialiased selection:bg-[#c29b53] selection:text-white min-h-screen flex flex-col"
      x-data="{ sidebarOpen: false }">

    <!-- ========================================================
         EXECUTIVE CMS TOPBAR (Dedicated to Admin Portal)
    ========================================================= -->
    <header class="sticky top-0 z-40 bg-[#0d1424]/95 backdrop-blur-md border-b border-slate-800/80 shadow-lg">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Left: Mobile Toggle & Admin Brand -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <!-- Mobile Hamburger -->
                    <button type="button"
                            @click="sidebarOpen = !sidebarOpen"
                            class="lg:hidden p-2 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition"
                            aria-label="Toggle Sidebar Menu">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>

                    <!-- Brand Logo -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                        <img src="{{ asset('images/enzo_full_logo.png') }}" alt="enzo CMS"
                             class="h-8 w-auto object-contain transition-transform duration-200 group-hover:scale-105 filter drop-shadow">
                        <div class="hidden sm:flex flex-col">
                            <span class="px-2 py-0.5 rounded text-[10px] font-extrabold uppercase tracking-wider bg-[#1a2332] text-[#c29b53] border border-[#c29b53]/40 w-fit">
                                CMS PORTAL
                            </span>
                            <span class="text-[10px] tracking-wider text-slate-400 font-medium leading-tight mt-0.5">Executive Tender Engine</span>
                        </div>
                    </a>
                </div>

                <!-- Right: Quick Actions & Profile -->
                <div class="flex items-center gap-3 sm:gap-4">
                    
                    <!-- Direct Link to Public Website -->
                    <a href="{{ route('home') }}" target="_blank"
                       class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-800/80 hover:bg-slate-800 text-slate-200 hover:text-white text-xs font-semibold border border-slate-700/80 transition shadow-sm"
                       title="Buka Website Publik ENZO di tab baru">
                        <i data-lucide="external-link" class="w-3.5 h-3.5 text-[#c29b53]"></i>
                        <span>Web Publik</span>
                    </a>

                    <!-- Status Indicator Badge -->
                    <div class="hidden md:inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#1a2332] border border-emerald-500/30 text-emerald-400 text-[11px] font-semibold">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Portal Terenkripsi</span>
                    </div>

                    <!-- Admin User Profile Pill -->
                    @if(Auth::check())
                        <div class="flex items-center gap-3 pl-3 border-l border-slate-800">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-[#c29b53] to-[#ad8741] text-white flex items-center justify-center font-bold text-xs uppercase shadow-sm">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                                <div class="hidden xl:flex flex-col text-left">
                                    <span class="text-xs font-bold text-white leading-tight">{{ Auth::user()->name }}</span>
                                    <span class="text-[10px] text-[#c29b53] font-semibold leading-tight capitalize">
                                        {{ Auth::user()->role === 'admin' ? 'Administrator' : Auth::user()->role }}
                                    </span>
                                </div>
                            </div>

                            <!-- Logout Form -->
                            <form action="{{ route('admin.logout') }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit"
                                        title="Keluar dari sesi Administrator dengan aman"
                                        class="p-2 rounded-lg bg-rose-950/40 hover:bg-rose-900/60 text-rose-300 hover:text-white border border-rose-800/40 transition">
                                    <i data-lucide="log-out" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- ========================================================
         MAIN BODY WRAPPER (Dedicated Sidebar + Workspace)
    ========================================================= -->
    <div class="flex-1 flex overflow-hidden">
        
        <!-- ====================================================
             DESKTOP DEDICATED SIDEBAR
        ==================================================== -->
        <aside class="w-64 bg-[#0d1424] border-r border-slate-800/80 p-4 shrink-0 hidden lg:flex flex-col justify-between">
            <div class="space-y-6">
                
                <!-- Section 1: Ringkasan & Pipeline -->
                <div>
                    <div class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-[#c29b53] mb-2.5">
                        Lead & Tender Pipeline
                    </div>
                    <nav class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('admin.dashboard') && !request()->has('status') ? 'bg-[#c29b53] text-white shadow-md' : 'text-slate-300 hover:bg-[#1a2332] hover:text-white' }}">
                            <i data-lucide="layout-dashboard" class="w-4 h-4 {{ request()->routeIs('admin.dashboard') && !request()->has('status') ? 'text-white' : 'text-[#c29b53]' }}"></i>
                            <span>Dashboard Pipeline</span>
                        </a>

                        <a href="{{ route('admin.dashboard', ['status' => 'submitted']) }}"
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->query('status') === 'submitted' ? 'bg-[#c29b53] text-white shadow-md' : 'text-slate-300 hover:bg-[#1a2332] hover:text-white' }}">
                            <div class="flex items-center gap-3">
                                <i data-lucide="inbox" class="w-4 h-4 {{ request()->query('status') === 'submitted' ? 'text-white' : 'text-[#c29b53]' }}"></i>
                                <span>RFP Baru Masuk</span>
                            </div>
                        </a>

                        <a href="{{ route('admin.dashboard', ['status' => 'survey_scheduled']) }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->query('status') === 'survey_scheduled' ? 'bg-[#c29b53] text-white shadow-md' : 'text-slate-300 hover:bg-[#1a2332] hover:text-white' }}">
                            <i data-lucide="calendar" class="w-4 h-4 {{ request()->query('status') === 'survey_scheduled' ? 'text-white' : 'text-[#c29b53]' }}"></i>
                            <span>Survey Terjadwal</span>
                        </a>

                        <a href="{{ route('admin.dashboard', ['status' => 'deal']) }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->query('status') === 'deal' ? 'bg-[#c29b53] text-white shadow-md' : 'text-slate-300 hover:bg-[#1a2332] hover:text-white' }}">
                            <i data-lucide="check-circle-2" class="w-4 h-4 {{ request()->query('status') === 'deal' ? 'text-white' : 'text-emerald-400]' }}"></i>
                            <span>SPK Deal Kontrak</span>
                        </a>
                    </nav>
                </div>

                <!-- Section 2: Operasional Lapangan & Evaluasi -->
                <div>
                    <div class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-[#c29b53] mb-2.5">
                        Operasional & Lapangan
                    </div>
                    <nav class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}#pipeline-table"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:bg-[#1a2332] hover:text-white transition">
                            <i data-lucide="users" class="w-4 h-4 text-[#c29b53]"></i>
                            <span>Penugasan PIC Staf</span>
                        </a>

                        <a href="{{ route('admin.dashboard') }}#pipeline-table"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:bg-[#1a2332] hover:text-white transition">
                            <i data-lucide="hard-hat" class="w-4 h-4 text-[#c29b53]"></i>
                            <span>Jurnal Mandor Lapangan</span>
                        </a>

                        <a href="{{ route('admin.dashboard') }}#pipeline-table"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:bg-[#1a2332] hover:text-white transition">
                            <i data-lucide="shield-alert" class="w-4 h-4 text-rose-400"></i>
                            <span>Komplain & Garansi</span>
                        </a>
                    </nav>
                </div>

                <!-- Section 3: Katalog & Publikasi -->
                <div>
                    <div class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-[#c29b53] mb-2.5">
                        Etalase Publik
                    </div>
                    <nav class="space-y-1">
                        <a href="{{ route('projects.index') }}" target="_blank"
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:bg-[#1a2332] hover:text-white transition">
                            <div class="flex items-center gap-3">
                                <i data-lucide="building-2" class="w-4 h-4 text-[#c29b53]"></i>
                                <span>Katalog Portofolio</span>
                            </div>
                            <i data-lucide="arrow-up-right" class="w-3.5 h-3.5 text-slate-500"></i>
                        </a>

                        <a href="{{ route('layouts.index') }}" target="_blank"
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:bg-[#1a2332] hover:text-white transition">
                            <div class="flex items-center gap-3">
                                <i data-lucide="compass" class="w-4 h-4 text-[#c29b53]"></i>
                                <span>Katalog Desain Denah</span>
                            </div>
                            <i data-lucide="arrow-up-right" class="w-3.5 h-3.5 text-slate-500"></i>
                        </a>

                        <a href="{{ route('specifications.index') }}" target="_blank"
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:bg-[#1a2332] hover:text-white transition">
                            <div class="flex items-center gap-3">
                                <i data-lucide="layers" class="w-4 h-4 text-[#c29b53]"></i>
                                <span>Matriks Spesifikasi</span>
                            </div>
                            <i data-lucide="arrow-up-right" class="w-3.5 h-3.5 text-slate-500"></i>
                        </a>
                    </nav>
                </div>

            </div>

            <!-- Sidebar Footer Security Badge -->
            <div class="pt-4 border-t border-slate-800/80">
                <div class="p-3.5 rounded-xl bg-[#1a2332]/80 border border-[#c29b53]/30 text-center">
                    <div class="flex items-center justify-center gap-1.5 text-[11px] font-bold text-[#c29b53] uppercase tracking-wider mb-1">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-400"></i>
                        <span>Security Hardened</span>
                    </div>
                    <p class="text-[10px] text-slate-400 font-light leading-relaxed">
                        Anti Brute-Force Rate Limiting & Audit Trail Terproteksi.
                    </p>
                </div>
            </div>
        </aside>

        <!-- ====================================================
             MOBILE SLIDE-OVER DRAWER
        ==================================================== -->
        <div x-cloak x-show="sidebarOpen"
             class="fixed inset-0 z-50 lg:hidden flex"
             role="dialog" aria-modal="true">
            <!-- Backdrop -->
            <div x-show="sidebarOpen"
                 x-transition:enter="transition-opacity ease-linear duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm"></div>

            <!-- Drawer Container -->
            <div x-show="sidebarOpen"
                 x-transition:enter="transition ease-in-out duration-200 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-200 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="relative max-w-xs w-full bg-[#0d1424] p-5 flex flex-col justify-between shadow-2xl border-r border-slate-800 z-10">
                
                <div>
                    <div class="flex items-center justify-between pb-4 border-b border-slate-800 mb-4">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/enzo_full_logo.png') }}" alt="enzo" class="h-6 w-auto">
                            <span class="px-1.5 py-0.5 rounded text-[9px] font-extrabold uppercase tracking-wider bg-[#1a2332] text-[#c29b53] border border-[#c29b53]/40">
                                CMS
                            </span>
                        </div>
                        <button type="button" @click="sidebarOpen = false" class="p-1.5 rounded-lg text-slate-400 hover:text-white">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <nav class="space-y-2 text-xs font-bold">
                        <a href="{{ route('admin.dashboard') }}"
                           @click="sidebarOpen = false"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-[#c29b53] text-white">
                            <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                            <span>Dashboard Pipeline</span>
                        </a>
                        <a href="{{ route('admin.dashboard', ['status' => 'submitted']) }}"
                           @click="sidebarOpen = false"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-[#1a2332]">
                            <i data-lucide="inbox" class="w-4 h-4 text-[#c29b53]"></i>
                            <span>RFP Baru Masuk</span>
                        </a>
                        <a href="{{ route('projects.index') }}" target="_blank"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-[#1a2332]">
                            <i data-lucide="building-2" class="w-4 h-4 text-[#c29b53]"></i>
                            <span>Katalog Portofolio</span>
                        </a>
                        <a href="{{ route('home') }}" target="_blank"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-[#1a2332]">
                            <i data-lucide="external-link" class="w-4 h-4 text-[#c29b53]"></i>
                            <span>Web Publik ENZO</span>
                        </a>
                    </nav>
                </div>

                <div class="pt-4 border-t border-slate-800">
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-rose-900/60 hover:bg-rose-800 text-rose-200 text-xs font-bold transition">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                            <span>Logout Administrator</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- ====================================================
             MAIN EXECUTIVE WORKSPACE (Scrollable Content)
        ==================================================== -->
        <main class="flex-1 overflow-y-auto">
            
            <!-- Global Flash Messages -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-2xl bg-emerald-950/80 border border-emerald-500/50 text-emerald-200 text-xs flex items-center gap-3 shadow-lg backdrop-blur-sm">
                        <div class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                        </div>
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 rounded-2xl bg-rose-950/80 border border-rose-500/50 text-rose-200 text-xs flex items-center gap-3 shadow-lg backdrop-blur-sm">
                        <div class="w-8 h-8 rounded-xl bg-rose-500/20 text-rose-400 flex items-center justify-center shrink-0">
                            <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                        </div>
                        <span class="font-semibold">{{ session('error') }}</span>
                    </div>
                @endif
            </div>

            <!-- Page Injected Content -->
            @yield('content')

            <!-- Dedicated Admin System Footer -->
            <footer class="mt-auto py-6 border-t border-slate-800/80 bg-[#090e1a] text-center text-xs text-slate-500">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-slate-400">ENZO Executive CMS Suite</span>
                        <span>•</span>
                        <span class="text-[11px] text-[#c29b53]">v2.5 Enterprise Architecture</span>
                    </div>
                    <div class="text-[11px] text-slate-500">
                        &copy; {{ date('Y') }} enzo — building construction and interior. Hak cipta dilindungi.
                    </div>
                </div>
            </footer>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
