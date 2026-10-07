@extends('layouts.app')

@section('title', $project->title . ' — Studi Kasus ENZO Contractor')
@section('meta_description', 'Detail studi kasus rekayasa konstruksi: ' . $project->title . '. Tantangan lapangan dan solusi rekayasa oleh Enzo Contractor.')

@section('content')

<!-- Project Breadcrumb & Header -->
<section class="py-16 bg-[#060A14] border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-slate-400 mb-6">
            <a href="{{ route('home') }}" class="hover:text-amber-400">Beranda</a>
            <span>/</span>
            <a href="{{ route('projects.index') }}" class="hover:text-amber-400">Portofolio</a>
            <span>/</span>
            <span class="text-amber-400 font-semibold truncate">{{ $project->title }}</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
            <div class="max-w-3xl">
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-2.5 py-1 rounded bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-bold uppercase tracking-wider">
                        {{ $project->project_type }}
                    </span>
                    <span class="px-2.5 py-1 rounded {{ $project->status === 'completed' ? 'bg-emerald-950/80 text-emerald-400 border border-emerald-500/40' : 'bg-amber-950/80 text-amber-400 border border-amber-500/40' }} text-xs font-semibold">
                        Status: {{ $project->status === 'completed' ? 'Telah Selesai' : 'Dalam Pengerjaan' }}
                    </span>
                </div>
                <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4">
                    {{ $project->title }}
                </h1>
                <div class="flex flex-wrap items-center gap-4 text-xs sm:text-sm text-slate-300">
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="map-pin" class="w-4 h-4 text-amber-500"></i>
                        <span>{{ $project->location }}</span>
                    </div>
                    @if($project->client_name)
                        <span>•</span>
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="building" class="w-4 h-4 text-amber-500"></i>
                            <span>Klien: {{ $project->client_name }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('rfp.create', ['category' => $project->service?->slug, 'notes' => 'Terkait referensi: ' . $project->title]) }}"
                   class="px-6 py-3 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-slate-950 text-xs sm:text-sm font-bold rounded-lg shadow-xl shadow-amber-500/20 transition">
                    Ajukan Proyek Sejenis
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Content Body -->
<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        
        <!-- Main Column: Media & Engineering Narratives -->
        <div class="lg:col-span-2 space-y-12">
            
            <!-- Before & After Interactive Slider (If both exist) -->
            @if($beforeImage && $afterImage)
                <div class="glass-panel p-4 sm:p-6 rounded-2xl border border-amber-500/30">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-serif text-lg font-bold text-white flex items-center gap-2">
                            <i data-lucide="sliders-horizontal" class="w-5 h-5 text-amber-400"></i>
                            <span>Perbandingan Fasad: Sebelum & Sesudah</span>
                        </h2>
                        <span class="text-xs text-amber-400/80 font-medium">Geser untuk membandingkan</span>
                    </div>

                    <div x-data="{ sliderPos: 50, isDragging: false }"
                         class="relative w-full aspect-[16/10] rounded-xl overflow-hidden select-none cursor-ew-resize border border-slate-800"
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
                        <span class="absolute top-4 right-4 bg-emerald-950/90 border border-emerald-500/50 text-emerald-300 text-xs px-3 py-1 rounded-md font-bold uppercase tracking-wider z-10 backdrop-blur-md">
                            Sesudah (After)
                        </span>

                        <!-- Before Image -->
                        <div class="absolute inset-0 overflow-hidden pointer-events-none"
                             :style="`width: ${sliderPos}%`">
                            <img src="{{ asset($beforeImage->image_path) }}" alt="Sebelum Pengerjaan Enzo"
                                 class="absolute inset-0 w-full h-full object-cover max-w-none"
                                 style="width: 100%; min-width: 100%;">
                            <span class="absolute top-4 left-4 bg-slate-900/90 border border-slate-700 text-slate-300 text-xs px-3 py-1 rounded-md font-bold uppercase tracking-wider z-10 backdrop-blur-md">
                                Sebelum (Before)
                            </span>
                        </div>

                        <!-- Handle -->
                        <div class="absolute top-0 bottom-0 z-20 pointer-events-none flex items-center justify-center"
                             :style="`left: ${sliderPos}%; transform: translateX(-50%);`">
                            <div class="w-1 bg-amber-400 h-full shadow-[0_0_12px_rgba(245,158,11,0.9)]"></div>
                            <div class="absolute w-10 h-10 rounded-full bg-amber-500 border-2 border-white shadow-2xl flex items-center justify-center text-slate-950">
                                <i data-lucide="chevrons-left-right" class="w-5 h-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Main Gallery Cover Image -->
                <div class="rounded-2xl overflow-hidden border border-slate-800 aspect-[16/10] relative shadow-2xl">
                    @php
                        $mainImg = $galleryImages->first()?->image_path ?? 'images/hero_architecture.jpg';
                    @endphp
                    <img src="{{ asset($mainImg) }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <!-- Engineering Narrative (Challenges & Solutions) -->
            <div class="bg-[#0B1220] p-8 rounded-2xl border border-slate-800 space-y-8">
                <div>
                    <h2 class="font-serif text-xl font-bold text-white mb-3 flex items-center gap-2">
                        <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-500"></i>
                        <span>Tantangan Rekayasa & Kondisi Lapangan</span>
                    </h2>
                    <p class="text-sm text-slate-300 leading-relaxed">
                        {{ $project->challenge_description ?? 'Proyek ini memerlukan penanganan khusus terkait kondisi daya dukung tanah, integrasi struktur eksisting tanpa mengganggu operasional lingkungan sekitar, serta penjadwalan ketat untuk memastikan tidak terjadi keterlambatan serah terima.' }}
                    </p>
                </div>

                <div class="pt-6 border-t border-slate-800/80">
                    <h2 class="font-serif text-xl font-bold text-white mb-3 flex items-center gap-2">
                        <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-400"></i>
                        <span>Solusi & Metode Rekayasa Enzo</span>
                    </h2>
                    <p class="text-sm text-slate-300 leading-relaxed">
                        {{ $project->solution_description ?? 'Tim rekayasa kami menerapkan metode konstruksi modular presisi, perkuatan struktur bertulang dengan standar mutu K-350, serta pengawasan berkala berbasis pemodelan 3D guna menjamin ketepatan dimensi milimeter.' }}
                    </p>
                </div>
            </div>

            <!-- Gallery Grid (If multiple images) -->
            @if($galleryImages->count() > 1)
                <div>
                    <h3 class="font-serif text-xl font-bold text-white mb-6">Galeri Dokumentasi Lapangan</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($galleryImages as $img)
                            <div class="group relative rounded-xl overflow-hidden border border-slate-800 aspect-[4/3]">
                                <img src="{{ asset($img->image_path) }}" alt="{{ $img->caption ?? $project->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @if($img->caption)
                                    <div class="absolute inset-x-0 bottom-0 p-2 bg-gradient-to-t from-black/90 to-transparent text-[11px] text-slate-300 truncate">
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
            <div class="bg-[#0B1220] p-6 rounded-2xl border border-slate-800 shadow-xl">
                <h3 class="font-serif text-base font-bold text-white uppercase tracking-wider mb-6 pb-3 border-b border-slate-800 flex items-center gap-2">
                    <i data-lucide="layers" class="w-4 h-4 text-amber-500"></i>
                    <span>Spesifikasi Teknis Proyek</span>
                </h3>

                <div class="space-y-4 text-xs">
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-800/60">
                        <span class="text-slate-400">Kategori Pekerjaan</span>
                        <span class="font-semibold text-slate-200 uppercase">{{ $project->project_type }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-800/60">
                        <span class="text-slate-400">Luas Bangunan</span>
                        <span class="font-semibold text-slate-200">{{ $project->building_area_sqm ? number_format($project->building_area_sqm, 0) . ' m²' : '-' }}</span>
                    </div>
                    @if($project->land_area_sqm)
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-800/60">
                        <span class="text-slate-400">Luas Tanah</span>
                        <span class="font-semibold text-slate-200">{{ number_format($project->land_area_sqm, 0) . ' m²' }}</span>
                    </div>
                    @endif
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-800/60">
                        <span class="text-slate-400">Durasi Pengerjaan</span>
                        <span class="font-semibold text-slate-200">{{ $project->duration ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-800/60">
                        <span class="text-slate-400">Tahun Penyelesaian</span>
                        <span class="font-semibold text-slate-200">{{ $project->completion_year ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5">
                        <span class="text-slate-400">Standar Keselamatan</span>
                        <span class="font-semibold text-emerald-400">SMK3 Kemenaker (Zero Accident)</span>
                    </div>
                </div>
            </div>

            <!-- Direct Contact & RFP Card -->
            <div class="bg-gradient-to-b from-amber-950/40 to-[#0A101D] p-6 rounded-2xl border border-amber-500/30 text-center">
                <div class="w-12 h-12 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="send" class="w-6 h-6"></i>
                </div>
                <h3 class="font-serif text-lg font-bold text-white mb-2">Tertarik Mewujudkan Proyek Serupa?</h3>
                <p class="text-xs text-slate-300 leading-relaxed mb-6 font-light">
                    Diskusikan denah dan kebutuhan bangunan Anda dengan tim estimator kami. Kami siap memberikan konsultasi teknis dan estimasi BOQ gratis.
                </p>
                <div class="space-y-3">
                    <a href="{{ route('rfp.create', ['category' => $project->service?->slug, 'notes' => 'Referensi: ' . $project->title]) }}"
                       class="w-full inline-flex items-center justify-center py-3 px-4 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs rounded-lg transition">
                        Ajukan Proposal Tender (RFP)
                    </a>
                    <a href="https://wa.me/{{ $settings['whatsapp'] ?? '6281348593725' }}?text={{ urlencode('Halo Enzo Contractor, saya tertarik dengan studi kasus ' . $project->title . '. Bisakah kita konsultasi?') }}"
                       target="_blank"
                       class="w-full inline-flex items-center justify-center py-3 px-4 bg-slate-900 hover:bg-slate-800 text-slate-200 border border-slate-700 font-semibold text-xs rounded-lg transition">
                        <i data-lucide="message-circle" class="w-4 h-4 mr-1.5 text-emerald-400"></i>
                        <span>Diskusi via WhatsApp</span>
                    </a>
                </div>
            </div>

            <!-- Related Projects -->
            @if($relatedProjects->isNotEmpty())
                <div class="bg-[#0B1220] p-6 rounded-2xl border border-slate-800">
                    <h3 class="font-serif text-sm font-bold text-white uppercase tracking-wider mb-4 pb-2 border-b border-slate-800">
                        Proyek Terkait Lainnya
                    </h3>
                    <div class="space-y-4">
                        @foreach($relatedProjects as $rel)
                            <a href="{{ route('projects.show', $rel->slug) }}" class="flex items-center gap-3 group">
                                <div class="w-14 h-14 rounded-lg overflow-hidden bg-slate-800 shrink-0">
                                    @php
                                        $relThumb = $rel->images->first()?->image_path ?? 'images/project_commercial.jpg';
                                    @endphp
                                    <img src="{{ asset($relThumb) }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-xs font-semibold text-white group-hover:text-amber-400 truncate transition">{{ $rel->title }}</h4>
                                    <span class="text-[11px] text-slate-400 block truncate">{{ $rel->location }}</span>
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
