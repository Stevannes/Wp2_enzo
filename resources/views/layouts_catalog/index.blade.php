@extends('layouts.app')

@section('title', 'Katalog Referensi Desain & Layout Siap Bangun — ENZO Contractor')
@section('meta_description', 'Katalog referensi denah dan layout arsitektur siap pakai. Pilihan desain hunian standar hingga custom rancangan sendiri oleh Enzo Contractor.')

@section('content')

<!-- ========================================================
     HERO SECTION (Strictly Matching PT MKP Mockup Style)
========================================================= -->
<section class="relative min-h-[380px] sm:min-h-[420px] flex items-center justify-center overflow-hidden">
    <!-- Clean Architectural Twilight Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/ptmkp_hero_clean.jpg') }}"
             alt="Enzo Architectural Design Catalog Hero"
             class="w-full h-full object-cover object-center">
        <!-- Subtle dark overlay -->
        <div class="absolute inset-0 bg-slate-950/50"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-slate-950/40"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center pt-20 pb-28">
        <span class="inline-block text-xs font-bold text-[#c29b53] uppercase tracking-widest mb-3 font-sans">
            Ready-To-Build Architectural Layouts
        </span>
        <h1 class="font-sans text-3xl sm:text-5xl font-extrabold tracking-wide text-white uppercase leading-tight">
            Katalog Referensi Desain & <span class="text-[#c29b53]">Layout Siap Bangun</span>
        </h1>
        <p class="text-xs sm:text-sm text-slate-100 font-light max-w-xl mx-auto mt-3 leading-relaxed tracking-normal">
            Pilihan konsep tata letak standar teruji siap bangun di bawah ini, atau ajukan rancangan kustom Anda sendiri bersama tim arsitek kami.
        </p>
    </div>
</section>

<!-- ========================================================
     WHITE FLOATING CONTAINER (Matching PT MKP Layout)
========================================================= -->
<section class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 sm:-mt-24 mb-20">
    <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl p-6 sm:p-10 border border-slate-100">

        <!-- Filter Bar -->
        <div class="pb-8 mb-8 border-b border-slate-100">
            <form action="{{ route('layouts.index') }}" method="GET" class="flex flex-col lg:flex-row items-center justify-between gap-4">
                
                <!-- Category Tabs -->
                <div class="flex items-center overflow-x-auto w-full lg:w-auto pb-2 lg:pb-0 gap-1.5 text-xs font-semibold">
                    <a href="{{ route('layouts.index', array_merge(request()->query(), ['category' => 'all'])) }}"
                       class="px-4 py-2.5 rounded-lg whitespace-nowrap transition {{ (!$category || $category === 'all') ? 'bg-[#c29b53] text-white font-bold shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-200' }}">
                        Semua Desain ({{ $stats['total'] }})
                    </a>
                    <a href="{{ route('layouts.index', array_merge(request()->query(), ['category' => 'minimalis'])) }}"
                       class="px-4 py-2.5 rounded-lg whitespace-nowrap transition {{ $category === 'minimalis' ? 'bg-[#c29b53] text-white font-bold shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-200' }}">
                        Minimalis Modern
                    </a>
                    <a href="{{ route('layouts.index', array_merge(request()->query(), ['category' => 'skandinavia'])) }}"
                       class="px-4 py-2.5 rounded-lg whitespace-nowrap transition {{ $category === 'skandinavia' ? 'bg-[#c29b53] text-white font-bold shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-200' }}">
                        Skandinavia Split-Level
                    </a>
                    <a href="{{ route('layouts.index', array_merge(request()->query(), ['category' => 'industrial'])) }}"
                       class="px-4 py-2.5 rounded-lg whitespace-nowrap transition {{ $category === 'industrial' ? 'bg-[#c29b53] text-white font-bold shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-200' }}">
                        Industrial Contemporary
                    </a>
                    <a href="{{ route('layouts.index', array_merge(request()->query(), ['category' => 'tropis_modern'])) }}"
                       class="px-4 py-2.5 rounded-lg whitespace-nowrap transition {{ $category === 'tropis_modern' ? 'bg-[#c29b53] text-white font-bold shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-200' }}">
                        Tropis Villa Mewah
                    </a>
                </div>

                <!-- Search & Floor Filter -->
                <div class="flex items-center gap-3 w-full lg:w-auto">
                    <select name="floors" onchange="this.form.submit()"
                            class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-xs text-slate-700 focus:outline-none focus:border-[#c29b53]">
                        <option value="all" {{ (!$floors || $floors === 'all') ? 'selected' : '' }}>Semua Lantai</option>
                        <option value="1" {{ $floors === '1' ? 'selected' : '' }}>1 Lantai ({{ $stats['1_floor'] }})</option>
                        <option value="2" {{ $floors === '2' ? 'selected' : '' }}>2 Lantai ({{ $stats['2_floors'] }})</option>
                    </select>

                    <div class="relative flex-1 lg:w-64">
                        <input type="text" name="q" value="{{ $search }}"
                               placeholder="Cari tipe atau nama layout..."
                               class="w-full bg-slate-50 border border-slate-200 rounded-lg pl-9 pr-4 py-2.5 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-[#c29b53]">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-3"></i>
                    </div>

                    <button type="submit" class="bg-[#c29b53] hover:bg-[#ad8741] text-white font-bold px-4 py-2.5 rounded-lg text-xs uppercase tracking-wider transition shadow-md">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Custom Upload Notice Ribbon -->
        <div class="mb-10">
            <div class="bg-gradient-to-r from-[#1a2332] via-[#222e42] to-[#1a2332] p-6 rounded-2xl shadow-xl flex flex-col md:flex-row items-center justify-between gap-4 text-white">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-[#c29b53]/20 text-[#c29b53] flex items-center justify-center shrink-0 border border-[#c29b53]/30">
                        <i data-lucide="compass" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-sans text-sm sm:text-base font-bold text-white uppercase tracking-wide">Sudah Memiliki Denah Sendiri atau Ingin Desain Kustom Penuh?</h3>
                        <p class="text-xs text-slate-300 font-light mt-0.5">
                            Unggah berkas CAD/PDF denah Anda langsung di formulir RFP Tender untuk konsultasi DED gratis bersama tim arsitek kami.
                        </p>
                    </div>
                </div>
                <a href="{{ route('rfp.create') }}"
                   class="px-6 py-2.5 bg-[#c29b53] hover:bg-[#ad8741] text-white text-xs font-bold uppercase tracking-wider rounded-lg whitespace-nowrap transition shadow-md shrink-0">
                    Unggah Desain Kustom &rarr;
                </a>
            </div>
        </div>

        <!-- Layouts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($layouts as $layout)
                <div class="group bg-white rounded-2xl overflow-hidden border border-slate-200 hover:border-[#c29b53] hover:shadow-2xl transition-all duration-300 flex flex-col justify-between shadow-md hover:-translate-y-1">
                    <div>
                        <!-- Visual Render Image -->
                        <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                            <img src="{{ asset($layout->render_3d_image ?: 'images/project_residential.jpg') }}" alt="{{ $layout->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-black/20"></div>

                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded bg-[#1a2332]/90 backdrop-blur-sm text-[10px] font-bold uppercase tracking-wider text-[#c29b53] border border-[#c29b53]/40">
                                {{ $layout->building_type }}
                            </span>

                            <span class="absolute top-3 right-3 px-2.5 py-1 rounded bg-slate-900/90 text-white text-[10px] font-bold uppercase tracking-wider shadow">
                                {{ $layout->floor_count }} Lantai
                            </span>
                        </div>

                        <!-- Info Body -->
                        <div class="p-6">
                            <h3 class="font-sans text-base sm:text-lg font-bold text-slate-900 uppercase tracking-wide mb-2 group-hover:text-[#c29b53] transition">
                                <a href="{{ route('layouts.show', $layout->slug) }}">{{ $layout->name }}</a>
                            </h3>

                            <!-- Dimension Metrics Ribbon -->
                            <div class="grid grid-cols-4 gap-2 text-center text-xs bg-slate-50 p-3 rounded-xl border border-slate-200 my-4">
                                <div>
                                    <span class="text-slate-400 block text-[10px] uppercase font-semibold">L. Bangunan</span>
                                    <span class="font-bold text-[#c29b53]">{{ (int)$layout->building_size_sqm }} m²</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[10px] uppercase font-semibold">Min. Lahan</span>
                                    <span class="font-bold text-slate-800">{{ (int)$layout->land_size_sqm }} m²</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[10px] uppercase font-semibold">Kamar</span>
                                    <span class="font-bold text-slate-800">{{ $layout->bedrooms }} KT</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block text-[10px] uppercase font-semibold">Toilet</span>
                                    <span class="font-bold text-slate-800">{{ $layout->bathrooms }} KM</span>
                                </div>
                            </div>

                            <p class="text-xs text-slate-600 leading-relaxed font-light line-clamp-2 mb-4">
                                {{ $layout->specifications_summary }}
                            </p>

                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-[11px] text-slate-500 font-medium">Estimasi Biaya:</span>
                                <span class="font-sans text-sm font-bold text-emerald-700">
                                    Rp {{ number_format($layout->estimated_price_idr / 1000000, 0, ',', '.') }} Juta*
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Action CTA -->
                    <div class="px-6 pb-6 pt-2 border-t border-slate-100 flex items-center justify-between gap-2">
                        <a href="{{ route('layouts.show', $layout->slug) }}"
                           class="text-xs font-bold text-slate-600 hover:text-[#c29b53] flex items-center gap-1 transition uppercase tracking-wider">
                            <span>Detail Denah</span>
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                        </a>

                        @auth
                        <a href="{{ route('rfp.create', ['layout_id' => $layout->id, 'category' => $layout->building_type, 'area' => $layout->building_size_sqm, 'budget' => $layout->estimated_price_idr]) }}"
                           class="px-4 py-2 bg-[#c29b53] hover:bg-[#ad8741] text-white font-bold text-xs uppercase tracking-wider rounded-lg transition shadow-md">
                            Pilih & Ajukan
                        </a>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $layouts->links() }}
        </div>

    </div>
</section>

@endsection
