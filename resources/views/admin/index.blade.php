@extends('layouts.app')

@section('title', 'Admin CMS & Lead Pipeline Tracker — ENZO Contractor')

@section('content')

<!-- Header Panel -->
<section class="py-10 bg-[#060A14] border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-amber-500 font-semibold uppercase tracking-wider mb-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span>Executive CMS Portal</span>
                </div>
                <h1 class="font-serif text-2xl sm:text-3xl font-bold text-white">
                    Lead Pipeline Tracker & <span class="gold-gradient-text">Tender Management</span>
                </h1>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('rfp.create') }}" target="_blank"
                   class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold rounded-lg border border-slate-700 transition flex items-center gap-1.5">
                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                    <span>Buka Form RFP Publik</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- KPI Metrics Ribbon (Wireframe 5) -->
<section class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <!-- Metric 1: Total RFP -->
        <div class="bg-[#0B1220] p-4 rounded-xl border border-slate-800">
            <div class="text-[11px] text-slate-400 uppercase font-semibold">Total Masuk</div>
            <div class="font-serif text-2xl font-bold text-white mt-1">{{ $stats['total'] }}</div>
            <div class="text-[10px] text-slate-500 mt-0.5">Tiket RFP</div>
        </div>

        <!-- Metric 2: Baru -->
        <div class="bg-[#0B1220] p-4 rounded-xl border border-blue-500/30">
            <div class="text-[11px] text-blue-400 uppercase font-semibold">RFP Baru</div>
            <div class="font-serif text-2xl font-bold text-blue-400 mt-1">{{ $stats['submitted'] }}</div>
            <div class="text-[10px] text-slate-500 mt-0.5">Menunggu respon</div>
        </div>

        <!-- Metric 3: Dihubungi -->
        <div class="bg-[#0B1220] p-4 rounded-xl border border-amber-500/30">
            <div class="text-[11px] text-amber-400 uppercase font-semibold">Evaluasi PIC</div>
            <div class="font-serif text-2xl font-bold text-amber-400 mt-1">{{ $stats['contacted'] }}</div>
            <div class="text-[10px] text-slate-500 mt-0.5">Sedang dikaji</div>
        </div>

        <!-- Metric 4: Survey Terjadwal -->
        <div class="bg-[#0B1220] p-4 rounded-xl border border-purple-500/30">
            <div class="text-[11px] text-purple-400 uppercase font-semibold">Survey Lokasi</div>
            <div class="font-serif text-2xl font-bold text-purple-400 mt-1">{{ $stats['survey_scheduled'] }}</div>
            <div class="text-[10px] text-slate-500 mt-0.5">Terjadwal lapangan</div>
        </div>

        <!-- Metric 5: Deal Kontrak -->
        <div class="bg-[#0B1220] p-4 rounded-xl border border-emerald-500/30">
            <div class="text-[11px] text-emerald-400 uppercase font-semibold">Deal Kontrak</div>
            <div class="font-serif text-2xl font-bold text-emerald-400 mt-1">{{ $stats['deal'] }}</div>
            <div class="text-[10px] text-slate-500 mt-0.5">SPK Ditandatangani</div>
        </div>

        <!-- Metric 6: Nilai Pipeline -->
        <div class="bg-gradient-to-br from-amber-950/40 to-[#0B1220] p-4 rounded-xl border border-amber-500/40">
            <div class="text-[11px] text-amber-300 uppercase font-semibold">Plafon Pipeline</div>
            <div class="font-serif text-lg font-bold text-amber-400 mt-1 truncate">
                {{ $stats['pipeline_value'] > 0 ? 'Rp ' . number_format($stats['pipeline_value'] / 1000000000, 1) . ' M' : 'Rp 0' }}
            </div>
            <div class="text-[10px] text-slate-400 mt-0.5">Potensi anggaran</div>
        </div>
    </div>
</section>

<!-- Lead Pipeline Tracker Table -->
<section class="pb-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="glass-panel rounded-2xl border border-slate-800 overflow-hidden shadow-2xl">
        
        <!-- Table Filter Bar -->
        <div class="p-5 border-b border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2 overflow-x-auto w-full sm:w-auto text-xs">
                <span class="text-slate-400 font-semibold mr-1">Filter:</span>
                <a href="{{ route('admin.dashboard', ['status' => 'all']) }}"
                   class="px-3 py-1.5 rounded-lg {{ (!$statusFilter || $statusFilter === 'all') ? 'bg-amber-500 text-slate-950 font-bold' : 'bg-slate-900 text-slate-300 hover:bg-slate-800' }}">
                    Semua
                </a>
                <a href="{{ route('admin.dashboard', ['status' => 'submitted']) }}"
                   class="px-3 py-1.5 rounded-lg {{ $statusFilter === 'submitted' ? 'bg-amber-500 text-slate-950 font-bold' : 'bg-slate-900 text-slate-300 hover:bg-slate-800' }}">
                    Baru
                </a>
                <a href="{{ route('admin.dashboard', ['status' => 'survey_scheduled']) }}"
                   class="px-3 py-1.5 rounded-lg {{ $statusFilter === 'survey_scheduled' ? 'bg-amber-500 text-slate-950 font-bold' : 'bg-slate-900 text-slate-300 hover:bg-slate-800' }}">
                    Survey
                </a>
                <a href="{{ route('admin.dashboard', ['status' => 'rab_sent']) }}"
                   class="px-3 py-1.5 rounded-lg {{ $statusFilter === 'rab_sent' ? 'bg-amber-500 text-slate-950 font-bold' : 'bg-slate-900 text-slate-300 hover:bg-slate-800' }}">
                    RAB Terkirim
                </a>
                <a href="{{ route('admin.dashboard', ['status' => 'deal']) }}"
                   class="px-3 py-1.5 rounded-lg {{ $statusFilter === 'deal' ? 'bg-amber-500 text-slate-950 font-bold' : 'bg-slate-900 text-slate-300 hover:bg-slate-800' }}">
                    Deal
                </a>
            </div>

            <div class="text-xs text-slate-400">
                Menampilkan <span class="font-bold text-white">{{ $rfps->total() }}</span> pengajuan tiket
            </div>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-900/80 text-[11px] uppercase tracking-wider text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="py-4 px-4 font-semibold">No. Tiket & Waktu</th>
                        <th class="py-4 px-4 font-semibold">Nama Klien & Kontak</th>
                        <th class="py-4 px-4 font-semibold">Kategori & Lokasi</th>
                        <th class="py-4 px-4 font-semibold">Plafon Anggaran</th>
                        <th class="py-4 px-4 font-semibold">Lampiran</th>
                        <th class="py-4 px-4 font-semibold">Status Pipeline</th>
                        <th class="py-4 px-4 font-semibold text-right">Aksi Cepat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80">
                    @forelse($rfps as $rfp)
                        <tr class="hover:bg-slate-900/40 transition">
                            <!-- No. Tiket -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <a href="{{ route('admin.rfp.show', $rfp->id) }}" class="font-mono font-bold text-amber-400 hover:underline">
                                    {{ $rfp->rfp_number }}
                                </a>
                                <div class="text-[10px] text-slate-500">{{ $rfp->created_at->diffForHumans() }}</div>
                            </td>

                            <!-- Klien & Kontak -->
                            <td class="py-4 px-4">
                                <div class="font-semibold text-white">{{ $rfp->full_name }}</div>
                                @if($rfp->company_name)
                                    <div class="text-[11px] text-slate-400">{{ $rfp->company_name }}</div>
                                @endif
                                <div class="text-[11px] text-slate-500 mt-0.5">{{ $rfp->phone_number }}</div>
                            </td>

                            <!-- Kategori & Lokasi -->
                            <td class="py-4 px-4 max-w-xs">
                                <div class="font-medium text-slate-200 truncate">{{ $rfp->project_category }}</div>
                                <div class="text-[11px] text-slate-400 truncate flex items-center gap-1 mt-0.5">
                                    <i data-lucide="map-pin" class="w-3 h-3 text-amber-500 shrink-0"></i>
                                    <span>{{ $rfp->site_location }}</span>
                                </div>
                            </td>

                            <!-- Anggaran -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <div class="font-semibold text-emerald-400">
                                    {{ $rfp->estimated_budget_idr ? 'Rp ' . number_format($rfp->estimated_budget_idr, 0, ',', '.') : '-' }}
                                </div>
                                <div class="text-[10px] text-slate-500">
                                    {{ $rfp->planned_area_sqm ? number_format($rfp->planned_area_sqm, 0) . ' m²' : '' }}
                                </div>
                            </td>

                            <!-- Lampiran -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                @if($rfp->attachments->isNotEmpty())
                                    <a href="{{ route('admin.rfp.show', $rfp->id) }}"
                                       class="inline-flex items-center gap-1 px-2 py-1 rounded bg-slate-800 text-[11px] text-amber-300 border border-slate-700 hover:border-amber-500">
                                        <i data-lucide="paperclip" class="w-3 h-3 text-amber-400"></i>
                                        <span>{{ $rfp->attachments->count() }} Berkas</span>
                                    </a>
                                @else
                                    <span class="text-slate-600 text-[11px]">-</span>
                                @endif
                            </td>

                            <!-- Status Dropdown -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <form action="{{ route('admin.rfp.status', $rfp->id) }}" method="POST">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()"
                                            class="bg-slate-900 border border-slate-700 rounded-lg px-2.5 py-1 text-[11px] text-white focus:outline-none focus:border-amber-500">
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
                            <td class="py-4 px-4 text-right whitespace-nowrap space-x-2">
                                @php
                                    // WhatsApp direct template with official greeting
                                    $phoneClean = preg_replace('/[^0-9]/', '', $rfp->phone_number);
                                    if(str_starts_with($phoneClean, '0')) {
                                        $phoneClean = '62' . substr($phoneClean, 1);
                                    }
                                    $waText = "Halo Bpk/Ibu {$rfp->full_name}, kami dari Tim Estimator & Rekayasa Enzo Contractor ingin mengonfirmasi pengajuan penawaran tender {$rfp->rfp_number} untuk proyek {$rfp->project_category} di {$rfp->site_location}. Apakah ada waktu luang untuk koordinasi survey lapangan?";
                                    $waLink = "https://wa.me/{$phoneClean}?text=" . urlencode($waText);
                                @endphp

                                <a href="{{ $waLink }}" target="_blank"
                                   title="Buka WhatsApp Otomatis"
                                   class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-emerald-600/90 hover:bg-emerald-500 text-white text-[11px] font-semibold transition">
                                    <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                                    <span>WA Chat</span>
                                </a>

                                <a href="{{ route('admin.rfp.show', $rfp->id) }}"
                                   class="inline-flex items-center px-2.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 text-[11px] font-semibold transition">
                                    <span>Detail</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-500">
                                <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                                <span>Belum ada tiket RFP yang sesuai dengan filter ini.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-800">
            {{ $rfps->links() }}
        </div>
    </div>
</section>

<!-- Portfolio CMS Quick Overview -->
<section class="pb-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="glass-panel p-6 rounded-2xl border border-slate-800">
        <div class="flex items-center justify-between mb-6 pb-3 border-b border-slate-800">
            <div>
                <h3 class="font-serif text-lg font-bold text-white">Status Portofolio Aktif ({{ $projects->count() }} Proyek)</h3>
                <p class="text-xs text-slate-400">Proyek yang sedang ditayangkan pada beranda dan halaman studi kasus</p>
            </div>
            <a href="{{ route('projects.index') }}" target="_blank" class="text-xs text-amber-400 hover:underline">
                Lihat Katalog Publik &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
            @foreach($projects as $proj)
                <div class="p-3 rounded-xl bg-slate-900/60 border border-slate-800 flex items-center gap-3">
                    <div class="w-12 h-12 rounded-lg bg-slate-800 overflow-hidden shrink-0">
                        @php
                            $pThumb = $proj->images->first()?->image_path ?? 'images/project_commercial.jpg';
                        @endphp
                        <img src="{{ asset($pThumb) }}" alt="{{ $proj->title }}" class="w-full h-full object-cover">
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="font-semibold text-white truncate">{{ $proj->title }}</div>
                        <div class="text-[11px] text-slate-400">{{ $proj->location }}</div>
                        <div class="text-[10px] text-amber-400 mt-0.5">
                            {{ $proj->is_featured ? '★ Featured Beranda' : 'Katalog Standar' }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
