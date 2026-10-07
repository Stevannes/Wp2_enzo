@extends('layouts.app')

@section('title', 'ENZO Contractor — Building Excellence With Precision & Passion')
@section('meta_description', 'Enzo Contractor adalah kontraktor umum premium spesialis gedung komersial, perumahan mewah, gudang industri, dan renovasi fasad berstandar ISO 9001:2015.')

@section('content')

<!-- ==========================================
     HERO SECTION (Cinematic PT MKP Style)
=========================================== -->
<section class="relative min-h-[92vh] flex items-center justify-center overflow-hidden">
    <!-- Background Architectural Image with Gradient Overlays -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/hero_architecture.jpg') }}"
             alt="Enzo Architectural Construction"
             class="w-full h-full object-cover object-center scale-105 transform animate-pulse duration-10000"
             style="animation-duration: 25s;">
        <div class="absolute inset-0 bg-gradient-to-t from-[#070C16] via-[#070C16]/80 to-[#070C16]/40"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#070C16]/90 via-[#070C16]/60 to-transparent"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,transparent_0%,#070C16_85%)]"></div>
    </div>

    <!-- Architectural Grid Background Overlay -->
    <div class="absolute inset-0 z-0 opacity-10 bg-[linear-gradient(to_right,#F59E0B_1px,transparent_1px),linear-gradient(to_bottom,#F59E0B_1px,transparent_1px)] bg-[size:4rem_4rem]"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center lg:text-left">
        <div class="max-w-3xl">
            <!-- Badge Subtitle -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-semibold uppercase tracking-widest mb-6 backdrop-blur-md">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                General Contractor & Design-Build Specialist
            </div>

            <!-- Primary Headline -->
            <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight mb-6">
                BUILDING EXCELLENCE WITH <span class="gold-gradient-text">PRECISION & PASSION</span>
            </h1>

            <!-- Narrative Paragraph -->
            <p class="text-base sm:text-lg text-slate-300 leading-relaxed mb-8 max-w-2xl font-light">
                Mitra kontraktor konstruksi terpercaya untuk pembangunan gedung komersial, hunian residensial mewah, struktur industri, dan revitalisasi fasad dengan standar rekayasa tertinggi.
            </p>

            <!-- Call to Actions -->
            <div class="flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start">
                <a href="{{ route('rfp.create') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center px-7 py-3.5 text-sm font-bold text-slate-950 bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 rounded-md shadow-xl shadow-amber-500/25 hover:shadow-amber-500/40 hover:scale-[1.02] active:scale-[0.98] transition">
                    <i data-lucide="file-check-2" class="w-4 h-4 mr-2"></i>
                    <span>Ajukan Tender / RFP Sekarang</span>
                </a>
                
                <a href="{{ route('estimator.index') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3.5 text-sm font-semibold text-slate-200 bg-slate-900/80 hover:bg-slate-800 border border-amber-500/30 hover:border-amber-400 rounded-md backdrop-blur-md transition group">
                    <i data-lucide="calculator" class="w-4 h-4 mr-2 text-amber-400 group-hover:scale-110 transition"></i>
                    <span>Hitung Estimasi Biaya (RAB)</span>
                </a>

                <a href="{{ route('projects.index') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3.5 text-sm font-medium text-slate-400 hover:text-white transition">
                    <span>Lihat Portofolio</span>
                    <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Bottom Scroll Indicator -->
    <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 z-10 hidden md:flex flex-col items-center text-slate-500">
        <span class="text-[10px] uppercase tracking-widest text-slate-400 mb-2">Scroll to explore</span>
        <div class="w-5 h-9 rounded-full border border-slate-600 flex items-start justify-center p-1">
            <div class="w-1 h-2 bg-amber-400 rounded-full animate-bounce"></div>
        </div>
    </div>
</section>

<!-- ==========================================
     STATS KPI COUNTER BAR
=========================================== -->
<section class="relative z-20 -mt-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="glass-panel rounded-xl p-6 lg:p-8 shadow-2xl border border-amber-500/20">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center divide-y md:divide-y-0 md:divide-x divide-slate-800">
            <div class="pt-4 md:pt-0">
                <div class="font-serif text-3xl sm:text-4xl font-bold gold-gradient-text">{{ $stats['completed_projects'] }}+</div>
                <div class="text-xs text-slate-400 mt-1 uppercase tracking-wider font-semibold">Proyek Sukses Selesai</div>
            </div>
            <div class="pt-4 md:pt-0">
                <div class="font-serif text-3xl sm:text-4xl font-bold gold-gradient-text">{{ $stats['client_satisfaction'] }}</div>
                <div class="text-xs text-slate-400 mt-1 uppercase tracking-wider font-semibold">Tingkat Kepuasan Klien</div>
            </div>
            <div class="pt-4 md:pt-0">
                <div class="font-serif text-3xl sm:text-4xl font-bold gold-gradient-text">{{ $stats['experience_years'] }}+ Tahun</div>
                <div class="text-xs text-slate-400 mt-1 uppercase tracking-wider font-semibold">Rekam Jejak Konstruksi</div>
            </div>
            <div class="pt-4 md:pt-0">
                <div class="font-serif text-3xl sm:text-4xl font-bold text-emerald-400">100%</div>
                <div class="text-xs text-slate-400 mt-1 uppercase tracking-wider font-semibold">Zero Accident K3 Record</div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     SECTION: WHY CHOOSE US (5 Floating Cards)
=========================================== -->
<section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-2xl mx-auto mb-16">
        <span class="text-xs font-bold text-amber-500 uppercase tracking-widest block mb-2 font-serif">Kredibilitas & Keunggulan</span>
        <h2 class="font-serif text-3xl sm:text-4xl font-bold text-white tracking-tight">Mengapa Memilih Enzo Contractor?</h2>
        <p class="text-slate-400 text-sm mt-3">Kami menggabungkan ketelitian rekayasa sipil modern dengan disiplin manajemen anggaran untuk memberikan hasil terbaik.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-5">
        <!-- Card 1: Expertise -->
        <div class="bg-gradient-to-b from-[#0F172A] to-[#090E1A] p-6 rounded-xl border border-slate-800 gold-border-glow transition-all duration-300">
            <div class="w-12 h-12 rounded-lg bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400 mb-5">
                <i data-lucide="award" class="w-6 h-6"></i>
            </div>
            <h3 class="font-serif text-base font-bold text-white mb-2 uppercase tracking-wide">Expertise</h3>
            <p class="text-xs text-slate-400 leading-relaxed">
                Didukung tim insinyur dan tenaga ahli berlisensi SKA dengan jam terbang tinggi di berbagai skala proyek.
            </p>
        </div>

        <!-- Card 2: Quality -->
        <div class="bg-gradient-to-b from-[#0F172A] to-[#090E1A] p-6 rounded-xl border border-slate-800 gold-border-glow transition-all duration-300">
            <div class="w-12 h-12 rounded-lg bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400 mb-5">
                <i data-lucide="shield-check" class="w-6 h-6"></i>
            </div>
            <h3 class="font-serif text-base font-bold text-white mb-2 uppercase tracking-wide">Quality</h3>
            <p class="text-xs text-slate-400 leading-relaxed">
                Standar manajemen mutu tersertifikasi ISO 9001:2015 serta penggunaan material SNI kelas satu.
            </p>
        </div>

        <!-- Card 3: Innovation -->
        <div class="bg-gradient-to-b from-[#0F172A] to-[#090E1A] p-6 rounded-xl border border-slate-800 gold-border-glow transition-all duration-300">
            <div class="w-12 h-12 rounded-lg bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400 mb-5">
                <i data-lucide="cpu" class="w-6 h-6"></i>
            </div>
            <h3 class="font-serif text-base font-bold text-white mb-2 uppercase tracking-wide">Innovation</h3>
            <p class="text-xs text-slate-400 leading-relaxed">
                Penerapan teknologi rekayasa BIM 3D & estimasi presisi digital untuk meminimalkan deviasi lapangan.
            </p>
        </div>

        <!-- Card 4: Reliability -->
        <div class="bg-gradient-to-b from-[#0F172A] to-[#090E1A] p-6 rounded-xl border border-slate-800 gold-border-glow transition-all duration-300">
            <div class="w-12 h-12 rounded-lg bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400 mb-5">
                <i data-lucide="clock" class="w-6 h-6"></i>
            </div>
            <h3 class="font-serif text-base font-bold text-white mb-2 uppercase tracking-wide">Reliability</h3>
            <p class="text-xs text-slate-400 leading-relaxed">
                Komitmen ketat serah terima on-time sesuai milestone jadwal dan transparansi pagu anggaran tanpa biaya siluman.
            </p>
        </div>

        <!-- Card 5: Sustainability -->
        <div class="bg-gradient-to-b from-[#0F172A] to-[#090E1A] p-6 rounded-xl border border-slate-800 gold-border-glow transition-all duration-300">
            <div class="w-12 h-12 rounded-lg bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400 mb-5">
                <i data-lucide="leaf" class="w-6 h-6"></i>
            </div>
            <h3 class="font-serif text-base font-bold text-white mb-2 uppercase tracking-wide">Sustainability</h3>
            <p class="text-xs text-slate-400 leading-relaxed">
                Prinsip konstruksi ramah lingkungan, efisiensi sirkulasi udara & pencahayaan, serta struktur berdaya tahan puluhan tahun.
            </p>
        </div>
    </div>
</section>

<!-- ==========================================
     SECTION: WHAT WE OFFER (Services Showcase)
=========================================== -->
<section id="services" class="py-20 bg-[#060A14] border-y border-slate-800/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
            <div>
                <span class="text-xs font-bold text-amber-500 uppercase tracking-widest block mb-2 font-serif">Layanan Unggulan</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-white">Solusi Konstruksi Terintegrasi</h2>
            </div>
            <p class="text-xs sm:text-sm text-slate-400 max-w-md">
                Menyediakan spektrum pekerjaan dari tahap studi kelayakan, perancangan arsitektur, hingga pembangunan fisik berskala penuh.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
                <div class="group bg-[#0B1220] rounded-xl overflow-hidden border border-slate-800 hover:border-amber-500/50 transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <!-- Service Header / Cover -->
                        <div class="h-48 overflow-hidden relative">
                            @php
                                $coverImage = match($service->slug) {
                                    'konstruksi-komersial' => 'images/project_commercial.jpg',
                                    'residensial-design-build' => 'images/project_residential.jpg',
                                    'industri-pergudangan' => 'images/project_industrial.jpg',
                                    'renovasi-interior' => 'images/project_interior.jpg',
                                    default => 'images/hero_architecture.jpg'
                                };
                            @endphp
                            <img src="{{ asset($coverImage) }}" alt="{{ $service->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0B1220] via-transparent to-black/30"></div>
                            
                            <!-- Icon Badge -->
                            <div class="absolute top-4 right-4 w-10 h-10 rounded-lg bg-black/60 backdrop-blur-md border border-amber-500/40 flex items-center justify-center text-amber-400 shadow-lg">
                                <i data-lucide="{{ $service->icon ?? 'hammer' }}" class="w-5 h-5"></i>
                            </div>
                        </div>

                        <!-- Service Details -->
                        <div class="p-6">
                            <h3 class="font-serif text-lg font-bold text-white mb-2 group-hover:text-amber-400 transition">
                                {{ $service->name }}
                            </h3>
                            <p class="text-xs text-slate-400 line-clamp-3 leading-relaxed mb-4">
                                {{ $service->full_description }}
                            </p>
                        </div>
                    </div>

                    <!-- Footer Link -->
                    <div class="px-6 pb-6 pt-2 border-t border-slate-800/60 flex items-center justify-between">
                        <a href="{{ route('projects.index') }}" class="text-xs font-semibold text-amber-400 hover:text-amber-300 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            <span>Lihat Studi Kasus</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                        <a href="{{ route('rfp.create', ['category' => $service->slug]) }}" class="text-[11px] text-slate-400 hover:text-white underline">
                            Ajukan Penawaran
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ==========================================
     PROYEK UNGGULAN & SLIDER BEFORE-AFTER INTERAKTIF
     (Wireframe 1 Approved Feature)
=========================================== -->
<section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-2xl mx-auto mb-16">
        <span class="text-xs font-bold text-amber-500 uppercase tracking-widest block mb-2 font-serif">Keahlian Revitalisasi Arsitektur</span>
        <h2 class="font-serif text-3xl sm:text-4xl font-bold text-white">Studi Kasus: Fasad Sebelum & Sesudah</h2>
        <p class="text-slate-400 text-sm mt-3">Geser tombol pengatur di bawah untuk melihat transformasi nyata struktur bangunan lama menjadi karya arsitektural modern berkelas tinggi.</p>
    </div>

    <!-- Interactive Draggable Before-After Slider Component (Alpine.js) -->
    <div x-data="{ sliderPos: 50, isDragging: false }" class="max-w-4xl mx-auto glass-panel rounded-2xl overflow-hidden p-4 sm:p-6 shadow-2xl border border-amber-500/30">
        <div class="relative w-full aspect-[16/10] sm:aspect-[16/9] rounded-xl overflow-hidden select-none cursor-ew-resize"
             @mousedown="isDragging = true"
             @mouseup="isDragging = false"
             @mouseleave="isDragging = false"
             @mousemove="if(isDragging) {
                 let rect = $el.getBoundingClientRect();
                 let x = $event.clientX - rect.left;
                 sliderPos = Math.max(0, Math.min(100, (x / rect.width) * 100));
             }"
             @touchstart="isDragging = true"
             @touchend="isDragging = false"
             @touchmove="let touch = $event.touches[0];
                 let rect = $el.getBoundingClientRect();
                 let x = touch.clientX - rect.left;
                 sliderPos = Math.max(0, Math.min(100, (x / rect.width) * 100));">

            <!-- After Image (Background) -->
            <img src="{{ asset('images/after_renovation.jpg') }}"
                 alt="Sesudah Renovasi Enzo"
                 class="absolute inset-0 w-full h-full object-cover pointer-events-none">
            <span class="absolute top-4 right-4 bg-emerald-950/90 border border-emerald-500/50 text-emerald-300 text-xs px-3 py-1 rounded-md font-bold tracking-wider uppercase z-10 backdrop-blur-md">
                Sesudah (After)
            </span>

            <!-- Before Image (Clipped by slider position) -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none"
                 :style="`width: ${sliderPos}%`">
                <img src="{{ asset('images/before_renovation.jpg') }}"
                     alt="Sebelum Renovasi Enzo"
                     class="absolute inset-0 w-full h-full object-cover max-w-none"
                     style="width: 100%; min-width: 100%;">
                <span class="absolute top-4 left-4 bg-slate-900/90 border border-slate-700 text-slate-300 text-xs px-3 py-1 rounded-md font-bold tracking-wider uppercase z-10 backdrop-blur-md">
                    Sebelum (Before)
                </span>
            </div>

            <!-- Divider Line & Handle -->
            <div class="absolute top-0 bottom-0 z-20 pointer-events-none flex items-center justify-center"
                 :style="`left: ${sliderPos}%; transform: translateX(-50%);`">
                <div class="w-1 bg-amber-400 h-full shadow-[0_0_10px_rgba(245,158,11,0.8)]"></div>
                <div class="absolute w-10 h-10 rounded-full bg-amber-500 border-2 border-white shadow-2xl flex items-center justify-center text-slate-950">
                    <i data-lucide="chevrons-left-right" class="w-5 h-5"></i>
                </div>
            </div>
        </div>

        <!-- Slider Range Control for Accessibility -->
        <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4 px-2">
            <div class="text-xs text-slate-400 flex items-center gap-2">
                <i data-lucide="move-horizontal" class="w-4 h-4 text-amber-500"></i>
                <span>Gunakan mouse atau sentuhan jari untuk menggeser perbandingan</span>
            </div>
            <input type="range" min="0" max="100" x-model="sliderPos"
                   class="w-full sm:w-64 h-2 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-amber-500">
        </div>

        <!-- Project Narrative Meta -->
        <div class="mt-6 pt-6 border-t border-slate-800 grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
            <div class="bg-slate-900/60 p-3 rounded-lg border border-slate-800">
                <span class="text-slate-400 block text-[10px] uppercase font-bold text-amber-500">Proyek Revitalisasi</span>
                <span class="text-slate-200 font-semibold text-sm">Renovasi Fasad Komersial Modern</span>
            </div>
            <div class="bg-slate-900/60 p-3 rounded-lg border border-slate-800">
                <span class="text-slate-400 block text-[10px] uppercase font-bold text-amber-500">Tantangan Rekayasa</span>
                <span class="text-slate-200">Perbaikan struktur retak & pembaruan fasad tanpa merusak aktivitas bisnis</span>
            </div>
            <div class="bg-slate-900/60 p-3 rounded-lg border border-slate-800">
                <span class="text-slate-400 block text-[10px] uppercase font-bold text-amber-500">Solusi Enzo Contractor</span>
                <span class="text-slate-200">Aplikasi ACP premium, kisi-kisi arsitektural, dan perkuatan struktur baja SNI</span>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     SECTION: FEATURED PROJECTS GRID
=========================================== -->
<section class="py-20 bg-[#060A14] border-t border-slate-800/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-14 gap-4">
            <div>
                <span class="text-xs font-bold text-amber-500 uppercase tracking-widest block mb-2 font-serif">Portofolio Pilihan</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-white">Rekam Jejak Pembangunan</h2>
            </div>
            <a href="{{ route('projects.index') }}" class="text-sm font-semibold text-amber-400 hover:text-amber-300 flex items-center gap-1.5 group">
                <span>Lihat Seluruh Katalog</span>
                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProjects as $project)
                <div class="group bg-[#0B1220] rounded-xl overflow-hidden border border-slate-800 hover:border-amber-500/50 transition-all duration-300 flex flex-col">
                    <!-- Thumbnail -->
                    <div class="relative aspect-[4/3] overflow-hidden">
                        @php
                            $thumb = $project->images->firstWhere('type', 'gallery')?->image_path
                                    ?? $project->images->first()?->image_path
                                    ?? 'images/project_commercial.jpg';
                        @endphp
                        <img src="{{ asset($thumb) }}" alt="{{ $project->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0B1220] via-transparent to-black/30"></div>

                        <!-- Status Badge -->
                        <span class="absolute top-3 left-3 px-2.5 py-1 rounded bg-black/70 backdrop-blur-md text-[10px] font-bold uppercase tracking-wider text-amber-400 border border-amber-500/30">
                            {{ $project->project_type }}
                        </span>

                        <span class="absolute top-3 right-3 px-2 py-0.5 rounded bg-emerald-950/80 text-[10px] font-semibold text-emerald-400 border border-emerald-500/40">
                            {{ ucfirst($project->status) }}
                        </span>
                    </div>

                    <!-- Content -->
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-serif text-base font-bold text-white mb-2 line-clamp-1 group-hover:text-amber-400 transition">
                                {{ $project->title }}
                            </h3>
                            <div class="flex items-center gap-1.5 text-xs text-slate-400 mb-3">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-amber-500 shrink-0"></i>
                                <span class="truncate">{{ $project->location }}</span>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-2 text-[11px] bg-slate-900/60 p-2.5 rounded-lg border border-slate-800/80 mb-4">
                                <div>
                                    <span class="text-slate-500 block">Luas:</span>
                                    <span class="font-semibold text-slate-300">{{ $project->building_area_sqm ? number_format($project->building_area_sqm, 0) . ' m²' : '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-500 block">Tahun / Durasi:</span>
                                    <span class="font-semibold text-slate-300">{{ $project->completion_year ?? $project->duration }}</span>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('projects.show', $project->slug) }}"
                           class="w-full text-center py-2 px-3 rounded bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-xs font-semibold text-slate-200 transition duration-200">
                            Lihat Detail Studi Kasus
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ==========================================
     SECTION: TESTIMONIALS (Client Trust)
=========================================== -->
<section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-2xl mx-auto mb-16">
        <span class="text-xs font-bold text-amber-500 uppercase tracking-widest block mb-2 font-serif">Apresiasi Klien</span>
        <h2 class="font-serif text-3xl sm:text-4xl font-bold text-white">Kepuasan Klien Korporat & Residensial</h2>
        <p class="text-slate-400 text-sm mt-3">Komitmen kami dibuktikan oleh kepercayaan jangka panjang dari para pemilik gedung dan institusi.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($testimonials as $testi)
            <div class="glass-panel p-8 rounded-xl border border-slate-800 relative flex flex-col justify-between">
                <i data-lucide="quote" class="w-8 h-8 text-amber-500/20 absolute top-6 right-6 pointer-events-none"></i>
                
                <div>
                    <!-- Star Rating -->
                    <div class="flex items-center gap-1 text-amber-400 mb-4">
                        @for($i = 0; $i < $testi->rating; $i++)
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        @endfor
                    </div>

                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed italic mb-6">
                        "{{ $testi->testimonial_text }}"
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-800 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-slate-950 font-bold text-sm">
                        {{ substr($testi->client_name, 0, 1) }}
                    </div>
                    <div>
                        <div class="font-semibold text-xs sm:text-sm text-white">{{ $testi->client_name }}</div>
                        <div class="text-[11px] text-amber-400/90 font-medium">
                            {{ $testi->client_role }} {{ $testi->company_name ? '• ' . $testi->company_name : '' }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- ==========================================
     SECTION: TRUST & CERTIFICATIONS
=========================================== -->
<section class="py-16 bg-[#04070E] border-y border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-xs font-semibold text-slate-500 uppercase tracking-widest block mb-8">Standarisasi Teknis & Legalitas Badan Usaha</span>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 items-center">
            <div class="p-4 rounded-xl bg-slate-900/40 border border-slate-800 flex flex-col items-center">
                <div class="font-serif text-lg font-bold text-amber-400 mb-1">ISO 9001:2015</div>
                <div class="text-[11px] text-slate-400">Quality Management System</div>
            </div>
            <div class="p-4 rounded-xl bg-slate-900/40 border border-slate-800 flex flex-col items-center">
                <div class="font-serif text-lg font-bold text-amber-400 mb-1">SMK3 KEMENAKER</div>
                <div class="text-[11px] text-slate-400">Keselamatan Kerja Zero Accident</div>
            </div>
            <div class="p-4 rounded-xl bg-slate-900/40 border border-slate-800 flex flex-col items-center">
                <div class="font-serif text-lg font-bold text-amber-400 mb-1">LPJK TERAKREDITASI</div>
                <div class="text-[11px] text-slate-400">Sertifikat Badan Usaha (SBU)</div>
            </div>
            <div class="p-4 rounded-xl bg-slate-900/40 border border-slate-800 flex flex-col items-center">
                <div class="font-serif text-lg font-bold text-amber-400 mb-1">GARANSI STRUKTUR</div>
                <div class="text-[11px] text-slate-400">Jaminan Mutu Pemeliharaan Resmi</div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     SECTION: CALL TO ACTION BANNER (RFP & RAB)
=========================================== -->
<section class="relative py-24 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-amber-950/60 via-slate-950 to-amber-950/40"></div>
    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6">
            Siap Mewujudkan Bangunan Impian & Proyek Komersial Anda?
        </h2>
        <p class="text-slate-300 text-sm sm:text-base max-w-2xl mx-auto mb-10 leading-relaxed font-light">
            Dapatkan estimasi biaya instan dengan kalkulator RAB kami atau unggah dokumen tender (CAD/PDF) untuk penawaran menyeluruh dalam 1x24 jam kerja.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('rfp.create') }}"
               class="w-full sm:w-auto px-8 py-4 text-sm font-bold text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 rounded-md shadow-2xl hover:scale-105 transition">
                Ajukan Proposal Tender (RFP)
            </a>
            <a href="{{ route('estimator.index') }}"
               class="w-full sm:w-auto px-8 py-4 text-sm font-semibold text-white bg-slate-900/90 hover:bg-slate-800 border border-amber-500/40 rounded-md backdrop-blur-md transition">
                Simulasi Hitung Anggaran (RAB)
            </a>
            <a href="https://wa.me/6281348593725?text=Halo%20Enzo%20Contractor,%20saya%20ingin%20jadwalkan%20survey%20lokasi%20proyek."
               target="_blank"
               class="w-full sm:w-auto px-6 py-4 text-sm font-semibold text-emerald-400 hover:text-emerald-300 transition flex items-center justify-center gap-2">
                <i data-lucide="message-circle" class="w-4 h-4"></i>
                <span>Jadwalkan Survey Lokasi via WA</span>
            </a>
        </div>
    </div>
</section>

@endsection
