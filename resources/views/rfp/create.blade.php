@extends('layouts.app')

@section('title', 'Formulir Pengajuan Penawaran Tender (RFP) — ENZO Contractor')
@section('meta_description', 'Kirimkan kerangka proyek konstruksi Anda. Tim estimator dan sales engineer Enzo akan mengkaji dan menghubungi Anda dalam 1x24 jam kerja.')

@section('content')

<!-- ========================================================
     HERO SECTION (Strictly Matching PT MKP Mockup Style)
========================================================= -->
<section class="relative min-h-[380px] sm:min-h-[420px] flex items-center justify-center overflow-hidden">
    <!-- Clean Architectural Twilight Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/ptmkp_hero_clean.jpg') }}"
             alt="Enzo RFP Tender Portal Hero"
             class="w-full h-full object-cover object-center">
        <!-- Subtle dark overlay -->
        <div class="absolute inset-0 bg-slate-950/50"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-slate-950/40"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center pt-20 pb-28">
        <span class="inline-block text-xs font-bold text-[#c29b53] uppercase tracking-widest mb-3 font-sans">
            Request For Proposal (RFP) Portal
        </span>
        <h1 class="font-sans text-3xl sm:text-5xl font-extrabold tracking-wide text-white uppercase leading-tight">
            Pengajuan Permintaan <span class="text-[#c29b53]">Penawaran & Tender (RFP)</span>
        </h1>
        <p class="text-xs sm:text-sm text-slate-100 font-light max-w-xl mx-auto mt-3 leading-relaxed tracking-normal">
            Kirimkan kerangka kebutuhan dan dokumen arsitektur proyek Anda. Tim estimator berlisensi kami akan membedah spesifikasi dan menyusun proposal teknis dalam 1x24 jam kerja.
        </p>
    </div>
</section>

<!-- ========================================================
     WHITE FLOATING CONTAINER (Matching PT MKP Layout)
========================================================= -->
<section class="relative z-20 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 sm:-mt-24 mb-20"
         x-data="{
             designMode: '{{ !empty($prefill['design_layout_id']) ? 'template' : 'custom' }}'
         }">
    
    <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl p-6 sm:p-10 border border-slate-100">

        @if ($errors->any())
            <div class="mb-8 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs shadow-sm">
                <div class="font-bold flex items-center gap-2 mb-2">
                    <i data-lucide="alert-octagon" class="w-4 h-4 text-rose-600"></i>
                    <span>Terdapat beberapa isian yang perlu diperiksa:</span>
                </div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('rfp.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Anti-Bot Security Honeypot (Hidden from human visitors, traps automated bots) -->
            <div class="hidden" aria-hidden="true" style="display:none !important; position:absolute; left:-9999px;">
                <label for="website_hp">Leave this field empty</label>
                <input type="text" name="website_hp" id="website_hp" value="" tabindex="-1" autocomplete="off">
            </div>

            <!-- ==============================================
                 BAGIAN 1: IDENTITAS PEMOHON
            =============================================== -->
            <div class="bg-slate-50 p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex items-center gap-3 mb-6 pb-3 border-b border-slate-200">
                    <span class="w-7 h-7 rounded-full bg-[#c29b53] text-white font-bold text-xs flex items-center justify-center shadow">1</span>
                    <h2 class="font-sans text-base sm:text-lg font-bold text-slate-900 uppercase tracking-wide">Identitas Pemohon / PIC Proyek</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Nama Lengkap Penanggung Jawab <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="full_name" value="{{ old('full_name', $prefill['full_name'] ?? '') }}" required
                               placeholder="Contoh: Ir. Budi Santoso, M.T."
                               class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-[#c29b53] shadow-sm">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Nama Perusahaan / Instansi (Opsional)
                        </label>
                        <input type="text" name="company_name" value="{{ old('company_name', $prefill['company_name'] ?? '') }}"
                               placeholder="Contoh: PT Graha Mega Persada"
                               class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-[#c29b53] shadow-sm">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Nomor WhatsApp Aktif <span class="text-rose-500">*</span>
                        </label>
                        <input type="tel" name="phone_number" value="{{ old('phone_number', $prefill['phone_number'] ?? '') }}" required
                               placeholder="Contoh: 081234567890"
                               inputmode="numeric"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-[#c29b53] shadow-sm">
                        <p class="text-xs text-slate-500 mt-1">Cukup masukkan angka saja tanpa tanda hubung (-)</p>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Alamat Email Resmi <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', $prefill['email'] ?? '') }}" required
                               placeholder="Contoh: budi@graha-megapersada.co.id"
                               class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-[#c29b53] shadow-sm">
                    </div>
                </div>
            </div>

            <!-- ==============================================
                 BAGIAN 2: REFERENSI DENAH & RUANG LINGKUP
            =============================================== -->
            <div class="bg-slate-50 p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex items-center gap-3 mb-6 pb-3 border-b border-slate-200">
                    <span class="w-7 h-7 rounded-full bg-[#c29b53] text-white font-bold text-xs flex items-center justify-center shadow">2</span>
                    <h2 class="font-sans text-base sm:text-lg font-bold text-slate-900 uppercase tracking-wide">Referensi Desain & Denah Tata Letak</h2>
                </div>

                <!-- Pilihan Mode: Template Standar vs Custom Unggah -->
                <div class="mb-6">
                    <label class="block font-bold text-xs text-slate-700 uppercase tracking-wider mb-2">
                        Pilihan Acuan Arsitektur:
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <label @click="designMode = 'template'"
                               :class="designMode === 'template' ? 'border-[#c29b53] bg-white ring-2 ring-[#c29b53] text-slate-900 shadow-md' : 'border-slate-200 bg-white text-slate-700 hover:border-slate-300'"
                               class="p-4 rounded-xl border cursor-pointer flex items-start gap-3 transition">
                            <input type="radio" name="design_mode_select" value="template" :checked="designMode === 'template'" class="mt-0.5 accent-[#c29b53]">
                            <div>
                                <div class="font-bold text-sm uppercase tracking-wide">Pilih Denah Standar Siap Bangun</div>
                                <div class="text-[11px] text-slate-500 mt-0.5 font-light">Pilih dari katalog referensi teruji arsitek Enzo (Type 45, 70, 120, Villa).</div>
                            </div>
                        </label>

                        <label @click="designMode = 'custom'"
                               :class="designMode === 'custom' ? 'border-[#c29b53] bg-white ring-2 ring-[#c29b53] text-slate-900 shadow-md' : 'border-slate-200 bg-white text-slate-700 hover:border-slate-300'"
                               class="p-4 rounded-xl border cursor-pointer flex items-start gap-3 transition">
                            <input type="radio" name="design_mode_select" value="custom" :checked="designMode === 'custom'" class="mt-0.5 accent-[#c29b53]">
                            <div>
                                <div class="font-bold text-sm uppercase tracking-wide">Desain Kustom Penuh (Unggah Sendiri)</div>
                                <div class="text-[11px] text-slate-500 mt-0.5 font-light">Rancang bebas dari nol atau unggah dokumen arsitektur/CAD milik Anda.</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Template Layout Selector (If template mode) -->
                <div x-show="designMode === 'template'" class="mb-6 p-4 rounded-xl bg-white border border-slate-200 shadow-sm">
                    <label class="block font-bold text-xs text-[#c29b53] uppercase tracking-wider mb-2">
                        Pilih Template Layout dari Katalog:
                    </label>
                    <select name="design_layout_id"
                            class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-3 text-xs text-slate-900 focus:outline-none focus:border-[#c29b53]">
                        <option value="">-- Pilih Katalog Layout Siap Pakai --</option>
                        @foreach($layouts as $l)
                            <option value="{{ $l->id }}" {{ (old('design_layout_id', $prefill['design_layout_id']) == $l->id) ? 'selected' : '' }}>
                                {{ $l->name }} ({{ $l->building_type }} — {{ (int)$l->building_size_sqm }}m² / {{ (int)$l->land_size_sqm }}m² Tanah) — Rp {{ number_format($l->estimated_price_idr / 1000000, 0) }} Juta
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Scope Inputs -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Kategori Pekerjaan Konstruksi <span class="text-rose-500">*</span>
                        </label>
                        <select name="project_category" required
                                class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 focus:outline-none focus:border-[#c29b53] shadow-sm">
                            <option value="">-- Pilih Kategori Pekerjaan --</option>
                            <option value="Konstruksi Komersial & Perkantoran" {{ old('project_category', $prefill['project_category']) === 'Konstruksi Komersial & Perkantoran' || old('project_category', $prefill['project_category']) === 'konstruksi-komersial' || old('project_category', $prefill['project_category']) === 'office' ? 'selected' : '' }}>Konstruksi Komersial & Perkantoran</option>
                            <option value="Residensial & Design-and-Build" {{ old('project_category', $prefill['project_category']) === 'Residensial & Design-and-Build' || old('project_category', $prefill['project_category']) === 'residensial-design-build' || old('project_category', $prefill['project_category']) === 'residential_standard' || old('project_category', $prefill['project_category']) === 'residential_luxury' ? 'selected' : '' }}>Residensial & Design-and-Build</option>
                            <option value="Industri & Pergudangan Baja" {{ old('project_category', $prefill['project_category']) === 'Industri & Pergudangan Baja' || old('project_category', $prefill['project_category']) === 'industri-pergudangan' || old('project_category', $prefill['project_category']) === 'warehouse' ? 'selected' : '' }}>Industri & Pergudangan Baja</option>
                            <option value="Renovasi & Revitalisasi Fasad" {{ old('project_category', $prefill['project_category']) === 'Renovasi & Revitalisasi Fasad' || old('project_category', $prefill['project_category']) === 'renovasi-interior' ? 'selected' : '' }}>Renovasi & Revitalisasi Fasad</option>
                            <option value="Pekerjaan Sipil & Infrastruktur" {{ old('project_category', $prefill['project_category']) === 'Pekerjaan Sipil & Infrastruktur' || old('project_category', $prefill['project_category']) === 'pekerjaan-sipil' ? 'selected' : '' }}>Pekerjaan Sipil & Infrastruktur</option>
                            <option value="Ruko / Shophouse Komersial" {{ old('project_category', $prefill['project_category']) === 'shophouse' ? 'selected' : '' }}>Ruko / Shophouse Komersial</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Lokasi Tapak Proyek <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="site_location" value="{{ old('site_location') }}" required
                               placeholder="Contoh: Jl. Ahmad Yani No. 12, Pontianak"
                               class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-[#c29b53] shadow-sm">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Perkiraan Luas Bangunan (m²)
                        </label>
                        <input type="number" name="planned_area_sqm" value="{{ old('planned_area_sqm', $prefill['planned_area_sqm']) }}" min="10"
                               placeholder="Contoh: 150"
                               class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-[#c29b53] shadow-sm">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Alokasi Plafon Anggaran (Rp) (Opsional)
                        </label>
                        <input type="number" name="estimated_budget_idr" value="{{ old('estimated_budget_idr', $prefill['estimated_budget_idr']) }}" min="0" step="1000000"
                               placeholder="Contoh: 750000000"
                               class="w-full bg-white border border-slate-300 rounded-lg px-4 py-3 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-[#c29b53] shadow-sm">
                    </div>

                    <!-- Sistem Pembayaran: Tunai Bertahap (Standar Kebijakan Perusahaan) -->
                    <input type="hidden" name="payment_scheme" value="cash_tempo">
                    <div class="md:col-span-2 p-4 rounded-xl bg-slate-100/90 border border-slate-200 text-slate-700 text-xs flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-[#c29b53]/15 text-[#c29b53] flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                        </div>
                        <div class="text-[11px] leading-relaxed">
                            <span class="font-bold text-slate-900 block text-xs mb-0.5">Ketentuan Metode Pembayaran:</span>
                            Seluruh kontrak proyek menggunakan sistem <strong>Pembayaran Tunai Bertahap</strong> yang disesuaikan secara transparan berdasarkan termin opname progres fisik lapangan.
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==============================================
                 BAGIAN 3: UNGGAH DOKUMEN TENDER & CATATAN
            =============================================== -->
            <div class="bg-slate-50 p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex items-center gap-3 mb-6 pb-3 border-b border-slate-200">
                    <span class="w-7 h-7 rounded-full bg-[#c29b53] text-white font-bold text-xs flex items-center justify-center shadow">3</span>
                    <h2 class="font-sans text-base sm:text-lg font-bold text-slate-900 uppercase tracking-wide">Unggah Berkas Tender & Kerangka Acuan (TOR)</h2>
                </div>

                <!-- Drag & Drop File Upload Box -->
                <div class="mb-6" x-data="{ filesCount: 0 }">
                    <label class="block font-bold text-xs text-slate-700 uppercase tracking-wider mb-2">
                        Lampiran Dokumen Desain / Gambar Arsitektur / BOQ (Bila Tersedia)
                    </label>
                    <div class="border-2 border-dashed border-slate-300 hover:border-[#c29b53] rounded-xl p-8 text-center bg-white transition cursor-pointer relative group">
                        <input type="file" name="attachments[]" multiple
                               @change="filesCount = $el.files.length"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="w-12 h-12 rounded-full bg-[#c29b53]/10 text-[#c29b53] flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition border border-[#c29b53]/30">
                            <i data-lucide="upload-cloud" class="w-6 h-6"></i>
                        </div>
                        <div class="text-xs font-bold text-slate-800 mb-1">
                            <span class="text-[#c29b53] underline">Klik untuk memilih file</span> atau seret & lepas berkas di sini
                        </div>
                        <div class="text-[11px] text-slate-400 font-light">
                            Format didukung: PDF, DWG (AutoCAD), ZIP, RAR, JPG, PNG, DOCX (Maksimal 25 MB per berkas)
                        </div>
                        <div x-show="filesCount > 0" class="mt-3 text-xs font-bold text-emerald-600 flex items-center justify-center gap-1.5" x-cloak>
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                            <span x-text="filesCount + ' berkas terpilih siap diunggah'"></span>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="text-xs">
                    <label class="block font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Catatan Khusus / Lingkup Pekerjaan Tambahan:
                    </label>
                    <textarea name="project_notes" rows="4"
                              placeholder="Jelaskan kebutuhan spesifik, target serah terima, kondisi tanah, atau preferensi material khusus..."
                              class="w-full bg-white border border-slate-300 rounded-lg p-3 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-[#c29b53] shadow-sm">{{ old('project_notes', $prefill['notes']) }}</textarea>
                </div>

                <!-- Agreement Checkbox -->
                <div class="mt-6 pt-4 border-t border-slate-200 flex items-start gap-3">
                    <input type="checkbox" id="consent" required checked
                           class="mt-1 w-4 h-4 rounded bg-white border-slate-300 text-[#c29b53] focus:ring-[#c29b53]">
                    <label for="consent" class="text-xs text-slate-600 leading-relaxed cursor-pointer font-light">
                        Saya bersedia dihubungi oleh tim rekayasa teknis Enzo Contractor untuk klarifikasi lingkup pekerjaan dan koordinasi jadwal survey lokasi. Data pribadi dilindungi sesuai kebijakan kerahasiaan.
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center pt-2">
                <button type="submit"
                        class="w-full sm:w-auto px-10 py-4 bg-[#c29b53] hover:bg-[#ad8741] text-white font-sans font-bold text-sm uppercase tracking-wider rounded-xl shadow-xl shadow-black/20 hover:scale-[1.01] active:scale-[0.99] transition">
                    <span class="flex items-center justify-center gap-2">
                        <i data-lucide="send" class="w-5 h-5"></i>
                        <span>SUBMIT PENGAJUAN PENAWARAN (RFP) SEKARANG</span>
                    </span>
                </button>
                <p class="text-[11px] text-slate-500 mt-3 font-light">
                    Data Anda dilindungi kerahasiaan NDA profesional dan hanya digunakan untuk keperluan kalkulasi tender.
                </p>
            </div>

        </form>

    </div>
</section>

@endsection
