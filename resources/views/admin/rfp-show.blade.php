@extends('layouts.app')

@section('title', 'Detail Tiket ' . $rfp->rfp_number . ' — Admin CMS ENZO Contractor')

@section('content')

<!-- Header Section -->
<section class="py-10 bg-[#060A14] border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-xs text-amber-400 hover:underline flex items-center gap-1 mb-2">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Kembali ke Pipeline Tracker</span>
                </a>
                <h1 class="font-serif text-2xl sm:text-3xl font-bold text-white">
                    Detail Tiket Tender: <span class="font-mono text-amber-400">{{ $rfp->rfp_number }}</span>
                </h1>
            </div>
            
            <div class="flex items-center gap-3">
                @php
                    $phoneClean = preg_replace('/[^0-9]/', '', $rfp->phone_number);
                    if(str_starts_with($phoneClean, '0')) {
                        $phoneClean = '62' . substr($phoneClean, 1);
                    }
                    $waText = "Halo Bpk/Ibu {$rfp->full_name}, kami dari Tim Estimator & Rekayasa Enzo Contractor ingin mengonfirmasi pengajuan penawaran tender {$rfp->rfp_number} untuk proyek {$rfp->project_category} di {$rfp->site_location}.";
                    $waLink = "https://wa.me/{$phoneClean}?text=" . urlencode($waText);
                @endphp
                <a href="{{ $waLink }}" target="_blank"
                   class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-lg shadow-emerald-600/20">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    <span>Hubungi Klien via WA</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Details & Attachments -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Lead Profile Card -->
            <div class="glass-panel p-6 sm:p-8 rounded-2xl border border-slate-800">
                <h3 class="font-serif text-base font-bold text-white uppercase tracking-wider mb-6 pb-3 border-b border-slate-800 flex items-center gap-2">
                    <i data-lucide="user" class="w-4 h-4 text-amber-500"></i>
                    <span>Informasi Pemohon & Spesifikasi Proyek</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs">
                    <div>
                        <span class="text-slate-400 block text-[11px]">Nama Lengkap PIC:</span>
                        <span class="text-sm font-semibold text-white">{{ $rfp->full_name }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Perusahaan / Instansi:</span>
                        <span class="text-sm font-semibold text-white">{{ $rfp->company_name ?? '-' }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">WhatsApp / Telp:</span>
                        <span class="text-sm font-semibold text-white">{{ $rfp->phone_number }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Email Resmi:</span>
                        <span class="text-sm font-semibold text-white">{{ $rfp->email }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Kategori Pekerjaan:</span>
                        <span class="text-sm font-semibold text-amber-400">{{ $rfp->project_category }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Lokasi Tapak Proyek:</span>
                        <span class="text-sm font-semibold text-white">{{ $rfp->site_location }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Rencana Luas Bangunan:</span>
                        <span class="text-sm font-semibold text-white">{{ $rfp->planned_area_sqm ? number_format($rfp->planned_area_sqm, 0) . ' m²' : '-' }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Alokasi Plafon Anggaran:</span>
                        <span class="text-sm font-semibold text-emerald-400">
                            {{ $rfp->estimated_budget_idr ? 'Rp ' . number_format($rfp->estimated_budget_idr, 0, ',', '.') : 'Belum ditentukan' }}
                        </span>
                    </div>
                </div>

                @if($rfp->project_notes)
                    <div class="mt-6 pt-6 border-t border-slate-800 text-xs">
                        <span class="text-slate-400 block text-[11px] mb-2 font-semibold">Catatan Klien:</span>
                        <div class="p-4 bg-slate-900/80 rounded-xl text-slate-300 leading-relaxed font-light border border-slate-800">
                            {{ $rfp->project_notes }}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Uploaded Tender Documents Card -->
            <div class="glass-panel p-6 sm:p-8 rounded-2xl border border-slate-800">
                <h3 class="font-serif text-base font-bold text-white uppercase tracking-wider mb-6 pb-3 border-b border-slate-800 flex items-center gap-2">
                    <i data-lucide="paperclip" class="w-4 h-4 text-amber-500"></i>
                    <span>Dokumen & Berkas Tender Terlampir ({{ $rfp->attachments->count() }})</span>
                </h3>

                @if($rfp->attachments->isEmpty())
                    <div class="p-6 text-center text-slate-500 text-xs bg-slate-900/30 rounded-xl">
                        Tidak ada berkas lampiran yang diunggah pada pengajuan ini.
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($rfp->attachments as $att)
                            <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-lg bg-amber-500/10 text-amber-400 flex items-center justify-center shrink-0">
                                        <i data-lucide="file" class="w-5 h-5"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-mono text-xs font-semibold text-white truncate">{{ $att->original_filename }}</div>
                                        <div class="text-[10px] text-slate-400">{{ number_format($att->file_size_bytes / 1024, 0) }} KB • Format: {{ strtoupper($att->file_type) }}</div>
                                    </div>
                                </div>

                                <a href="{{ route('admin.attachment.download', $att->id) }}"
                                   class="px-3.5 py-2 bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-slate-200 text-xs font-semibold rounded-lg transition shrink-0 flex items-center gap-1.5">
                                    <i data-lucide="download" class="w-3.5 h-3.5"></i>
                                    <span>Unduh</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>

        <!-- Right Column: Status Update & Internal Notes -->
        <div class="space-y-8">
            <div class="glass-panel p-6 rounded-2xl border border-slate-800 shadow-xl">
                <h3 class="font-serif text-base font-bold text-white uppercase tracking-wider mb-6 pb-3 border-b border-slate-800 flex items-center gap-2">
                    <i data-lucide="sliders" class="w-4 h-4 text-amber-500"></i>
                    <span>Kelola Status Tiket</span>
                </h3>

                <form action="{{ route('admin.rfp.status', $rfp->id) }}" method="POST" class="space-y-5 text-xs">
                    @csrf
                    
                    <div>
                        <label class="block font-semibold text-slate-300 mb-2">Status Pipeline:</label>
                        <select name="status" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2.5 text-white focus:outline-none focus:border-amber-500">
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
                        <label class="block font-semibold text-slate-300 mb-2">Catatan Internal Estimator (Private):</label>
                        <textarea name="internal_admin_notes" rows="6"
                                  placeholder="Catatan hasil telp, jadwal survey lokasi, negosiasi harga BOQ, PIC lapangan yang ditugaskan..."
                                  class="w-full bg-slate-900 border border-slate-700 rounded-lg p-3 text-white placeholder-slate-500 focus:outline-none focus:border-amber-500">{{ old('internal_admin_notes', $rfp->internal_admin_notes) }}</textarea>
                    </div>

                    <button type="submit"
                            class="w-full py-3 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs rounded-lg transition shadow-lg shadow-amber-500/20">
                        Simpan Pembaruan Status
                    </button>
                </form>
            </div>

            <!-- Public Tracker Quick Link -->
            <div class="p-5 rounded-2xl bg-slate-900/50 border border-slate-800 text-xs">
                <span class="text-slate-400 block text-[11px] mb-1">Tautan Pelacakan Klien Publik:</span>
                <a href="{{ route('rfp.track', ['rfp_number' => $rfp->rfp_number]) }}" target="_blank"
                   class="text-amber-400 hover:underline flex items-center gap-1 font-mono text-[11px] break-all">
                    <span>{{ route('rfp.track', ['rfp_number' => $rfp->rfp_number]) }}</span>
                    <i data-lucide="external-link" class="w-3 h-3 shrink-0"></i>
                </a>
            </div>
        </div>

    </div>
</section>

@endsection
