@extends('layouts.app')

@section('title', 'Katalog Portofolio Proyek — ENZO Contractor')
@section('meta_description', 'Eksplorasi rekam jejak pembangunan gedung komersial, perumahan mewah, pergudangan, dan renovasi fasad oleh Enzo Contractor.')

@section('content')

<!-- ========================================================
     HERO SECTION (Strictly Matching PT MKP Mockup Style)
========================================================= -->
<section class="relative min-h-[380px] sm:min-h-[420px] flex items-center justify-center overflow-hidden">
    <!-- Clean Architectural Twilight Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/ptmkp_hero_clean.jpg') }}"
             alt="Enzo Luxury Modern Villa at Dusk"
             class="w-full h-full object-cover object-center">
        <!-- Subtle dark overlay ensuring clear text readability -->
        <div class="absolute inset-0 bg-slate-950/50"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-slate-950/40"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center pt-20 pb-28">
        <span class="inline-block text-xs font-bold text-[#c29b53] uppercase tracking-widest mb-3 font-sans">
            Portofolio & Rekayasa Konstruksi
        </span>
        <h1 class="font-sans text-3xl sm:text-5xl font-extrabold tracking-wide text-white uppercase leading-tight">
            Katalog Rekam Jejak <span class="text-[#c29b53]">Proyek Konstruksi</span>
        </h1>
        <p class="text-xs sm:text-sm text-slate-100 font-light max-w-xl mx-auto mt-3 leading-relaxed tracking-normal">
            Dokumentasi terverifikasi proyek komersial, residensial mewah, pergudangan industri, dan peremajaan fasad yang diselesaikan dengan standar rekayasa tertinggi.
        </p>
    </div>
</section>

<!-- ========================================================
     WHITE FLOATING CONTAINER (Matching PT MKP Layout)
========================================================= -->
<section class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 sm:-mt-24 mb-20">
    <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl p-6 sm:p-10 border border-slate-100">

        <!-- Filter & Search Bar -->
        <div class="pb-8 mb-8 border-b border-slate-100">
            <form action="{{ route('projects.index') }}" method="GET" class="flex flex-col lg:flex-row items-center justify-between gap-4">
                
                <!-- Category Tabs -->
                <div class="flex items-center overflow-x-auto w-full lg:w-auto pb-2 lg:pb-0 gap-1.5 text-xs font-semibold">
                    <a href="{{ route('projects.index', array_merge(request()->query(), ['category' => 'all'])) }}"
                       class="px-4 py-2.5 rounded-lg whitespace-nowrap transition {{ (!$category || $category === 'all') ? 'bg-[#c29b53] text-white font-bold shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-200' }}">
                        Semua ({{ $stats['total'] }})
                    </a>
                    <a href="{{ route('projects.index', array_merge(request()->query(), ['category' => 'commercial'])) }}"
                       class="px-4 py-2.5 rounded-lg whitespace-nowrap transition {{ $category === 'commercial' ? 'bg-[#c29b53] text-white font-bold shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-200' }}">
                        Komersial ({{ $stats['commercial'] }})
                    </a>
                    <a href="{{ route('projects.index', array_merge(request()->query(), ['category' => 'residential'])) }}"
                       class="px-4 py-2.5 rounded-lg whitespace-nowrap transition {{ $category === 'residential' ? 'bg-[#c29b53] text-white font-bold shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-200' }}">
                        Residensial Mewah ({{ $stats['residential'] }})
                    </a>
                    <a href="{{ route('projects.index', array_merge(request()->query(), ['category' => 'industrial'])) }}"
                       class="px-4 py-2.5 rounded-lg whitespace-nowrap transition {{ $category === 'industrial' ? 'bg-[#c29b53] text-white font-bold shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-200' }}">
                        Industri & Baja ({{ $stats['industrial'] }})
                    </a>
                </div>

                <!-- Search & Status Filter -->
                <div class="flex items-center gap-3 w-full lg:w-auto">
                    <div class="relative flex-1 lg:w-72">
                        <input type="text" name="q" value="{{ $search }}"
                               placeholder="Cari nama proyek atau lokasi..."
                               class="w-full bg-slate-50 border border-slate-200 rounded-lg pl-9 pr-4 py-2.5 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-[#c29b53] transition">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-3"></i>
                    </div>

                    <select name="status" onchange="this.form.submit()"
                            class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-xs text-slate-700 focus:outline-none focus:border-[#c29b53]">
                        <option value="all" {{ (!$status || $status === 'all') ? 'selected' : '' }}>Semua Status</option>
                        <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="ongoing" {{ $status === 'ongoing' ? 'selected' : '' }}>Sedang Berjalan</option>
                    </select>

                    <button type="submit" class="bg-[#c29b53] hover:bg-[#ad8741] text-white font-bold px-5 py-2.5 rounded-lg text-xs uppercase tracking-wider transition shadow-md">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Projects Grid -->
        @if($projects->isEmpty())
            <div class="text-center py-16 bg-slate-50 rounded-2xl border border-slate-200 p-8">
                <div class="w-16 h-16 rounded-full bg-slate-200/80 flex items-center justify-center mx-auto text-[#c29b53] mb-4">
                    <i data-lucide="folder-search" class="w-8 h-8"></i>
                </div>
                <h3 class="font-sans text-lg font-bold text-slate-800 mb-2 uppercase tracking-wide">Tidak Ada Proyek yang Cocok</h3>
                <p class="text-xs text-slate-500 max-w-md mx-auto mb-6">
                    Kriteria pencarian Anda tidak menemukan hasil. Coba atur ulang filter pencarian atau jelajahi kategori lainnya.
                </p>
                <a href="{{ route('projects.index') }}" class="inline-flex items-center px-5 py-2.5 bg-[#c29b53] hover:bg-[#ad8741] text-white rounded-lg text-xs font-bold uppercase tracking-wider transition shadow-md">
                    Reset Filter Pencarian
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($projects as $project)
                    <div class="group bg-white rounded-2xl overflow-hidden border border-slate-200 hover:border-[#c29b53] hover:shadow-2xl transition-all duration-300 flex flex-col justify-between shadow-md hover:-translate-y-1">
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
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/75 via-transparent to-black/20"></div>

                                <span class="absolute top-3 left-3 px-2.5 py-1 rounded bg-[#1a2332]/90 backdrop-blur-sm text-[10px] font-bold uppercase tracking-wider text-[#c29b53] border border-[#c29b53]/40">
                                    {{ $project->project_type }}
                                </span>

                                <span class="absolute top-3 right-3 px-2.5 py-1 rounded {{ $project->status === 'completed' ? 'bg-emerald-600/90 text-white' : 'bg-[#c29b53]/90 text-white' }} text-[10px] font-bold tracking-wider uppercase backdrop-blur-sm shadow">
                                    {{ $project->status === 'completed' ? 'Selesai' : 'Sedang Berjalan' }}
                                </span>
                            </div>

                            <!-- Info -->
                            <div class="p-6">
                                <h3 class="font-sans text-base sm:text-lg font-bold text-slate-900 mb-2 group-hover:text-[#c29b53] transition uppercase tracking-wide">
                                    <a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a>
                                </h3>
                                
                                <div class="flex items-center gap-1.5 text-xs text-slate-500 mb-4">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#c29b53] shrink-0"></i>
                                    <span class="truncate">{{ $project->masked_location }}</span>
                                    @if($project->masked_client_name)
                                        <span class="text-slate-300">•</span>
                                        <span class="truncate text-slate-400">{{ $project->masked_client_name }}</span>
                                    @endif
                                </div>

                                <div class="grid grid-cols-2 gap-2 text-xs bg-slate-50 p-3 rounded-xl border border-slate-200 mb-4">
                                    <div>
                                        <span class="text-slate-400 block text-[10px] uppercase font-semibold">Luas Bangunan:</span>
                                        <span class="font-bold text-slate-800">{{ $project->building_area_sqm ? number_format($project->building_area_sqm, 0) . ' m²' : '-' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[10px] uppercase font-semibold">Tahun / Durasi:</span>
                                        <span class="font-bold text-slate-800">{{ $project->completion_year ?? $project->duration }}</span>
                                    </div>
                                </div>

                                @if($project->challenge_description)
                                    <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed font-light">
                                        {{ $project->challenge_description }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="px-6 pb-6 pt-3 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ route('projects.show', $project->slug) }}"
                               class="text-xs font-bold text-[#c29b53] hover:text-[#ad8741] flex items-center gap-1 group-hover:translate-x-1 transition-transform uppercase tracking-wider">
                                <span>Lihat Detail Proyek</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </a>
                            @auth
                            <a href="{{ route('rfp.create', ['notes' => 'Terkait proyek: ' . $project->title]) }}"
                               class="text-[11px] text-slate-400 hover:text-slate-700 underline font-medium">
                                Ajukan Serupa
                            </a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $projects->links() }}
            </div>
        @endif

    </div>
</section>

@endsection
