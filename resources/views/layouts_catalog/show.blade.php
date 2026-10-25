@extends('layouts.app')

@section('title', $layout->name . ' — Referensi Desain Layout ENZO Contractor')
@section('meta_description', 'Detail denah dan spesifikasi tata letak siap bangun ' . $layout->name . ' oleh tim arsitek Enzo Contractor.')

@section('content')

<!-- ========================================================
     HERO BANNER & BREADCRUMB (Strictly Matching PT MKP Mockup Style)
========================================================= -->
<section class="relative min-h-[380px] sm:min-h-[420px] flex items-center justify-center overflow-hidden">
    <!-- Clean Architectural Twilight Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/ptmkp_hero_clean.jpg') }}"
             alt="Design Layout Backdrop"
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
            <a href="{{ route('layouts.index') }}" class="hover:text-[#c29b53] transition">Katalog Desain & Layout</a>
            <span>/</span>
            <span class="text-[#c29b53] font-bold truncate">{{ $layout->name }}</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
            <div class="max-w-3xl">
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-2.5 py-1 rounded bg-[#1a2332]/90 text-[#c29b53] border border-[#c29b53]/40 text-xs font-bold uppercase tracking-wider backdrop-blur-sm">
                        {{ $layout->building_type }}
                    </span>
                    <span class="px-2.5 py-1 rounded bg-slate-800 text-slate-200 text-xs font-bold uppercase tracking-wider">
                        {{ $layout->floor_count }} Lantai • {{ $layout->bedrooms }} KT / {{ $layout->bathrooms }} KM
                    </span>
                </div>
                <h1 class="font-sans text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white mb-3 tracking-wide uppercase leading-tight">
                    {{ $layout->name }}
                </h1>
                <p class="text-slate-200 text-xs sm:text-sm leading-relaxed font-light">
                    Konsep arsitektural {{ ucfirst(str_replace('_', ' ', $layout->category)) }} dengan sirkulasi udara alami optimal, pencahayaan maksimal, dan efisiensi ruang tanpa sekat berlebih.
                </p>
            </div>

            @auth
            <div class="flex items-center gap-3">
                <a href="{{ route('rfp.create', ['layout_id' => $layout->id, 'category' => $layout->building_type, 'area' => $layout->building_size_sqm, 'budget' => $layout->estimated_price_idr]) }}"
                   class="px-6 py-3 bg-[#c29b53] hover:bg-[#ad8741] text-white text-xs sm:text-sm font-bold uppercase tracking-wider rounded-lg shadow-xl shadow-black/20 transition">
                    Pilih Denah & Ajukan RFP
                </a>
            </div>
            @endauth
        </div>
    </div>
</section>

<!-- ========================================================
     MAIN BODY (Matching PT MKP Layout)
========================================================= -->
<section class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 sm:-mt-20 mb-20">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left 2 Cols: Visual 3D Render & 2D Floor Plan -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- 3D Render Hero Image -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xl">
                <div class="relative aspect-[16/10] rounded-xl overflow-hidden bg-slate-100 shadow-inner">
                    <img src="{{ asset($layout->render_3d_image ?: 'images/project_residential.jpg') }}" alt="{{ $layout->name }}"
                         class="w-full h-full object-cover">
                    <span class="absolute top-4 left-4 bg-[#1a2332]/90 border border-[#c29b53]/40 text-[#c29b53] text-xs px-3 py-1 rounded font-bold uppercase tracking-wider backdrop-blur-sm shadow">
                        Visual Render 3D Arsitektur
                    </span>
                </div>
            </div>

            <!-- 2D Architectural Floor Plan Drawing -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-xl space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div>
                        <h3 class="font-sans text-base sm:text-lg font-bold text-slate-900 flex items-center gap-2 uppercase tracking-wide">
                            <i data-lucide="layout" class="w-5 h-5 text-[#c29b53]"></i>
                            <span>Gambar Denah Tata Letak Arsitektural (Floor Plan)</span>
                        </h3>
                        <p class="text-xs text-slate-500 font-light mt-0.5">Cetak biru penataan ruang terukur dan zonasi sirkulasi</p>
                    </div>
                    <span class="text-xs text-[#c29b53] font-bold font-mono">Skala DED 1:100</span>
                </div>

                <div class="relative aspect-[16/10] rounded-xl overflow-hidden bg-slate-50 border border-slate-200 p-2 flex items-center justify-center">
                    <img src="{{ asset($layout->layout_plan_image ?: 'images/wallpaper_calculator_hd.jpg') }}" alt="Denah {{ $layout->name }}"
                         class="w-full h-full object-cover rounded-lg">
                </div>

                <!-- Room Dimensions Breakdown -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs pt-4 border-t border-slate-100">
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-slate-400 block text-[10px] uppercase font-semibold">Kamar Utama:</span>
                        <span class="font-bold text-slate-800">4.0 x 3.5 m (En-suite)</span>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-slate-400 block text-[10px] uppercase font-semibold">Ruang Keluarga:</span>
                        <span class="font-bold text-slate-800">6.0 x 4.0 m (Open Plan)</span>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-slate-400 block text-[10px] uppercase font-semibold">Dapur & Makan:</span>
                        <span class="font-bold text-slate-800">4.5 x 3.0 m (Island)</span>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-slate-400 block text-[10px] uppercase font-semibold">Carport & Taman:</span>
                        <span class="font-bold text-slate-800">{{ $layout->carport_capacity }} Mobil + Taman</span>
                    </div>
                </div>
            </div>

            <!-- Material & Engineering Specifications -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-xl space-y-4">
                <h3 class="font-sans text-base sm:text-lg font-bold text-slate-900 flex items-center gap-2 uppercase tracking-wide">
                    <i data-lucide="check-square" class="w-5 h-5 text-emerald-600"></i>
                    <span>Spesifikasi Teknis Material Terpasang</span>
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-light">
                    {{ $layout->specifications_summary }}
                </p>
            </div>

        </div>

        <!-- Right Sidebar: Specs Summary & Action Box -->
        <div class="space-y-8">
            
            <!-- Quick Specs Box -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-xl">
                <h3 class="font-sans text-sm font-bold text-slate-900 uppercase tracking-wider mb-6 pb-3 border-b border-slate-100">
                    Ringkasan Parameter Bangunan
                </h3>

                <div class="space-y-4 text-xs">
                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500 font-medium">Luas Bangunan</span>
                        <span class="font-bold text-[#c29b53] text-sm">{{ (int)$layout->building_size_sqm }} m²</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500 font-medium">Minimal Luas Tanah</span>
                        <span class="font-bold text-slate-800">{{ (int)$layout->land_size_sqm }} m²</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500 font-medium">Jumlah Lantai</span>
                        <span class="font-bold text-slate-800">{{ $layout->floor_count }} Lantai</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500 font-medium">Kamar Tidur</span>
                        <span class="font-bold text-slate-800">{{ $layout->bedrooms }} Ruangan</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500 font-medium">Kamar Mandi</span>
                        <span class="font-bold text-slate-800">{{ $layout->bathrooms }} Ruangan</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500 font-medium">Kapasitas Carport</span>
                        <span class="font-bold text-slate-800">{{ $layout->carport_capacity }} Mobil</span>
                    </div>
                    <div class="flex items-center justify-between py-3 border-t border-slate-200">
                        <span class="text-slate-700 font-bold">Estimasi Total Biaya:</span>
                        <span class="font-sans text-base font-extrabold text-emerald-700">
                            Rp {{ number_format($layout->estimated_price_idr, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Direct Action Card (Contrasting Dark PT MKP Box) -->
            <div class="bg-gradient-to-br from-[#1a2332] to-[#0f172a] p-6 sm:p-8 rounded-2xl shadow-xl text-white text-center">
                <div class="w-12 h-12 rounded-xl bg-[#c29b53]/20 text-[#c29b53] flex items-center justify-center mx-auto mb-4 border border-[#c29b53]/30">
                    <i data-lucide="file-check" class="w-6 h-6"></i>
                </div>
                <h3 class="font-sans text-base sm:text-lg font-bold text-white mb-2 uppercase tracking-wide">Gunakan Denah Ini Untuk Proyek Anda</h3>
                <p class="text-xs text-slate-300 leading-relaxed mb-6 font-light">
                    Lanjutkan ke form penawaran tender untuk menyesuaikan preferensi lokasi tapak, material spesifik, dan jadwal survey lahan.
                </p>
                <div class="space-y-3">
                    @auth
                    <a href="{{ route('rfp.create', ['layout_id' => $layout->id, 'category' => $layout->building_type, 'area' => $layout->building_size_sqm, 'budget' => $layout->estimated_price_idr]) }}"
                       class="w-full inline-flex items-center justify-center py-3 px-4 bg-[#c29b53] hover:bg-[#ad8741] text-white font-bold text-xs uppercase tracking-wider rounded-lg transition shadow-md">
                        Ajukan Penawaran Tender (RFP)
                    </a>
                    @endauth
                    <a href="{{ route('estimator.index') }}"
                       class="w-full inline-flex items-center justify-center py-3 px-4 bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 font-semibold text-xs rounded-lg transition">
                        Simulasikan di Kalkulator RAB
                    </a>
                </div>
            </div>

        </div>

    </div>
</section>

@endsection
