@extends('layouts.app')

@section('title', 'Pelacakan Status Tiket Tender (RFP) — ENZO Contractor')
@section('meta_description', 'Lacak kemajuan pengajuan proposal tender konstruksi Anda secara real-time dengan memasukkan nomor tiket RFP resmi.')

@section('content')

<!-- ========================================================
     HERO SECTION (Strictly Matching PT MKP Mockup Style)
========================================================= -->
<section class="relative min-h-[380px] sm:min-h-[420px] flex items-center justify-center overflow-hidden">
    <!-- Clean Architectural Twilight Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/ptmkp_hero_clean.jpg') }}"
             alt="Enzo RFP Tracking Hero"
             class="w-full h-full object-cover object-center">
        <!-- Subtle dark overlay -->
        <div class="absolute inset-0 bg-slate-950/50"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-slate-950/40"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center pt-20 pb-28">
        <span class="inline-block text-xs font-bold text-[#c29b53] uppercase tracking-widest mb-3 font-sans">
            Real-time Tender Pipeline Tracking
        </span>
        <h1 class="font-sans text-3xl sm:text-5xl font-extrabold tracking-wide text-white uppercase leading-tight">
            LACAK STATUS PENGAJUAN TENDER (RFP)
        </h1>
        <p class="text-xs sm:text-sm text-slate-100 font-light max-w-xl mx-auto mt-3 leading-relaxed tracking-normal">
            Masukkan Nomor Tiket Pengajuan Anda (misal: <code class="text-[#c29b53] bg-black/50 px-2 py-0.5 rounded font-mono font-bold">RFP-2610-001</code>) untuk memantau progres evaluasi tim estimator kami.
        </p>

        <!-- Search Input Form -->
        <form action="{{ route('rfp.track') }}" method="GET" class="mt-6 max-w-md mx-auto flex gap-2">
            <div class="relative flex-1">
                <input type="text" name="rfp_number" value="{{ $rfpNumber }}" required
                       placeholder="Contoh: RFP-2610-001"
                       class="w-full bg-white border border-slate-200 rounded-lg pl-10 pr-4 py-3 text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-[#c29b53] uppercase font-mono shadow-md">
                <i data-lucide="ticket" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
            </div>
            <button type="submit" class="bg-[#c29b53] hover:bg-[#ad8741] text-white font-bold px-6 py-3 rounded-lg text-xs sm:text-sm transition flex items-center gap-1.5 shadow-md uppercase tracking-wider">
                <i data-lucide="search" class="w-4 h-4"></i>
                <span>Lacak</span>
            </button>
        </form>
    </div>
</section>

<!-- ========================================================
     WHITE FLOATING CONTAINER (Matching PT MKP Layout)
========================================================= -->
<section class="relative z-20 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 sm:-mt-24 mb-20">
    <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl p-6 sm:p-10 border border-slate-100">

        @if($searched && $rfp)
            <!-- Result Found Card -->
            <div class="space-y-8">
                
                <!-- Top Status Banner -->
                <div class="bg-slate-50 p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-200">
                        <div>
                            <div class="text-[11px] font-mono text-[#c29b53] uppercase tracking-widest font-bold">Nomor Tiket Tender</div>
                            <div class="font-mono text-2xl font-bold text-slate-900">{{ $rfp->rfp_number }}</div>
                            <div class="text-xs text-slate-500 mt-1">Diajukan pada: {{ $rfp->created_at->translatedFormat('d F Y, H:i') }} WIB</div>
                        </div>

                        <div>
                            @php
                                $statusBadge = match($rfp->status) {
                                    'submitted' => ['label' => 'Menunggu Review', 'color' => 'bg-blue-100 text-blue-800 border-blue-200'],
                                    'in_review', 'contacted' => ['label' => 'Dalam Evaluasi PIC', 'color' => 'bg-amber-100 text-amber-800 border-amber-200'],
                                    'survey_scheduled' => ['label' => 'Survey Terjadwal', 'color' => 'bg-purple-100 text-purple-800 border-purple-200'],
                                    'rab_sent' => ['label' => 'Proposal & RAB Terkirim', 'color' => 'bg-emerald-100 text-emerald-800 border-emerald-200'],
                                    'deal' => ['label' => 'Deal Kontrak Resmi', 'color' => 'bg-emerald-600 text-white border-emerald-700 shadow'],
                                    'rejected' => ['label' => 'Tender Belum Sesuai', 'color' => 'bg-rose-100 text-rose-800 border-rose-200'],
                                    default => ['label' => ucfirst($rfp->status), 'color' => 'bg-slate-100 text-slate-700 border-slate-200']
                                };
                            @endphp
                            <span class="inline-flex px-4 py-2 rounded-xl border {{ $statusBadge['color'] }} text-xs font-bold uppercase tracking-wider">
                                {{ $statusBadge['label'] }}
                            </span>
                        </div>
                    </div>

                    <!-- 5-Step Pipeline Milestone Progress Bar -->
                    <div class="pt-8">
                        <h3 class="font-sans text-xs font-bold text-slate-700 uppercase tracking-wider mb-6">Tahapan Evaluasi Tender</h3>
                        
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
                            <div class="p-3 rounded-xl border {{ $stepLevel >= 1 ? 'border-[#c29b53] bg-white ring-1 ring-[#c29b53]' : 'border-slate-200 bg-white/60' }} transition shadow-sm">
                                <div class="w-8 h-8 rounded-full {{ $stepLevel >= 1 ? 'bg-[#c29b53] text-white' : 'bg-slate-200 text-slate-500' }} font-bold text-xs flex items-center justify-center mx-auto mb-2 shadow">1</div>
                                <div class="font-bold text-xs text-slate-900 uppercase">Diajukan</div>
                                <div class="text-[10px] text-slate-500">Berkas Masuk</div>
                            </div>

                            <!-- Step 2 -->
                            <div class="p-3 rounded-xl border {{ $stepLevel >= 2 ? 'border-[#c29b53] bg-white ring-1 ring-[#c29b53]' : 'border-slate-200 bg-white/60' }} transition shadow-sm">
                                <div class="w-8 h-8 rounded-full {{ $stepLevel >= 2 ? 'bg-[#c29b53] text-white' : 'bg-slate-200 text-slate-500' }} font-bold text-xs flex items-center justify-center mx-auto mb-2 shadow">2</div>
                                <div class="font-bold text-xs text-slate-900 uppercase">Klarifikasi PIC</div>
                                <div class="text-[10px] text-slate-500">Review Kebutuhan</div>
                            </div>

                            <!-- Step 3 -->
                            <div class="p-3 rounded-xl border {{ $stepLevel >= 3 ? 'border-[#c29b53] bg-white ring-1 ring-[#c29b53]' : 'border-slate-200 bg-white/60' }} transition shadow-sm">
                                <div class="w-8 h-8 rounded-full {{ $stepLevel >= 3 ? 'bg-[#c29b53] text-white' : 'bg-slate-200 text-slate-500' }} font-bold text-xs flex items-center justify-center mx-auto mb-2 shadow">3</div>
                                <div class="font-bold text-xs text-slate-900 uppercase">Survey Lapangan</div>
                                <div class="text-[10px] text-slate-500">Pengukuran Tapak</div>
                            </div>

                            <!-- Step 4 -->
                            <div class="p-3 rounded-xl border {{ $stepLevel >= 4 ? 'border-[#c29b53] bg-white ring-1 ring-[#c29b53]' : 'border-slate-200 bg-white/60' }} transition shadow-sm">
                                <div class="w-8 h-8 rounded-full {{ $stepLevel >= 4 ? 'bg-[#c29b53] text-white' : 'bg-slate-200 text-slate-500' }} font-bold text-xs flex items-center justify-center mx-auto mb-2 shadow">4</div>
                                <div class="font-bold text-xs text-slate-900 uppercase">RAB & Proposal</div>
                                <div class="text-[10px] text-slate-500">Dokumen Tender</div>
                            </div>

                            <!-- Step 5 -->
                            <div class="p-3 rounded-xl border {{ $stepLevel >= 5 ? 'border-emerald-600 bg-white ring-1 ring-emerald-600' : 'border-slate-200 bg-white/60' }} transition shadow-sm">
                                <div class="w-8 h-8 rounded-full {{ $stepLevel >= 5 ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500' }} font-bold text-xs flex items-center justify-center mx-auto mb-2 shadow">5</div>
                                <div class="font-bold text-xs text-slate-900 uppercase">Deal Kontrak</div>
                                <div class="text-[10px] text-slate-500">SPK Pelaksanaan</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Data Pengajuan -->
                <div class="bg-slate-50 p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
                    <h3 class="font-sans text-sm font-bold text-slate-900 uppercase tracking-wider mb-6 pb-3 border-b border-slate-200 flex items-center gap-2">
                        <i data-lucide="file-text" class="w-4 h-4 text-[#c29b53]"></i>
                        <span>Rincian Pengajuan Tender</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs">
                        <div>
                            <span class="text-slate-500 block text-[11px] uppercase font-semibold">Penanggung Jawab (PIC)</span>
                            <span class="text-sm font-bold text-slate-900">{{ $rfp->full_name }}</span>
                            @if($rfp->company_name)
                                <span class="text-slate-500 block text-xs">({{ $rfp->company_name }})</span>
                            @endif
                        </div>

                        <div>
                            <span class="text-slate-500 block text-[11px] uppercase font-semibold">Kategori Pekerjaan</span>
                            <span class="text-sm font-bold text-[#c29b53]">{{ $rfp->project_category }}</span>
                        </div>

                        <div>
                            <span class="text-slate-500 block text-[11px] uppercase font-semibold">Lokasi Tapak Proyek</span>
                            <span class="text-sm font-bold text-slate-900">{{ $rfp->site_location }}</span>
                        </div>

                        <div>
                            <span class="text-slate-500 block text-[11px] uppercase font-semibold">Perkiraan Luas Bangunan</span>
                            <span class="text-sm font-bold text-slate-900">{{ $rfp->planned_area_sqm ? number_format($rfp->planned_area_sqm, 0) . ' m²' : '-' }}</span>
                        </div>

                        <div>
                            <span class="text-slate-500 block text-[11px] uppercase font-semibold">Alokasi Plafon Anggaran</span>
                            <span class="text-sm font-bold text-emerald-700">
                                {{ $rfp->estimated_budget_idr ? 'Rp ' . number_format($rfp->estimated_budget_idr, 0, ',', '.') : 'Akan didiskusikan' }}
                            </span>
                        </div>

                        <div>
                            <span class="text-slate-500 block text-[11px] uppercase font-semibold">Kontak Terdaftar</span>
                            <span class="text-sm font-bold text-slate-900">{{ $rfp->phone_number }} • {{ $rfp->email }}</span>
                        </div>
                    </div>

                    @if($rfp->project_notes)
                        <div class="mt-6 pt-6 border-t border-slate-200 text-xs">
                            <span class="text-slate-500 block text-[11px] font-bold uppercase mb-1">Catatan Khusus Klien:</span>
                            <div class="p-3 bg-white rounded-lg text-slate-700 font-light leading-relaxed border border-slate-200">
                                {{ $rfp->project_notes }}
                            </div>
                        </div>
                    @endif

                    <!-- Uploaded Attachments -->
                    @if($rfp->attachments->isNotEmpty())
                        <div class="mt-6 pt-6 border-t border-slate-200 text-xs">
                            <span class="text-slate-500 block text-[11px] font-bold uppercase mb-2">Berkas Lampiran Tersimpan ({{ $rfp->attachments->count() }}):</span>
                            <div class="flex flex-wrap gap-2">
                                @foreach($rfp->attachments as $att)
                                    <div class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 flex items-center gap-2 text-slate-700 shadow-sm">
                                        <i data-lucide="paperclip" class="w-3.5 h-3.5 text-[#c29b53]"></i>
                                        <span class="font-mono text-[11px]">{{ $att->original_filename }}</span>
                                        <span class="text-[10px] text-slate-400">({{ number_format($att->file_size_bytes / 1024, 0) }} KB)</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Layout & Payment Scheme Info Banner -->
                    @if($rfp->designLayout || $rfp->payment_scheme)
                        <div class="mt-6 pt-6 border-t border-slate-200 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @if($rfp->designLayout)
                                <div class="p-4 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] uppercase font-mono text-[#c29b53] font-bold block tracking-wider">Katalog Denah Acuan</span>
                                        <div class="text-sm font-bold text-slate-900 font-sans uppercase tracking-wide">{{ $rfp->designLayout->title }} ({{ $rfp->designLayout->code }})</div>
                                        <div class="text-[11px] text-slate-500">Tipe Luas: {{ $rfp->designLayout->building_area_sqm }} m² / Tanah {{ $rfp->designLayout->land_area_sqm }} m²</div>
                                    </div>
                                    <a href="{{ route('layouts.show', $rfp->designLayout->slug) }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-[#c29b53]/10 text-[#c29b53] hover:bg-[#c29b53]/20 text-xs font-bold border border-[#c29b53]/30 uppercase">
                                        Lihat 3D
                                    </a>
                                </div>
                            @endif

                            @if($rfp->payment_scheme)
                                <div class="p-4 rounded-xl bg-white border border-slate-200 shadow-sm">
                                    <span class="text-[10px] uppercase font-mono text-emerald-700 font-bold block tracking-wider">Metode Pembayaran</span>
                                    <div class="text-sm font-bold text-slate-900">{{ $rfp->payment_scheme_label }}</div>
                                    <div class="text-[11px] text-slate-500">
                                        @if($rfp->payment_scheme === 'cash_tempo')
                                            4 Termin Bertahap sesuai opname fisik mingguan
                                        @elseif($rfp->payment_scheme === 'kpr_bank')
                                            Fasilitas KPR Konstruksi Bank Rekanan (BCA, Mandiri, BNI)
                                        @else
                                            Pelunasan tunai terencana sesuai kesepakatan SPK
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if($rfp->assignedUser)
                        <div class="mt-4 p-3 rounded-lg bg-blue-50 border border-blue-200 flex items-center justify-between text-xs">
                            <div class="flex items-center gap-2">
                                <i data-lucide="user-check" class="w-4 h-4 text-blue-600"></i>
                                <span class="text-slate-600 font-medium">Penanggung Jawab Proyek (PIC):</span>
                                <span class="text-slate-900 font-bold">{{ $rfp->assignedUser->name }}</span>
                                <span class="text-slate-500 text-[10px]">({{ $rfp->assignedUser->role ?? 'Estimator / Project Manager' }})</span>
                            </div>
                            <span class="text-[10px] font-mono text-blue-700 bg-blue-100 px-2 py-0.5 rounded font-bold">SIAP KONSULTASI</span>
                        </div>
                    @endif

                    <!-- Fast WhatsApp Action -->
                    <div class="mt-8 pt-6 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <span class="text-xs text-slate-500 font-light">Perlu klarifikasi cepat mengenai tiket ini?</span>
                        <a href="https://wa.me/{{ $settings['whatsapp'] ?? '6281348593725' }}?text={{ urlencode('Halo Enzo Contractor, saya ingin konfirmasi status tiket RFP ' . $rfp->rfp_number . ' atas nama ' . $rfp->full_name) }}"
                           target="_blank"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg text-xs font-bold transition shadow-md">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                            <span>Hubungi Tim Estimator via WA</span>
                        </a>
                    </div>
                </div>

                <!-- SECTION 7: Jurnal Mandor & Pemantauan Progres Fisik -->
                <div class="bg-slate-50 p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-6 border-b border-slate-200">
                        <div>
                            <div class="inline-flex items-center gap-2 text-xs font-mono text-[#c29b53] uppercase tracking-widest mb-1 font-bold">
                                <i data-lucide="activity" class="w-3.5 h-3.5"></i>
                                <span>Pemantauan Progres Konstruksi</span>
                            </div>
                            <h3 class="font-sans text-lg sm:text-xl font-bold text-slate-900 uppercase tracking-wide">
                                Jurnal Harian Mandor & Komparasi Fisik vs Render 3D
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 font-light">
                                Transparansi pengawasan tahapan konstruksi riil di lapangan disandingkan langsung dengan desain yang disepakati.
                            </p>
                        </div>

                        @if($rfp->progressLogs->isNotEmpty())
                            <div class="text-right">
                                <span class="text-[11px] text-slate-500 block uppercase font-semibold">Progres Terkini:</span>
                                <span class="text-2xl font-bold text-[#c29b53] font-mono">{{ $rfp->progressLogs->last()->progress_percentage }}%</span>
                            </div>
                        @endif
                    </div>

                    @if($rfp->progressLogs->isEmpty())
                        <div class="py-12 text-center text-slate-400 text-xs">
                            <i data-lucide="hourglass" class="w-8 h-8 text-slate-400 mx-auto mb-3"></i>
                            <p class="font-bold text-slate-700">Belum Ada Catatan Jurnal Fisik Lapangan</p>
                            <p class="text-slate-500 text-[11px] mt-1 max-w-md mx-auto font-light">
                                Jurnal harian mandor dan dokumentasi opname fisik lapangan akan diperbarui secara berkala setelah proses tender mencapai kesepakatan (deal kontrak) dan pengerjaan pondasi dimulai.
                            </p>
                        </div>
                    @else
                        <div class="mt-8 space-y-8">
                            @foreach($rfp->progressLogs->sortByDesc('day_number') as $log)
                                <div class="p-6 rounded-xl bg-white border border-slate-200 shadow-sm">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                                        <div class="flex items-center gap-3">
                                            <span class="px-3 py-1 rounded-full bg-[#c29b53] text-white font-bold font-mono text-xs shadow-sm">
                                                Hari Ke-{{ $log->day_number }}
                                            </span>
                                            <h4 class="font-sans text-sm sm:text-base font-bold text-slate-900 uppercase">{{ $log->stage_name }}</h4>
                                        </div>
                                        <div class="flex items-center gap-4 text-xs font-mono">
                                            <span class="text-slate-500"><i data-lucide="calendar" class="w-3.5 h-3.5 inline mr-1 text-slate-400"></i>{{ $log->logged_date->translatedFormat('d F Y') }}</span>
                                            <span class="text-[#c29b53] font-bold"><i data-lucide="trending-up" class="w-3.5 h-3.5 inline mr-1"></i>{{ $log->progress_percentage }}% Selesai</span>
                                            @if($log->weather_notes)
                                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[10px] font-semibold">{{ $log->weather_notes }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    @if($log->notes)
                                        <p class="text-xs text-slate-600 mt-4 leading-relaxed font-light">
                                            {{ $log->notes }}
                                        </p>
                                    @endif

                                    <!-- Side-by-Side Visual Comparison -->
                                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <!-- Render 3D / Promised Design -->
                                        <div class="rounded-xl overflow-hidden border border-slate-200 bg-slate-50 p-3">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-[10px] font-mono uppercase tracking-wider text-slate-700 font-bold flex items-center gap-1.5">
                                                    <i data-lucide="box" class="w-3.5 h-3.5 text-[#c29b53]"></i>
                                                    <span>1. Desain Rencana (Visual 3D)</span>
                                                </span>
                                                <span class="text-[10px] text-slate-400">Target SPK</span>
                                            </div>
                                            <div class="relative h-52 rounded-lg overflow-hidden bg-slate-100 group border border-slate-200">
                                                @if($log->ai_render_promised_url)
                                                    <img src="{{ $log->ai_render_promised_url }}" alt="Render Rencana {{ $log->stage_name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                                @else
                                                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 text-xs">
                                                        <i data-lucide="image" class="w-8 h-8 mb-1"></i>
                                                        <span>Visual Render Sesuai Desain Acuan</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Physical Real Condition -->
                                        <div class="rounded-xl overflow-hidden border border-[#c29b53]/40 bg-slate-50 p-3">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-[10px] font-mono uppercase tracking-wider text-[#c29b53] font-bold flex items-center gap-1.5">
                                                    <i data-lucide="camera" class="w-3.5 h-3.5"></i>
                                                    <span>2. Progres Fisik Nyata di Lapangan</span>
                                                </span>
                                                <span class="text-[10px] text-emerald-700 font-mono font-bold">Verifikasi Mandor</span>
                                            </div>
                                            <div class="relative h-52 rounded-lg overflow-hidden bg-slate-100 group border border-slate-200">
                                                @if($log->physical_photo_url)
                                                    <img src="{{ $log->physical_photo_url }}" alt="Foto Lapangan {{ $log->stage_name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                                @else
                                                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 text-xs">
                                                        <i data-lucide="camera-off" class="w-8 h-8 mb-1"></i>
                                                        <span>Foto Opname Lapangan Sedang Diproses</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @if($log->foreman_name)
                                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                                            <span>Dilaporkan oleh Mandor Lapangan: <strong class="text-slate-900">{{ $log->foreman_name }}</strong></span>
                                            <span class="font-mono text-emerald-700 font-bold">Tervalidasi Lapangan</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- SECTION 8: Wadah Pengaduan & Komplain Pelanggan -->
                <div class="bg-slate-50 p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="pb-6 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <div class="inline-flex items-center gap-2 text-xs font-mono text-rose-600 uppercase tracking-widest mb-1 font-bold">
                                <i data-lucide="shield-alert" class="w-3.5 h-3.5"></i>
                                <span>Garansi & Pengaduan Konsumen</span>
                            </div>
                            <h3 class="font-sans text-lg sm:text-xl font-bold text-slate-900 uppercase tracking-wide">
                                Layanan Pengaduan <span class="text-rose-600">Ketidaksesuaian Pengerjaan</span>
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 font-light">
                                Jika ada hasil fisik lapangan yang tidak sesuai perjanjian awal (warna cat/pintu, posisi sanitasi/WC, retak acian, atau merk material), sampaikan di sini untuk penanganan segera.
                            </p>
                        </div>
                    </div>

                    <!-- Feedback Messages -->
                    @if(session('complaint_success'))
                        <div class="mt-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-2">
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                            <span>{{ session('complaint_success') }}</span>
                        </div>
                    @endif

                    <!-- Complaint History List -->
                    @if($rfp->complaints->isNotEmpty())
                        <div class="mt-6 mb-8">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 font-mono mb-3">Daftar Tiket Pengaduan Terdaftar:</h4>
                            <div class="space-y-3">
                                @foreach($rfp->complaints as $cmp)
                                    <div class="p-4 rounded-xl bg-white border border-slate-200 text-xs shadow-sm">
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-2 border-b border-slate-100">
                                            <div class="flex items-center gap-2">
                                                <span class="font-mono font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded border border-rose-200">{{ $cmp->complaint_number }}</span>
                                                <span class="font-bold text-slate-900">{{ $cmp->title }}</span>
                                            </div>
                                            <div>
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase
                                                    @if($cmp->status === 'resolved') bg-emerald-100 text-emerald-800 border border-emerald-200
                                                    @elseif($cmp->status === 'fixing') bg-amber-100 text-amber-800 border border-amber-200
                                                    @else bg-blue-100 text-blue-800 border border-blue-200 @endif">
                                                    Status: {{ $cmp->status_label }}
                                                </span>
                                            </div>
                                        </div>
                                        <p class="text-slate-600 mt-2 font-light leading-relaxed">{{ $cmp->description }}</p>

                                        @if($cmp->photo_evidence_url)
                                            <div class="mt-3">
                                                <a href="{{ $cmp->photo_evidence_url }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] text-[#c29b53] hover:underline font-bold">
                                                    <i data-lucide="image" class="w-3.5 h-3.5"></i>
                                                    <span>Lihat Bukti Foto Terlampir</span>
                                                </a>
                                            </div>
                                        @endif

                                        @if($cmp->resolution_notes)
                                            <div class="mt-3 p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-[11px] text-emerald-800">
                                                <strong class="block text-emerald-900">Tanggapan & Solusi Kontraktor:</strong>
                                                {{ $cmp->resolution_notes }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Complaint Form -->
                    <div class="mt-6 p-6 rounded-xl bg-white border border-slate-200 shadow-sm">
                        <h4 class="font-sans text-xs sm:text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <i data-lucide="plus-circle" class="w-4 h-4 text-rose-600"></i>
                            <span>Ajukan Laporan Keluhan Baru</span>
                        </h4>

                        <form action="{{ route('rfp.complaint.store', $rfp->rfp_number) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Judul Permasalahan *</label>
                                    <input type="text" name="title" required placeholder="Contoh: Posisi Kloset Sanitasi Geser 30cm"
                                           class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:border-rose-500">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori Masalah *</label>
                                    <select name="category" required class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-xs text-slate-900 focus:outline-none focus:border-rose-500">
                                        <option value="sanitasi">Sanitasi & Plumbing (WC, Kran, Septic Tank)</option>
                                        <option value="warna_cat_kusen">Warna Cat, Kusen & Finishing Pintu/Jendela</option>
                                        <option value="plafon_atap">Plafon, Rangka Atap & Talang Air</option>
                                        <option value="keramik_lantai">Keramik / Granit Lantai (Kopong/Miring)</option>
                                        <option value="instalasi_listrik">Instalasi Stopkontak & Titik Lampu</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Rincian Ketidaksesuaian & Lokasi Ruang *</label>
                                <textarea name="description" rows="3" required placeholder="Jelaskan detail ketidaksesuaian fisik yang ditemukan di lokasi pengerjaan..."
                                          class="w-full bg-slate-50 border border-slate-300 rounded-lg p-3 text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:border-rose-500"></textarea>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Unggah Foto Bukti Lapangan (JPG/PNG/PDF, Max 5MB)</label>
                                    <input type="file" name="evidence_file" accept="image/*,.pdf"
                                           class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-rose-100 file:text-rose-700 hover:file:bg-rose-200">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Atau Masukkan URL Link Foto Bukti</label>
                                    <input type="url" name="photo_evidence_url" placeholder="https://..."
                                           class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:border-rose-500">
                                </div>
                            </div>

                            <div class="pt-2 text-right">
                                <button type="submit" class="px-5 py-2.5 rounded-lg bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs uppercase tracking-wider transition inline-flex items-center gap-1.5 shadow-md">
                                    <i data-lucide="send" class="w-3.5 h-3.5"></i>
                                    <span>Kirim Laporan Pengaduan</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- SECTION 9: Testimoni & Ulasan Konsumen -->
                <div class="bg-slate-50 p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="pb-6 border-b border-slate-200">
                        <div class="inline-flex items-center gap-2 text-xs font-mono text-emerald-700 uppercase tracking-widest mb-1 font-bold">
                            <i data-lucide="award" class="w-3.5 h-3.5"></i>
                            <span>Ulasan & Portofolio Publik</span>
                        </div>
                        <h3 class="font-sans text-lg sm:text-xl font-bold text-slate-900 uppercase tracking-wide">
                            Testimoni Kepuasan Pelanggan ENZO
                        </h3>
                        <p class="text-xs text-slate-500 mt-1 font-light">
                            Ulasan Anda berharga bagi kami untuk penyempurnaan mutu dan dapat ditampilkan pada etalase portofolio publik kami.
                        </p>
                    </div>

                    @if(session('testimonial_success'))
                        <div class="mt-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-2">
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                            <span>{{ session('testimonial_success') }}</span>
                        </div>
                    @endif

                    @if($rfp->client_review)
                        <!-- Already Submitted Review -->
                        <div class="mt-6 p-6 rounded-xl bg-white border border-slate-200 shadow-sm">
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                <div class="flex items-center gap-1 text-[#c29b53]">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i data-lucide="star" class="w-4 h-4 {{ $i <= $rfp->client_rating ? 'fill-[#c29b53] text-[#c29b53]' : 'text-slate-300' }}"></i>
                                    @endfor
                                    <span class="ml-2 font-mono text-xs font-bold text-slate-800">{{ $rfp->client_rating }}.0 / 5.0</span>
                                </div>
                                <span class="text-[11px] font-mono text-emerald-700 bg-emerald-100 px-2.5 py-0.5 rounded font-bold">
                                    Testimoni Terverifikasi
                                </span>
                            </div>
                            <blockquote class="mt-4 text-slate-700 text-xs italic font-light leading-relaxed">
                                "{{ $rfp->client_review }}"
                            </blockquote>
                            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                                <span>Oleh: <strong class="text-slate-900">{{ $rfp->full_name }}</strong></span>
                                <span>Izin Tampil Publik: <strong class="{{ $rfp->client_privacy_consented ? 'text-emerald-700' : 'text-slate-500' }}">{{ $rfp->client_privacy_consented ? 'Disetujui (Dengan Masking Privasi)' : 'Privat' }}</strong></span>
                            </div>
                        </div>
                    @else
                        <!-- Testimonial Submission Form -->
                        <form action="{{ route('rfp.testimonial.store', $rfp->rfp_number) }}" method="POST" class="mt-6 space-y-4">
                            @csrf
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Penilaian Tingkat Kepuasan *</label>
                                <select name="rating" required class="w-full sm:w-64 bg-white border border-slate-300 rounded-lg px-3 py-2 text-xs text-slate-900 focus:outline-none focus:border-[#c29b53]">
                                    <option value="5">⭐⭐⭐⭐⭐ 5 Bintang (Sangat Memuaskan)</option>
                                    <option value="4">⭐⭐⭐⭐ 4 Bintang (Puas & Rapi)</option>
                                    <option value="3">⭐⭐⭐ 3 Bintang (Cukup Baik)</option>
                                    <option value="2">⭐⭐ 2 Bintang (Kurang Sesuai)</option>
                                    <option value="1">⭐ 1 Bintang (Perlu Banyak Perbaikan)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Ulasan & Kesan Pelaksanaan Proyek *</label>
                                <textarea name="review" rows="3" required placeholder="Bagikan pengalaman Anda selama proses tender, ketepatan jadwal, hingga pengerjaan bangunan oleh tim ENZO..."
                                          class="w-full bg-white border border-slate-300 rounded-lg p-3 text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:border-[#c29b53]"></textarea>
                            </div>

                            <div class="p-3 rounded-lg bg-white border border-slate-200 text-[11px] text-slate-600 flex items-start gap-2 shadow-sm">
                                <input type="checkbox" name="privacy_consent" id="privacy_consent" value="1" checked class="mt-0.5 rounded border-slate-300 text-[#c29b53] focus:ring-0">
                                <label for="privacy_consent" class="cursor-pointer">
                                    <strong>Persetujuan Portofolio Publik:</strong> Saya menyetujui testimoni dan foto bangunan ditampilkan di etalase publik portofolio dengan alamat hunian disamarkan demi privasi.
                                </label>
                            </div>

                            <div class="pt-2 text-right">
                                <button type="submit" class="px-5 py-2.5 rounded-lg bg-[#c29b53] hover:bg-[#ad8741] text-white font-bold text-xs uppercase tracking-wider transition inline-flex items-center gap-1.5 shadow-md">
                                    <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                    <span>Kirim Testimoni & Ulasan</span>
                                </button>
                            </div>
                        </form>
                    @endif
                </div>

            </div>
        @elseif($searched)
            <!-- Search Not Found -->
            <div class="text-center py-16 bg-slate-50 rounded-2xl border border-slate-200 p-8 shadow-sm">
                <div class="w-16 h-16 rounded-full bg-slate-200 flex items-center justify-center mx-auto text-rose-500 mb-4 border border-rose-300">
                    <i data-lucide="alert-circle" class="w-8 h-8"></i>
                </div>
                <h3 class="font-sans text-lg sm:text-xl font-bold text-slate-900 uppercase tracking-wider mb-2">Tiket RFP Tidak Ditemukan</h3>
                <p class="text-xs text-slate-500 max-w-md mx-auto mb-6">
                    Nomor tiket <code class="text-rose-600 bg-rose-50 px-2 py-0.5 rounded font-mono border border-rose-200">{{ $rfpNumber }}</code> tidak tercatat pada sistem kami. Pastikan format nomor sudah tepat atau ajukan proposal tender baru.
                </p>
                <div class="flex items-center justify-center gap-3">
                    <a href="{{ route('rfp.track') }}" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-md text-xs font-bold uppercase tracking-wider hover:bg-slate-300 transition">
                        Coba Lagi
                    </a>
                    <a href="{{ route('rfp.create') }}" class="px-4 py-2 bg-[#c29b53] text-white rounded-md text-xs font-bold uppercase tracking-wider hover:bg-[#ad8741] transition shadow-md">
                        Buat Pengajuan RFP Baru
                    </a>
                </div>
            </div>
        @else
            <!-- Initial Guidance State -->
            <div class="bg-slate-50 p-8 rounded-2xl border border-slate-200 text-center max-w-xl mx-auto shadow-sm">
                <div class="w-14 h-14 rounded-full bg-[#c29b53]/10 text-[#c29b53] flex items-center justify-center mx-auto mb-4 border border-[#c29b53]/30">
                    <i data-lucide="search" class="w-7 h-7"></i>
                </div>
                <h3 class="font-sans text-base sm:text-lg font-bold text-slate-900 uppercase tracking-wider mb-2">Pantau Proses Tender Secara Transparan</h3>
                <p class="text-xs text-slate-600 leading-relaxed mb-6 font-light">
                    Setelah mengirimkan formulir RFP, Anda akan menerima nomor tiket unik. Masukkan nomor tersebut pada kolom pencarian di atas untuk memantau kemajuan evaluasi dokumen dan jadwal survey lokasi.
                </p>
                <a href="{{ route('rfp.create') }}" class="inline-flex items-center gap-1.5 text-xs text-[#c29b53] hover:text-[#ad8741] font-bold uppercase tracking-wider">
                    <span>Belum memiliki tiket? Ajukan RFP sekarang</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        @endif

    </div>
</section>

@endsection
