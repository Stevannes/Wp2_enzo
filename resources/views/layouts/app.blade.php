<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'ENZO Contractor — General Contractor & Architectural Construction')</title>
    <meta name="description" content="@yield('meta_description', 'Enzo Contractor: Mitra konstruksi terpercaya untuk pembangunan gedung komersial, rumah mewah, gudang industri, dan renovasi arsitektural berskala nasional.')">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            dark: '#070C16',
                            card: '#0D1526',
                            cardHover: '#142038',
                            border: '#1E2D48',
                            gold: '#F59E0B',
                            goldLight: '#FDE68A',
                            goldDark: '#B45309',
                            slate: '#94A3B8'
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['Cinzel', 'serif']
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
        .glass-panel {
            background: rgba(13, 21, 38, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(245, 158, 11, 0.12);
        }
        .gold-gradient-text {
            background: linear-gradient(135deg, #FFFDF0 0%, #F59E0B 50%, #D97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gold-border-glow:hover {
            border-color: rgba(245, 158, 11, 0.5);
            box-shadow: 0 0 25px rgba(245, 158, 11, 0.15);
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #070C16;
        }
        ::-webkit-scrollbar-thumb {
            background: #1E2D48;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #F59E0B;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-[#070C16] text-slate-100 font-sans antialiased selection:bg-amber-500 selection:text-black min-h-screen flex flex-col">

    <!-- Top Announcement Bar -->
    <div class="bg-gradient-to-r from-amber-950 via-slate-900 to-amber-950 text-xs py-2 px-4 border-b border-amber-500/20 text-slate-300">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
            <div class="flex items-center gap-4">
                <span class="inline-flex items-center gap-1.5 text-amber-400 font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    ISO 9001:2015 Certified
                </span>
                <span class="hidden md:inline text-slate-400">•</span>
                <span class="hidden md:inline text-slate-300">Standar K3 Zero Accident & Garansi Konstruksi Resmi</span>
            </div>
            <div class="flex items-center gap-4 text-xs">
                <a href="tel:081348593725" class="hover:text-amber-400 transition flex items-center gap-1">
                    <i data-lucide="phone" class="w-3.5 h-3.5 text-amber-500"></i>
                    <span>0813-4859-3725</span>
                </a>
                <span class="text-slate-600">|</span>
                <a href="mailto:enzo.ng7786@gmail.com" class="hover:text-amber-400 transition flex items-center gap-1">
                    <i data-lucide="mail" class="w-3.5 h-3.5 text-amber-500"></i>
                    <span>enzo.ng7786@gmail.com</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header x-data="{ mobileOpen: false, scrolled: false }"
            @scroll.window="scrolled = (window.pageYOffset > 20)"
            :class="scrolled ? 'bg-[#070C16]/95 backdrop-blur-md shadow-2xl border-b border-amber-500/20' : 'bg-transparent border-b border-slate-800/80'"
            class="sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo & Brand Name -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-lg overflow-hidden border border-amber-500/30 p-0.5 bg-black/40 group-hover:border-amber-400 transition shadow-lg">
                        <img src="{{ asset('images/enzo_logo.jpg') }}" alt="ENZO Logo" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <div class="font-serif text-xl tracking-wider font-bold gold-gradient-text uppercase">ENZO</div>
                        <div class="text-[10px] tracking-widest uppercase text-slate-400 -mt-1 font-medium">Contractor & Build</div>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center space-x-1">
                    <a href="{{ route('home') }}"
                       class="px-3.5 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('home') ? 'text-amber-400 font-semibold' : 'text-slate-300 hover:text-amber-400 hover:bg-slate-900/60' }}">
                        Beranda
                    </a>
                    <a href="{{ route('projects.index') }}"
                       class="px-3.5 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('projects.*') ? 'text-amber-400 font-semibold' : 'text-slate-300 hover:text-amber-400 hover:bg-slate-900/60' }}">
                        Portofolio Proyek
                    </a>
                    <a href="{{ route('home') }}#services"
                       class="px-3.5 py-2 rounded-md text-sm font-medium transition text-slate-300 hover:text-amber-400 hover:bg-slate-900/60">
                        Layanan
                    </a>
                    <a href="{{ route('estimator.index') }}"
                       class="px-3.5 py-2 rounded-md text-sm font-medium transition flex items-center gap-1.5 {{ request()->routeIs('estimator.*') ? 'text-amber-400 font-semibold' : 'text-slate-300 hover:text-amber-400 hover:bg-slate-900/60' }}">
                        <i data-lucide="calculator" class="w-4 h-4 text-amber-500"></i>
                        <span>Kalkulator RAB</span>
                    </a>
                    <a href="{{ route('rfp.track') }}"
                       class="px-3.5 py-2 rounded-md text-sm font-medium transition flex items-center gap-1.5 {{ request()->routeIs('rfp.track') ? 'text-amber-400 font-semibold' : 'text-slate-300 hover:text-amber-400 hover:bg-slate-900/60' }}">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                        <span>Lacak Tiket</span>
                    </a>
                    <a href="{{ route('admin.dashboard') }}"
                       class="px-3.5 py-2 rounded-md text-xs font-semibold tracking-wider uppercase transition text-slate-400 hover:text-amber-300 hover:bg-slate-900/80 border border-slate-800 rounded">
                        Admin CMS
                    </a>
                </nav>

                <!-- Action Button (RFP CTA) -->
                <div class="hidden lg:flex items-center gap-3">
                    <a href="{{ route('rfp.create') }}"
                       class="relative inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-slate-950 bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 rounded-md shadow-lg shadow-amber-500/20 hover:shadow-amber-500/40 hover:scale-[1.02] active:scale-[0.98] transition duration-200">
                        <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                        <span>Ajukan Tender / RFP</span>
                    </a>
                </div>

                <!-- Mobile Menu Hamburger Button -->
                <div class="flex lg:hidden items-center gap-2">
                    <a href="{{ route('rfp.create') }}" class="text-xs bg-amber-500 text-slate-950 px-3 py-1.5 rounded font-semibold">
                        RFP
                    </a>
                    <button @click="mobileOpen = !mobileOpen" type="button" class="p-2 rounded-md text-slate-300 hover:text-white hover:bg-slate-800 focus:outline-none">
                        <i x-show="!mobileOpen" data-lucide="menu" class="w-6 h-6"></i>
                        <i x-show="mobileOpen" x-cloak data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Slide-out Menu -->
        <div x-show="mobileOpen" x-cloak x-transition class="lg:hidden bg-[#0A101D] border-b border-amber-500/20 px-4 pt-3 pb-6 space-y-2">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded text-base font-medium text-slate-200 hover:bg-slate-800 hover:text-amber-400">Beranda</a>
            <a href="{{ route('projects.index') }}" class="block px-3 py-2 rounded text-base font-medium text-slate-200 hover:bg-slate-800 hover:text-amber-400">Portofolio Proyek</a>
            <a href="{{ route('home') }}#services" class="block px-3 py-2 rounded text-base font-medium text-slate-200 hover:bg-slate-800 hover:text-amber-400">Layanan Konstruksi</a>
            <a href="{{ route('estimator.index') }}" class="block px-3 py-2 rounded text-base font-medium text-slate-200 hover:bg-slate-800 hover:text-amber-400">Kalkulator RAB Interaktif</a>
            <a href="{{ route('rfp.create') }}" class="block px-3 py-2 rounded text-base font-medium text-amber-400 font-semibold bg-amber-500/10 border border-amber-500/30">Formulir Tender / RFP</a>
            <a href="{{ route('rfp.track') }}" class="block px-3 py-2 rounded text-base font-medium text-slate-300 hover:bg-slate-800">Lacak Tiket Tender</a>
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded text-xs font-semibold text-slate-400 border border-slate-800 uppercase">Panel Admin CMS</a>
        </div>
    </header>

    <!-- Global Toast Alert (Flash Message) -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition class="fixed top-24 right-4 z-50 max-w-md bg-emerald-950/90 border border-emerald-500/50 backdrop-blur-md p-4 rounded-lg shadow-2xl text-emerald-200 flex items-start gap-3">
            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-400 shrink-0 mt-0.5"></i>
            <div class="flex-1 text-sm font-medium">{{ session('success') }}</div>
            <button @click="show = false" class="text-emerald-400 hover:text-white"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition class="fixed top-24 right-4 z-50 max-w-md bg-rose-950/90 border border-rose-500/50 backdrop-blur-md p-4 rounded-lg shadow-2xl text-rose-200 flex items-start gap-3">
            <i data-lucide="alert-circle" class="w-5 h-5 text-rose-400 shrink-0 mt-0.5"></i>
            <div class="flex-1 text-sm font-medium">{{ session('error') }}</div>
            <button @click="show = false" class="text-rose-400 hover:text-white"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
    @endif

    <!-- Main Page Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Floating WhatsApp Fast-Response Widget -->
    <div class="fixed bottom-6 right-6 z-40 flex items-center group">
        <a href="https://wa.me/6281348593725?text=Halo%20Tim%20Enzo%20Contractor,%20saya%20ingin%20berkonsultasi%20mengenai%20rencana%20pembangunan%20konstruksi."
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
        <div class="mr-3 px-3 py-1.5 rounded-lg bg-slate-900 border border-emerald-500/30 text-xs font-semibold text-emerald-300 shadow-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none hidden sm:block">
            Chat WhatsApp Fast Response
        </div>
    </div>

    <!-- Architectural Global Footer -->
    <footer class="bg-[#050811] border-t border-slate-800 text-slate-400 pt-16 pb-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-16">
                
                <!-- Col 1: Brand Profile -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg overflow-hidden border border-amber-500/40 p-0.5 bg-black">
                            <img src="{{ asset('images/enzo_logo.jpg') }}" alt="Enzo Logo" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <span class="font-serif text-lg tracking-wider font-bold gold-gradient-text uppercase">ENZO</span>
                            <span class="text-xs block text-slate-400 font-medium">Contractor & Interior</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        {{ $settings['company_vision'] ?? 'Perusahaan kontraktor umum dan desain interior terkemuka dengan komitmen mutu tinggi, ketepatan waktu, dan integritas rekayasa berstandar SNI & ISO.' }}
                    </p>
                    <div class="pt-2 flex items-center gap-3">
                        <a href="{{ $settings['instagram_url'] ?? 'https://instagram.com/enzocontractor' }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-900 border border-slate-700 flex items-center justify-center text-slate-300 hover:text-amber-400 hover:border-amber-400 transition">
                            <i data-lucide="instagram" class="w-4 h-4"></i>
                        </a>
                        <a href="https://wa.me/{{ $settings['whatsapp'] ?? '6281348593725' }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-900 border border-slate-700 flex items-center justify-center text-slate-300 hover:text-emerald-400 hover:border-emerald-400 transition">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                        </a>
                        <a href="mailto:{{ $settings['email'] ?? 'enzo.ng7786@gmail.com' }}" class="w-8 h-8 rounded-full bg-slate-900 border border-slate-700 flex items-center justify-center text-slate-300 hover:text-amber-400 hover:border-amber-400 transition">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Layanan Spesialis -->
                <div>
                    <h3 class="text-xs font-semibold text-slate-200 uppercase tracking-widest mb-4 font-serif">Layanan Konstruksi</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('projects.index', ['category' => 'commercial']) }}" class="hover:text-amber-400 transition flex items-center gap-1.5"><i data-lucide="chevron-right" class="w-3 h-3 text-amber-500"></i> Pembangunan Gedung & Komersial</a></li>
                        <li><a href="{{ route('projects.index', ['category' => 'residential']) }}" class="hover:text-amber-400 transition flex items-center gap-1.5"><i data-lucide="chevron-right" class="w-3 h-3 text-amber-500"></i> Residensial Mewah Design-and-Build</a></li>
                        <li><a href="{{ route('projects.index', ['category' => 'industrial']) }}" class="hover:text-amber-400 transition flex items-center gap-1.5"><i data-lucide="chevron-right" class="w-3 h-3 text-amber-500"></i> Gudang & Pabrik Struktur Baja</a></li>
                        <li><a href="{{ route('projects.index') }}" class="hover:text-amber-400 transition flex items-center gap-1.5"><i data-lucide="chevron-right" class="w-3 h-3 text-amber-500"></i> Renovasi Fasad & Interior Fit-Out</a></li>
                        <li><a href="{{ route('projects.index') }}" class="hover:text-amber-400 transition flex items-center gap-1.5"><i data-lucide="chevron-right" class="w-3 h-3 text-amber-500"></i> Pekerjaan Sipil & Infrastruktur</a></li>
                    </ul>
                </div>

                <!-- Col 3: Solusi Klien & Estimasi -->
                <div>
                    <h3 class="text-xs font-semibold text-slate-200 uppercase tracking-widest mb-4 font-serif">Solusi Klien & Tender</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('estimator.index') }}" class="text-amber-400 font-medium hover:underline flex items-center gap-1.5"><i data-lucide="calculator" class="w-3.5 h-3.5"></i> Simulasi Estimasi Biaya RAB</a></li>
                        <li><a href="{{ route('rfp.create') }}" class="hover:text-amber-400 transition flex items-center gap-1.5"><i data-lucide="file-plus" class="w-3.5 h-3.5 text-amber-500"></i> Pengajuan Proposal Tender (RFP)</a></li>
                        <li><a href="{{ route('rfp.track') }}" class="hover:text-amber-400 transition flex items-center gap-1.5"><i data-lucide="check-check" class="w-3.5 h-3.5 text-amber-500"></i> Pelacakan Status Tiket Tender</a></li>
                        <li><a href="{{ route('projects.index') }}" class="hover:text-amber-400 transition flex items-center gap-1.5"><i data-lucide="images" class="w-3.5 h-3.5 text-amber-500"></i> Studi Kasus Before & After</a></li>
                        <li><a href="{{ route('admin.dashboard') }}" class="hover:text-slate-300 transition flex items-center gap-1.5"><i data-lucide="lock" class="w-3.5 h-3.5 text-slate-600"></i> Portal CMS Manajemen Prospek</a></li>
                    </ul>
                </div>

                <!-- Col 4: Kantor & Kontak Resmi -->
                <div>
                    <h3 class="text-xs font-semibold text-slate-200 uppercase tracking-widest mb-4 font-serif">Kantor Pusat & Operasional</h3>
                    <div class="space-y-2.5 text-xs text-slate-400">
                        <div class="flex items-start gap-2.5">
                            <i data-lucide="map-pin" class="w-4 h-4 text-amber-500 shrink-0 mt-0.5"></i>
                            <span>{{ $settings['address'] ?? 'Jalan Karya Baru No. 56A, Parit Tokaya, Kec. Pontianak Selatan, 78115' }}</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="phone-call" class="w-4 h-4 text-amber-500 shrink-0"></i>
                            <span>{{ $settings['phone'] ?? '0813-4859-3725' }}</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="clock" class="w-4 h-4 text-amber-500 shrink-0"></i>
                            <span>Senin - Sabtu: 08.00 - 17.00 WIB</span>
                        </div>
                    </div>

                    <!-- Trust Accreditation Badges -->
                    <div class="mt-4 pt-4 border-t border-slate-800/80">
                        <div class="text-[10px] tracking-wider uppercase text-slate-500 mb-2 font-semibold">Akreditasi & Kemitraan:</div>
                        <div class="flex flex-wrap items-center gap-2 text-[10px] text-slate-300">
                            <span class="px-2 py-0.5 rounded bg-slate-900 border border-slate-700">LPJK</span>
                            <span class="px-2 py-0.5 rounded bg-slate-900 border border-slate-700">K3 Kemenaker</span>
                            <span class="px-2 py-0.5 rounded bg-slate-900 border border-slate-700">ISO 9001</span>
                            <span class="px-2 py-0.5 rounded bg-slate-900 border border-slate-700">SBU Konstruksi</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright & Credit -->
            <div class="pt-8 border-t border-slate-900 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} PT Enzo Karya Konstruksi. Seluruh Hak Cipta Dilindungi Undang-Undang.</p>
                <div class="flex items-center gap-6">
                    <a href="{{ route('home') }}" class="hover:text-amber-400">Kebijakan Privasi</a>
                    <span>•</span>
                    <a href="{{ route('home') }}" class="hover:text-amber-400">Syarat Ketentuan Tender</a>
                    <span>•</span>
                    <span class="text-amber-500/80">Build With Trust & Quality</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Initialize Lucide icons
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
