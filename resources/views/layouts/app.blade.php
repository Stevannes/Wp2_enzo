<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'ENZO Construction — Building Excellence With Precision & Passion')</title>
    <meta name="description" content="@yield('meta_description', 'Your premier partner for high-end construction and architectural excellence across sectors.')">

    <!-- Google Fonts: Montserrat & Plus Jakarta Sans for crisp architectural typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
                        sans: ['"Montserrat"', '"Plus Jakarta Sans"', 'sans-serif'],
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
        
        /* Smooth transitions */
        .card-shadow {
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.12);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased selection:bg-[#c29b53] selection:text-white min-h-screen flex flex-col">

    <!-- Main Navigation Bar (PT MKP Mockup Style) -->
    <header x-data="{ mobileOpen: false, scrolled: false }"
            @scroll.window="scrolled = (window.pageYOffset > 30)"
            :class="scrolled ? 'bg-[#0f172a]/95 backdrop-blur-md shadow-xl py-4' : 'bg-transparent py-6'"
            class="fixed top-0 inset-x-0 z-50 transition-all duration-300 border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                
                <!-- Logo & Brand (Matching PT MKP Mockup) -->
                <a href="{{ route('home') }}" class="flex items-center gap-3.5 group">
                    <!-- Geometric 3D Hexagon/Cube Icon matching Mockup -->
                    <div class="text-white group-hover:text-[#c29b53] transition-colors duration-200">
                        <svg class="w-10 h-10" viewBox="0 0 60 60" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polygon points="30,5 55,19 55,47 30,59 5,47 5,19" stroke="currentColor" stroke-width="3"/>
                            <polyline points="30,5 30,59" stroke="currentColor" stroke-width="2"/>
                            <polyline points="30,33 55,19" stroke="currentColor" stroke-width="2"/>
                            <polyline points="30,33 5,19" stroke="currentColor" stroke-width="2"/>
                            <line x1="14" y1="24" x2="14" y2="42" stroke="currentColor" stroke-width="2"/>
                            <line x1="22" y1="28" x2="22" y2="48" stroke="currentColor" stroke-width="2"/>
                            <line x1="38" y1="28" x2="38" y2="48" stroke="currentColor" stroke-width="2"/>
                            <line x1="46" y1="24" x2="46" y2="42" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-2xl font-black tracking-widest text-white leading-none font-sans">ENZO</span>
                        <span class="text-[11px] tracking-wider text-slate-200 font-medium leading-tight mt-0.5">Construction</span>
                    </div>
                </a>

                <!-- Desktop Nav Links (PT MKP Mockup: HOME, SERVICES, PROJECTS, ABOUT, NEWS, CONTACT) -->
                <nav class="hidden md:flex items-center space-x-8">
                    <!-- HOME (Active with gold dot underneath) -->
                    <a href="{{ route('home') }}"
                       class="relative py-1 flex flex-col items-center text-xs font-bold tracking-widest uppercase transition {{ request()->routeIs('home') ? 'text-[#c29b53]' : 'text-white hover:text-[#c29b53]' }}">
                        <span>HOME</span>
                        @if(request()->routeIs('home'))
                            <span class="w-1 h-1 rounded-full bg-[#c29b53] mt-1 absolute -bottom-1"></span>
                        @endif
                    </a>

                    <!-- SERVICES -->
                    <a href="{{ route('home') }}#services"
                       class="py-1 text-xs font-semibold tracking-widest uppercase text-white hover:text-[#c29b53] transition">
                        SERVICES
                    </a>

                    <!-- PROJECTS -->
                    <a href="{{ route('projects.index') }}"
                       class="relative py-1 flex flex-col items-center text-xs font-semibold tracking-widest uppercase transition {{ request()->routeIs('projects.*') ? 'text-[#c29b53] font-bold' : 'text-white hover:text-[#c29b53]' }}">
                        <span>PROJECTS</span>
                        @if(request()->routeIs('projects.*'))
                            <span class="w-1 h-1 rounded-full bg-[#c29b53] mt-1 absolute -bottom-1"></span>
                        @endif
                    </a>

                    <!-- ABOUT (Why Choose Us) -->
                    <a href="{{ route('home') }}#why-choose-us"
                       class="py-1 text-xs font-semibold tracking-widest uppercase text-white hover:text-[#c29b53] transition">
                        ABOUT
                    </a>

                    <!-- ESTIMATOR (RAB Calculator) -->
                    <a href="{{ route('estimator.index') }}"
                       class="relative py-1 flex flex-col items-center text-xs font-semibold tracking-widest uppercase transition {{ request()->routeIs('estimator.*') ? 'text-[#c29b53] font-bold' : 'text-white hover:text-[#c29b53]' }}">
                        <span>CALCULATOR</span>
                        @if(request()->routeIs('estimator.*'))
                            <span class="w-1 h-1 rounded-full bg-[#c29b53] mt-1 absolute -bottom-1"></span>
                        @endif
                    </a>

                    <!-- RFP TENDER -->
                    <a href="{{ route('rfp.create') }}"
                       class="relative py-1 flex flex-col items-center text-xs font-semibold tracking-widest uppercase transition {{ request()->routeIs('rfp.*') ? 'text-[#c29b53] font-bold' : 'text-white hover:text-[#c29b53]' }}">
                        <span>RFP TENDER</span>
                        @if(request()->routeIs('rfp.*'))
                            <span class="w-1 h-1 rounded-full bg-[#c29b53] mt-1 absolute -bottom-1"></span>
                        @endif
                    </a>

                    <!-- CONTACT -->
                    <a href="https://wa.me/6281348593725" target="_blank"
                       class="py-1 text-xs font-semibold tracking-widest uppercase text-white hover:text-[#c29b53] transition">
                        CONTACT
                    </a>

                    <!-- Admin Portal (Subtle icon/button) -->
                    <a href="{{ route('admin.dashboard') }}" title="Admin CMS Portal"
                       class="text-slate-300 hover:text-[#c29b53] p-1.5 transition">
                        <i data-lucide="shield" class="w-4 h-4"></i>
                    </a>
                </nav>

                <!-- Mobile Hamburger Button -->
                <div class="flex md:hidden items-center gap-2">
                    <button @click="mobileOpen = !mobileOpen" type="button" class="p-2 text-white hover:text-[#c29b53] focus:outline-none">
                        <i x-show="!mobileOpen" data-lucide="menu" class="w-6 h-6"></i>
                        <i x-show="mobileOpen" x-cloak data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileOpen" x-cloak x-transition
             class="md:hidden bg-[#0f172a] border-b border-slate-800 px-6 py-6 space-y-4 text-center">
            <a href="{{ route('home') }}" class="block text-xs font-bold tracking-widest uppercase text-[#c29b53]">HOME</a>
            <a href="{{ route('home') }}#services" class="block text-xs font-semibold tracking-widest uppercase text-white hover:text-[#c29b53]">SERVICES</a>
            <a href="{{ route('projects.index') }}" class="block text-xs font-semibold tracking-widest uppercase text-white hover:text-[#c29b53]">PROJECTS</a>
            <a href="{{ route('home') }}#why-choose-us" class="block text-xs font-semibold tracking-widest uppercase text-white hover:text-[#c29b53]">ABOUT</a>
            <a href="{{ route('estimator.index') }}" class="block text-xs font-semibold tracking-widest uppercase text-white hover:text-[#c29b53]">CALCULATOR RAB</a>
            <a href="{{ route('rfp.create') }}" class="block text-xs font-semibold tracking-widest uppercase text-white hover:text-[#c29b53]">RFP TENDER</a>
            <a href="{{ route('rfp.track') }}" class="block text-xs font-semibold tracking-widest uppercase text-slate-300 hover:text-[#c29b53]">LACAK TIKET</a>
            <a href="{{ route('admin.dashboard') }}" class="block text-xs font-semibold tracking-widest uppercase text-slate-400">ADMIN CMS</a>
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
        <a href="https://wa.me/6281348593725?text=Halo%20Tim%20Enzo%20Construction,%20saya%20ingin%20berkonsultasi%20mengenai%20rencana%20proyek%20konstruksi."
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
                    <div class="flex items-center gap-3">
                        <svg class="w-8 h-8 text-[#c29b53]" viewBox="0 0 60 60" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polygon points="30,5 55,19 55,47 30,59 5,47 5,19" stroke="currentColor" stroke-width="3"/>
                            <polyline points="30,5 30,59" stroke="currentColor" stroke-width="2"/>
                            <polyline points="30,33 55,19" stroke="currentColor" stroke-width="2"/>
                            <polyline points="30,33 5,19" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        <div>
                            <span class="text-lg font-black tracking-widest text-white leading-none font-sans">ENZO</span>
                            <span class="text-[10px] tracking-wider text-slate-400 block">Construction</span>
                        </div>
                    </div>
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
                        <li><a href="{{ route('rfp.create') }}" class="hover:text-white transition">Formulir Tender (RFP)</a></li>
                        <li><a href="{{ route('rfp.track') }}" class="hover:text-white transition">Lacak Tiket Tender</a></li>
                        <li><a href="{{ route('admin.dashboard') }}" class="hover:text-white transition">Admin CMS</a></li>
                    </ul>
                </div>

                <!-- Col 4: Contact -->
                <div>
                    <h3 class="text-xs font-bold text-white uppercase tracking-widest mb-4">Kontak Resmi</h3>
                    <div class="space-y-2 text-xs text-slate-400 font-light">
                        <p>Jalan Karya Baru No. 56A, Parit Tokaya, Pontianak Selatan</p>
                        <p class="text-white font-medium">Telp: 0813-4859-3725</p>
                        <p>Email: enzo.ng7786@gmail.com</p>
                    </div>
                </div>

            </div>

            <div class="pt-8 border-t border-slate-800 text-center text-xs text-slate-500 font-light">
                &copy; {{ date('Y') }} PT Enzo Karya Konstruksi. All Rights Reserved.
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
