@extends('layouts.app')

@section('title', $project->title . ' — Studi Kasus ENZO Contractor')
@section('meta_description', 'Detail studi kasus rekayasa konstruksi: ' . $project->title . '. Tantangan lapangan dan solusi rekayasa oleh Enzo Contractor.')

@section('content')

<!-- ========================================================
     HERO BANNER & BREADCRUMB (Strictly Matching PT MKP Mockup Style)
========================================================= -->
<section class="relative min-h-[380px] sm:min-h-[420px] flex items-center justify-center overflow-hidden">
    <!-- Clean Architectural Twilight Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/ptmkp_hero_clean.jpg') }}"
             alt="Enzo Architectural Project Backdrop"
             class="w-full h-full object-cover object-center">
        <!-- Subtle dark overlay -->
        <div class="absolute inset-0 bg-slate-950/60"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-transparent to-slate-950/50"></div>
    </div>

    <!-- Header Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pt-20 pb-28">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-slate-300 mb-4 font-medium">
            <a href="{{ route('home') }}" class="hover:text-[#c29b53] transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('projects.index') }}" class="hover:text-[#c29b53] transition">Portofolio</a>
            <span>/</span>
            <span class="text-[#c29b53] font-bold truncate">{{ $project->title }}</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
            <div class="max-w-3xl">
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-2.5 py-1 rounded bg-[#1a2332]/90 text-[#c29b53] border border-[#c29b53]/40 text-xs font-bold uppercase tracking-wider backdrop-blur-sm">
                        {{ $project->project_type }}
                    </span>
                    <span class="px-2.5 py-1 rounded {{ $project->status === 'completed' ? 'bg-emerald-600/90 text-white' : 'bg-[#c29b53]/90 text-white' }} text-xs font-bold tracking-wider uppercase backdrop-blur-sm shadow">
                        Status: {{ $project->status === 'completed' ? 'Telah Selesai' : 'Dalam Pengerjaan' }}
                    </span>
                </div>
                <h1 class="font-sans text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-wide uppercase leading-tight mb-3">
                    {{ $project->title }}
                </h1>
                <div class="flex flex-wrap items-center gap-4 text-xs sm:text-sm text-slate-200">
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="map-pin" class="w-4 h-4 text-[#c29b53]"></i>
                        <span>{{ $project->masked_location }}</span>
                    </div>
                    @if($project->masked_client_name)
                        <span class="text-slate-400">•</span>
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="building" class="w-4 h-4 text-[#c29b53]"></i>
                            <span>Klien: {{ $project->masked_client_name }}</span>
                        </div>
                    @endif
                </div>
            </div>

            @auth
            <div class="flex items-center gap-3">
                <a href="{{ route('rfp.create', ['category' => $project->service?->slug, 'notes' => 'Terkait referensi: ' . $project->title]) }}"
                   class="px-6 py-3 bg-[#c29b53] hover:bg-[#ad8741] text-white text-xs sm:text-sm font-bold uppercase tracking-wider rounded-lg shadow-xl shadow-black/20 transition">
                    Ajukan Proyek Sejenis
                </a>
            </div>
            @endauth
        </div>
    </div>
</section>

<!-- ========================================================
     MAIN CONTENT BODY (Matching PT MKP Layout)
========================================================= -->
<section class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 sm:-mt-20 mb-20">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Main Column: Media & Engineering Narratives -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Before & After Interactive Slider (If both exist) -->
            @if($beforeImage && $afterImage)
                <div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200 shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-sans text-base sm:text-lg font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                            <i data-lucide="sliders-horizontal" class="w-5 h-5 text-[#c29b53]"></i>
                            <span>Perbandingan Fasad: Sebelum & Sesudah</span>
                        </h2>
                        <span class="text-xs text-slate-500 font-medium">Geser untuk membandingkan</span>
                    </div>

                    <div x-data="{ sliderPos: 50, isDragging: false }"
                         class="relative w-full aspect-[16/10] rounded-xl overflow-hidden select-none cursor-ew-resize border border-slate-200"
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

                        <!-- After Image -->
                        <img src="{{ asset($afterImage->image_path) }}" alt="Sesudah Pengerjaan Enzo"
                             class="absolute inset-0 w-full h-full object-cover pointer-events-none">
                        <span class="absolute top-4 right-4 bg-emerald-600/95 text-white text-xs px-3 py-1 rounded font-bold uppercase tracking-wider z-10 shadow">
                            Sesudah (After)
                        </span>

                        <!-- Before Image -->
                        <div class="absolute inset-0 overflow-hidden pointer-events-none"
                             :style="`width: ${sliderPos}%`">
                            <img src="{{ asset($beforeImage->image_path) }}" alt="Sebelum Pengerjaan Enzo"
                                 class="absolute inset-0 w-full h-full object-cover max-w-none"
                                 style="width: 100%; min-width: 100%;">
                            <span class="absolute top-4 left-4 bg-slate-900/90 text-white text-xs px-3 py-1 rounded font-bold uppercase tracking-wider z-10 shadow">
                                Sebelum (Before)
                            </span>
                        </div>

                        <!-- Handle -->
                        <div class="absolute top-0 bottom-0 z-20 pointer-events-none flex items-center justify-center"
                             :style="`left: ${sliderPos}%; transform: translateX(-50%);`">
                            <div class="w-1 bg-[#c29b53] h-full shadow-[0_0_10px_rgba(194,155,83,0.8)]"></div>
                            <div class="absolute w-9 h-9 rounded-full bg-[#c29b53] border-2 border-white shadow-xl flex items-center justify-center text-white">
                                <i data-lucide="chevrons-left-right" class="w-4 h-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Main Gallery Cover Image -->
                <div class="rounded-2xl overflow-hidden border border-slate-200 aspect-[16/10] relative shadow-xl bg-slate-100">
                    @php
                        $mainImg = $galleryImages->first()?->image_path ?? 'images/hero_architecture.jpg';
                    @endphp
                    <img src="{{ asset($mainImg) }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <!-- Engineering Narrative (Challenges & Solutions) -->
            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-xl space-y-8">
                <div>
                    <h2 class="font-sans text-base sm:text-lg font-bold text-slate-900 mb-3 flex items-center gap-2 uppercase tracking-wide">
                        <i data-lucide="alert-triangle" class="w-5 h-5 text-[#c29b53]"></i>
                        <span>Tantangan Rekayasa & Kondisi Lapangan</span>
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-light">
                        {{ $project->challenge_description ?? 'Proyek ini memerlukan penanganan khusus terkait kondisi daya dukung tanah, integrasi struktur eksisting tanpa mengganggu operasional lingkungan sekitar, serta penjadwalan ketat untuk memastikan tidak terjadi keterlambatan serah terima.' }}
                    </p>
                </div>

                <div class="pt-6 border-t border-slate-100">
                    <h2 class="font-sans text-base sm:text-lg font-bold text-slate-900 mb-3 flex items-center gap-2 uppercase tracking-wide">
                        <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600"></i>
                        <span>Solusi & Metode Rekayasa Enzo</span>
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-light">
                        {{ $project->solution_description ?? 'Tim rekayasa kami menerapkan metode konstruksi modular presisi, perkuatan struktur bertulang dengan standar mutu K-350, serta pengawasan berkala berbasis pemodelan 3D guna menjamin ketepatan dimensi milimeter.' }}
                    </p>
                </div>
            </div>

            <!-- Gallery Grid (If multiple images) -->
            @if($galleryImages->count() > 1)
                <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-xl">
                    <h3 class="font-sans text-base sm:text-lg font-bold text-slate-900 uppercase tracking-wide mb-6">Galeri Dokumentasi Lapangan</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($galleryImages as $img)
                            <div class="group relative rounded-xl overflow-hidden border border-slate-200 aspect-[4/3] bg-slate-100 shadow-sm">
                                <img src="{{ asset($img->image_path) }}" alt="{{ $img->caption ?? $project->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @if($img->caption)
                                    <div class="absolute inset-x-0 bottom-0 p-2 bg-gradient-to-t from-black/80 to-transparent text-[11px] text-white truncate font-light">
                                        {{ $img->caption }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        <!-- Sidebar Column: Specifications & CTA -->
        <div class="space-y-8">
            
            <!-- Technical Specs Box -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-xl">
                <h3 class="font-sans text-sm font-bold text-slate-900 uppercase tracking-wider mb-6 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <i data-lucide="layers" class="w-4 h-4 text-[#c29b53]"></i>
                    <span>Spesifikasi Teknis Proyek</span>
                </h3>

                <div class="space-y-4 text-xs">
                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500 font-medium">Kategori Pekerjaan</span>
                        <span class="font-bold text-slate-800 uppercase">{{ $project->project_type }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500 font-medium">Luas Bangunan</span>
                        <span class="font-bold text-slate-800">{{ $project->building_area_sqm ? number_format($project->building_area_sqm, 0) . ' m²' : '-' }}</span>
                    </div>
                    @if($project->land_area_sqm)
                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500 font-medium">Luas Tanah</span>
                        <span class="font-bold text-slate-800">{{ number_format($project->land_area_sqm, 0) . ' m²' }}</span>
                    </div>
                    @endif
                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500 font-medium">Durasi Pengerjaan</span>
                        <span class="font-bold text-slate-800">{{ $project->duration ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500 font-medium">Tahun Penyelesaian</span>
                        <span class="font-bold text-slate-800">{{ $project->completion_year ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-slate-500 font-medium">Standar Keselamatan</span>
                        <span class="font-bold text-emerald-600">SMK3 (Zero Accident)</span>
                    </div>
                </div>
            </div>

            <!-- Direct Contact & RFP Card (Contrasting Dark PT MKP Box) -->
            <div class="bg-gradient-to-br from-[#1a2332] to-[#0f172a] p-6 sm:p-8 rounded-2xl shadow-xl text-white text-center">
                <div class="w-12 h-12 rounded-xl bg-[#c29b53]/20 text-[#c29b53] flex items-center justify-center mx-auto mb-4 border border-[#c29b53]/30">
                    <i data-lucide="send" class="w-6 h-6"></i>
                </div>
                <h3 class="font-sans text-base sm:text-lg font-bold text-white mb-2 uppercase tracking-wide">Tertarik Mewujudkan Proyek Serupa?</h3>
                <p class="text-xs text-slate-300 leading-relaxed mb-6 font-light">
                    Diskusikan denah dan kebutuhan bangunan Anda dengan tim estimator kami. Kami siap memberikan konsultasi teknis dan estimasi BOQ gratis.
                </p>
                <div class="space-y-3">
                    @auth
                    <a href="{{ route('rfp.create', ['category' => $project->service?->slug, 'notes' => 'Referensi: ' . $project->title]) }}"
                       class="w-full inline-flex items-center justify-center py-3 px-4 bg-[#c29b53] hover:bg-[#ad8741] text-white font-bold text-xs uppercase tracking-wider rounded-lg transition shadow-md">
                        Ajukan Proposal Tender (RFP)
                    </a>
                    @endauth
                    <a href="https://wa.me/{{ $settings['whatsapp'] ?? '6281348593725' }}?text={{ urlencode('Halo Enzo Contractor, saya tertarik dengan studi kasus ' . $project->title . '. Bisakah kita konsultasi?') }}"
                       target="_blank"
                       class="w-full inline-flex items-center justify-center py-3 px-4 bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 font-semibold text-xs rounded-lg transition">
                        <i data-lucide="message-circle" class="w-4 h-4 mr-1.5 text-emerald-400"></i>
                        <span>Diskusi via WhatsApp</span>
                    </a>
                </div>
            </div>

            <!-- Related Projects -->
            @if($relatedProjects->isNotEmpty())
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xl">
                    <h3 class="font-sans text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100">
                        Proyek Terkait Lainnya
                    </h3>
                    <div class="space-y-4">
                        @foreach($relatedProjects as $rel)
                            <a href="{{ route('projects.show', $rel->slug) }}" class="flex items-center gap-3 group">
                                <div class="w-14 h-14 rounded-lg overflow-hidden bg-slate-100 shrink-0 border border-slate-200">
                                    @php
                                        $relThumb = $rel->images->first()?->image_path ?? 'images/project_commercial.jpg';
                                    @endphp
                                    <img src="{{ asset($relThumb) }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#c29b53] truncate transition uppercase">{{ $rel->title }}</h4>
                                    <span class="text-[11px] text-slate-500 block truncate">{{ $rel->location }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

    </div>
</section>

@endsection
