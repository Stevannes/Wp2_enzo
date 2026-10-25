@extends('layouts.app')

@section('title', 'Dashboard Klien & Pelacakan Proyek — enzo building construction and interior')

@section('content')

<div x-data="{ profileModalOpen: {{ $errors->has('name') || $errors->has('phone_number') || $errors->has('company_name') || session('open_profile_modal') ? 'true' : 'false' }} }">

<!-- ========================================================
     HERO SECTION (Matching PT MKP Mockup & Navbar Clearance)
========================================================= -->
<section class="relative min-h-[360px] sm:min-h-[400px] flex items-center justify-center overflow-hidden">
    <!-- Clean Architectural Twilight Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/ptmkp_hero_clean.jpg') }}"
             alt="Executive Customer Portal Hero"
             class="w-full h-full object-cover object-center">
        <!-- Overlay ensuring high contrast and luxury feel -->
        <div class="absolute inset-0 bg-slate-950/65"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/40 to-slate-950/60"></div>
    </div>

    <!-- Hero Content with deliberate top spacing so not obscured by fixed header -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center pt-28 pb-24 sm:pt-32 sm:pb-28">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#1a2332]/85 border border-[#c29b53]/40 text-[#c29b53] text-xs font-bold uppercase tracking-wider mb-3 backdrop-blur-sm shadow-sm">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>Customer Portal & Construction Workspace</span>
        </div>
        
        <h1 class="font-sans text-3xl sm:text-5xl font-extrabold tracking-wide text-white uppercase leading-tight">
            Selamat Datang, <span class="text-[#c29b53]">{{ $user->name }}</span>
        </h1>
        
        <p class="text-xs sm:text-sm text-slate-200 font-light max-w-2xl mx-auto mt-3 leading-relaxed">
            Pusat pemantauan resmi penawaran tender konstruksi, jurnal opname harian mandor, keluhan pengerjaan, dan status kontrak Anda bersama ENZO.
        </p>

        <!-- Profile Badges & Actions (Luxury Architectural Glass Ribbon) -->
        <div class="mt-6 inline-flex flex-wrap items-center justify-center gap-2 sm:gap-2.5 p-1.5 sm:px-3 sm:py-2 rounded-2xl bg-slate-900/70 backdrop-blur-xl border border-white/10 shadow-2xl shadow-black/50 ring-1 ring-white/5 text-xs">
            
            <!-- User Identity Monogram / Avatar -->
            <div class="inline-flex items-center gap-2 py-0.5 pl-1 pr-1.5">
                @if(!empty($user->avatar))
                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-7 h-7 rounded-full object-cover ring-2 ring-[#c29b53]/60 shadow-md" referrerpolicy="no-referrer">
                @else
                    <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-[#8a6828] via-[#c29b53] to-[#ebd29b] text-slate-950 font-extrabold text-[11px] flex items-center justify-center ring-1 ring-white/25 shadow-sm">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <div class="text-left leading-none hidden sm:block">
                    <span class="text-xs font-semibold text-white tracking-tight">{{ Str::limit($user->name, 18) }}</span>
                </div>
            </div>

            <!-- Divider -->
            <div class="h-5 w-px bg-white/15 hidden sm:block"></div>

            <!-- Email Badge -->
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white/[0.05] hover:bg-white/[0.08] text-slate-200 border border-white/[0.08] transition-colors duration-200" title="Email Akun">
                <span class="w-5 h-5 rounded-lg bg-[#c29b53]/15 text-[#e4bd68] flex items-center justify-center shrink-0 border border-[#c29b53]/30">
                    <i data-lucide="mail" class="w-3 h-3"></i>
                </span>
                <span class="text-xs font-medium tracking-tight text-slate-200">{{ $user->email }}</span>
            </div>

            <!-- Phone Badge -->
            @if(!empty($user->phone_number))
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white/[0.05] hover:bg-white/[0.08] text-slate-200 border border-white/[0.08] transition-colors duration-200" title="Nomor Kontak WhatsApp">
                    <span class="w-5 h-5 rounded-lg bg-emerald-500/15 text-emerald-400 flex items-center justify-center shrink-0 border border-emerald-500/30">
                        <i data-lucide="phone" class="w-3 h-3"></i>
                    </span>
                    <span class="text-xs font-medium tracking-tight text-slate-200">{{ $user->phone_number }}</span>
                </div>
            @endif

            <!-- Company / Organization Badge -->
            @if(!empty($user->company_name))
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white/[0.05] hover:bg-white/[0.08] text-slate-200 border border-white/[0.08] transition-colors duration-200" title="Perusahaan / Instansi">
                    <span class="w-5 h-5 rounded-lg bg-amber-500/15 text-amber-300 flex items-center justify-center shrink-0 border border-amber-500/30">
                        <i data-lucide="building" class="w-3 h-3"></i>
                    </span>
                    <span class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold hidden md:inline">Instansi:</span>
                    <span class="text-xs font-semibold text-white tracking-tight">{{ $user->company_name }}</span>
                </div>
            @endif

            <!-- Button Tambah Nomor HP (Khusus Belum Ada No. HP) -->
            @if(empty($user->phone_number))
                <button @click="profileModalOpen = true; $nextTick(() => document.getElementById('modal_phone')?.focus())"
                        type="button"
                        class="group inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-[#c29b53]/25 hover:bg-[#c29b53] text-[#e4bd68] hover:text-slate-950 border border-[#c29b53]/60 font-bold shadow-md shadow-amber-950/40 animate-pulse hover:animate-none text-xs transition-all duration-200 shadow-sm active:scale-95"
                        title="Tambahkan Nomor WhatsApp">
                    <i data-lucide="plus-circle" class="w-3.5 h-3.5 text-[#e4bd68] group-hover:text-slate-950"></i>
                    <span>+ Tambah Nomor HP</span>
                </button>
            @endif

            <!-- Button Tambah Nama Perusahaan (Khusus Belum Ada Perusahaan) -->
            @if(empty($user->company_name))
                <button @click="profileModalOpen = true; $nextTick(() => document.getElementById('modal_company')?.focus())"
                        type="button"
                        class="group inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white/[0.05] hover:bg-[#c29b53]/20 text-slate-300 hover:text-[#e4bd68] border border-white/10 hover:border-[#c29b53]/40 text-xs font-medium transition-all duration-200 shadow-sm active:scale-95"
                        title="Tambahkan Nama Perusahaan / Instansi (Opsional)">
                    <i data-lucide="building" class="w-3.5 h-3.5 text-amber-400/80 group-hover:text-amber-300 transition-colors"></i>
                    <span>+ Tambah Nama Perusahaan</span>
                </button>
            @endif

            <!-- Button Ubah Data Profil (Tampil jika Nomor HP sudah terisi) -->
            @if(!empty($user->phone_number))
                <button @click="profileModalOpen = true"
                        type="button"
                        class="group inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white/[0.05] hover:bg-white/[0.12] text-slate-300 hover:text-white border border-white/10 font-medium text-xs transition-all duration-200 shadow-sm active:scale-95"
                        title="Perbarui Profil Klien">
                    <i data-lucide="user-cog" class="w-3.5 h-3.5 text-[#c29b53]"></i>
                    <span>Ubah Data</span>
                </button>
            @endif

            <!-- Divider -->
            <div class="h-5 w-px bg-white/15 hidden sm:block"></div>

            <!-- Logout Button -->
            <form action="{{ route('customer.logout') }}" method="POST" class="inline-block m-0">
                @csrf
                <button type="submit"
                        title="Keluar dari sesi akun Anda"
                        class="group inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-rose-500/15 hover:bg-rose-500 text-rose-300 hover:text-white border border-rose-500/30 hover:border-rose-400 text-xs font-semibold transition-all duration-200 backdrop-blur-sm shadow-sm active:scale-95">
                    <i data-lucide="log-out" class="w-3 h-3 group-hover:translate-x-0.5 transition-transform duration-200"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </div>
</section>

<!-- ========================================================
     CUSTOMER DASHBOARD WORKSPACE (PT MKP Clean Architecture)
========================================================= -->
<div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-14 sm:-mt-16 mb-20 space-y-8">

    <!-- Banner Pemberitahuan: Lengkapi Nomor Telepon (Khusus Login Google / Belum Ada No. HP) -->
    @if(empty($user->phone_number))
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#0d1424] via-[#162136] to-[#0d1424] border border-[#c29b53]/50 p-6 sm:p-7 shadow-2xl">
            <div class="absolute -right-16 -top-16 w-56 h-56 rounded-full bg-[#c29b53]/15 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-[#c29b53]/20 text-[#e4bd68] flex items-center justify-center shrink-0 border border-[#c29b53]/40 shadow-inner mt-0.5">
                        <i data-lucide="phone-forwarded" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-1.5">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-[#c29b53] text-slate-950 shadow-sm">
                                <i data-lucide="sparkles" class="w-3 h-3"></i>
                                Akun Google Terhubung
                            </span>
                            <span class="text-xs text-[#e4bd68] font-semibold">• Data Kontak Belum Lengkap</span>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-white tracking-tight">
                            Tambahkan Nomor Telepon / WhatsApp Anda
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-300 font-light mt-1 max-w-2xl leading-relaxed">
                            Karena Anda masuk menggunakan akun Google (<span class="font-semibold text-white">{{ $user->email }}</span>), data nomor kontak WhatsApp belum terdaftar. Tambahkan sekarang agar tim estimator dan mandor pengawas lapangan ENZO dapat segera berkoordinasi terkait penawaran tender dan survei lokasi.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <button @click="profileModalOpen = true"
                            type="button"
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-[#c29b53] hover:bg-[#ad8741] text-white font-bold text-xs uppercase tracking-wider transition-all duration-200 shadow-xl shadow-black/40 hover:scale-[1.02] active:scale-95">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        <span>Tambahkan Nomor Telepon</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Flash Notifications -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border-2 border-emerald-300 text-emerald-800 text-xs flex items-center gap-2.5 shadow-sm font-semibold">
            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border-2 border-rose-300 text-rose-800 text-xs shadow-sm">
            <div class="font-bold flex items-center gap-1.5 mb-1 text-rose-900">
                <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600"></i>
                <span>Terdapat kendala pada isian:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- KPI Metric Cards Ribbon -->
    <section>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Inquiries -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="text-[11px] text-slate-500 uppercase font-bold tracking-wider">Total Pengajuan</div>
                <div class="font-sans text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">{{ $stats['total'] }}</div>
                <div class="text-[11px] text-slate-500 mt-0.5 font-medium">Tiket Tender Anda</div>
            </div>

            <!-- Active / In Review -->
            <div class="bg-white p-5 rounded-2xl border border-blue-200 shadow-sm hover:shadow-md transition">
                <div class="text-[11px] text-blue-600 uppercase font-bold tracking-wider">Sedang Berjalan</div>
                <div class="font-sans text-2xl sm:text-3xl font-extrabold text-blue-600 mt-1">{{ $stats['active'] }}</div>
                <div class="text-[11px] text-slate-500 mt-0.5 font-medium">Dalam kajian & survey</div>
            </div>

            <!-- Deals -->
            <div class="bg-white p-5 rounded-2xl border border-emerald-200 shadow-sm hover:shadow-md transition">
                <div class="text-[11px] text-emerald-600 uppercase font-bold tracking-wider">Deal Kontrak (SPK)</div>
                <div class="font-sans text-2xl sm:text-3xl font-extrabold text-emerald-600 mt-1">{{ $stats['deals'] }}</div>
                <div class="text-[11px] text-slate-500 mt-0.5 font-medium">Kesepakatan resmi</div>
            </div>

            <!-- Total Budget Portfolio (PT MKP Navy Signature Card) -->
            <div class="bg-[#1a2332] p-5 rounded-2xl border border-[#c29b53]/40 shadow-md hover:shadow-lg transition">
                <div class="text-[11px] text-[#c29b53] uppercase font-bold tracking-wider">Total Plafon Anggaran</div>
                <div class="font-sans text-lg sm:text-xl font-black text-[#c29b53] mt-1 truncate">
                    {{ $stats['total_budget'] > 0 ? 'Rp ' . number_format($stats['total_budget'] / 1000000000, 2) . ' M' : 'Rp 0' }}
                </div>
                <div class="text-[11px] text-slate-300 mt-0.5 font-medium">Rencana investasi</div>
            </div>
        </div>
    </section>

    <!-- Tender History Table & Active Projects -->
    <section>
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200 overflow-hidden shadow-xl">
            
            <div class="p-6 border-b border-slate-200 bg-slate-50/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="font-sans text-lg font-bold text-[#1a2332] uppercase tracking-wide">
                        Riwayat Tender & Proyek Konstruksi Anda
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Daftar lengkap tiket permintaan penawaran (RFP) yang terhubung dengan akun Anda
                    </p>
                </div>
                @if(empty($user->phone_number))
                    <button type="button" @click="profileModalOpen = true"
                       class="inline-flex items-center gap-2 px-4 py-2 bg-[#c29b53] hover:bg-[#ad8741] text-white text-xs font-bold rounded-xl transition shadow-sm">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        <span>Ajukan Tender Baru</span>
                    </button>
                @else
                    <a href="{{ route('rfp.create') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 bg-[#c29b53] hover:bg-[#ad8741] text-white text-xs font-bold rounded-xl transition shadow-sm">
                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                        <span>Ajukan Tender Baru</span>
                    </a>
                @endif
            </div>

            <!-- List of RFPs -->
            @if($rfps->isEmpty())
                <div class="p-12 text-center text-slate-500">
                    <div class="w-16 h-16 rounded-2xl bg-amber-50 text-[#c29b53] border border-amber-200 flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="folder-plus" class="w-8 h-8"></i>
                    </div>
                    <h3 class="font-sans text-base font-bold text-slate-800">Belum Ada Pengajuan Tender</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto mt-1 leading-relaxed">
                        Anda belum memiliki pengajuan penawaran tender aktif. Klik tombol di bawah untuk mengirimkan spesifikasi dan kebutuhan proyek bangunan Anda.
                    </p>
                    @if(empty($user->phone_number))
                        <button type="button" @click="profileModalOpen = true"
                           class="mt-5 inline-flex items-center gap-2 px-5 py-2.5 bg-[#1a2332] hover:bg-[#233044] text-[#c29b53] hover:text-white text-xs font-bold rounded-xl transition shadow-md">
                            <i data-lucide="send" class="w-4 h-4"></i>
                            <span>Kirim Formulir RFP Sekarang</span>
                        </button>
                    @else
                        <a href="{{ route('rfp.create') }}"
                           class="mt-5 inline-flex items-center gap-2 px-5 py-2.5 bg-[#1a2332] hover:bg-[#233044] text-[#c29b53] hover:text-white text-xs font-bold rounded-xl transition shadow-md">
                            <i data-lucide="send" class="w-4 h-4"></i>
                            <span>Kirim Formulir RFP Sekarang</span>
                        </a>
                    @endif
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-700">
                        <thead class="bg-slate-100 text-[11px] uppercase tracking-wider text-slate-700 font-bold border-b border-slate-200">
                            <tr>
                                <th class="py-4 px-4 font-bold">No. Tiket Tender</th>
                                <th class="py-4 px-4 font-bold">Kategori & Lokasi</th>
                                <th class="py-4 px-4 font-bold">Plafon Anggaran</th>
                                <th class="py-4 px-4 font-bold">Status Pipeline</th>
                                <th class="py-4 px-4 font-bold">Progres Fisik</th>
                                <th class="py-4 px-4 font-bold text-right">Aksi Pelacakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($rfps as $rfp)
                                @php
                                    $latestProgress = $rfp->progressLogs->sortByDesc('day_number')->first();
                                @endphp
                                <tr class="hover:bg-slate-50 transition">
                                    <!-- No Tiket -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="font-mono font-bold text-[#c29b53] text-sm">
                                            {{ $rfp->rfp_number }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 mt-0.5">
                                            Diajukan: {{ $rfp->created_at->translatedFormat('d M Y') }}
                                        </div>
                                    </td>

                                    <!-- Kategori & Lokasi -->
                                    <td class="py-4 px-4">
                                        <div class="font-bold text-slate-900">{{ $rfp->project_category }}</div>
                                        <div class="text-[11px] text-slate-500 mt-0.5 flex items-center gap-1">
                                            <i data-lucide="map-pin" class="w-3 h-3 text-slate-400 shrink-0"></i>
                                            <span class="truncate">{{ $rfp->site_location }}</span>
                                        </div>
                                    </td>

                                    <!-- Anggaran & Skema -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <div class="font-bold text-emerald-600">
                                            {{ $rfp->estimated_budget_idr ? 'Rp ' . number_format($rfp->estimated_budget_idr, 0, ',', '.') : 'Belum ditentukan' }}
                                        </div>
                                        <div class="text-[10px] text-slate-500 mt-0.5">
                                            {{ $rfp->payment_scheme_label ?? 'Skema Normal' }}
                                        </div>
                                    </td>

                                    <!-- Status Pipeline -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider
                                            @if($rfp->status === 'deal') bg-emerald-100 text-emerald-800 border border-emerald-300
                                            @elseif($rfp->status === 'survey_scheduled') bg-purple-100 text-purple-800 border border-purple-300
                                            @elseif($rfp->status === 'rab_sent') bg-amber-100 text-amber-800 border border-amber-300
                                            @elseif($rfp->status === 'rejected') bg-slate-200 text-slate-700
                                            @else bg-blue-100 text-blue-800 border border-blue-300 @endif">
                                            {{ $rfp->status_label ?? $rfp->status }}
                                        </span>
                                    </td>

                                    <!-- Progres Mandor Lapangan -->
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        @if($latestProgress)
                                            <div class="flex items-center gap-2">
                                                <div class="w-16 bg-slate-200 rounded-full h-2 overflow-hidden">
                                                    <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ min(100, $latestProgress->progress_percentage) }}%"></div>
                                                </div>
                                                <span class="font-mono font-bold text-slate-800 text-[11px]">{{ $latestProgress->progress_percentage }}%</span>
                                            </div>
                                            <div class="text-[10px] text-slate-500 mt-0.5 truncate max-w-[120px]">
                                                Hari {{ $latestProgress->day_number }}: {{ $latestProgress->stage_name }}
                                            </div>
                                        @else
                                            <span class="text-slate-400 text-[11px] italic">Tahap Persiapan</span>
                                        @endif
                                    </td>

                                    <!-- Action -->
                                    <td class="py-4 px-4 text-right whitespace-nowrap">
                                        <a href="{{ route('rfp.track', ['rfp_number' => $rfp->rfp_number]) }}" target="_blank"
                                           class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-[#1a2332] hover:bg-[#233044] text-[#c29b53] hover:text-white text-xs font-bold transition shadow-sm">
                                            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                            <span>Buka Detail & Jurnal</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </section>

    <!-- Quick Tools & Profile Settings Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Tools Shortcut (2 Cols) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 sm:p-8 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-xl">
                <h3 class="font-sans text-base font-bold text-[#1a2332] uppercase tracking-wider mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <i data-lucide="wrench" class="w-4 h-4 text-[#c29b53]"></i>
                    <span>Layanan Cepat Untuk Klien</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                    <!-- Calculator -->
                    <a href="{{ route('estimator.index') }}"
                       class="p-4 rounded-2xl bg-slate-50 border border-slate-200 hover:border-[#c29b53] hover:shadow-md transition flex flex-col justify-between group">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-[#c29b53] border border-amber-200 flex items-center justify-center mb-3 group-hover:scale-105 transition">
                                <i data-lucide="calculator" class="w-5 h-5"></i>
                            </div>
                            <h4 class="font-bold text-slate-900">Kalkulator RAB</h4>
                            <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                                Simulasi estimasi biaya konstruksi per m² sesuai tipe hunian Anda.
                            </p>
                        </div>
                        <span class="text-[#c29b53] font-bold mt-4 inline-flex items-center gap-1 text-[11px]">
                            Hitung Sekarang &rarr;
                        </span>
                    </a>

                    <!-- Designs -->
                    <a href="{{ route('layouts.index') }}"
                       class="p-4 rounded-2xl bg-slate-50 border border-slate-200 hover:border-[#c29b53] hover:shadow-md transition flex flex-col justify-between group">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-[#c29b53] border border-amber-200 flex items-center justify-center mb-3 group-hover:scale-105 transition">
                                <i data-lucide="layout" class="w-5 h-5"></i>
                            </div>
                            <h4 class="font-bold text-slate-900">Katalog Denah</h4>
                            <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                                Jelajahi tata letak arsitektur siap bangun dengan 3D rendering.
                            </p>
                        </div>
                        <span class="text-[#c29b53] font-bold mt-4 inline-flex items-center gap-1 text-[11px]">
                            Pilih Denah &rarr;
                        </span>
                    </a>

                    <!-- Specs -->
                    <a href="{{ route('specifications.index') }}"
                       class="p-4 rounded-2xl bg-slate-50 border border-slate-200 hover:border-[#c29b53] hover:shadow-md transition flex flex-col justify-between group">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-[#c29b53] border border-amber-200 flex items-center justify-center mb-3 group-hover:scale-105 transition">
                                <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                            </div>
                            <h4 class="font-bold text-slate-900">Spesifikasi Material</h4>
                            <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                                Transparansi matriks mutu material struktur, lantai, dan atap.
                            </p>
                        </div>
                        <span class="text-[#c29b53] font-bold mt-4 inline-flex items-center gap-1 text-[11px]">
                            Bandingkan &rarr;
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Update Profile Form (1 Col) -->
        <div>
            <div class="bg-white p-6 sm:p-8 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-xl text-xs">
                <h3 class="font-sans text-base font-bold text-[#1a2332] uppercase tracking-wider mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <i data-lucide="user-cog" class="w-4 h-4 text-[#c29b53]"></i>
                    <span>Perbarui Data Kontak Klien</span>
                </h3>

                <form action="{{ route('customer.profile.update') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1">
                            Nama Lengkap
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-slate-800 font-medium focus:bg-white focus:outline-none focus:border-[#c29b53]">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1">
                            Nomor WhatsApp / Telepon <span class="text-rose-500">*</span>
                        </label>
                        <input type="tel" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required
                               placeholder="081234567890"
                               inputmode="numeric"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-slate-800 font-medium focus:bg-white focus:outline-none focus:border-[#c29b53]">
                        <p class="text-[11px] text-slate-500 mt-1">Cukup angka saja tanpa tanda hubung (-)</p>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1">
                            Perusahaan / Instansi (Opsional)
                        </label>
                        <input type="text" name="company_name" value="{{ old('company_name', $user->company_name) }}"
                               placeholder="PT / Instansi"
                               class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-slate-800 font-medium focus:bg-white focus:outline-none focus:border-[#c29b53]">
                    </div>

                    <div class="pt-3 border-t border-slate-100">
                        <span class="text-[11px] font-bold text-slate-700 block mb-1">Ganti Kata Sandi (Kosongkan jika tidak diubah):</span>
                        <p class="text-[10px] text-slate-500 mb-2 font-normal leading-relaxed">
                            Pembaruan kata sandi dapat dikonfirmasi dengan <strong>kode verifikasi 6 digit</strong> yang dikirim ke email Anda, atau menggunakan kata sandi saat ini.
                        </p>

                        <!-- Box Minta Kode Verifikasi Email -->
                        <div class="mb-3 p-3 rounded-xl bg-amber-50/70 border border-amber-200 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2">
                                <i data-lucide="shield-alert" class="w-4 h-4 text-amber-600 shrink-0"></i>
                                <div>
                                    <span class="font-bold text-amber-900 block text-[11px]">Butuh Kode Verifikasi?</span>
                                    <span class="text-[10px] text-amber-700">Kirim 6-digit OTP ke {{ $user->email }}</span>
                                </div>
                            </div>
                            <button type="submit" form="form-send-code"
                                    class="px-3 py-1.5 bg-[#1a2332] hover:bg-[#233044] text-[#c29b53] hover:text-white font-bold text-[10px] uppercase tracking-wider rounded-lg border border-[#c29b53]/40 transition shadow-sm whitespace-nowrap">
                                Kirim Kode OTP
                            </button>
                        </div>
                        
                        <div class="space-y-2">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-600 mb-0.5">Kode OTP Email (6 digit):</label>
                                    <input type="text" name="verification_code" placeholder="Contoh: 123456" maxlength="6" inputmode="numeric"
                                           class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2 text-slate-800 font-mono tracking-widest text-xs focus:bg-white focus:outline-none focus:border-[#c29b53]">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-600 mb-0.5">Atau Kata Sandi Saat Ini:</label>
                                    <input type="password" name="current_password" placeholder="Kata sandi saat ini"
                                           class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#c29b53]">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 mb-0.5">Kata Sandi Baru:</label>
                                <input type="password" name="new_password" placeholder="Kata sandi baru (min 8 char, angka & simbol)"
                                       class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#c29b53]">
                            </div>
                            
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 mb-0.5">Konfirmasi Kata Sandi Baru:</label>
                                <input type="password" name="new_password_confirmation" placeholder="Ulangi kata sandi baru"
                                       class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2 text-slate-800 text-xs focus:bg-white focus:outline-none focus:border-[#c29b53]">
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full mt-2 py-3 bg-[#1a2332] hover:bg-[#233044] text-[#c29b53] hover:text-white font-bold rounded-xl transition shadow-md">
                        Simpan Perubahan Profil
                    </button>
                </form>

                <form id="form-send-code" action="{{ route('customer.password.send-code') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>

    </div>

</div>

<!-- Modal: Lengkapi / Perbarui Data Profil & Kontak (Khusus Google Login & Klien) -->
<div x-show="profileModalOpen"
     x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4">
    
    <div @click.away="profileModalOpen = false"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden text-slate-800 my-8">
        
        <!-- Modal Header (Navy Luxury) -->
        <div class="bg-[#0f172a] px-6 py-5 text-white flex items-center justify-between border-b border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#c29b53]/20 text-[#e4bd68] flex items-center justify-center border border-[#c29b53]/40">
                    <i data-lucide="user-check" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-white tracking-wide">
                        {{ empty($user->phone_number) ? 'Lengkapi Nomor Telepon / WhatsApp' : 'Perbarui Profil Klien' }}
                    </h3>
                    <p class="text-[11px] text-slate-300 font-light">
                        Data penting untuk koordinasi tender proyek & opname mandor
                    </p>
                </div>
            </div>
            <button @click="profileModalOpen = false" type="button" class="text-slate-400 hover:text-white p-1 rounded-lg transition">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Modal Form Body -->
        <form action="{{ route('customer.profile.update') }}" method="POST" class="p-6 sm:p-8 space-y-4 text-xs">
            @csrf

            <!-- Nama Lengkap -->
            <div>
                <label for="modal_name" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">
                    Nama Lengkap Penanggung Jawab / Klien <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="user" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="name" id="modal_name" required
                           value="{{ old('name', $user->name) }}"
                           placeholder="Contoh: Hendro Kusumo"
                           class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs font-medium focus:bg-white focus:outline-none focus:border-[#c29b53] focus:ring-1 focus:ring-[#c29b53] transition">
                </div>
            </div>

            <!-- Email (Readonly / Locked) -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block font-bold text-slate-700 uppercase tracking-wider text-[11px]">
                        Alamat Email Terdaftar
                    </label>
                    <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-[#c29b53]">
                        <i data-lucide="shield-check" class="w-3 h-3 text-emerald-500"></i>
                        {{ !empty($user->google_id) ? 'Akun Google Resmi' : 'Email Terdaftar' }}
                    </span>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                    </div>
                    <input type="email" disabled
                           value="{{ $user->email }}"
                           class="w-full pl-10 pr-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-slate-500 text-xs font-medium cursor-not-allowed select-none">
                </div>
                <p class="text-[10px] text-slate-400 mt-1">Alamat email terikat dengan akun masuk Anda.</p>
            </div>

            <!-- Nomor Telepon / WhatsApp (Crucial for Google Users) -->
            <div>
                <label for="modal_phone" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">
                    Nomor WhatsApp / HP Aktif <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="phone" class="w-4 h-4"></i>
                    </div>
                    <input type="tel" name="phone_number" id="modal_phone" required
                           value="{{ old('phone_number', $user->phone_number) }}"
                           placeholder="Contoh: 081234567890"
                           inputmode="numeric"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs font-medium focus:bg-white focus:outline-none focus:border-[#c29b53] focus:ring-1 focus:ring-[#c29b53] transition">
                </div>
                <p class="text-[11px] text-slate-500 mt-1">Digunakan tim estimator dan pengawas mandor ENZO untuk koordinasi tender & survei lokasi.</p>
            </div>

            <!-- Nama Perusahaan / Instansi (Opsional) -->
            <div>
                <label for="modal_company" class="block font-bold text-slate-700 uppercase tracking-wider text-[11px] mb-1.5">
                    Nama Perusahaan / Instansi <span class="text-slate-400 font-normal">(Opsional)</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="building" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="company_name" id="modal_company"
                           value="{{ old('company_name', $user->company_name) }}"
                           placeholder="Contoh: PT Megah Perkasa Abadi (kosongkan jika pribadi)"
                           class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs font-medium focus:bg-white focus:outline-none focus:border-[#c29b53] focus:ring-1 focus:ring-[#c29b53] transition">
                </div>
                <p class="text-[11px] text-slate-500 mt-1">Kosongkan jika pembangunan hunian pribadi perorangan.</p>
            </div>

            <!-- Footer Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <button @click="profileModalOpen = false" type="button"
                        class="px-4 py-2.5 rounded-xl border border-slate-300 text-slate-600 hover:text-slate-800 text-xs font-semibold transition">
                    Batal
                </button>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#1a2332] hover:bg-[#233044] text-[#c29b53] hover:text-white border border-[#c29b53]/40 text-xs font-bold uppercase tracking-wider transition shadow-lg">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>Simpan Data Profil</span>
                </button>
            </div>
        </form>
    </div>
</div>

</div>

@endsection
