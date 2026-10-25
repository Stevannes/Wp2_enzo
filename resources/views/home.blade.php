@extends('layouts.app')

@section('title', 'enzo — building construction and interior')
@section('meta_description', 'Your premier partner for building construction and interior architectural excellence across sectors.')

@push('styles')
<style>
    /* ========================================================
       ENZO LUXURY ARCHITECTURAL ENTRANCE ANIMATIONS
       (Strictly Scoped Exclusively to Home Page)
    ======================================================== */

    /* 1. Grand Architectural Entrance Curtain */
    #enzo-home-curtain {
        transition: transform 0.95s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.75s ease;
        will-change: transform, opacity;
    }
    #enzo-home-curtain.curtain-lift {
        transform: translateY(-100%);
        opacity: 0.96;
        pointer-events: none !important;
    }
    .enzo-curtain-content {
        transition: opacity 0.45s ease, transform 0.45s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .enzo-curtain-content.fade-out {
        opacity: 0;
        transform: translateY(-16px) scale(0.96);
    }
    .enzo-curtain-line {
        width: 0;
        height: 1.5px;
        background: linear-gradient(90deg, transparent, #c29b53 30%, #fcd34d 50%, #c29b53 70%, transparent);
        animation: enzoExpandLine 0.85s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        box-shadow: 0 0 12px rgba(194, 155, 83, 0.7);
    }
    @keyframes enzoExpandLine {
        0% { width: 0; opacity: 0; }
        50% { opacity: 1; }
        100% { width: 140px; opacity: 1; }
    }
    .enzo-curtain-logo {
        animation: enzoPulseGlow 1.8s ease-in-out infinite alternate;
    }
    @keyframes enzoPulseGlow {
        0% { transform: scale(1); filter: drop-shadow(0 0 10px rgba(194,155,83,0.3)); }
        100% { transform: scale(1.05); filter: drop-shadow(0 0 26px rgba(194,155,83,0.8)); }
    }

    /* 2. Hero Cinematic Scale & Staggered Reveal */
    .enzo-hero-bg {
        transform: scale(1.08) translateZ(0);
        transition: transform 2.4s cubic-bezier(0.16, 1, 0.3, 1);
        will-change: transform;
    }
    .enzo-hero-bg.is-active {
        transform: scale(1) translateZ(0);
    }

    .enzo-hero-item {
        opacity: 0;
        transform: translateY(24px) translateZ(0);
        transition: opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1), transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
        will-change: opacity, transform;
    }
    .enzo-hero-item.is-active {
        opacity: 1;
        transform: translateY(0) translateZ(0);
    }
    .enzo-hero-delay-1 { transition-delay: 0.12s; }
    .enzo-hero-delay-2 { transition-delay: 0.28s; }
    .enzo-hero-delay-3 { transition-delay: 0.44s; }
    .enzo-hero-delay-4 { transition-delay: 0.60s; }
    .enzo-hero-delay-5 { transition-delay: 0.76s; }

    /* Hero Button Elegant Light Shimmer */
    .enzo-shimmer-sweep {
        position: absolute;
        top: 0;
        left: -120%;
        width: 60%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.35), transparent);
        transform: skewX(-25deg);
        animation: enzoShimmer 5.5s infinite 2.2s ease-in-out;
        pointer-events: none;
    }
    @keyframes enzoShimmer {
        0% { left: -120%; }
        22%, 100% { left: 160%; }
    }

    /* Hero Scroll Indicator */
    .enzo-scroll-dot {
        animation: enzoScrollBounce 2.5s cubic-bezier(0.65, 0, 0.35, 1) infinite;
    }
    @keyframes enzoScrollBounce {
        0% { transform: translateY(0); opacity: 0; }
        30% { opacity: 1; }
        70% { transform: translateY(11px); opacity: 1; }
        100% { transform: translateY(15px); opacity: 0; }
    }

    /* 3. Scroll-Triggered Entrance Animations (IntersectionObserver) */
    .enzo-reveal {
        opacity: 0;
        transform: translateY(26px) translateZ(0);
        transition: opacity 0.85s cubic-bezier(0.22, 1, 0.36, 1), transform 0.85s cubic-bezier(0.22, 1, 0.36, 1);
        will-change: opacity, transform;
    }
    .enzo-reveal.is-revealed {
        opacity: 1;
        transform: translateY(0) translateZ(0);
    }
    .enzo-delay-1 { transition-delay: 0.10s; }
    .enzo-delay-2 { transition-delay: 0.20s; }
    .enzo-delay-3 { transition-delay: 0.30s; }
    .enzo-delay-4 { transition-delay: 0.40s; }
    .enzo-delay-5 { transition-delay: 0.50s; }

    /* Accessibility: Respect Reduced Motion */
    @media (prefers-reduced-motion: reduce) {
        #enzo-home-curtain { display: none !important; }
        .enzo-hero-bg { transform: none !important; transition: none !important; }
        .enzo-hero-item { opacity: 1 !important; transform: none !important; transition: none !important; }
        .enzo-reveal { opacity: 1 !important; transform: none !important; transition: none !important; }
        .enzo-shimmer-sweep { display: none !important; }
        .enzo-scroll-dot { animation: none !important; }
    }
</style>
<noscript>
    <style>
        #enzo-home-curtain { display: none !important; }
        .enzo-hero-bg { transform: none !important; }
        .enzo-hero-item { opacity: 1 !important; transform: none !important; }
        .enzo-reveal { opacity: 1 !important; transform: none !important; }
    </style>
</noscript>
@endpush

@section('content')

<!-- ========================================================
     HOME ENTRANCE CURTAIN (ELEGANT ARCHITECTURAL PRELOADER)
     Plays smoothly once on entering the Home page
========================================================= -->
<div id="enzo-home-curtain"
     class="fixed inset-0 z-[100] bg-[#070b14] flex flex-col items-center justify-center cursor-pointer select-none"
     title="Klik untuk langsung masuk">
    <div class="flex flex-col items-center text-center px-4 enzo-curtain-content" id="enzo-curtain-box">
        <div class="relative mb-4">
            <img src="{{ asset('images/enzo_full_logo.png') }}" alt="enzo — building construction and interior"
                 class="h-16 sm:h-20 w-auto object-contain filter drop-shadow-[0_0_25px_rgba(194,155,83,0.45)] enzo-curtain-logo">
        </div>
        <div class="enzo-curtain-line my-3"></div>
        <span class="text-[10px] sm:text-xs tracking-[0.25em] text-[#c29b53] uppercase font-bold">
            Executive Architecture & Interior
        </span>
    </div>
</div>

<!-- ========================================================
     HERO SECTION (Strictly Matching PT MKP Mockup)
========================================================= -->
<section class="relative min-h-[680px] lg:min-h-[760px] flex items-center justify-center overflow-hidden">
    <!-- Clean Architectural Twilight Villa Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/ptmkp_hero_clean.jpg') }}"
             alt="Enzo Luxury Modern Villa at Dusk"
             class="w-full h-full object-cover object-center enzo-hero-bg"
             id="enzoHeroBg">
        <!-- Subtle dark overlay ensuring clear text readability while preserving the glowing villa -->
        <div class="absolute inset-0 bg-slate-950/25"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-slate-950/40"></div>
    </div>

    <!-- Hero Content (Centered, Uppercase, Precise Spacing) -->
    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center pt-24 pb-36">
        <!-- Main Headline -->
        <h1 class="enzo-hero-item enzo-hero-delay-1 font-sans text-3xl sm:text-5xl lg:text-[3.5rem] font-extrabold tracking-wide text-white uppercase leading-tight sm:leading-tight">
            BUILDING EXCELLENCE WITH<br>
            PRECISION & PASSION
        </h1>

        <!-- Subtitle -->
        <p class="enzo-hero-item enzo-hero-delay-2 text-xs sm:text-sm md:text-base text-slate-100 font-light max-w-xl mx-auto mt-4 mb-8 leading-relaxed tracking-normal">
            Your premier partner for high-end construction and<br class="hidden sm:inline"> architectural excellence across sectors.
        </p>

        <!-- Centered Action Button matching Mockup -->
        <div class="enzo-hero-item enzo-hero-delay-3">
            <a href="{{ route('projects.index') }}"
               class="relative inline-flex items-center gap-2.5 px-6 py-2.5 bg-[#c29b53] hover:bg-[#ad8741] text-white text-xs font-bold uppercase tracking-widest rounded-sm transition duration-200 shadow-xl shadow-black/20 overflow-hidden group">
                <span class="relative z-10">VIEW PROJECTS</span>
                <span class="relative z-10 text-sm leading-none transition-transform duration-200 group-hover:translate-x-1">&rarr;</span>
                <span class="enzo-shimmer-sweep"></span>
            </a>
        </div>
    </div>
</section>

<!-- ========================================================
     WHITE FLOATING CONTAINER (WHY CHOOSE US & WHAT WE OFFER)
     (Strictly Matching PT MKP Mockup Layout)
========================================================= -->
<section class="relative z-20 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-28 sm:-mt-36 mb-20 enzo-reveal" id="why-choose-us">
    <div class="bg-white rounded-t-2xl sm:rounded-t-3xl shadow-2xl p-6 sm:p-10 lg:p-12 border-t border-slate-100">
        
        <!-- ==============================================
             SECTION: WHY CHOOSE US (5 Luxury Dark Cards)
        =============================================== -->
        <div class="mb-16">
            <div class="text-center mb-10 enzo-reveal">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#1a2332] border border-[#c29b53]/40 text-[#c29b53] text-[11px] font-bold uppercase tracking-wider mb-3 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-[#c29b53] animate-pulse"></span>
                    <span>Keunggulan Kompetitif & Standar Mutu</span>
                </div>
                <h2 class="font-sans font-extrabold text-2xl sm:text-3xl text-slate-900 uppercase tracking-widest">
                    WHY CHOOSE <span class="text-[#c29b53]">US</span>
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 font-light max-w-xl mx-auto mt-2 leading-relaxed">
                    Pondasi reputasi ENZO dibangun dari komitmen mutu tanpa kompromi, inovasi teknologi terdepan, dan transparansi penuh di setiap jengkal konstruksi.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 lg:gap-4.5">
                
                <!-- Card 1: EXPERTISE -->
                <div class="enzo-reveal enzo-delay-1 group relative bg-gradient-to-b from-[#182335] to-[#0f1726] hover:from-[#1e2c42] hover:to-[#131d2e] rounded-2xl p-6 text-center flex flex-col items-center justify-between min-h-[250px] text-white border border-slate-700/60 hover:border-[#c29b53] hover:shadow-2xl hover:shadow-[#c29b53]/15 hover:-translate-y-2 transition-all duration-300">
                    <!-- Subtle Glow Effect -->
                    <div class="absolute -top-10 -right-10 w-24 h-24 rounded-full bg-[#c29b53]/10 blur-xl group-hover:bg-[#c29b53]/25 transition-all duration-500 pointer-events-none"></div>

                    <div class="w-14 h-14 rounded-2xl bg-[#0a0f1d] border border-[#c29b53]/40 text-[#c29b53] flex items-center justify-center shadow-inner group-hover:bg-[#c29b53] group-hover:text-white group-hover:scale-110 group-hover:border-[#c29b53] transition-all duration-300">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                            <path d="m16 11 2 2 4-4"/>
                        </svg>
                    </div>

                    <div class="my-auto py-2">
                        <h3 class="font-sans font-extrabold text-sm sm:text-base uppercase tracking-wider text-white group-hover:text-[#c29b53] transition-colors duration-200">
                            EXPERTISE
                        </h3>
                        <span class="inline-block text-[10px] font-bold uppercase tracking-wider text-[#c29b53] bg-[#c29b53]/10 px-2.5 py-0.5 rounded-full border border-[#c29b53]/30 my-2">
                            Tenaga Ahli SKA
                        </span>
                        <p class="text-xs sm:text-[13px] text-slate-200 leading-relaxed font-normal">
                            Didukung tim insinyur & arsitek berpengalaman dengan jam terbang tinggi di berbagai sektor konstruksi.
                        </p>
                    </div>
                </div>

                <!-- Card 2: QUALITY -->
                <div class="enzo-reveal enzo-delay-2 group relative bg-gradient-to-b from-[#182335] to-[#0f1726] hover:from-[#1e2c42] hover:to-[#131d2e] rounded-2xl p-6 text-center flex flex-col items-center justify-between min-h-[250px] text-white border border-slate-700/60 hover:border-[#c29b53] hover:shadow-2xl hover:shadow-[#c29b53]/15 hover:-translate-y-2 transition-all duration-300">
                    <div class="absolute -top-10 -right-10 w-24 h-24 rounded-full bg-[#c29b53]/10 blur-xl group-hover:bg-[#c29b53]/25 transition-all duration-500 pointer-events-none"></div>

                    <div class="w-14 h-14 rounded-2xl bg-[#0a0f1d] border border-[#c29b53]/40 text-[#c29b53] flex items-center justify-center shadow-inner group-hover:bg-[#c29b53] group-hover:text-white group-hover:scale-110 group-hover:border-[#c29b53] transition-all duration-300">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="6"/>
                            <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
                        </svg>
                    </div>

                    <div class="my-auto py-2">
                        <h3 class="font-sans font-extrabold text-sm sm:text-base uppercase tracking-wider text-white group-hover:text-[#c29b53] transition-colors duration-200">
                            QUALITY
                        </h3>
                        <span class="inline-block text-[10px] font-bold uppercase tracking-wider text-[#c29b53] bg-[#c29b53]/10 px-2.5 py-0.5 rounded-full border border-[#c29b53]/30 my-2">
                            Standar ISO 9001
                        </span>
                        <p class="text-xs sm:text-[13px] text-slate-200 leading-relaxed font-normal">
                            Standar mutu ISO 9001:2015, pengujian berkala struktur beton, serta kurasi material SNI kelas premium.
                        </p>
                    </div>
                </div>

                <!-- Card 3: INNOVATION -->
                <div class="enzo-reveal enzo-delay-3 group relative bg-gradient-to-b from-[#182335] to-[#0f1726] hover:from-[#1e2c42] hover:to-[#131d2e] rounded-2xl p-6 text-center flex flex-col items-center justify-between min-h-[250px] text-white border border-slate-700/60 hover:border-[#c29b53] hover:shadow-2xl hover:shadow-[#c29b53]/15 hover:-translate-y-2 transition-all duration-300">
                    <div class="absolute -top-10 -right-10 w-24 h-24 rounded-full bg-[#c29b53]/10 blur-xl group-hover:bg-[#c29b53]/25 transition-all duration-500 pointer-events-none"></div>

                    <div class="w-14 h-14 rounded-2xl bg-[#0a0f1d] border border-[#c29b53]/40 text-[#c29b53] flex items-center justify-center shadow-inner group-hover:bg-[#c29b53] group-hover:text-white group-hover:scale-110 group-hover:border-[#c29b53] transition-all duration-300">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 18h6"/>
                            <path d="M10 22h4"/>
                            <path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1 .23 2.23 1.5 3.5.76.76 1.23 1.52 1.41 2.5"/>
                        </svg>
                    </div>

                    <div class="my-auto py-2">
                        <h3 class="font-sans font-extrabold text-sm sm:text-base uppercase tracking-wider text-white group-hover:text-[#c29b53] transition-colors duration-200">
                            INNOVATION
                        </h3>
                        <span class="inline-block text-[10px] font-bold uppercase tracking-wider text-[#c29b53] bg-[#c29b53]/10 px-2.5 py-0.5 rounded-full border border-[#c29b53]/30 my-2">
                            Pemodelan BIM 3D
                        </span>
                        <p class="text-xs sm:text-[13px] text-slate-200 leading-relaxed font-normal">
                            Aplikasi rekayasa modern & pemodelan BIM 3D untuk kalkulasi RAB presisi dan meminimalkan revisi fisik.
                        </p>
                    </div>
                </div>

                <!-- Card 4: RELIABILITY -->
                <div class="enzo-reveal enzo-delay-4 group relative bg-gradient-to-b from-[#182335] to-[#0f1726] hover:from-[#1e2c42] hover:to-[#131d2e] rounded-2xl p-6 text-center flex flex-col items-center justify-between min-h-[250px] text-white border border-slate-700/60 hover:border-[#c29b53] hover:shadow-2xl hover:shadow-[#c29b53]/15 hover:-translate-y-2 transition-all duration-300">
                    <div class="absolute -top-10 -right-10 w-24 h-24 rounded-full bg-[#c29b53]/10 blur-xl group-hover:bg-[#c29b53]/25 transition-all duration-500 pointer-events-none"></div>

                    <div class="w-14 h-14 rounded-2xl bg-[#0a0f1d] border border-[#c29b53]/40 text-[#c29b53] flex items-center justify-center shadow-inner group-hover:bg-[#c29b53] group-hover:text-white group-hover:scale-110 group-hover:border-[#c29b53] transition-all duration-300">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/>
                            <path d="m9 12 2 2 4-4"/>
                        </svg>
                    </div>

                    <div class="my-auto py-2">
                        <h3 class="font-sans font-extrabold text-sm sm:text-base uppercase tracking-wider text-white group-hover:text-[#c29b53] transition-colors duration-200">
                            RELIABILITY
                        </h3>
                        <span class="inline-block text-[10px] font-bold uppercase tracking-wider text-[#c29b53] bg-[#c29b53]/10 px-2.5 py-0.5 rounded-full border border-[#c29b53]/30 my-2">
                            Zero Hidden Cost
                        </span>
                        <p class="text-xs sm:text-[13px] text-slate-200 leading-relaxed font-normal">
                            Jaminan pengerjaan tepat waktu sesuai jadwal SPK, garansi pemeliharaan, serta tanpa biaya siluman.
                        </p>
                    </div>
                </div>

                <!-- Card 5: SUSTAINABILITY -->
                <div class="enzo-reveal enzo-delay-5 group relative bg-gradient-to-b from-[#182335] to-[#0f1726] hover:from-[#1e2c42] hover:to-[#131d2e] rounded-2xl p-6 text-center flex flex-col items-center justify-between min-h-[250px] text-white border border-slate-700/60 hover:border-[#c29b53] hover:shadow-2xl hover:shadow-[#c29b53]/15 hover:-translate-y-2 transition-all duration-300">
                    <div class="absolute -top-10 -right-10 w-24 h-24 rounded-full bg-[#c29b53]/10 blur-xl group-hover:bg-[#c29b53]/25 transition-all duration-500 pointer-events-none"></div>

                    <div class="w-14 h-14 rounded-2xl bg-[#0a0f1d] border border-[#c29b53]/40 text-[#c29b53] flex items-center justify-center shadow-inner group-hover:bg-[#c29b53] group-hover:text-white group-hover:scale-110 group-hover:border-[#c29b53] transition-all duration-300">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/>
                            <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
                        </svg>
                    </div>

                    <div class="my-auto py-2">
                        <h3 class="font-sans font-extrabold text-sm sm:text-base uppercase tracking-wider text-white group-hover:text-[#c29b53] transition-colors duration-200">
                            SUSTAINABILITY
                        </h3>
                        <span class="inline-block text-[10px] font-bold uppercase tracking-wider text-[#c29b53] bg-[#c29b53]/10 px-2.5 py-0.5 rounded-full border border-[#c29b53]/30 my-2">
                            Green Building
                        </span>
                        <p class="text-xs sm:text-[13px] text-slate-200 leading-relaxed font-normal">
                            Penerapan konsep ramah lingkungan, efisiensi sirkulasi energi, dan ketahanan struktur jangka panjang.
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <!-- ==============================================
             SECTION: WHAT WE OFFER (4 Photo Cards in 1 Row)
        =============================================== -->
        <div id="services">
            <h2 class="enzo-reveal text-center font-sans font-extrabold text-xl sm:text-2xl text-slate-900 uppercase tracking-widest mb-8">
                WHAT WE OFFER
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- Card 1: CIVIL WORK -->
                <a href="{{ route('projects.index', ['category' => 'commercial']) }}"
                   class="enzo-reveal enzo-delay-1 group aspect-[4/3] rounded-xl overflow-hidden relative shadow-lg block">
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
                   class="enzo-reveal enzo-delay-2 group aspect-[4/3] rounded-xl overflow-hidden relative shadow-lg block">
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
                   class="enzo-reveal enzo-delay-3 group aspect-[4/3] rounded-xl overflow-hidden relative shadow-lg block">
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
                   class="enzo-reveal enzo-delay-4 group aspect-[4/3] rounded-xl overflow-hidden relative shadow-lg block">
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
        <div class="text-center max-w-2xl mx-auto mb-10 enzo-reveal">
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
             class="enzo-reveal enzo-delay-2 max-w-3xl mx-auto bg-slate-950 p-4 sm:p-5 rounded-2xl shadow-2xl border border-slate-800">
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
        <div class="grid grid-cols-1 @auth md:grid-cols-2 @else max-w-2xl mx-auto @endauth gap-8">
            
            <!-- Box 1: Kalkulator RAB -->
            <div class="enzo-reveal enzo-delay-1 bg-white p-8 rounded-2xl shadow-xl border border-slate-200 flex flex-col justify-between">
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

            @auth
            <!-- Box 2: Pengajuan Tender RFP (Hanya Muncul Jika Sudah Login) -->
            <div class="enzo-reveal enzo-delay-2 bg-gradient-to-br from-[#1a2332] to-[#0f172a] p-8 rounded-2xl shadow-xl text-white flex flex-col justify-between">
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
            @endauth

        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const curtain = document.getElementById('enzo-home-curtain');
        const curtainBox = document.getElementById('enzo-curtain-box');
        const heroBg = document.getElementById('enzoHeroBg');
        const heroItems = document.querySelectorAll('.enzo-hero-item');

        let isDismissed = false;

        const dismissCurtain = () => {
            if (isDismissed) return;
            isDismissed = true;

            // Fade and lift curtain
            if (curtainBox) curtainBox.classList.add('fade-out');
            if (curtain) {
                curtain.classList.add('curtain-lift');
                setTimeout(() => {
                    curtain.style.display = 'none';
                }, 950);
            }

            // Trigger hero cinematic scale and staggered reveals
            requestAnimationFrame(() => {
                if (heroBg) heroBg.classList.add('is-active');
                heroItems.forEach(item => item.classList.add('is-active'));
            });
        };

        // Elegant architectural brand reveal (1100ms), giving time to appreciate the emblem
        const autoDismissTimer = setTimeout(dismissCurtain, 1100);

        // Instant dismiss on user interaction (never blocks user)
        if (curtain) {
            curtain.addEventListener('click', () => {
                clearTimeout(autoDismissTimer);
                dismissCurtain();
            });
        }
        window.addEventListener('keydown', () => {
            clearTimeout(autoDismissTimer);
            dismissCurtain();
        }, { once: true });
        window.addEventListener('wheel', () => {
            clearTimeout(autoDismissTimer);
            dismissCurtain();
        }, { once: true });
        window.addEventListener('touchmove', () => {
            clearTimeout(autoDismissTimer);
            dismissCurtain();
        }, { once: true });

        // Scroll-triggered Reveal Animations via IntersectionObserver
        const revealElements = document.querySelectorAll('.enzo-reveal');
        if ('IntersectionObserver' in window) {
            const revealObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-revealed');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                root: null,
                threshold: 0.12,
                rootMargin: '0px 0px -40px 0px'
            });

            revealElements.forEach(el => revealObserver.observe(el));
        } else {
            // Fallback for browsers without IntersectionObserver
            revealElements.forEach(el => el.classList.add('is-revealed'));
        }
    });
</script>
@endpush
