@extends('layouts.app')

@section('title', 'Matriks Komparatif Spesifikasi Teknis Material Konstruksi — ENZO Contractor')
@section('meta_description', 'Perbandingan spesifikasi teknis material bangunan lengkap: pondasi, struktur kolom, jenis lantai, rangka atap baja ringan, genteng metal, dan utilitas MEP.')

@section('content')

<!-- ========================================================
     HERO SECTION (Strictly Matching PT MKP Mockup Style)
========================================================= -->
<section class="relative min-h-[380px] sm:min-h-[420px] flex items-center justify-center overflow-hidden">
    <!-- Clean Architectural Twilight Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/ptmkp_hero_clean.jpg') }}"
             alt="Enzo Engineering Specifications Hero"
             class="w-full h-full object-cover object-center">
        <!-- Subtle dark overlay -->
        <div class="absolute inset-0 bg-slate-950/50"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-slate-950/40"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center pt-20 pb-28">
        <span class="inline-block text-xs font-bold text-[#c29b53] uppercase tracking-widest mb-3 font-sans">
            Tabel Komparatif Teknis Terperinci
        </span>
        <h1 class="font-sans text-3xl sm:text-5xl font-extrabold tracking-wide text-white uppercase leading-tight">
            Matriks Spesifikasi Teknis <span class="text-[#c29b53]">Material Bangunan</span>
        </h1>
        <p class="text-xs sm:text-sm text-slate-100 font-light max-w-xl mx-auto mt-3 leading-relaxed tracking-normal">
            Transparansi penuh spesifikasi material konstruksi untuk pertimbangan investasi Anda. Bandingkan jenis pondasi, struktur beton, penutup lantai, hingga utilitas fasilitas pendukung antartingkat mutu.
        </p>
    </div>
</section>

<!-- ========================================================
     WHITE FLOATING CONTAINER (Matching PT MKP Layout)
========================================================= -->
<section class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 sm:-mt-24 mb-20">
    <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl p-6 sm:p-10 border border-slate-100">

        <!-- Grade Legend Ribbon -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-10">
            <!-- Standard Grade -->
            <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Tingkat Mutu A</span>
                    <span class="text-[10px] bg-slate-200 text-slate-700 px-2 py-0.5 rounded font-mono font-bold">Efisiensi SNI</span>
                </div>
                <h3 class="font-sans text-base font-bold text-slate-900 uppercase tracking-wider">Standar SNI</h3>
                <p class="text-xs text-slate-600 mt-1 font-light leading-relaxed">
                    Standar minimum kelayakan bangunan Indonesia, hemat anggaran, material lokal bermutu terverifikasi SNI.
                </p>
            </div>

            <!-- Premium Grade -->
            <div class="bg-white p-5 rounded-2xl border-2 border-[#c29b53] shadow-md relative overflow-hidden">
                <span class="absolute top-0 right-0 bg-[#c29b53] text-white text-[9px] font-bold px-2.5 py-0.5 rounded-bl uppercase">
                    Rekomendasi
                </span>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#c29b53]">Tingkat Mutu AA</span>
                    <span class="text-[10px] bg-[#c29b53]/10 text-[#c29b53] border border-[#c29b53]/30 px-2 py-0.5 rounded font-mono font-bold">Favorit Klien</span>
                </div>
                <h3 class="font-sans text-base font-bold text-slate-900 uppercase tracking-wider">Premium High-Grade</h3>
                <p class="text-xs text-slate-600 mt-1 font-light leading-relaxed">
                    Kombinasi daya tahan jangka panjang dan estetika modern: granit tile, cakar ayam K-275, genteng flat beton, dan kusen Alexindo.
                </p>
            </div>

            <!-- Luxury Grade -->
            <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Tingkat Mutu AAA</span>
                    <span class="text-[10px] bg-slate-200 text-slate-700 px-2 py-0.5 rounded font-mono font-bold">Mahakarya</span>
                </div>
                <h3 class="font-sans text-base font-bold text-slate-900 uppercase tracking-wider">Luxury Executive</h3>
                <p class="text-xs text-slate-600 mt-1 font-light leading-relaxed">
                    Kemewahan tanpa kompromi: bore pile anti-gempa, marmer slab import, smart home automation, sanitair Kohler, kaca double low-E.
                </p>
            </div>
        </div>

        <!-- Detailed Comparative Specifications Table -->
        <div class="space-y-10">
            @foreach($specMatrix as $matrixSection)
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-md">
                    <!-- Category Header Bar -->
                    <div class="p-4 sm:p-5 bg-[#1a2332] text-white flex items-center justify-between">
                        <h2 class="font-sans text-sm sm:text-base font-bold text-white uppercase tracking-wider flex items-center gap-2.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#c29b53]"></span>
                            <span>{{ $matrixSection['category'] }}</span>
                        </h2>
                        <span class="text-[11px] text-slate-300 font-mono hidden sm:inline">Dokumen Spesifikasi Teknis ENZO</span>
                    </div>

                    <!-- Comparison Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="bg-slate-100 border-b border-slate-200 text-slate-700 uppercase tracking-wider text-[11px]">
                                    <th class="p-4 w-1/4 font-bold">Komponen Teknis</th>
                                    <th class="p-4 w-1/4 font-bold">Grade A — Standar SNI</th>
                                    <th class="p-4 w-1/4 bg-[#c29b53]/10 text-slate-900 font-bold border-x border-[#c29b53]/30">
                                        <div class="flex items-center gap-1.5">
                                            <span>Grade AA — Premium</span>
                                            <i data-lucide="star" class="w-3.5 h-3.5 text-[#c29b53] fill-[#c29b53]"></i>
                                        </div>
                                    </th>
                                    <th class="p-4 w-1/4 font-bold">Grade AAA — Luxury</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($matrixSection['items'] as $item)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="p-4 font-bold text-slate-900">
                                            {{ $item['name'] }}
                                        </td>
                                        <td class="p-4 text-slate-600 font-light">
                                            {{ $item['standard'] }}
                                        </td>
                                        <td class="p-4 bg-[#c29b53]/5 text-slate-900 font-semibold border-x border-[#c29b53]/20">
                                            {{ $item['premium'] }}
                                        </td>
                                        <td class="p-4 text-slate-700 font-medium">
                                            {{ $item['luxury'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Call to Action Footer -->
        <div class="mt-12 p-8 rounded-2xl bg-gradient-to-br from-[#1a2332] to-[#0f172a] text-center shadow-xl text-white">
            <h3 class="font-sans text-xl sm:text-2xl font-extrabold text-white uppercase tracking-wider mb-2">
                Ingin Konsultasi Rincian Bill of Quantities (BOQ)?
            </h3>
            <p class="text-xs sm:text-sm text-slate-300 max-w-2xl mx-auto mb-6 font-light leading-relaxed">
                Setiap proyek memiliki karakteristik tanah dan arsitektur yang unik. Diskusikan rencana bangunan Anda dengan tim estimator kami untuk mendapatkan proposal teknis resmi dan survey lapangan.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('estimator.index') }}"
                   class="px-6 py-3 bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 rounded-lg text-xs font-bold uppercase tracking-wider transition">
                    Buka Kalkulator Biaya RAB
                </a>
                @auth
                <a href="{{ route('rfp.create') }}"
                   class="px-8 py-3 bg-[#c29b53] hover:bg-[#ad8741] text-white font-bold text-xs uppercase tracking-wider rounded-lg transition shadow-md">
                    Ajukan Penawaran Tender (RFP)
                </a>
                @endauth
            </div>
        </div>

    </div>
</section>

@endsection
