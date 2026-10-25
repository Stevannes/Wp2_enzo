@extends('layouts.admin')

@section('title', 'Lead Pipeline Tracker & Executive CMS — ENZO Contractor')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 space-y-8">

    <!-- ========================================================
         PAGE HEADER (Matching Home Landing Page Luxury Design)
    ========================================================= -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#0d1424] via-[#151f33] to-[#0d1424] border border-slate-800 p-6 sm:p-8 lg:p-10 shadow-2xl">
        <!-- Background subtle glow -->
        <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-[#c29b53]/10 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#1a2332]/90 border border-[#c29b53]/40 text-[#c29b53] text-[11px] font-bold uppercase tracking-wider mb-3 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Executive CMS Portal • Real-Time Pipeline</span>
                </div>
                
                <h1 class="font-sans text-2xl sm:text-4xl font-extrabold tracking-wide text-white uppercase leading-tight">
                    Lead Pipeline Tracker & <span class="text-[#c29b53]">Tender Management</span>
                </h1>
                
                <p class="text-xs sm:text-sm text-slate-300 font-light mt-2.5 leading-relaxed">
                    Sistem manajemen prospek tender konstruksi, respon cepat evaluasi RFP, penugasan staf penanggung jawab (PIC), dan rekam jejak negosiasi kontrak.
                </p>
            </div>

            <!-- Quick Action Links -->
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="{{ route('rfp.create') }}" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#c29b53] hover:bg-[#ad8741] text-white text-xs font-bold uppercase tracking-wider rounded-xl transition shadow-lg shadow-black/30">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    <span>Formulir RFP Publik</span>
                </a>
                <a href="{{ route('projects.index') }}" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#1a2332] hover:bg-[#233044] text-slate-200 hover:text-white text-xs font-bold rounded-xl border border-slate-700 transition shadow-sm">
                    <i data-lucide="layout-grid" class="w-4 h-4 text-[#c29b53]"></i>
                    <span>Lihat Portofolio</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ========================================================
         EXECUTIVE KPI METRICS (Matching Home "Why Choose Us" 5 Dark Cards Aesthetic)
    ========================================================= -->
    <section>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3.5">
            
            <!-- Metric 1: Total Masuk -->
            <div class="bg-[#1a2332] hover:bg-[#222e42] transition-colors duration-200 rounded-2xl p-4 sm:p-5 text-center flex flex-col items-center justify-between min-h-[170px] text-white shadow-md border border-slate-800">
                <div class="w-9 h-9 flex items-center justify-center text-[#c29b53]">
                    <i data-lucide="folder-kanban" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="font-sans font-extrabold text-2xl sm:text-3xl text-white">{{ $stats['total'] }}</div>
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mt-1">Total Prospek</div>
                </div>
                <div class="text-[10px] text-slate-400 font-light">Seluruh tiket masuk</div>
            </div>

            <!-- Metric 2: RFP Baru -->
            <div class="bg-[#1a2332] hover:bg-[#222e42] transition-colors duration-200 rounded-2xl p-4 sm:p-5 text-center flex flex-col items-center justify-between min-h-[170px] text-white shadow-md border border-blue-900/40">
                <div class="w-9 h-9 flex items-center justify-center text-blue-400">
                    <i data-lucide="inbox" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="font-sans font-extrabold text-2xl sm:text-3xl text-blue-400">{{ $stats['submitted'] }}</div>
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mt-1">RFP Baru</div>
                </div>
                <div class="text-[10px] text-slate-400 font-light">Menunggu respon</div>
            </div>

            <!-- Metric 3: Dalam Evaluasi -->
            <div class="bg-[#1a2332] hover:bg-[#222e42] transition-colors duration-200 rounded-2xl p-4 sm:p-5 text-center flex flex-col items-center justify-between min-h-[170px] text-white shadow-md border border-amber-900/40">
                <div class="w-9 h-9 flex items-center justify-center text-amber-400">
                    <i data-lucide="user-check" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="font-sans font-extrabold text-2xl sm:text-3xl text-amber-400">{{ $stats['contacted'] }}</div>
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mt-1">Evaluasi PIC</div>
                </div>
                <div class="text-[10px] text-slate-400 font-light">Sedang dikaji staf</div>
            </div>

            <!-- Metric 4: Survey Lokasi -->
            <div class="bg-[#1a2332] hover:bg-[#222e42] transition-colors duration-200 rounded-2xl p-4 sm:p-5 text-center flex flex-col items-center justify-between min-h-[170px] text-white shadow-md border border-purple-900/40">
                <div class="w-9 h-9 flex items-center justify-center text-purple-400">
                    <i data-lucide="calendar" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="font-sans font-extrabold text-2xl sm:text-3xl text-purple-400">{{ $stats['survey_scheduled'] }}</div>
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mt-1">Survey Lokasi</div>
                </div>
                <div class="text-[10px] text-slate-400 font-light">Jadwal lapangan</div>
            </div>

            <!-- Metric 5: Deal Kontrak -->
            <div class="bg-[#1a2332] hover:bg-[#222e42] transition-colors duration-200 rounded-2xl p-4 sm:p-5 text-center flex flex-col items-center justify-between min-h-[170px] text-white shadow-md border border-emerald-900/40">
                <div class="w-9 h-9 flex items-center justify-center text-emerald-400">
                    <i data-lucide="check-circle-2" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="font-sans font-extrabold text-2xl sm:text-3xl text-emerald-400">{{ $stats['deal'] }}</div>
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mt-1">Deal Kontrak</div>
                </div>
                <div class="text-[10px] text-slate-400 font-light">SPK disepakati</div>
            </div>

            <!-- Metric 6: Plafon Pipeline (Signature Luxury Gold) -->
            <div class="bg-[#1a2332] hover:bg-[#222e42] transition-colors duration-200 rounded-2xl p-4 sm:p-5 text-center flex flex-col items-center justify-between min-h-[170px] text-white shadow-md border-2 border-[#c29b53]/50">
                <div class="w-9 h-9 flex items-center justify-center text-[#c29b53]">
                    <i data-lucide="wallet" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="font-sans font-extrabold text-lg sm:text-xl text-[#c29b53] truncate">
                        {{ $stats['pipeline_value'] > 0 ? 'Rp ' . number_format($stats['pipeline_value'] / 1000000000, 1) . ' M' : 'Rp 0' }}
                    </div>
                    <div class="text-[11px] font-bold uppercase tracking-wider text-[#c29b53] mt-1">Plafon Pipeline</div>
                </div>
                <div class="text-[10px] text-slate-400 font-light">Potensi total proyek</div>
            </div>

        </div>
    </section>

    <!-- ========================================================
         POIN 4 EVALUASI DOSEN: BANNER PENGINGAT RESPON CEPAT (SLA ALERT)
    ========================================================= -->
    @if($unhandledRfps->isNotEmpty())
        <section>
            <div class="p-5 sm:p-6 rounded-3xl bg-rose-950/80 border-2 border-rose-500/70 shadow-xl backdrop-blur-md">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-rose-600 text-white flex items-center justify-center shrink-0 shadow-lg shadow-rose-900/50">
                            <i data-lucide="bell-ring" class="w-6 h-6 animate-pulse"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded text-[10px] font-sans font-extrabold bg-rose-600 text-white uppercase tracking-wider">
                                    Peringatan Respon Lambat
                                </span>
                                <span class="text-xs text-rose-300 font-bold">Evaluasi Poin 4 • Pengingat Otomatis Tiket Belum Direspon</span>
                            </div>
                            <h3 class="font-sans text-base sm:text-lg font-bold text-white mt-1">
                                Terdapat <span class="text-rose-400 underline font-extrabold">{{ $unhandledRfps->count() }} Pengajuan Tiket</span> yang Belum Direspons / Dibuka Selama Lebih dari 6 Jam
                            </h3>
                            <p class="text-xs text-rose-200/80 mt-1 font-light leading-relaxed">
                                Notifikasi SLA sistem aktif otomatis demi kepuasan calon klien. Peringatan ini otomatis berhenti begitu Anda membuka tiket terkait.
                            </p>
                        </div>
                    </div>

                    <!-- Shortcut Quick Open -->
                    <div class="flex flex-wrap items-center gap-2 shrink-0">
                        @foreach($unhandledRfps->take(3) as $ur)
                            <a href="{{ route('admin.rfp.show', $ur->id) }}"
                               class="px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-xs font-mono font-bold flex items-center gap-2 transition shadow-md">
                                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                <span>Buka {{ $ur->rfp_number }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- ========================================================
         LEAD PIPELINE TRACKER TABLE (Matching Home Floating White Container)
    ========================================================= -->
    <section id="pipeline-table">
        <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-2xl text-slate-800">
            
            <!-- Table Filter Bar -->
            <div class="p-5 sm:p-6 border-b border-slate-200 bg-slate-50 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <h2 class="font-sans text-base sm:text-lg font-extrabold uppercase tracking-wide text-slate-900">
                        Daftar Prospek Tender Konstruksi
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Kelola alur konversi tiket RFP, verifikasi berkas, dan delegasikan penanggung jawab staf
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-1.5 text-xs">
                    <span class="text-slate-500 font-bold uppercase tracking-wider text-[10px] mr-1">Filter:</span>
                    <a href="{{ route('admin.dashboard', ['status' => 'all']) }}"
                       class="px-3.5 py-1.5 rounded-lg transition {{ (!$statusFilter || $statusFilter === 'all') ? 'bg-[#c29b53] text-white font-bold shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-300 font-semibold' }}">
                        Semua
                    </a>
                    <a href="{{ route('admin.dashboard', ['status' => 'submitted']) }}"
                       class="px-3.5 py-1.5 rounded-lg transition {{ $statusFilter === 'submitted' ? 'bg-[#c29b53] text-white font-bold shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-300 font-semibold' }}">
                        Baru
                    </a>
                    <a href="{{ route('admin.dashboard', ['status' => 'survey_scheduled']) }}"
                       class="px-3.5 py-1.5 rounded-lg transition {{ $statusFilter === 'survey_scheduled' ? 'bg-[#c29b53] text-white font-bold shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-300 font-semibold' }}">
                        Survey
                    </a>
                    <a href="{{ route('admin.dashboard', ['status' => 'rab_sent']) }}"
                       class="px-3.5 py-1.5 rounded-lg transition {{ $statusFilter === 'rab_sent' ? 'bg-[#c29b53] text-white font-bold shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-300 font-semibold' }}">
                        RAB Terkirim
                    </a>
                    <a href="{{ route('admin.dashboard', ['status' => 'deal']) }}"
                       class="px-3.5 py-1.5 rounded-lg transition {{ $statusFilter === 'deal' ? 'bg-[#c29b53] text-white font-bold shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-300 font-semibold' }}">
                        Deal
                    </a>
                </div>
            </div>

            <!-- Table Content -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-100 text-[11px] uppercase tracking-wider text-slate-700 font-extrabold border-b border-slate-200">
                        <tr>
                            <th class="py-4 px-5">No. Tiket & Tanggal</th>
                            <th class="py-4 px-5">Klien & Kontak</th>
                            <th class="py-4 px-5">Kategori & Pilihan Denah</th>
                            <th class="py-4 px-5">Pagu Anggaran & Skema</th>
                            <th class="py-4 px-5">Penugasan PIC</th>
                            <th class="py-4 px-5">Status Pipeline</th>
                            <th class="py-4 px-5 text-right">Aksi Cepat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($rfps as $rfp)
                            @php
                                $isOverdue = in_array($rfp->status, ['submitted', 'in_review']) && (!$rfp->admin_last_viewed_at || $rfp->admin_last_viewed_at->lt(now()->subHours(6)));
                            @endphp
                            <tr class="hover:bg-slate-50 transition {{ $isOverdue ? 'bg-rose-50/70' : '' }}">
                                
                                <!-- No. Tiket -->
                                <td class="py-4 px-5 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.rfp.show', $rfp->id) }}" class="font-mono font-bold text-[#c29b53] hover:underline text-xs">
                                            {{ $rfp->rfp_number }}
                                        </a>
                                        @if($isOverdue)
                                            <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-ping" title="Perlu Respon Segera (>6 jam)"></span>
                                        @endif
                                    </div>
                                    <div class="text-[11px] text-slate-500 mt-0.5">{{ $rfp->created_at->diffForHumans() }}</div>
                                    @if($rfp->complaints->isNotEmpty())
                                        <span class="inline-flex mt-1 text-[10px] px-2 py-0.5 rounded font-bold bg-rose-100 text-rose-700 border border-rose-300">
                                            {{ $rfp->complaints->count() }} Komplain
                                        </span>
                                    @endif
                                </td>

                                <!-- Klien & Kontak -->
                                <td class="py-4 px-5">
                                    <div class="font-bold text-slate-900 text-xs">{{ $rfp->full_name }}</div>
                                    @if($rfp->company_name)
                                        <div class="text-[11px] text-slate-600 font-medium">{{ $rfp->company_name }}</div>
                                    @endif
                                    <div class="text-[11px] text-slate-500 mt-0.5 font-mono">{{ $rfp->phone_number }}</div>
                                </td>

                                <!-- Kategori & Pilihan Layout -->
                                <td class="py-4 px-5 max-w-xs">
                                    <div class="font-semibold text-slate-800 truncate">{{ $rfp->project_category }}</div>
                                    @if($rfp->designLayout)
                                        <div class="text-[11px] text-[#c29b53] flex items-center gap-1 font-semibold mt-0.5">
                                            <i data-lucide="layout" class="w-3.5 h-3.5 shrink-0"></i>
                                            <span class="truncate">{{ $rfp->designLayout->title }} ({{ $rfp->designLayout->code }})</span>
                                        </div>
                                    @else
                                        <div class="text-[11px] text-slate-500 flex items-center gap-1 mt-0.5">
                                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                            <span class="truncate">{{ $rfp->site_location }}</span>
                                        </div>
                                    @endif
                                </td>

                                <!-- Anggaran & Skema Pembayaran -->
                                <td class="py-4 px-5 whitespace-nowrap">
                                    <div class="font-bold text-emerald-600 text-xs">
                                        {{ $rfp->estimated_budget_idr ? 'Rp ' . number_format($rfp->estimated_budget_idr, 0, ',', '.') : '-' }}
                                    </div>
                                    <div class="text-[10px] font-semibold text-slate-600 mt-0.5">
                                        {{ $rfp->payment_scheme_label ?? 'Belum Pilih Skema' }}
                                    </div>
                                </td>

                                <!-- Penugasan PIC (Poin 5 Evaluasi Dosen) -->
                                <td class="py-4 px-5 whitespace-nowrap">
                                    <form action="{{ route('admin.rfp.assign', $rfp->id) }}" method="POST">
                                        @csrf
                                        <select name="assigned_to_user_id" onchange="this.form.submit()"
                                                class="bg-white border border-slate-300 rounded-lg px-2.5 py-1.5 text-xs text-slate-800 font-medium focus:outline-none focus:border-[#c29b53] focus:ring-1 focus:ring-[#c29b53] shadow-sm">
                                            <option value="" disabled {{ !$rfp->assigned_to_user_id ? 'selected' : '' }}>-- Tugaskan PIC --</option>
                                            @foreach($staffUsers as $staff)
                                                <option value="{{ $staff->id }}" {{ $rfp->assigned_to_user_id == $staff->id ? 'selected' : '' }}>
                                                    {{ $staff->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>

                                <!-- Status Dropdown -->
                                <td class="py-4 px-5 whitespace-nowrap">
                                    <form action="{{ route('admin.rfp.status', $rfp->id) }}" method="POST">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()"
                                                class="bg-white border border-slate-300 rounded-lg px-2.5 py-1.5 text-xs text-slate-800 font-semibold focus:outline-none focus:border-[#c29b53] focus:ring-1 focus:ring-[#c29b53] shadow-sm">
                                            <option value="submitted" {{ $rfp->status === 'submitted' ? 'selected' : '' }}>Baru Masuk</option>
                                            <option value="in_review" {{ $rfp->status === 'in_review' ? 'selected' : '' }}>Dalam Review</option>
                                            <option value="contacted" {{ $rfp->status === 'contacted' ? 'selected' : '' }}>Dihubungi PIC</option>
                                            <option value="survey_scheduled" {{ $rfp->status === 'survey_scheduled' ? 'selected' : '' }}>Survey Dijadwalkan</option>
                                            <option value="rab_sent" {{ $rfp->status === 'rab_sent' ? 'selected' : '' }}>RAB & Proposal Kirim</option>
                                            <option value="deal" {{ $rfp->status === 'deal' ? 'selected' : '' }}>Deal Kontrak</option>
                                            <option value="rejected" {{ $rfp->status === 'rejected' ? 'selected' : '' }}>Ditolak / Batal</option>
                                        </select>
                                    </form>
                                </td>

                                <!-- Aksi Cepat (WA Chat & View) -->
                                <td class="py-4 px-5 text-right whitespace-nowrap space-x-2">
                                    @php
                                        $phoneClean = preg_replace('/[^0-9]/', '', $rfp->phone_number);
                                        if(str_starts_with($phoneClean, '0')) {
                                            $phoneClean = '62' . substr($phoneClean, 1);
                                        }
                                        $waText = "Halo Bpk/Ibu {$rfp->full_name}, kami dari Tim Estimator & Rekayasa Enzo Contractor ingin mengonfirmasi pengajuan penawaran tender {$rfp->rfp_number} untuk proyek {$rfp->project_category} di {$rfp->site_location}. Apakah ada waktu luang untuk koordinasi survey lapangan?";
                                        $waLink = "https://wa.me/{$phoneClean}?text=" . urlencode($waText);
                                    @endphp

                                    <a href="{{ $waLink }}" target="_blank"
                                       title="Buka WhatsApp Otomatis"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm">
                                        <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                        <span>WA Chat</span>
                                    </a>

                                    <a href="{{ route('admin.rfp.show', $rfp->id) }}"
                                       class="inline-flex items-center px-3 py-1.5 rounded-lg bg-[#1a2332] hover:bg-[#233044] text-[#c29b53] hover:text-white text-xs font-bold transition shadow-sm border border-[#c29b53]/40">
                                        <span>Detail</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-500">
                                    <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                                    <span class="font-medium">Belum ada tiket RFP yang sesuai dengan filter ini.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table Pagination -->
            <div class="p-5 border-t border-slate-200 bg-slate-50">
                {{ $rfps->links() }}
            </div>
        </div>
    </section>

    <!-- ========================================================
         PORTOFOLIO STATUS QUICK OVERVIEW
    ========================================================= -->
    <section class="pb-8">
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-2xl text-slate-800">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="font-sans text-base sm:text-lg font-extrabold text-[#1a2332] uppercase tracking-wide">
                        Status Portofolio Aktif ({{ $projects->count() }} Proyek)
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Proyek yang sedang ditayangkan pada beranda dan halaman studi kasus etalase publik
                    </p>
                </div>
                <a href="{{ route('projects.index') }}" target="_blank"
                   class="text-xs font-bold text-[#c29b53] hover:text-[#ad8741] flex items-center gap-1 transition">
                    <span>Lihat Katalog Publik</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
                @foreach($projects as $proj)
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 hover:border-[#c29b53] hover:shadow-md transition flex items-center gap-3">
                        <div class="w-14 h-14 rounded-xl bg-slate-200 overflow-hidden shrink-0 border border-slate-300">
                            @php
                                $pThumb = $proj->images->first()?->image_path ?? 'images/project_commercial.jpg';
                            @endphp
                            <img src="{{ asset($pThumb) }}" alt="{{ $proj->title }}" class="w-full h-full object-cover">
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-bold text-slate-900 truncate">{{ $proj->title }}</div>
                            <div class="text-[11px] text-slate-500 truncate">{{ $proj->location }}</div>
                            <div class="text-[10px] font-bold mt-1">
                                @if($proj->is_featured)
                                    <span class="text-[#c29b53] bg-amber-50 px-2 py-0.5 rounded border border-amber-200 inline-block">★ Featured Beranda</span>
                                @else
                                    <span class="text-slate-500 bg-slate-200 px-2 py-0.5 rounded inline-block">Katalog Standar</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

</div>

@endsection
