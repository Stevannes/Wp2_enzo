@extends('layouts.app')

@section('title', 'Katalog Portofolio Proyek — ENZO Contractor')
@section('meta_description', 'Eksplorasi rekam jejak pembangunan gedung komersial, perumahan mewah, pergudangan, dan renovasi fasad oleh Enzo Contractor.')

@section('content')

<!-- Header Section -->
<section class="relative py-20 bg-[#060A14] border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-semibold uppercase tracking-wider mb-4">
                <span>Portofolio & Studi Kasus Rekayasa</span>
            </div>
            <h1 class="font-serif text-3xl sm:text-5xl font-bold text-white mb-4">
                Katalog Rekam Jejak <span class="gold-gradient-text">Konstruksi Nyata</span>
            </h1>
            <p class="text-slate-400 text-sm sm:text-base leading-relaxed font-light">
                Dokumentasi terverifikasi proyek komersial, residensial, pergudangan industri, dan peremajaan fasad yang diselesaikan dengan standar rekayasa tertinggi.
            </p>
        </div>
    </div>
</section>

<!-- Filter & Search Bar (Wireframe 2) -->
<section class="py-8 bg-[#080D1A] border-b border-slate-800/80 sticky top-20 z-30 backdrop-blur-md bg-opacity-95">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form action="{{ route('projects.index') }}" method="GET" class="flex flex-col lg:flex-row items-center justify-between gap-4">
            
            <!-- Category Tabs -->
            <div class="flex items-center overflow-x-auto w-full lg:w-auto pb-2 lg:pb-0 gap-1.5 text-xs font-medium">
                <a href="{{ route('projects.index', array_merge(request()->query(), ['category' => 'all'])) }}"
                   class="px-4 py-2 rounded-lg whitespace-nowrap transition {{ (!$category || $category === 'all') ? 'bg-amber-500 text-slate-950 font-bold shadow' : 'bg-slate-900 text-slate-300 hover:text-white hover:bg-slate-800' }}">
                    Semua ({{ $stats['total'] }})
                </a>
                <a href="{{ route('projects.index', array_merge(request()->query(), ['category' => 'commercial'])) }}"
                   class="px-4 py-2 rounded-lg whitespace-nowrap transition {{ $category === 'commercial' ? 'bg-amber-500 text-slate-950 font-bold shadow' : 'bg-slate-900 text-slate-300 hover:text-white hover:bg-slate-800' }}">
                    Komersial ({{ $stats['commercial'] }})
                </a>
                <a href="{{ route('projects.index', array_merge(request()->query(), ['category' => 'residential'])) }}"
                   class="px-4 py-2 rounded-lg whitespace-nowrap transition {{ $category === 'residential' ? 'bg-amber-500 text-slate-950 font-bold shadow' : 'bg-slate-900 text-slate-300 hover:text-white hover:bg-slate-800' }}">
                    Residensial Mewah ({{ $stats['residential'] }})
                </a>
                <a href="{{ route('projects.index', array_merge(request()->query(), ['category' => 'industrial'])) }}"
                   class="px-4 py-2 rounded-lg whitespace-nowrap transition {{ $category === 'industrial' ? 'bg-amber-500 text-slate-950 font-bold shadow' : 'bg-slate-900 text-slate-300 hover:text-white hover:bg-slate-800' }}">
                    Industri & Baja ({{ $stats['industrial'] }})
                </a>
            </div>

            <!-- Search & Status Filter -->
            <div class="flex items-center gap-3 w-full lg:w-auto">
                <div class="relative flex-1 lg:w-72">
                    <input type="text" name="q" value="{{ $search }}"
                           placeholder="Cari nama proyek atau lokasi..."
                           class="w-full bg-slate-900 border border-slate-700 rounded-lg pl-9 pr-4 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-amber-500">
                    <i data-lucide="search" class="w-4 h-4 text-slate-500 absolute left-3 top-2.5"></i>
                </div>

                <select name="status" onchange="this.form.submit()"
                        class="bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-amber-500">
                    <option value="all" {{ (!$status || $status === 'all') ? 'selected' : '' }}>Semua Status</option>
                    <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="ongoing" {{ $status === 'ongoing' ? 'selected' : '' }}>Sedang Berjalan</option>
                </select>

                <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-4 py-2 rounded-lg text-xs transition">
                    Cari
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Projects Grid -->
<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    @if($projects->isEmpty())
        <div class="text-center py-20 bg-slate-900/40 rounded-2xl border border-slate-800 p-8">
            <div class="w-16 h-16 rounded-full bg-slate-800 flex items-center justify-center mx-auto text-amber-500 mb-4">
                <i data-lucide="folder-search" class="w-8 h-8"></i>
            </div>
            <h3 class="font-serif text-xl font-bold text-white mb-2">Tidak Ada Proyek yang Cocok</h3>
            <p class="text-xs text-slate-400 max-w-md mx-auto mb-6">
                Kriteria pencarian Anda tidak menemukan hasil. Coba atur ulang filter pencarian atau jelajahi kategori lainnya.
            </p>
            <a href="{{ route('projects.index') }}" class="inline-flex items-center px-4 py-2 bg-amber-500 text-slate-950 rounded-md text-xs font-bold hover:bg-amber-400 transition">
                Reset Filter Pencarian
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($projects as $project)
                <div class="group bg-[#0B1220] rounded-xl overflow-hidden border border-slate-800 hover:border-amber-500/50 transition-all duration-300 flex flex-col justify-between shadow-xl">
                    <div>
                        <!-- Thumbnail -->
                        <div class="relative aspect-[16/10] overflow-hidden">
                            @php
                                $thumb = $project->images->firstWhere('type', 'gallery')?->image_path
                                        ?? $project->images->first()?->image_path
                                        ?? 'images/project_commercial.jpg';
                            @endphp
                            <img src="{{ asset($thumb) }}" alt="{{ $project->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0B1220] via-transparent to-black/30"></div>

                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded bg-black/70 backdrop-blur-md text-[10px] font-bold uppercase tracking-wider text-amber-400 border border-amber-500/30">
                                {{ $project->project_type }}
                            </span>

                            <span class="absolute top-3 right-3 px-2 py-0.5 rounded {{ $project->status === 'completed' ? 'bg-emerald-950/80 text-emerald-400 border border-emerald-500/40' : 'bg-amber-950/80 text-amber-400 border border-amber-500/40' }} text-[10px] font-semibold">
                                {{ $project->status === 'completed' ? 'Selesai' : 'Sedang Berjalan' }}
                            </span>
                        </div>

                        <!-- Info -->
                        <div class="p-6">
                            <h3 class="font-serif text-lg font-bold text-white mb-2 group-hover:text-amber-400 transition">
                                <a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a>
                            </h3>
                            
                            <div class="flex items-center gap-1.5 text-xs text-slate-400 mb-4">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-amber-500 shrink-0"></i>
                                <span class="truncate">{{ $project->location }}</span>
                                @if($project->client_name)
                                    <span class="text-slate-600">•</span>
                                    <span class="truncate text-slate-500">{{ $project->client_name }}</span>
                                @endif
                            </div>

                            <div class="grid grid-cols-2 gap-2 text-xs bg-slate-900/60 p-3 rounded-lg border border-slate-800/80 mb-4">
                                <div>
                                    <span class="text-slate-500 block text-[10px]">Luas Bangunan:</span>
                                    <span class="font-semibold text-slate-200">{{ $project->building_area_sqm ? number_format($project->building_area_sqm, 0) . ' m²' : '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-500 block text-[10px]">Tahun / Durasi:</span>
                                    <span class="font-semibold text-slate-200">{{ $project->completion_year ?? $project->duration }}</span>
                                </div>
                            </div>

                            @if($project->challenge_description)
                                <p class="text-xs text-slate-400 line-clamp-2 leading-relaxed">
                                    {{ $project->challenge_description }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="px-6 pb-6 pt-2 border-t border-slate-800/60 flex items-center justify-between">
                        <a href="{{ route('projects.show', $project->slug) }}"
                           class="text-xs font-semibold text-amber-400 hover:text-amber-300 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            <span>Lihat Studi Kasus Lengkap</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                        <a href="{{ route('rfp.create', ['notes' => 'Terkait proyek: ' . $project->title]) }}"
                           class="text-[11px] text-slate-400 hover:text-white underline">
                            Ajukan Serupa
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $projects->links() }}
        </div>
    @endif
</section>

@endsection
