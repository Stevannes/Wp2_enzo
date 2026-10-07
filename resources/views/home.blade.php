@extends('layouts.app')

@section('title', 'ENZO Construction — Building Excellence With Precision & Passion')
@section('meta_description', 'Your premier partner for high-end construction and architectural excellence across sectors.')

@section('content')

<!-- ========================================================
     HERO SECTION (Strictly Matching PT MKP Mockup)
========================================================= -->
<section class="relative min-h-[680px] lg:min-h-[760px] flex items-center justify-center overflow-hidden">
    <!-- Clean Architectural Twilight Villa Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/ptmkp_hero_clean.jpg') }}"
             alt="Enzo Luxury Modern Villa at Dusk"
             class="w-full h-full object-cover object-center">
        <!-- Subtle dark overlay ensuring clear text readability while preserving the glowing villa -->
        <div class="absolute inset-0 bg-slate-950/25"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-slate-950/40"></div>
    </div>

    <!-- Hero Content (Centered, Uppercase, Precise Spacing) -->
    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center pt-24 pb-36">
        <!-- Main Headline -->
        <h1 class="font-sans text-3xl sm:text-5xl lg:text-[3.5rem] font-extrabold tracking-wide text-white uppercase leading-tight sm:leading-tight">
            BUILDING EXCELLENCE WITH<br>
            PRECISION & PASSION
        </h1>

        <!-- Subtitle -->
        <p class="text-xs sm:text-sm md:text-base text-slate-100 font-light max-w-xl mx-auto mt-4 mb-8 leading-relaxed tracking-normal">
            Your premier partner for high-end construction and<br class="hidden sm:inline"> architectural excellence across sectors.
        </p>

        <!-- Centered Action Button matching Mockup -->
        <div>
            <a href="{{ route('projects.index') }}"
               class="inline-flex items-center gap-2.5 px-6 py-2.5 bg-[#c29b53] hover:bg-[#ad8741] text-white text-xs font-bold uppercase tracking-widest rounded-sm transition duration-200 shadow-xl shadow-black/20">
                <span>VIEW PROJECTS</span>
                <span class="text-sm leading-none">&rarr;</span>
            </a>
        </div>
    </div>
</section>

<!-- ========================================================
     WHITE FLOATING CONTAINER (WHY CHOOSE US & WHAT WE OFFER)
     (Strictly Matching PT MKP Mockup Layout)
========================================================= -->
<section class="relative z-20 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-28 sm:-mt-36 mb-20" id="why-choose-us">
    <div class="bg-white rounded-t-2xl sm:rounded-t-3xl shadow-2xl p-6 sm:p-10 lg:p-12 border-t border-slate-100">
        
        <!-- ==============================================
             SECTION: WHY CHOOSE US (5 Dark Cards in 1 Row)
        =============================================== -->
        <div class="mb-14">
            <h2 class="text-center font-sans font-extrabold text-xl sm:text-2xl text-slate-900 uppercase tracking-widest mb-8">
                WHY CHOOSE US
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5">
                
                <!-- Card 1: EXPERTISE -->
                <div class="bg-[#1a2332] hover:bg-[#222e42] transition-colors duration-200 rounded-xl p-5 text-center flex flex-col items-center justify-between min-h-[195px] text-white shadow-md">
                    <div class="w-10 h-10 flex items-center justify-center text-[#c29b53] mt-1">
                        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-sans font-bold text-xs uppercase tracking-wider text-white mb-2">EXPERTISE</h3>
                        <p class="text-[10px] text-slate-300 font-light leading-relaxed">
                            Tenaga ahli bersertifikasi SKA dengan jam terbang tinggi di berbagai sektor.
                        </p>
                    </div>
                </div>

                <!-- Card 2: QUALITY -->
                <div class="bg-[#1a2332] hover:bg-[#222e42] transition-colors duration-200 rounded-xl p-5 text-center flex flex-col items-center justify-between min-h-[195px] text-white shadow-md">
                    <div class="w-10 h-10 flex items-center justify-center text-[#c29b53] mt-1">
                        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <circle cx="12" cy="8" r="6"/>
                            <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-sans font-bold text-xs uppercase tracking-wider text-white mb-2">QUALITY</h3>
                        <p class="text-[10px] text-slate-300 font-light leading-relaxed">
                            Standar mutu bersertifikasi ISO 9001:2015 dan penggunaan material SNI kelas atas.
                        </p>
                    </div>
                </div>

                <!-- Card 3: INNOVATION -->
                <div class="bg-[#1a2332] hover:bg-[#222e42] transition-colors duration-200 rounded-xl p-5 text-center flex flex-col items-center justify-between min-h-[195px] text-white shadow-md">
                    <div class="w-10 h-10 flex items-center justify-center text-[#c29b53] mt-1">
                        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M9 18h6"/>
                            <path d="M10 22h4"/>
                            <path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1 .23 2.23 1.5 3.5.76.76 1.23 1.52 1.41 2.5"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-sans font-bold text-xs uppercase tracking-wider text-white mb-2">INNOVATION</h3>
                        <p class="text-[10px] text-slate-300 font-light leading-relaxed">
                            Metode rekayasa modern, pemodelan BIM 3D, dan presisi digital terukur.
                        </p>
                    </div>
                </div>

                <!-- Card 4: RELIABILITY -->
                <div class="bg-[#1a2332] hover:bg-[#222e42] transition-colors duration-200 rounded-xl p-5 text-center flex flex-col items-center justify-between min-h-[195px] text-white shadow-md">
                    <div class="w-10 h-10 flex items-center justify-center text-[#c29b53] mt-1">
                        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/>
                            <path d="m9 12 2 2 4-4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-sans font-bold text-xs uppercase tracking-wider text-white mb-2">RELIABILITY</h3>
                        <p class="text-[10px] text-slate-300 font-light leading-relaxed">
                            Pengerjaan on-time sesuai jadwal serta transparansi anggaran tanpa biaya siluman.
                        </p>
                    </div>
                </div>

                <!-- Card 5: SUSTAINABILITY -->
                <div class="bg-[#1a2332] hover:bg-[#222e42] transition-colors duration-200 rounded-xl p-5 text-center flex flex-col items-center justify-between min-h-[195px] text-white shadow-md">
                    <div class="w-10 h-10 flex items-center justify-center text-[#c29b53] mt-1">
                        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/>
                            <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-sans font-bold text-xs uppercase tracking-wider text-white mb-2">SUSTAINABILITY</h3>
                        <p class="text-[10px] text-slate-300 font-light leading-relaxed">
                            Konsep ramah lingkungan, efisiensi energi, dan ketahanan struktur puluhan tahun.
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <!-- ==============================================
             SECTION: WHAT WE OFFER (4 Photo Cards in 1 Row)
        =============================================== -->
        <div id="services">
            <h2 class="text-center font-sans font-extrabold text-xl sm:text-2xl text-slate-900 uppercase tracking-widest mb-8">
                WHAT WE OFFER
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- Card 1: CIVIL WORK -->
                <a href="{{ route('projects.index', ['category' => 'commercial']) }}"
                   class="group aspect-[4/3] rounded-xl overflow-hidden relative shadow-lg block">
                    <img src="{{ asset('images/project_commercial.jpg') }}" alt="Civil Work"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/40 to-transparent p-4 flex flex-col justify-end">
                        <h3 class="font-sans font-extrabold text-xs text-white uppercase tracking-wider mb-1 group-hover:text-[#c29b53] transition">
                            CIVIL WORK
                        </h3>
                        <p class="text-[10px] text-slate-300 leading-tight font-light">
                            Gedung bertingkat, struktur beton bertulang, pondasi & infrastruktur publik.
                        </p>
                    </div>
                </a>

                <!-- Card 2: DESIGN & BUILD -->
                <a href="{{ route('projects.index', ['category' => 'residential']) }}"
                   class="group aspect-[4/3] rounded-xl overflow-hidden relative shadow-lg block">
                    <img src="{{ asset('images/project_residential.jpg') }}" alt="Design & Build"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/40 to-transparent p-4 flex flex-col justify-end">
                        <h3 class="font-sans font-extrabold text-xs text-white uppercase tracking-wider mb-1 group-hover:text-[#c29b53] transition">
                            DESIGN & BUILD
                        </h3>
                        <p class="text-[10px] text-slate-300 leading-tight font-light">
                            Layanan terpadu dari konsep rancangan arsitektur hingga serah terima kunci.
                        </p>
                    </div>
                </a>

                <!-- Card 3: COMMERCIAL INTERIOR -->
                <a href="{{ route('projects.index') }}"
                   class="group aspect-[4/3] rounded-xl overflow-hidden relative shadow-lg block">
                    <img src="{{ asset('images/project_interior.jpg') }}" alt="Commercial Interior"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/40 to-transparent p-4 flex flex-col justify-end">
                        <h3 class="font-sans font-extrabold text-xs text-white uppercase tracking-wider mb-1 group-hover:text-[#c29b53] transition">
                            COMMERCIAL INTERIOR
                        </h3>
                        <p class="text-[10px] text-slate-300 leading-tight font-light">
                            Fit-out kantor, peremajaan fasad arsitektural modern, hotel & area komersial.
                        </p>
                    </div>
                </a>

                <!-- Card 4: INDUSTRIAL STEEL -->
                <a href="{{ route('projects.index', ['category' => 'industrial']) }}"
                   class="group aspect-[4/3] rounded-xl overflow-hidden relative shadow-lg block">
                    <img src="{{ asset('images/project_industrial.jpg') }}" alt="Industrial Steel"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/40 to-transparent p-4 flex flex-col justify-end">
                        <h3 class="font-sans font-extrabold text-xs text-white uppercase tracking-wider mb-1 group-hover:text-[#c29b53] transition">
                            INDUSTRIAL STEEL
                        </h3>
                        <p class="text-[10px] text-slate-300 leading-tight font-light">
                            Gudang logistik bentang lebar, pabrik industri & konstruksi baja berat WF.
                        </p>
                    </div>
                </a>

            </div>
        </div>

    </div>
</section>

<!-- ========================================================
     FEATURE: INTERACTIVE BEFORE-AFTER SLIDER (Wireframe 1)
========================================================= -->
<section class="py-16 bg-slate-900 text-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-bold text-[#c29b53] uppercase tracking-widest block mb-2 font-sans">Keahlian Revitalisasi Fasad</span>
            <h2 class="font-sans text-2xl sm:text-3xl font-extrabold text-white uppercase tracking-wider">
                Studi Kasus: Sebelum & Sesudah Renovasi
            </h2>
            <p class="text-slate-400 text-xs sm:text-sm mt-2 font-light">
                Geser pembatas di bawah untuk melihat transformasi nyata struktur bangunan lama menjadi karya arsitektural modern berkelas tinggi.
            </p>
        </div>

        <!-- Slider Component (Alpine.js) -->
        <div x-data="{ sliderPos: 50, isDragging: false }"
             class="max-w-3xl mx-auto bg-slate-950 p-4 sm:p-5 rounded-2xl shadow-2xl border border-slate-800">
            <div class="relative w-full aspect-[16/10] rounded-xl overflow-hidden select-none cursor-ew-resize"
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
                <img src="{{ asset('images/after_renovation.jpg') }}" alt="Sesudah Renovasi Enzo"
                     class="absolute inset-0 w-full h-full object-cover pointer-events-none">
                <span class="absolute top-3 right-3 bg-emerald-950/90 border border-emerald-500/50 text-emerald-300 text-[10px] px-2.5 py-1 rounded font-bold uppercase tracking-wider z-10">
                    Sesudah (After)
                </span>

                <!-- Before Image -->
                <div class="absolute inset-0 overflow-hidden pointer-events-none" :style="`width: ${sliderPos}%`">
                    <img src="{{ asset('images/before_renovation.jpg') }}" alt="Sebelum Renovasi Enzo"
                         class="absolute inset-0 w-full h-full object-cover max-w-none"
                         style="width: 100%; min-width: 100%;">
                    <span class="absolute top-3 left-3 bg-slate-900/90 border border-slate-700 text-slate-300 text-[10px] px-2.5 py-1 rounded font-bold uppercase tracking-wider z-10">
                        Sebelum (Before)
                    </span>
                </div>

                <!-- Divider & Handle -->
                <div class="absolute top-0 bottom-0 z-20 pointer-events-none flex items-center justify-center"
                     :style="`left: ${sliderPos}%; transform: translateX(-50%);`">
                    <div class="w-1 bg-[#c29b53] h-full shadow-[0_0_10px_rgba(194,155,83,0.8)]"></div>
                    <div class="absolute w-8 h-8 rounded-full bg-[#c29b53] border-2 border-white shadow-xl flex items-center justify-center text-slate-950">
                        <i data-lucide="chevrons-left-right" class="w-4 h-4"></i>
                    </div>
                </div>
            </div>

            <!-- Accessibility slider range -->
            <div class="mt-4 flex items-center justify-between gap-4 px-2">
                <span class="text-[11px] text-slate-400">Gunakan mouse atau sentuhan jari untuk menggeser</span>
                <input type="range" min="0" max="100" x-model="sliderPos"
                       class="w-48 h-1.5 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-[#c29b53]">
            </div>
        </div>
    </div>
</section>

<!-- ========================================================
     PORTAL TOOLS CTA BANNER (RAB CALCULATOR & TENDER RFP)
========================================================= -->
<section class="py-16 bg-slate-100 border-t border-slate-200">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Box 1: Kalkulator RAB -->
            <div class="bg-white p-8 rounded-2xl shadow-xl border border-slate-200 flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded-lg bg-[#c29b53]/10 text-[#c29b53] flex items-center justify-center mb-4">
                        <i data-lucide="calculator" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-sans text-lg font-bold text-slate-900 uppercase tracking-wide mb-2">
                        Kalkulator RAB Interaktif
                    </h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-light mb-6">
                        Hitung estimasi kasar anggaran pembangunan gedung, rumah mewah, atau gudang Anda secara instan dan transparan dalam 3 langkah mudah.
                    </p>
                </div>
                <a href="{{ route('estimator.index') }}"
                   class="inline-flex items-center justify-center gap-2 py-3 px-5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold uppercase tracking-wider rounded-lg transition">
                    <span>Mulai Hitung Estimasi Biaya</span>
                    <i data-lucide="arrow-right" class="w-4 h-4 text-[#c29b53]"></i>
                </a>
            </div>

            <!-- Box 2: Pengajuan Tender RFP -->
            <div class="bg-gradient-to-br from-[#1a2332] to-[#0f172a] p-8 rounded-2xl shadow-xl text-white flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded-lg bg-[#c29b53]/20 text-[#c29b53] flex items-center justify-center mb-4">
                        <i data-lucide="file-text" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-sans text-lg font-bold text-white uppercase tracking-wide mb-2">
                        Pengajuan Penawaran (RFP)
                    </h3>
                    <p class="text-xs text-slate-300 leading-relaxed font-light mb-6">
                        Unggah berkas tender Anda (gambar CAD, PDF, TOR) dan dapatkan penawaran menyeluruh dari tim estimator kami dalam 1x24 jam kerja.
                    </p>
                </div>
                <a href="{{ route('rfp.create') }}"
                   class="inline-flex items-center justify-center gap-2 py-3 px-5 bg-[#c29b53] hover:bg-[#ad8741] text-white text-xs font-bold uppercase tracking-wider rounded-lg transition">
                    <span>Submit Dokumen Tender (RFP)</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

        </div>
    </div>
</section>

@endsection
