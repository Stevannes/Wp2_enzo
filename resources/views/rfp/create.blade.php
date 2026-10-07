@extends('layouts.app')

@section('title', 'Formulir Pengajuan Penawaran Tender (RFP) — ENZO Contractor')
@section('meta_description', 'Kirimkan kerangka proyek konstruksi Anda. Tim estimator dan sales engineer Enzo akan mengkaji dan menghubungi Anda dalam 1x24 jam kerja.')

@section('content')

<!-- Header Section -->
<section class="py-16 bg-[#060A14] border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-semibold uppercase tracking-wider mb-4">
            <i data-lucide="file-signature" class="w-3.5 h-3.5"></i>
            <span>Request For Proposal (RFP) Portal</span>
        </div>
        <h1 class="font-serif text-3xl sm:text-5xl font-bold text-white mb-4">
            Pengajuan Permintaan <span class="gold-gradient-text">Penawaran & Tender</span>
        </h1>
        <p class="text-slate-400 text-xs sm:text-sm leading-relaxed font-light">
            Kirimkan kerangka kebutuhan dan dokumen arsitektur proyek Anda. Tim estimator berlisensi kami akan membedah spesifikasi dan menyusun proposal teknis dalam 1x24 jam kerja.
        </p>
    </div>
</section>

<!-- RFP Submission Form (Wireframe 4) -->
<section class="py-16 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    
    @if ($errors->any())
        <div class="mb-8 p-4 rounded-xl bg-rose-950/80 border border-rose-500/50 text-rose-200 text-xs">
            <div class="font-bold flex items-center gap-2 mb-2">
                <i data-lucide="alert-octagon" class="w-4 h-4 text-rose-400"></i>
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

        <!-- ==============================================
             BAGIAN 1: IDENTITAS PEMOHON
        =============================================== -->
        <div class="glass-panel p-6 sm:p-8 rounded-2xl border border-slate-800 shadow-xl">
            <div class="flex items-center gap-3 mb-6 pb-3 border-b border-slate-800">
                <span class="w-7 h-7 rounded-full bg-amber-500 text-slate-950 font-bold text-xs flex items-center justify-center">1</span>
                <h2 class="font-serif text-lg font-bold text-white">Identitas Pemohon / PIC Proyek</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
                <div>
                    <label class="block font-semibold text-slate-300 mb-2">
                        Nama Lengkap Penanggung Jawab <span class="text-amber-500">*</span>
                    </label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" required
                           placeholder="Contoh: Ir. Budi Santoso, M.T."
                           class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block font-semibold text-slate-300 mb-2">
                        Nama Perusahaan / Instansi (Opsional)
                    </label>
                    <input type="text" name="company_name" value="{{ old('company_name') }}"
                           placeholder="Contoh: PT Graha Mega Persada"
                           class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block font-semibold text-slate-300 mb-2">
                        Nomor WhatsApp Aktif <span class="text-amber-500">*</span>
                    </label>
                    <input type="tel" name="phone_number" value="{{ old('phone_number') }}" required
                           placeholder="Contoh: 0812-3456-7890"
                           class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block font-semibold text-slate-300 mb-2">
                        Alamat Email Resmi <span class="text-amber-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="Contoh: budi@graha-megapersada.co.id"
                           class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-amber-500">
                </div>
            </div>
        </div>

        <!-- ==============================================
             BAGIAN 2: RUANG LINGKUP & SPESIFIKASI PROYEK
        =============================================== -->
        <div class="glass-panel p-6 sm:p-8 rounded-2xl border border-slate-800 shadow-xl">
            <div class="flex items-center gap-3 mb-6 pb-3 border-b border-slate-800">
                <span class="w-7 h-7 rounded-full bg-amber-500 text-slate-950 font-bold text-xs flex items-center justify-center">2</span>
                <h2 class="font-serif text-lg font-bold text-white">Ruang Lingkup & Lokasi Proyek</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
                <div>
                    <label class="block font-semibold text-slate-300 mb-2">
                        Kategori Pekerjaan <span class="text-amber-500">*</span>
                    </label>
                    <select name="project_category" required
                            class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500">
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
                    <label class="block font-semibold text-slate-300 mb-2">
                        Lokasi Tapak Proyek <span class="text-amber-500">*</span>
                    </label>
                    <input type="text" name="site_location" value="{{ old('site_location') }}" required
                           placeholder="Contoh: Jl. Ahmad Yani No. 12, Pontianak"
                           class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block font-semibold text-slate-300 mb-2">
                        Perkiraan Luas Bangunan (m²)
                    </label>
                    <input type="number" name="planned_area_sqm" value="{{ old('planned_area_sqm', $prefill['planned_area_sqm']) }}" min="10"
                           placeholder="Contoh: 450"
                           class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block font-semibold text-slate-300 mb-2">
                        Alokasi Plafon Anggaran (Rp) (Opsional)
                    </label>
                    <input type="number" name="estimated_budget_idr" value="{{ old('estimated_budget_idr', $prefill['estimated_budget_idr']) }}" min="0" step="1000000"
                           placeholder="Contoh: 2500000000"
                           class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-amber-500">
                </div>
            </div>
        </div>

        <!-- ==============================================
             BAGIAN 3: UNGGAH DOKUMEN TENDER & CATATAN
        =============================================== -->
        <div class="glass-panel p-6 sm:p-8 rounded-2xl border border-slate-800 shadow-xl">
            <div class="flex items-center gap-3 mb-6 pb-3 border-b border-slate-800">
                <span class="w-7 h-7 rounded-full bg-amber-500 text-slate-950 font-bold text-xs flex items-center justify-center">3</span>
                <h2 class="font-serif text-lg font-bold text-white">Unggah Berkas Tender & Kerangka Acuan (TOR)</h2>
            </div>

            <!-- Drag & Drop File Upload Box -->
            <div class="mb-6" x-data="{ filesCount: 0 }">
                <label class="block font-semibold text-xs text-slate-300 mb-2">
                    Lampiran Dokumen Desain / Gambar Arsitektur / BOQ (Bila Tersedia)
                </label>
                <div class="border-2 border-dashed border-slate-700 hover:border-amber-500/70 rounded-xl p-8 text-center bg-slate-900/40 transition cursor-pointer relative group">
                    <input type="file" name="attachments[]" multiple
                           @change="filesCount = $el.files.length"
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    <div class="w-12 h-12 rounded-full bg-amber-500/10 text-amber-400 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
                        <i data-lucide="upload-cloud" class="w-6 h-6"></i>
                    </div>
                    <div class="text-xs font-semibold text-white mb-1">
                        <span class="text-amber-400 underline">Klik untuk memilih file</span> atau seret & lepas berkas di sini
                    </div>
                    <div class="text-[11px] text-slate-400">
                        Format didukung: PDF, DWG (AutoCAD), ZIP, RAR, JPG, PNG, DOCX (Maksimal 25 MB per berkas)
                    </div>
                    <div x-show="filesCount > 0" class="mt-3 text-xs font-bold text-emerald-400 flex items-center justify-center gap-1.5" x-cloak>
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        <span x-text="filesCount + ' berkas terpilih siap diunggah'"></span>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="text-xs">
                <label class="block font-semibold text-slate-300 mb-2">
                    Catatan Khusus / Lingkup Pekerjaan Tambahan:
                </label>
                <textarea name="project_notes" rows="4"
                          placeholder="Jelaskan kebutuhan spesifik, target serah terima, kondisi tanah, atau preferensi material khusus..."
                          class="w-full bg-slate-900 border border-slate-700 rounded-lg p-3 text-white placeholder-slate-500 focus:outline-none focus:border-amber-500">{{ old('project_notes', $prefill['notes']) }}</textarea>
            </div>

            <!-- Agreement Checkbox -->
            <div class="mt-6 pt-4 border-t border-slate-800 flex items-start gap-3">
                <input type="checkbox" id="consent" required checked
                       class="mt-1 w-4 h-4 rounded bg-slate-900 border-slate-700 text-amber-500 focus:ring-amber-500">
                <label for="consent" class="text-xs text-slate-300 leading-relaxed cursor-pointer">
                    Saya bersedia dihubungi oleh tim rekayasa teknis Enzo Contractor untuk klarifikasi lingkup pekerjaan dan koordinasi jadwal survey lokasi.
                </label>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-center pt-2">
            <button type="submit"
                    class="w-full sm:w-auto px-10 py-4 bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 hover:from-amber-500 hover:to-amber-700 text-slate-950 font-serif font-bold text-sm sm:text-base rounded-xl shadow-2xl shadow-amber-500/25 hover:scale-[1.02] active:scale-[0.98] transition">
                <span class="flex items-center justify-center gap-2">
                    <i data-lucide="send" class="w-5 h-5"></i>
                    <span>SUBMIT PENGAJUAN PENAWARAN (RFP) SEKARANG</span>
                </span>
            </button>
            <p class="text-[11px] text-slate-500 mt-3">
                Data Anda dilindungi kerahasiaan NDA profesional dan hanya digunakan untuk keperluan kalkulasi tender.
            </p>
        </div>

    </form>
</section>

@endsection
