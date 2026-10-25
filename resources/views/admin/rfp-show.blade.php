@extends('layouts.admin')

@section('title', 'Detail Tiket ' . $rfp->rfp_number . ' — Admin CMS ENZO Contractor')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 space-y-8">

    <!-- ========================================================
         PAGE HEADER & BREADCRUMBS (Matching Home Landing Luxury Theme)
    ========================================================= -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#0d1424] via-[#151f33] to-[#0d1424] border border-slate-800 p-6 sm:p-8 shadow-2xl">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-3">
                    <a href="{{ route('admin.dashboard') }}" class="text-[#c29b53] hover:underline flex items-center gap-1">
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                        <span>Lead Pipeline Tracker</span>
                    </a>
                    <span>/</span>
                    <span class="text-slate-300">Detail Tiket</span>
                </nav>

                <div class="flex items-center gap-2.5">
                    <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-[#1a2332] text-[#c29b53] border border-[#c29b53]/40">
                        Tiket Tender Resmi
                    </span>
                    <span class="text-xs text-slate-300">
                        Dibuat: {{ $rfp->created_at->translatedFormat('d F Y, H:i') }} WIB
                    </span>
                </div>

                <h1 class="font-sans text-2xl sm:text-3xl font-extrabold text-white tracking-wide uppercase mt-2">
                    Tiket: <span class="text-[#c29b53] font-mono">{{ $rfp->rfp_number }}</span>
                </h1>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                @php
                    $phoneClean = preg_replace('/[^0-9]/', '', $rfp->phone_number);
                    if(str_starts_with($phoneClean, '0')) {
                        $phoneClean = '62' . substr($phoneClean, 1);
                    }
                    $waText = "Halo Bpk/Ibu {$rfp->full_name}, kami dari Tim Estimator & Rekayasa Enzo Contractor ingin mengonfirmasi pengajuan penawaran tender {$rfp->rfp_number} untuk proyek {$rfp->project_category} di {$rfp->site_location}.";
                    $waLink = "https://wa.me/{$phoneClean}?text=" . urlencode($waText);
                @endphp

                <a href="{{ $waLink }}" target="_blank"
                   class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-2 shadow-lg shadow-emerald-950/40">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    <span>Hubungi Klien via WA</span>
                </a>

                <a href="{{ route('rfp.track', ['rfp_number' => $rfp->rfp_number]) }}" target="_blank"
                   class="px-4 py-2.5 bg-[#1a2332] hover:bg-[#233044] text-slate-200 hover:text-white rounded-xl text-xs font-bold transition flex items-center gap-2 border border-slate-700 shadow-sm">
                    <i data-lucide="external-link" class="w-4 h-4 text-[#c29b53]"></i>
                    <span>Portal Klien</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ========================================================
         MAIN CONTENT GRID (2 COLUMNS: LEFT 2/3, RIGHT 1/3)
    ========================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- ====================================================
             LEFT COLUMN (Details, Negotiation, Logs, Complaints)
        ==================================================== -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Poin 4 Evaluasi Dosen: Status Pengingat & Log Dilihat Admin -->
            <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200 shadow-md flex items-center justify-between text-xs text-slate-800">
                <div class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-[#c29b53] border border-amber-200 flex items-center justify-center font-bold shrink-0">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="font-bold text-slate-900 block text-xs">Status Pengingat Otomatis (Admin Reminder): NONAKTIF</span>
                        <span class="text-slate-500 text-[11px]">Tiket telah dibuka pada: {{ $rfp->admin_last_viewed_at ? $rfp->admin_last_viewed_at->translatedFormat('d F Y, H:i') . ' WIB' : 'Baru saja' }}</span>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-200 uppercase tracking-wider">
                    TERPANTAU ADMIN
                </span>
            </div>

            <!-- Lead Profile Card -->
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xl text-slate-800">
                <h3 class="font-sans text-base font-extrabold text-[#1a2332] uppercase tracking-wider mb-6 pb-3 border-b border-slate-100 flex items-center gap-2.5">
                    <i data-lucide="user" class="w-5 h-5 text-[#c29b53]"></i>
                    <span>Informasi Pemohon & Spesifikasi Proyek</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs">
                    <div>
                        <span class="text-slate-500 block text-[11px] font-bold uppercase tracking-wider">Nama Lengkap PIC:</span>
                        <span class="text-sm font-bold text-slate-900 mt-0.5 block">{{ $rfp->full_name }}</span>
                    </div>

                    <div>
                        <span class="text-slate-500 block text-[11px] font-bold uppercase tracking-wider">Perusahaan / Instansi:</span>
                        <span class="text-sm font-semibold text-slate-900 mt-0.5 block">{{ $rfp->company_name ?? '-' }}</span>
                    </div>

                    <div>
                        <span class="text-slate-500 block text-[11px] font-bold uppercase tracking-wider">WhatsApp / Telp:</span>
                        <span class="text-sm font-semibold text-slate-900 font-mono mt-0.5 block">{{ $rfp->phone_number }}</span>
                    </div>

                    <div>
                        <span class="text-slate-500 block text-[11px] font-bold uppercase tracking-wider">Email Resmi:</span>
                        <span class="text-sm font-semibold text-slate-900 mt-0.5 block">{{ $rfp->email }}</span>
                    </div>

                    <div>
                        <span class="text-slate-500 block text-[11px] font-bold uppercase tracking-wider">Kategori Pekerjaan:</span>
                        <span class="text-sm font-bold text-[#c29b53] mt-0.5 block">{{ $rfp->project_category }}</span>
                    </div>

                    <div>
                        <span class="text-slate-500 block text-[11px] font-bold uppercase tracking-wider">Lokasi Tapak Proyek:</span>
                        <span class="text-sm font-semibold text-slate-900 mt-0.5 block">{{ $rfp->site_location }}</span>
                    </div>

                    <div>
                        <span class="text-slate-500 block text-[11px] font-bold uppercase tracking-wider">Katalog Denah Acuan (Poin 2):</span>
                        <span class="text-sm font-semibold text-slate-900 mt-0.5 block">
                            @if($rfp->designLayout)
                                <a href="{{ route('layouts.show', $rfp->designLayout->slug) }}" target="_blank" class="text-[#c29b53] hover:underline font-bold">
                                    {{ $rfp->designLayout->title }} ({{ $rfp->designLayout->code }})
                                </a>
                            @else
                                <span class="text-slate-600 font-normal">Kustom (Rancangan Sendiri)</span>
                            @endif
                        </span>
                    </div>

                    <div>
                        <span class="text-slate-500 block text-[11px] font-bold uppercase tracking-wider">Skema Pembayaran (Poin 6):</span>
                        <span class="text-sm font-bold text-emerald-600 mt-0.5 block">{{ $rfp->payment_scheme_label }}</span>
                    </div>

                    <div>
                        <span class="text-slate-500 block text-[11px] font-bold uppercase tracking-wider">Rencana Luas Bangunan:</span>
                        <span class="text-sm font-semibold text-slate-900 mt-0.5 block">{{ $rfp->planned_area_sqm ? number_format($rfp->planned_area_sqm, 0) . ' m²' : '-' }}</span>
                    </div>

                    <div>
                        <span class="text-slate-500 block text-[11px] font-bold uppercase tracking-wider">Alokasi Plafon Anggaran:</span>
                        <span class="text-sm font-bold text-emerald-600 mt-0.5 block">
                            {{ $rfp->estimated_budget_idr ? 'Rp ' . number_format($rfp->estimated_budget_idr, 0, ',', '.') : 'Belum ditentukan' }}
                        </span>
                    </div>
                </div>

                @if($rfp->project_notes)
                    <div class="mt-6 pt-6 border-t border-slate-100 text-xs">
                        <span class="text-slate-500 block text-[11px] mb-2 font-bold uppercase tracking-wider">Catatan Tambahan Klien:</span>
                        <div class="p-4 bg-slate-50 rounded-2xl text-slate-700 leading-relaxed font-normal border border-slate-200">
                            {{ $rfp->project_notes }}
                        </div>
                    </div>
                @endif
            </div>

            <!-- POIN 5: Rekam Jejak Negosiasi Harga & Spesifikasi (Negotiation Log) -->
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xl text-slate-800">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
                    <div>
                        <span class="text-[10px] font-bold text-[#c29b53] uppercase tracking-widest block">Evaluasi Poin 5</span>
                        <h3 class="font-sans text-base font-extrabold text-[#1a2332] uppercase tracking-wider flex items-center gap-2">
                            <i data-lucide="handshake" class="w-5 h-5 text-[#c29b53]"></i>
                            <span>Rekam Jejak Negosiasi Harga & Spesifikasi Material</span>
                        </h3>
                    </div>
                    <span class="text-xs text-slate-500 font-semibold">{{ $rfp->negotiationLogs->count() }} Tahap Tercatat</span>
                </div>

                <!-- Negotiation History Timeline -->
                @if($rfp->negotiationLogs->isNotEmpty())
                    <div class="space-y-4 mb-8">
                        @foreach($rfp->negotiationLogs->sortBy('created_at') as $neg)
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs">
                                <div class="flex items-center justify-between pb-2 border-b border-slate-200">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-[#c29b53] uppercase">{{ $neg->stage_label }}</span>
                                        <span class="text-slate-400">•</span>
                                        <span class="text-slate-500 text-[11px]">{{ $neg->created_at->translatedFormat('d M Y, H:i') }}</span>
                                    </div>
                                    @if($neg->proposed_amount_idr)
                                        <span class="font-mono font-bold text-emerald-600">Rp {{ number_format($neg->proposed_amount_idr, 0, ',', '.') }}</span>
                                    @endif
                                </div>

                                @if($neg->client_notes)
                                    <div class="mt-2 text-slate-700">
                                        <strong class="text-slate-500 text-[11px]">Permintaan Klien:</strong> {{ $neg->client_notes }}
                                    </div>
                                @endif

                                <div class="mt-2 text-slate-800 bg-white p-3 rounded-xl border border-slate-200">
                                    <strong class="text-[#c29b53] text-[11px] block mb-0.5">Tanggapan Tim / Kesepakatan:</strong>
                                    {{ $neg->admin_response }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-5 text-center text-slate-500 text-xs bg-slate-50 rounded-2xl border border-slate-200 mb-6">
                        Belum ada catatan negosiasi harga atau penyesuaian BOQ untuk tiket ini.
                    </div>
                @endif

                <!-- Form Tambah Catatan Negosiasi -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-[#1a2332] mb-3">Catat Perkembangan Negosiasi Baru</h4>
                    <form action="{{ route('admin.rfp.negotiate', $rfp->id) }}" method="POST" class="space-y-3.5 text-xs">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div>
                                <label class="block text-slate-600 font-semibold mb-1">Tahap Negosiasi *</label>
                                <select name="stage" required class="w-full bg-white border border-slate-300 rounded-xl p-2.5 text-slate-800 font-medium focus:outline-none focus:border-[#c29b53]">
                                    <option value="initial_proposal">1. Proposal Teknis Awal</option>
                                    <option value="spec_clarification">2. Klarifikasi Spek Material (Pondasi/Genteng/Lantai)</option>
                                    <option value="price_negotiation">3. Negosiasi Harga & Plafon Anggaran</option>
                                    <option value="revised_boq">4. Revisi BOQ / Addendum</option>
                                    <option value="final_deal">5. Kesepakatan Final (Deal Kontrak)</option>
                                    <option value="rejected">Batal / Tender Gugur</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-slate-600 font-semibold mb-1">Nilai Anggaran Kesepakatan (Rp)</label>
                                <input type="number" name="proposed_amount_idr" placeholder="Contoh: 450000000"
                                       class="w-full bg-white border border-slate-300 rounded-xl p-2.5 text-slate-800 font-medium focus:outline-none focus:border-[#c29b53]">
                            </div>
                        </div>

                        <div>
                            <label class="block text-slate-600 font-semibold mb-1">Catatan Keinginan Klien</label>
                            <input type="text" name="client_notes" placeholder="Misal: Klien minta upgrade genteng beton ke genteng keramik glazuur..."
                                   class="w-full bg-white border border-slate-300 rounded-xl p-2.5 text-slate-800 font-medium focus:outline-none focus:border-[#c29b53]">
                        </div>

                        <div>
                            <label class="block text-slate-600 font-semibold mb-1">Tanggapan Estimator & Solusi Teknis *</label>
                            <textarea name="admin_response" rows="2" required placeholder="Hasil keputusan penyesuaian biaya dan spesifikasi teknis..."
                                      class="w-full bg-white border border-slate-300 rounded-xl p-2.5 text-slate-800 font-medium focus:outline-none focus:border-[#c29b53]"></textarea>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="px-5 py-2.5 bg-[#c29b53] hover:bg-[#ad8741] text-white font-bold rounded-xl transition shadow-md">
                                Simpan Rekam Negosiasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- POIN 7: Input Laporan Progres Harian Mandor (Progress Tracking) -->
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xl text-slate-800">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
                    <div>
                        <span class="text-[10px] font-bold text-sky-600 uppercase tracking-widest block">Evaluasi Poin 7</span>
                        <h3 class="font-sans text-base font-extrabold text-[#1a2332] uppercase tracking-wider flex items-center gap-2">
                            <i data-lucide="camera" class="w-5 h-5 text-sky-600"></i>
                            <span>Jurnal Harian Mandor & Opname Fisik Lapangan</span>
                        </h3>
                    </div>
                    <span class="text-xs text-slate-500 font-semibold">{{ $rfp->progressLogs->count() }} Laporan Fisik</span>
                </div>

                <!-- Progress Logs List -->
                @if($rfp->progressLogs->isNotEmpty())
                    <div class="space-y-4 mb-8">
                        @foreach($rfp->progressLogs->sortByDesc('day_number') as $pl)
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs">
                                <div class="flex items-center justify-between pb-2 border-b border-slate-200">
                                    <span class="font-bold text-[#1a2332]">Hari Ke-{{ $pl->day_number }}: {{ $pl->stage_name }}</span>
                                    <span class="font-mono font-bold text-emerald-600">{{ $pl->progress_percentage }}% Selesai</span>
                                </div>
                                <p class="text-slate-700 mt-2 font-normal">{{ $pl->description }}</p>
                                <div class="mt-2 text-[11px] text-slate-500 flex items-center justify-between">
                                    <span>Mandor: <strong class="text-slate-900">{{ $pl->logged_by_name }}</strong></span>
                                    <span>{{ $pl->log_date ? $pl->log_date->translatedFormat('d M Y') : '-' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Form Tambah Jurnal Mandor -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-[#1a2332] mb-3">Input Jurnal Lapangan Mandor Baru</h4>
                    <form action="{{ route('admin.rfp.progressLog', $rfp->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3.5 text-xs">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-slate-600 font-semibold mb-1">Hari Ke- *</label>
                                <input type="number" name="day_number" required placeholder="Misal: 15"
                                       class="w-full bg-white border border-slate-300 rounded-xl p-2.5 text-slate-800 font-medium focus:outline-none focus:border-[#c29b53]">
                            </div>
                            <div>
                                <label class="block text-slate-600 font-semibold mb-1">Tahap Pekerjaan *</label>
                                <input type="text" name="stage_name" required placeholder="Misal: Pengecoran Sloof Kolom"
                                       class="w-full bg-white border border-slate-300 rounded-xl p-2.5 text-slate-800 font-medium focus:outline-none focus:border-[#c29b53]">
                            </div>
                            <div>
                                <label class="block text-slate-600 font-semibold mb-1">Persentase Fisik (%) *</label>
                                <input type="number" step="0.1" name="progress_percentage" required placeholder="Misal: 35.5"
                                       class="w-full bg-white border border-slate-300 rounded-xl p-2.5 text-slate-800 font-medium focus:outline-none focus:border-[#c29b53]">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-slate-600 font-semibold mb-1">Nama Mandor / Pengawas *</label>
                                <input type="text" name="logged_by_name" required placeholder="Misal: Mandor Rusli"
                                       class="w-full bg-white border border-slate-300 rounded-xl p-2.5 text-slate-800 font-medium focus:outline-none focus:border-[#c29b53]">
                            </div>
                            <div>
                                <label class="block text-slate-600 font-semibold mb-1">Foto Opname Lapangan</label>
                                <input type="file" name="actual_field_photo" accept="image/*"
                                       class="w-full text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:bg-slate-200 file:text-slate-800 text-xs">
                            </div>
                        </div>

                        <div>
                            <label class="block text-slate-600 font-semibold mb-1">Catatan Kondisi Lapangan & Cuaca *</label>
                            <textarea name="description" rows="2" required placeholder="Catatan cuaca cerah/hujan, jumlah tukang, kendala material..."
                                      class="w-full bg-white border border-slate-300 rounded-xl p-2.5 text-slate-800 font-medium focus:outline-none focus:border-[#c29b53]"></textarea>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="px-5 py-2.5 bg-[#1a2332] hover:bg-[#233044] text-white font-bold rounded-xl transition shadow-md">
                                Simpan Jurnal Progres
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- POIN 8: Daftar Komplain & Tindak Lanjut Perbaikan -->
            @if($rfp->complaints->isNotEmpty())
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-rose-300 shadow-xl text-slate-800">
                    <div class="flex items-center justify-between pb-4 border-b border-rose-100 mb-6">
                        <div>
                            <span class="text-[10px] font-bold text-rose-600 uppercase tracking-widest block">Evaluasi Poin 8</span>
                            <h3 class="font-sans text-base font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                <i data-lucide="shield-alert" class="w-5 h-5 text-rose-600"></i>
                                <span>Keluhan & Komplain Pelanggan Terdaftar</span>
                            </h3>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-700 text-xs font-bold border border-rose-200">
                            {{ $rfp->complaints->count() }} Pengaduan
                        </span>
                    </div>

                    <div class="space-y-4">
                        @foreach($rfp->complaints as $c)
                            <div class="p-4 rounded-2xl bg-rose-50/50 border border-rose-200 text-xs">
                                <div class="flex items-center justify-between pb-2 border-b border-rose-200">
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono font-bold text-rose-700">{{ $c->complaint_number }}</span>
                                        <span class="font-bold text-slate-900">{{ $c->title }}</span>
                                    </div>
                                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase
                                        @if($c->status === 'resolved') bg-emerald-100 text-emerald-800 border border-emerald-300 @else bg-amber-100 text-amber-800 border border-amber-300 @endif">
                                        Status: {{ $c->status_label }}
                                    </span>
                                </div>
                                <p class="text-slate-700 mt-2 font-normal">{{ $c->description }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Uploaded Tender Documents Card -->
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xl text-slate-800">
                <h3 class="font-sans text-base font-extrabold text-[#1a2332] uppercase tracking-wider mb-6 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <i data-lucide="paperclip" class="w-5 h-5 text-[#c29b53]"></i>
                    <span>Dokumen & Berkas Tender Terlampir ({{ $rfp->attachments->count() }})</span>
                </h3>

                @if($rfp->attachments->isEmpty())
                    <div class="p-6 text-center text-slate-500 text-xs bg-slate-50 rounded-2xl border border-slate-200 font-medium">
                        Tidak ada berkas lampiran yang diunggah pada pengajuan ini.
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($rfp->attachments as $att)
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between gap-4 hover:border-[#c29b53] transition">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-[#c29b53] flex items-center justify-center shrink-0 border border-amber-200">
                                        <i data-lucide="file" class="w-5 h-5"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-mono text-xs font-bold text-slate-900 truncate">{{ $att->original_filename }}</div>
                                        <div class="text-[11px] text-slate-500 font-medium">{{ number_format($att->file_size_bytes / 1024, 0) }} KB • Format: {{ strtoupper($att->file_type) }}</div>
                                    </div>
                                </div>

                                <a href="{{ route('admin.attachment.download', $att->id) }}"
                                   class="px-4 py-2 bg-slate-100 hover:bg-[#c29b53] hover:text-white text-slate-800 text-xs font-bold rounded-xl transition shrink-0 flex items-center gap-1.5 border border-slate-300">
                                    <i data-lucide="download" class="w-3.5 h-3.5"></i>
                                    <span>Unduh</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>

        <!-- ====================================================
             RIGHT COLUMN (Assignment, Status Update, Publishing)
        ==================================================== -->
        <div class="space-y-8">

            <!-- POIN 5: Penugasan Staf / Penanggung Jawab Proyek -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xl text-slate-800">
                <h3 class="font-sans text-base font-extrabold text-[#1a2332] uppercase tracking-wider mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <i data-lucide="user-check" class="w-5 h-5 text-[#c29b53]"></i>
                    <span>Penugasan PIC Proyek (Poin 5)</span>
                </h3>

                <form action="{{ route('admin.rfp.assign', $rfp->id) }}" method="POST" class="space-y-3.5 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1.5">Staf Penanggung Jawab (PIC):</label>
                        <select name="assigned_to_user_id" class="w-full bg-white border border-slate-300 rounded-xl p-2.5 text-slate-800 font-semibold focus:outline-none focus:border-[#c29b53]">
                            <option value="" disabled {{ !$rfp->assigned_to_user_id ? 'selected' : '' }}>-- Pilih Staf Penanggung Jawab --</option>
                            @foreach($staffUsers as $staff)
                                <option value="{{ $staff->id }}" {{ $rfp->assigned_to_user_id == $staff->id ? 'selected' : '' }}>
                                    {{ $staff->name }} ({{ $staff->role ?? 'Staff' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="w-full py-3 bg-[#1a2332] hover:bg-[#233044] text-[#c29b53] hover:text-white font-bold rounded-xl transition shadow-md border border-[#c29b53]/40">
                        Simpan Penugasan PIC
                    </button>
                </form>
            </div>

            <!-- Kelola Status Tiket -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xl text-slate-800">
                <h3 class="font-sans text-base font-extrabold text-[#1a2332] uppercase tracking-wider mb-6 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <i data-lucide="sliders" class="w-5 h-5 text-[#c29b53]"></i>
                    <span>Kelola Status Tiket</span>
                </h3>

                <form action="{{ route('admin.rfp.status', $rfp->id) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    
                    <div>
                        <label class="block font-bold text-slate-700 mb-1.5">Status Pipeline:</label>
                        <select name="status" class="w-full bg-white border border-slate-300 rounded-xl p-2.5 text-slate-800 font-semibold focus:outline-none focus:border-[#c29b53]">
                            <option value="submitted" {{ $rfp->status === 'submitted' ? 'selected' : '' }}>1. Baru Masuk (Submitted)</option>
                            <option value="in_review" {{ $rfp->status === 'in_review' ? 'selected' : '' }}>2. Dalam Evaluasi PIC</option>
                            <option value="contacted" {{ $rfp->status === 'contacted' ? 'selected' : '' }}>3. Sudah Dihubungi PIC</option>
                            <option value="survey_scheduled" {{ $rfp->status === 'survey_scheduled' ? 'selected' : '' }}>4. Survey Lokasi Dijadwalkan</option>
                            <option value="rab_sent" {{ $rfp->status === 'rab_sent' ? 'selected' : '' }}>5. Proposal Teknis & RAB Terkirim</option>
                            <option value="negotiation" {{ $rfp->status === 'negotiation' ? 'selected' : '' }}>6. Negosiasi Kontrak</option>
                            <option value="deal" {{ $rfp->status === 'deal' ? 'selected' : '' }}>7. Deal Kontrak (SPK Resmi)</option>
                            <option value="rejected" {{ $rfp->status === 'rejected' ? 'selected' : '' }}>8. Ditolak / Dibatalkan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1.5">Catatan Internal Estimator (Private):</label>
                        <textarea name="internal_admin_notes" rows="4"
                                  placeholder="Catatan hasil telp, jadwal survey lokasi, negosiasi harga BOQ, PIC lapangan yang ditugaskan..."
                                  class="w-full bg-white border border-slate-300 rounded-xl p-3 text-slate-800 placeholder-slate-400 focus:outline-none focus:border-[#c29b53]">{{ old('internal_admin_notes', $rfp->internal_admin_notes) }}</textarea>
                    </div>

                    <button type="submit"
                            class="w-full py-3 bg-[#c29b53] hover:bg-[#ad8741] text-white font-bold text-xs rounded-xl transition shadow-md">
                        Simpan Pembaruan Status
                    </button>
                </form>
            </div>

            <!-- POIN 9 & 10: Publikasikan ke Portofolio Publik & Proteksi Privasi -->
            <div class="bg-white p-6 rounded-3xl border border-emerald-300 shadow-xl text-xs text-slate-800">
                <h3 class="font-sans text-base font-extrabold text-[#1a2332] uppercase tracking-wider mb-3 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <i data-lucide="globe" class="w-5 h-5 text-emerald-600"></i>
                    <span>Portofolio & Privasi (Poin 9 & 10)</span>
                </h3>

                <p class="text-slate-600 text-[11px] leading-relaxed mb-4">
                    Proyek yang sudah deal atau rampung dapat otomatis dimasukkan ke etalase portofolio publik.
                </p>

                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-[11px] text-slate-700 mb-4">
                    <strong class="text-[#c29b53] block mb-1">Proteksi Kebijakan Privasi Hunian:</strong>
                    Alamat nomor jalan dan nama pemilik residensial otomatis dimask (hanya menampilkan wilayah kota/kabupaten) demi privasi keamanan pemilik hunian.
                </div>

                <form action="{{ route('admin.rfp.publishPortfolio', $rfp->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition shadow-md flex items-center justify-center gap-2">
                        <i data-lucide="share-2" class="w-4 h-4"></i>
                        <span>Publikasikan ke Portofolio Publik</span>
                    </button>
                </form>
            </div>

            <!-- Public Tracker Quick Link -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200 text-xs shadow-md text-slate-800">
                <span class="text-slate-500 block text-[11px] font-bold uppercase tracking-wider mb-1.5">Tautan Pelacakan Klien Publik:</span>
                <a href="{{ route('rfp.track', ['rfp_number' => $rfp->rfp_number]) }}" target="_blank"
                   class="text-[#c29b53] hover:underline flex items-center gap-1 font-mono text-[11px] break-all font-bold">
                    <span>{{ route('rfp.track', ['rfp_number' => $rfp->rfp_number]) }}</span>
                    <i data-lucide="external-link" class="w-3.5 h-3.5 shrink-0"></i>
                </a>
            </div>

        </div>

    </div>

</div>

@endsection
