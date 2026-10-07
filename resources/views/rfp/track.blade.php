@extends('layouts.app')

@section('title', 'Pelacakan Status Tiket Tender (RFP) — ENZO Contractor')
@section('meta_description', 'Lacak kemajuan pengajuan proposal tender konstruksi Anda secara real-time dengan memasukkan nomor tiket RFP resmi.')

@section('content')

<!-- Header Section -->
<section class="py-16 bg-[#060A14] border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-semibold uppercase tracking-wider mb-4">
            <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
            <span>Real-time Tender Pipeline Tracking</span>
        </div>
        <h1 class="font-serif text-3xl sm:text-5xl font-bold text-white mb-4">
            Lacak Status <span class="gold-gradient-text">Pengajuan Tender (RFP)</span>
        </h1>
        <p class="text-slate-400 text-xs sm:text-sm leading-relaxed font-light">
            Masukkan Nomor Tiket Pengajuan Anda (misal: <code class="text-amber-400 bg-slate-900 px-1.5 py-0.5 rounded">RFP-2610-001</code>) untuk memantau progres evaluasi tim estimator kami.
        </p>

        <!-- Search Input Form -->
        <form action="{{ route('rfp.track') }}" method="GET" class="mt-8 max-w-md mx-auto flex gap-2">
            <div class="relative flex-1">
                <input type="text" name="rfp_number" value="{{ $rfpNumber }}" required
                       placeholder="Contoh: RFP-2610-001"
                       class="w-full bg-slate-900 border border-slate-700 rounded-lg pl-10 pr-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-500 uppercase font-mono">
                <i data-lucide="ticket" class="w-4 h-4 text-slate-500 absolute left-3.5 top-3.5"></i>
            </div>
            <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-6 py-3 rounded-lg text-xs sm:text-sm transition flex items-center gap-1.5">
                <i data-lucide="search" class="w-4 h-4"></i>
                <span>Lacak</span>
            </button>
        </form>
    </div>
</section>

<!-- Content Section -->
<section class="py-16 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    @if($searched && $rfp)
        <!-- Result Found Card -->
        <div class="space-y-8">
            
            <!-- Top Status Banner -->
            <div class="glass-panel p-6 sm:p-8 rounded-2xl border border-amber-500/30 shadow-2xl">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-800">
                    <div>
                        <div class="text-[11px] font-mono text-amber-400 uppercase tracking-widest">Nomor Tiket Tender</div>
                        <div class="font-mono text-2xl font-bold text-white">{{ $rfp->rfp_number }}</div>
                        <div class="text-xs text-slate-400 mt-1">Diajukan pada: {{ $rfp->created_at->translatedFormat('d F Y, H:i') }} WIB</div>
                    </div>

                    <div>
                        @php
                            $statusBadge = match($rfp->status) {
                                'submitted' => ['label' => 'Menunggu Review', 'color' => 'bg-blue-950 text-blue-400 border-blue-500/40'],
                                'in_review', 'contacted' => ['label' => 'Dalam Evaluasi PIC', 'color' => 'bg-amber-950 text-amber-400 border-amber-500/40'],
                                'survey_scheduled' => ['label' => 'Survey Terjadwal', 'color' => 'bg-purple-950 text-purple-400 border-purple-500/40'],
                                'rab_sent' => ['label' => 'Proposal & RAB Terkirim', 'color' => 'bg-emerald-950 text-emerald-400 border-emerald-500/40'],
                                'deal' => ['label' => 'Deal Kontrak Resmi', 'color' => 'bg-emerald-900 text-white border-emerald-400'],
                                'rejected' => ['label' => 'Tender Belum Sesuai', 'color' => 'bg-rose-950 text-rose-400 border-rose-500/40'],
                                default => ['label' => ucfirst($rfp->status), 'color' => 'bg-slate-900 text-slate-300 border-slate-700']
                            };
                        @endphp
                        <span class="inline-flex px-4 py-2 rounded-xl border {{ $statusBadge['color'] }} text-xs font-bold uppercase tracking-wider">
                            {{ $statusBadge['label'] }}
                        </span>
                    </div>
                </div>

                <!-- 5-Step Pipeline Milestone Progress Bar -->
                <div class="pt-8">
                    <h3 class="font-serif text-sm font-bold text-white uppercase tracking-wider mb-6">Tahapan Evaluasi Tender</h3>
                    
                    @php
                        $stepLevel = match($rfp->status) {
                            'submitted' => 1,
                            'in_review', 'contacted' => 2,
                            'survey_scheduled' => 3,
                            'rab_sent', 'negotiation' => 4,
                            'deal' => 5,
                            default => 1
                        };
                    @endphp

                    <div class="grid grid-cols-1 sm:grid-cols-5 gap-3 text-center">
                        <!-- Step 1 -->
                        <div class="p-3 rounded-xl border {{ $stepLevel >= 1 ? 'border-amber-500/50 bg-amber-500/10' : 'border-slate-800 bg-slate-900/30' }}">
                            <div class="w-8 h-8 rounded-full {{ $stepLevel >= 1 ? 'bg-amber-500 text-slate-950' : 'bg-slate-800 text-slate-500' }} font-bold text-xs flex items-center justify-center mx-auto mb-2">1</div>
                            <div class="font-semibold text-xs text-white">Diajukan</div>
                            <div class="text-[10px] text-slate-400">Berkas Masuk</div>
                        </div>

                        <!-- Step 2 -->
                        <div class="p-3 rounded-xl border {{ $stepLevel >= 2 ? 'border-amber-500/50 bg-amber-500/10' : 'border-slate-800 bg-slate-900/30' }}">
                            <div class="w-8 h-8 rounded-full {{ $stepLevel >= 2 ? 'bg-amber-500 text-slate-950' : 'bg-slate-800 text-slate-500' }} font-bold text-xs flex items-center justify-center mx-auto mb-2">2</div>
                            <div class="font-semibold text-xs text-white">Klarifikasi PIC</div>
                            <div class="text-[10px] text-slate-400">Review Kebutuhan</div>
                        </div>

                        <!-- Step 3 -->
                        <div class="p-3 rounded-xl border {{ $stepLevel >= 3 ? 'border-amber-500/50 bg-amber-500/10' : 'border-slate-800 bg-slate-900/30' }}">
                            <div class="w-8 h-8 rounded-full {{ $stepLevel >= 3 ? 'bg-amber-500 text-slate-950' : 'bg-slate-800 text-slate-500' }} font-bold text-xs flex items-center justify-center mx-auto mb-2">3</div>
                            <div class="font-semibold text-xs text-white">Survey Lapangan</div>
                            <div class="text-[10px] text-slate-400">Pengukuran Tapak</div>
                        </div>

                        <!-- Step 4 -->
                        <div class="p-3 rounded-xl border {{ $stepLevel >= 4 ? 'border-amber-500/50 bg-amber-500/10' : 'border-slate-800 bg-slate-900/30' }}">
                            <div class="w-8 h-8 rounded-full {{ $stepLevel >= 4 ? 'bg-amber-500 text-slate-950' : 'bg-slate-800 text-slate-500' }} font-bold text-xs flex items-center justify-center mx-auto mb-2">4</div>
                            <div class="font-semibold text-xs text-white">RAB & Proposal</div>
                            <div class="text-[10px] text-slate-400">Dokumen Tender</div>
                        </div>

                        <!-- Step 5 -->
                        <div class="p-3 rounded-xl border {{ $stepLevel >= 5 ? 'border-emerald-500/50 bg-emerald-500/10' : 'border-slate-800 bg-slate-900/30' }}">
                            <div class="w-8 h-8 rounded-full {{ $stepLevel >= 5 ? 'bg-emerald-500 text-slate-950' : 'bg-slate-800 text-slate-500' }} font-bold text-xs flex items-center justify-center mx-auto mb-2">5</div>
                            <div class="font-semibold text-xs text-white">Deal Kontrak</div>
                            <div class="text-[10px] text-slate-400">SPK Pelaksanaan</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Data Pengajuan -->
            <div class="bg-[#0B1220] p-6 sm:p-8 rounded-2xl border border-slate-800 shadow-xl">
                <h3 class="font-serif text-base font-bold text-white uppercase tracking-wider mb-6 pb-3 border-b border-slate-800 flex items-center gap-2">
                    <i data-lucide="file-text" class="w-4 h-4 text-amber-500"></i>
                    <span>Rincian Pengajuan Tender</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs">
                    <div>
                        <span class="text-slate-400 block text-[11px]">Penanggung Jawab (PIC)</span>
                        <span class="text-sm font-semibold text-white">{{ $rfp->full_name }}</span>
                        @if($rfp->company_name)
                            <span class="text-slate-400 block text-xs">({{ $rfp->company_name }})</span>
                        @endif
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Kategori Pekerjaan</span>
                        <span class="text-sm font-semibold text-amber-400">{{ $rfp->project_category }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Lokasi Tapak Proyek</span>
                        <span class="text-sm font-semibold text-white">{{ $rfp->site_location }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Perkiraan Luas Bangunan</span>
                        <span class="text-sm font-semibold text-white">{{ $rfp->planned_area_sqm ? number_format($rfp->planned_area_sqm, 0) . ' m²' : '-' }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Alokasi Plafon Anggaran</span>
                        <span class="text-sm font-semibold text-emerald-400">
                            {{ $rfp->estimated_budget_idr ? 'Rp ' . number_format($rfp->estimated_budget_idr, 0, ',', '.') : 'Akan didiskusikan' }}
                        </span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Kontak Terdaftar</span>
                        <span class="text-sm font-semibold text-white">{{ $rfp->phone_number }} • {{ $rfp->email }}</span>
                    </div>
                </div>

                @if($rfp->project_notes)
                    <div class="mt-6 pt-6 border-t border-slate-800 text-xs">
                        <span class="text-slate-400 block text-[11px] mb-1">Catatan Khusus Klien:</span>
                        <div class="p-3 bg-slate-900/60 rounded-lg text-slate-300 font-light leading-relaxed">
                            {{ $rfp->project_notes }}
                        </div>
                    </div>
                @endif

                <!-- Uploaded Attachments -->
                @if($rfp->attachments->isNotEmpty())
                    <div class="mt-6 pt-6 border-t border-slate-800 text-xs">
                        <span class="text-slate-400 block text-[11px] mb-2">Berkas Lampiran Tersimpan ({{ $rfp->attachments->count() }}):</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach($rfp->attachments as $att)
                                <div class="px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-700 flex items-center gap-2 text-slate-300">
                                    <i data-lucide="paperclip" class="w-3.5 h-3.5 text-amber-500"></i>
                                    <span class="font-mono text-[11px]">{{ $att->original_filename }}</span>
                                    <span class="text-[10px] text-slate-500">({{ number_format($att->file_size_bytes / 1024, 0) }} KB)</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Fast WhatsApp Action -->
                <div class="mt-8 pt-6 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <span class="text-xs text-slate-400">Perlu klarifikasi cepat mengenai tiket ini?</span>
                    <a href="https://wa.me/{{ $settings['whatsapp'] ?? '6281348593725' }}?text={{ urlencode('Halo Enzo Contractor, saya ingin konfirmasi status tiket RFP ' . $rfp->rfp_number . ' atas nama ' . $rfp->full_name) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg text-xs font-bold transition">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                        <span>Hubungi Tim Estimator via WA</span>
                    </a>
                </div>
            </div>

        </div>
    @elseif($searched)
        <!-- Search Not Found -->
        <div class="text-center py-16 bg-slate-900/40 rounded-2xl border border-slate-800 p-8">
            <div class="w-16 h-16 rounded-full bg-slate-800 flex items-center justify-center mx-auto text-rose-500 mb-4">
                <i data-lucide="alert-circle" class="w-8 h-8"></i>
            </div>
            <h3 class="font-serif text-xl font-bold text-white mb-2">Tiket RFP Tidak Ditemukan</h3>
            <p class="text-xs text-slate-400 max-w-md mx-auto mb-6">
                Nomor tiket <code class="text-rose-400 bg-slate-900 px-2 py-0.5 rounded">{{ $rfpNumber }}</code> tidak tercatat pada sistem kami. Pastikan format nomor sudah tepat atau ajukan proposal tender baru.
            </p>
            <div class="flex items-center justify-center gap-3">
                <a href="{{ route('rfp.track') }}" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-md text-xs hover:text-white transition">
                    Coba Lagi
                </a>
                <a href="{{ route('rfp.create') }}" class="px-4 py-2 bg-amber-500 text-slate-950 rounded-md text-xs font-bold hover:bg-amber-400 transition">
                    Buat Pengajuan RFP Baru
                </a>
            </div>
        </div>
    @else
        <!-- Initial Guidance State -->
        <div class="glass-panel p-8 rounded-2xl border border-slate-800 text-center max-w-xl mx-auto">
            <div class="w-14 h-14 rounded-full bg-amber-500/10 text-amber-500 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="search" class="w-7 h-7"></i>
            </div>
            <h3 class="font-serif text-lg font-bold text-white mb-2">Pantau Proses Tender Secara Transparan</h3>
            <p class="text-xs text-slate-400 leading-relaxed mb-6 font-light">
                Setelah mengirimkan formulir RFP, Anda akan menerima nomor tiket unik. Masukkan nomor tersebut pada kolom pencarian di atas untuk memantau kemajuan evaluasi dokumen dan jadwal survey lokasi.
            </p>
            <a href="{{ route('rfp.create') }}" class="inline-flex items-center gap-1.5 text-xs text-amber-400 hover:text-amber-300 font-semibold underline">
                <span>Belum memiliki tiket? Ajukan RFP sekarang</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>
    @endif
</section>

@endsection
