@extends('layouts.app')

@section('title', 'Kalkulator Estimasi Biaya Bangun (RAB Interaktif) — ENZO Contractor')
@section('meta_description', 'Hitung estimasi anggaran biaya konstruksi (RAB kasar) secara instan berdasarkan tipe bangunan, mutu spesifikasi, dan luas meter persegi.')

@section('content')

<!-- ========================================================
     HERO SECTION (Strictly Matching PT MKP Mockup Style)
========================================================= -->
<section class="relative min-h-[380px] sm:min-h-[420px] flex items-center justify-center overflow-hidden">
    <!-- Clean Architectural Twilight Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/ptmkp_hero_clean.jpg') }}"
             alt="Enzo Estimator Hero"
             class="w-full h-full object-cover object-center">
        <!-- Subtle dark overlay -->
        <div class="absolute inset-0 bg-slate-950/50"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-slate-950/40"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center pt-20 pb-28">
        <span class="inline-block text-xs font-bold text-[#c29b53] uppercase tracking-widest mb-3 font-sans">
            Simulasi Anggaran Real-Time
        </span>
        <h1 class="font-sans text-3xl sm:text-5xl font-extrabold tracking-wide text-white uppercase leading-tight">
            KALKULATOR ESTIMASI BIAYA BANGUN (RAB)
        </h1>
        <p class="text-xs sm:text-sm text-slate-100 font-light max-w-xl mx-auto mt-3 leading-relaxed tracking-normal">
            Dapatkan gambaran kisaran biaya konstruksi awal secara transparan dan instan sebelum melangkah ke perencanaan DED dan survey lapangan.
        </p>
    </div>
</section>

<!-- ========================================================
     WHITE FLOATING CONTAINER (Matching PT MKP Layout)
========================================================= -->
<section class="relative z-20 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 sm:-mt-24 mb-20"
         x-data="{
             buildingType: 'residential_standard',
             finishGrade: 'premium',
             area: 250,
             floors: 2,

             // Tarif dasar sesuai seeder database
             rates: {
                 'residential_standard': {
                     'standard': { base: 3500000, mult: 1.15, spec: 'Pondasi batu kali, dinding bata merah plester aci, atap baja ringan, lantai keramik 40x40, sanitair standar SNI.' },
                     'premium': { base: 5000000, mult: 1.15, spec: 'Pondasi cakar ayam bertulang, dinding bata ringan, atap genteng flat beton, granit 60x60, sanitair Toto.' },
                     'luxury': { base: 7000000, mult: 1.20, spec: 'Pondasi footplat dalam, dinding bata hebel cat Dulux, granit tile 80x80, sanitair Toto premium, kusen aluminium Alexindo.' }
                 },
                 'residential_luxury': {
                     'standard': { base: 5500000, mult: 1.20, spec: 'Pondasi bertulang plat, granit 80x80, plafon gypsum shadowline, cat jotun premium.' },
                     'premium': { base: 7000000, mult: 1.20, spec: 'Pondasi tiang pancang/bore pile, marmer lokal/granit import, smart lock, sanitair Kohler/Grohe.' },
                     'luxury': { base: 8000000, mult: 1.20, spec: 'Pondasi bore pile, marmer import slab, atap dak beton waterproofing, smart home automation, sanitair Kohler.' }
                 },
                 'warehouse': {
                     'standard': { base: 2500000, mult: 1.10, spec: 'Struktur baja WF, penutup atap spandek zincalume, lantai cor beton tebal 15cm hardener, dinding bata/panel.' },
                     'premium': { base: 3500000, mult: 1.12, spec: 'Struktur portal baja berat WF, atap insulasi peredam panas, lantai tebal 20cm double wiremesh floor hardener, kantor mezanin.' },
                     'luxury': { base: 4500000, mult: 1.15, spec: 'Konstruksi baja bentang lebar bebas kolom, lantai epoxy heavy-duty, loading dock hidrolik, sistem pemadam sprinkler.' }
                 },
                 'office': {
                     'standard': { base: 4500000, mult: 1.15, spec: 'Struktur beton bertulang K-250, keramik komersial 60x60, partisi gypsum, instalasi listrik & AC standard.' },
                     'premium': { base: 6000000, mult: 1.18, spec: 'Struktur beton K-300, raised floor/granit 80x80, partisi kaca tempered, plafon akustik, MEP lengkap & hydrant.' },
                     'luxury': { base: 8500000, mult: 1.22, spec: 'Fasad curtain wall double glass low-E, marmer lobby eksekutif, lift penumpang, BMS (Building Management System).' }
                 },
                 'shophouse': {
                     'standard': { base: 3500000, mult: 1.12, spec: 'Struktur 2-3 lantai beton K-225, dinding bata ringan, lantai keramik 50x50, pintu rolling door besi.' },
                     'premium': { base: 4000000, mult: 1.12, spec: 'Pondasi cakar ayam, dinding bata ringan finishing cat luar weathershield, lantai granit 60x60, pintu folding door aluminium & fasad ACP.' },
                     'luxury': { base: 5500000, mult: 1.16, spec: 'Desain fasad modern kontemporer ACP & kaca, granit 80x80, tangga marmer dengan railing tempered glass, sanitair Toto.' }
                 }
             },

             getCurrentConfig() {
                 let typeObj = this.rates[this.buildingType] || this.rates['residential_standard'];
                 return typeObj[this.finishGrade] || typeObj['premium'];
             },

             getEffectiveRate() {
                 let cfg = this.getCurrentConfig();
                 let floorMult = this.floors > 1 ? (1 + (cfg.mult - 1) * (this.floors - 1) * 0.75) : 1.0;
                 return Math.round(cfg.base * floorMult);
             },

             getNominal() {
                 return this.getEffectiveRate() * this.area;
             },

             getMinCost() {
                 return Math.round(this.getNominal() * 0.92);
             },

             getMaxCost() {
                 return Math.round(this.getNominal() * 1.10);
             },

             formatRupiah(num) {
                 return 'Rp ' + new Intl.NumberFormat('id-ID').format(num);
             },

             getRfpUrl() {
                 let min = this.formatRupiah(this.getMinCost());
                 let max = this.formatRupiah(this.getMaxCost());
                 let budget = Math.round((this.getMinCost() + this.getMaxCost()) / 2);
                 return '{{ route('rfp.create') }}?category=' + encodeURIComponent(this.buildingType) + '&area=' + this.area + '&budget=' + budget + '&notes=' + encodeURIComponent('Estimasi RAB: ' + min + ' s/d ' + max + ' (' + this.floors + ' lantai, spesifikasi ' + this.finishGrade + ')');
             },

             getWaUrl() {
                 let msg = 'Halo Tim Estimator Enzo Contractor, saya melakukan simulasi estimasi biaya konstruksi dengan rincian:%0A' +
                           '- Tipe Bangunan: ' + this.buildingType + '%0A' +
                           '- Mutu Spesifikasi: ' + this.finishGrade + '%0A' +
                           '- Luas Bangunan: ' + this.area + ' m²%0A' +
                           '- Jumlah Lantai: ' + this.floors + ' Lantai%0A' +
                           '- Kisaran Estimasi: ' + this.formatRupiah(this.getMinCost()) + ' - ' + this.formatRupiah(this.getMaxCost()) + '%0A%0A' +
                           'Mohon info jadwal konsultasi teknis lebih lanjut.';
                 return 'https://wa.me/{{ $settings['whatsapp'] ?? '6281348593725' }}?text=' + msg;
             }
         }">

    <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl p-6 sm:p-10 border border-slate-100 space-y-10">

        <!-- ==============================================
             LANGKAH 1: PILIH JENIS BANGUNAN
        =============================================== -->
        <div class="bg-slate-50 p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <span class="w-8 h-8 rounded-full bg-[#c29b53] text-white font-bold text-sm flex items-center justify-center shadow">1</span>
                <div>
                    <h2 class="font-sans text-base sm:text-lg font-bold text-slate-900 uppercase tracking-wide">Pilih Jenis Bangunan</h2>
                    <p class="text-xs text-slate-500 font-light">Tipe struktur dan fungsi peruntukan bangunan Anda</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Type: Residential Standard -->
                <button type="button" @click="buildingType = 'residential_standard'"
                        :class="buildingType === 'residential_standard' ? 'border-[#c29b53] bg-white ring-2 ring-[#c29b53] text-slate-900 shadow-md' : 'border-slate-200 bg-white text-slate-700 hover:border-slate-300'"
                        class="p-4 rounded-xl border text-left transition duration-200 flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-2">
                        <i data-lucide="home" class="w-5 h-5 text-[#c29b53]"></i>
                        <span x-show="buildingType === 'residential_standard'" class="w-2.5 h-2.5 rounded-full bg-[#c29b53]"></span>
                    </div>
                    <div>
                        <div class="font-bold text-sm mb-1 uppercase tracking-wider">Rumah Tinggal Standar</div>
                        <div class="text-[11px] text-slate-500 font-light">Hunian 1-2 lantai modern & efisien</div>
                    </div>
                </button>

                <!-- Type: Residential Luxury -->
                <button type="button" @click="buildingType = 'residential_luxury'"
                        :class="buildingType === 'residential_luxury' ? 'border-[#c29b53] bg-white ring-2 ring-[#c29b53] text-slate-900 shadow-md' : 'border-slate-200 bg-white text-slate-700 hover:border-slate-300'"
                        class="p-4 rounded-xl border text-left transition duration-200 flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-2">
                        <i data-lucide="sparkles" class="w-5 h-5 text-[#c29b53]"></i>
                        <span x-show="buildingType === 'residential_luxury'" class="w-2.5 h-2.5 rounded-full bg-[#c29b53]"></span>
                    </div>
                    <div>
                        <div class="font-bold text-sm mb-1 uppercase tracking-wider">Rumah Mewah / Villa</div>
                        <div class="text-[11px] text-slate-500 font-light">Material prestisius & fasad mewah</div>
                    </div>
                </button>

                <!-- Type: Office -->
                <button type="button" @click="buildingType = 'office'"
                        :class="buildingType === 'office' ? 'border-[#c29b53] bg-white ring-2 ring-[#c29b53] text-slate-900 shadow-md' : 'border-slate-200 bg-white text-slate-700 hover:border-slate-300'"
                        class="p-4 rounded-xl border text-left transition duration-200 flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-2">
                        <i data-lucide="building-2" class="w-5 h-5 text-[#c29b53]"></i>
                        <span x-show="buildingType === 'office'" class="w-2.5 h-2.5 rounded-full bg-[#c29b53]"></span>
                    </div>
                    <div>
                        <div class="font-bold text-sm mb-1 uppercase tracking-wider">Gedung Kantor / Komersial</div>
                        <div class="text-[11px] text-slate-500 font-light">Struktur bertingkat & sistem MEP</div>
                    </div>
                </button>

                <!-- Type: Warehouse -->
                <button type="button" @click="buildingType = 'warehouse'"
                        :class="buildingType === 'warehouse' ? 'border-[#c29b53] bg-white ring-2 ring-[#c29b53] text-slate-900 shadow-md' : 'border-slate-200 bg-white text-slate-700 hover:border-slate-300'"
                        class="p-4 rounded-xl border text-left transition duration-200 flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-2">
                        <i data-lucide="warehouse" class="w-5 h-5 text-[#c29b53]"></i>
                        <span x-show="buildingType === 'warehouse'" class="w-2.5 h-2.5 rounded-full bg-[#c29b53]"></span>
                    </div>
                    <div>
                        <div class="font-bold text-sm mb-1 uppercase tracking-wider">Gudang & Bangunan Baja</div>
                        <div class="text-[11px] text-slate-500 font-light">Rangka baja WF bentang lebar</div>
                    </div>
                </button>

                <!-- Type: Shophouse -->
                <button type="button" @click="buildingType = 'shophouse'"
                        :class="buildingType === 'shophouse' ? 'border-[#c29b53] bg-white ring-2 ring-[#c29b53] text-slate-900 shadow-md' : 'border-slate-200 bg-white text-slate-700 hover:border-slate-300'"
                        class="p-4 rounded-xl border text-left transition duration-200 flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-2">
                        <i data-lucide="store" class="w-5 h-5 text-[#c29b53]"></i>
                        <span x-show="buildingType === 'shophouse'" class="w-2.5 h-2.5 rounded-full bg-[#c29b53]"></span>
                    </div>
                    <div>
                        <div class="font-bold text-sm mb-1 uppercase tracking-wider">Ruko / Shophouse</div>
                        <div class="text-[11px] text-slate-500 font-light">Ruang usaha bertingkat dengan fasad ACP</div>
                    </div>
                </button>
            </div>
        </div>

        <!-- ==============================================
             LANGKAH 2: TENTUKAN TINGKAT SPESIFIKASI MATERIAL
        =============================================== -->
        <div class="bg-slate-50 p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <span class="w-8 h-8 rounded-full bg-[#c29b53] text-white font-bold text-sm flex items-center justify-center shadow">2</span>
                <div>
                    <h2 class="font-sans text-base sm:text-lg font-bold text-slate-900 uppercase tracking-wide">Tingkat Mutu Spesifikasi Material (Finish Grade)</h2>
                    <p class="text-xs text-slate-500 font-light">Menentukan kualitas material struktur, arsitektur, dan sanitair</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Standard -->
                <div @click="finishGrade = 'standard'"
                     :class="finishGrade === 'standard' ? 'border-[#c29b53] bg-white ring-2 ring-[#c29b53] shadow-md' : 'border-slate-200 bg-white hover:border-slate-300'"
                     class="cursor-pointer p-5 rounded-xl border transition flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Grade A</span>
                            <span class="text-[10px] bg-slate-100 text-slate-700 px-2 py-0.5 rounded font-bold">Ekonomis SNI</span>
                        </div>
                        <h3 class="font-sans text-base font-bold text-slate-900 mb-2 uppercase tracking-wide">Standar SNI</h3>
                        <p class="text-xs text-slate-600 leading-relaxed mb-4 font-light">
                            Struktur SNI, keramik lantai 40-50cm, kusen aluminium standar, cat interior/eksterior andal.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 text-xs text-[#c29b53] font-bold">
                        Cocok untuk efisiensi investasi
                    </div>
                </div>

                <!-- Premium (Recommended) -->
                <div @click="finishGrade = 'premium'"
                     :class="finishGrade === 'premium' ? 'border-[#c29b53] bg-white ring-2 ring-[#c29b53] shadow-md' : 'border-slate-200 bg-white hover:border-slate-300'"
                     class="cursor-pointer p-5 rounded-xl border transition flex flex-col justify-between relative overflow-hidden">
                    <span class="absolute top-0 right-0 bg-[#c29b53] text-white text-[9px] font-bold px-2.5 py-0.5 rounded-bl uppercase">
                        Paling Populer
                    </span>
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#c29b53]">Grade AA</span>
                        </div>
                        <h3 class="font-sans text-base font-bold text-slate-900 mb-2 uppercase tracking-wide">Premium High-Grade</h3>
                        <p class="text-xs text-slate-600 leading-relaxed mb-4 font-light">
                            Pondasi cakar ayam bertulang, granit tile 60-80cm, sanitair merk Toto, cat Jotun/Dulux, kusen Alexindo.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 text-xs text-[#c29b53] font-bold">
                        Standar favorit residensial & kantor
                    </div>
                </div>

                <!-- Luxury -->
                <div @click="finishGrade = 'luxury'"
                     :class="finishGrade === 'luxury' ? 'border-[#c29b53] bg-white ring-2 ring-[#c29b53] shadow-md' : 'border-slate-200 bg-white hover:border-slate-300'"
                     class="cursor-pointer p-5 rounded-xl border transition flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Grade AAA</span>
                            <span class="text-[10px] bg-slate-100 text-slate-700 px-2 py-0.5 rounded font-bold">Eksklusif</span>
                        </div>
                        <h3 class="font-sans text-base font-bold text-slate-900 mb-2 uppercase tracking-wide">Luxury Executive</h3>
                        <p class="text-xs text-slate-600 leading-relaxed mb-4 font-light">
                            Bore pile, marmer import slab, kaca low-E akustik, sanitair Kohler/Grohe, smart automation.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 text-xs text-[#c29b53] font-bold">
                        Kualitas arsitektural mahakarya
                    </div>
                </div>
            </div>
        </div>

        <!-- ==============================================
             LANGKAH 3: INPUT DIMENSI & JUMLAH LANTAI
        =============================================== -->
        <div class="bg-slate-50 p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <span class="w-8 h-8 rounded-full bg-[#c29b53] text-white font-bold text-sm flex items-center justify-center shadow">3</span>
                <div>
                    <h2 class="font-sans text-base sm:text-lg font-bold text-slate-900 uppercase tracking-wide">Dimensi & Jumlah Lantai Bangunan</h2>
                    <p class="text-xs text-slate-500 font-light">Geser slider atau masukkan angka langsung untuk kalkulasi presisi</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Area Slider -->
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Perkiraan Luas Bangunan:</label>
                        <div class="flex items-center gap-1.5">
                            <input type="number" x-model.number="area" min="20" max="10000"
                                   class="w-24 bg-white border border-[#c29b53] text-[#c29b53] font-bold text-right py-1 px-2 rounded-lg text-sm focus:outline-none shadow-sm">
                            <span class="text-xs text-slate-500 font-bold">m²</span>
                        </div>
                    </div>
                    <input type="range" min="36" max="3000" step="10" x-model.number="area"
                           class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-[#c29b53]">
                    <div class="flex justify-between text-[10px] text-slate-500 mt-2 font-medium">
                        <span>36 m² (Rumah Mini)</span>
                        <span>500 m² (Ruko / Kantor)</span>
                        <span>3.000 m² (Pabrik / Gudang)</span>
                    </div>
                </div>

                <!-- Floors Input -->
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Jumlah Lantai:</label>
                        <div class="flex items-center gap-1.5">
                            <span class="text-sm font-bold text-[#c29b53]" x-text="floors + ' Lantai'"></span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-5 gap-2">
                        <template x-for="f in [1, 2, 3, 4, 5]" :key="f">
                            <button type="button" @click="floors = f"
                                    :class="floors === f ? 'bg-[#c29b53] text-white font-bold shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'"
                                    class="py-2.5 rounded-lg text-xs transition font-semibold"
                                    x-text="f + ' Lt'">
                            </button>
                        </template>
                    </div>
                    <p class="text-[11px] text-slate-500 mt-2 font-light">
                        *Koefisien struktur bertingkat otomatis dihitung untuk beban balok, kolom, dan plat lantai.
                    </p>
                </div>
            </div>
        </div>

        <!-- ==============================================
             HASIL ESTIMASI REAL-TIME & CALL TO ACTION
             (Contrasting Dark PT MKP Box)
        =============================================== -->
        <div class="bg-gradient-to-br from-[#1a2332] to-[#0f172a] p-6 sm:p-10 rounded-2xl shadow-xl text-white relative overflow-hidden">
            <div class="relative z-10">
                <span class="text-xs font-bold text-[#c29b53] uppercase tracking-widest block mb-2 font-sans">Hasil Kalkulasi Kasar Awal</span>
                <h3 class="font-sans text-xl sm:text-2xl font-extrabold text-white mb-6 uppercase tracking-wide">
                    Estimasi Kisaran Anggaran Konstruksi
                </h3>

                <!-- Price Range Highlight -->
                <div class="bg-black/40 border border-[#c29b53]/40 rounded-xl p-6 mb-6 text-center backdrop-blur-md">
                    <div class="text-xs text-slate-300 mb-1">Kisaran Anggaran Pelaksanaan (Non-Kontraktual):</div>
                    <div class="font-sans text-2xl sm:text-4xl font-extrabold text-[#c29b53] my-2 tracking-tight">
                        <span x-text="formatRupiah(getMinCost())"></span>
                        <span class="text-slate-400 font-light text-xl sm:text-2xl mx-2">—</span>
                        <span x-text="formatRupiah(getMaxCost())"></span>
                    </div>
                    <div class="text-xs text-slate-300 mt-1">
                        Rata-rata tarif efektif: <span class="text-white font-bold" x-text="formatRupiah(getEffectiveRate()) + ' / m²'"></span>
                    </div>
                </div>

                <!-- Specifications Breakdown -->
                <div class="bg-slate-900/80 p-4 rounded-xl border border-slate-800 text-xs mb-8">
                    <div class="font-bold text-white mb-1 flex items-center gap-1.5 uppercase tracking-wide">
                        <i data-lucide="info" class="w-4 h-4 text-[#c29b53]"></i>
                        <span>Spesifikasi Acuan Simulasi:</span>
                    </div>
                    <p class="text-slate-300 leading-relaxed font-light" x-text="getCurrentConfig().spec"></p>
                    <div class="mt-2 text-[11px] text-slate-400">
                        *Catatan: Nilai di atas adalah estimasi awal. Besaran riil akan dipastikan melalui pengujian sondir tanah, gambar kerja DED, dan rincian BOQ (Bill of Quantities) resmi.
                    </div>
                </div>

                <!-- Action CTAs -->
                <div class="grid grid-cols-1 @auth sm:grid-cols-2 @endauth gap-4">
                    @auth
                    <a :href="getRfpUrl()"
                       class="inline-flex items-center justify-center py-3.5 px-6 bg-[#c29b53] hover:bg-[#ad8741] text-white font-bold text-xs sm:text-sm uppercase tracking-wider rounded-lg shadow-xl shadow-black/20 transition">
                        <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                        <span>Konsultasikan ke Form RFP</span>
                    </a>
                    @endauth

                    <a :href="getWaUrl()" target="_blank"
                       class="inline-flex items-center justify-center py-3.5 px-6 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs sm:text-sm uppercase tracking-wider rounded-lg shadow-xl shadow-emerald-600/25 transition">
                        <i data-lucide="message-circle" class="w-4 h-4 mr-2"></i>
                        <span>Kirim Hasil ke WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
