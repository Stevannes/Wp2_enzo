<?php

namespace Database\Seeders;

use App\Models\ConstructionProgressLog;
use App\Models\DesignLayout;
use App\Models\InquiryRfp;
use App\Models\Project;
use App\Models\ProjectComplaint;
use App\Models\RfpNegotiationLog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EvaluationFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Mengisi data pembuktian seluruh 10 poin evaluasi dosen.
     */
    public function run(): void
    {
        // 1. Staff Users untuk Fitur Penugasan Staf (Poin 5)
        $estimator = User::firstOrCreate(
            ['email' => 'estimator.budi@enzocontractor.com'],
            [
                'name' => 'Ir. Budi Santoso, M.T. (Lead Estimator)',
                'password' => Hash::make('password123'),
                'role' => 'estimator',
            ]
        );

        $projectManager = User::firstOrCreate(
            ['email' => 'pm.hendra@enzocontractor.com'],
            [
                'name' => 'Hendra Kusuma, S.T. (Project Manager Lapangan)',
                'password' => Hash::make('password123'),
                'role' => 'project_manager',
            ]
        );

        // 2. Katalog Referensi Desain & Pemilihan Tata Letak (Poin 2)
        $layouts = [
            [
                'name' => 'Enzo Prime 45 — Urban Minimalist',
                'slug' => 'enzo-prime-45',
                'category' => 'minimalis',
                'building_type' => 'Type 45/90',
                'land_size_sqm' => 90,
                'building_size_sqm' => 45,
                'floor_count' => 1,
                'bedrooms' => 2,
                'bathrooms' => 1,
                'carport_capacity' => 1,
                'layout_plan_image' => 'images/wallpaper_calculator_hd.jpg',
                'render_3d_image' => 'images/project_residential.jpg',
                'estimated_price_idr' => 225000000,
                'specifications_summary' => 'Pondasi batu kali & cakar ayam, dinding hebel plester aci finishing Dulux, granit tile 60x60, atap baja ringan galvalum C75, genteng metal berpasir, sanitair Toto SNI, carport rabat beton sikat.',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Enzo Scandinavian 70 — Split Level Horizon',
                'slug' => 'enzo-scandinavian-70',
                'category' => 'skandinavia',
                'building_type' => 'Type 70/120',
                'land_size_sqm' => 120,
                'building_size_sqm' => 70,
                'floor_count' => 2,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'carport_capacity' => 1,
                'layout_plan_image' => 'images/wallpaper_calculator_hd.jpg',
                'render_3d_image' => 'images/hero_architecture.jpg',
                'estimated_price_idr' => 385000000,
                'specifications_summary' => 'Struktur beton bertulang K-275, lantai 2 mezanin kayu ulin & granit 60x60, plafon gypsum shadowline, atap miring spandek insulasi peredam panas, kanopi solar tuff carport, instalasi PDAM & tandon air 1.000 L.',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Enzo Contemporary 120 — Double Story Executive',
                'slug' => 'enzo-contemporary-120',
                'category' => 'industrial',
                'building_type' => 'Type 120/150',
                'land_size_sqm' => 150,
                'building_size_sqm' => 120,
                'floor_count' => 2,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'carport_capacity' => 2,
                'layout_plan_image' => 'images/wallpaper_calculator_hd.jpg',
                'render_3d_image' => 'images/project_commercial.jpg',
                'estimated_price_idr' => 720000000,
                'specifications_summary' => 'Pondasi footplat plat beton bertulang K-300, marmer lokal area ruang tamu, granit 80x80 kamar utama, kusen aluminium Alexindo powder coating hitam, genteng flat beton Monier, smart lock system & instalasi water heater.',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Enzo Pavilion Tropical Resort Villa',
                'slug' => 'enzo-pavilion-villa',
                'category' => 'tropis_modern',
                'building_type' => 'Villa Tropis 210/300',
                'land_size_sqm' => 300,
                'building_size_sqm' => 210,
                'floor_count' => 2,
                'bedrooms' => 4,
                'bathrooms' => 4,
                'carport_capacity' => 2,
                'layout_plan_image' => 'images/wallpaper_calculator_hd.jpg',
                'render_3d_image' => 'images/wallpaper_projects_hd.jpg',
                'estimated_price_idr' => 1470000000,
                'specifications_summary' => 'Konsep paviliun terbuka dengan kolam renang refleksi, marmer import slab, dinding batu alam andesit & kisi-kisi kayu ulin, kaca double glass acoustic, sanitair Kohler, instalasi bio-septic tank ramah lingkungan.',
                'is_featured' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($layouts as $lData) {
            DesignLayout::updateOrCreate(['slug' => $lData['slug']], $lData);
        }

        // 3. Update Existing RFP Data dengan Penugasan & Skema Pembayaran
        $rfps = InquiryRfp::all();
        $sampleLayout = DesignLayout::first();

        if ($rfps->isNotEmpty()) {
            // Tiket 1: Baru Masuk & Butuh Pengingat Admin (Poin 4)
            $rfp1 = $rfps->first();
            $rfp1->update([
                'design_layout_id' => $sampleLayout->id,
                'payment_scheme' => 'cash_tempo',
                'assigned_to_user_id' => $estimator->id,
                'admin_last_viewed_at' => null, // Belum dilihat -> Trigger Reminder!
                'reminder_count' => 2,
                'last_reminder_at' => now()->subHours(8),
            ]);

            // Tiket 2: Sedang Evaluasi & Negosiasi Harga (Poin 5)
            if ($rfps->count() >= 2) {
                $rfp2 = $rfps->get(1);
                $rfp2->update([
                    'payment_scheme' => 'kpr_bank',
                    'assigned_to_user_id' => $estimator->id,
                    'admin_last_viewed_at' => now()->subHours(2),
                    'status' => 'in_review',
                ]);

                // Riwayat Negosiasi (Poin 5)
                RfpNegotiationLog::firstOrCreate(
                    ['inquiry_rfp_id' => $rfp2->id, 'stage' => 'initial_proposal'],
                    [
                        'user_id' => $estimator->id,
                        'proposed_amount_idr' => 850000000,
                        'client_notes' => 'Klien meminta penyesuaian plafon anggaran menjadi di bawah 800 Juta dengan efisiensi material finishing.',
                        'admin_response' => 'Estimator menawarkan subtitusi marmer lantai ke granit tile 80x80 dan rangka atap baja ringan galvalum tebal 0.75mm.',
                    ]
                );

                RfpNegotiationLog::firstOrCreate(
                    ['inquiry_rfp_id' => $rfp2->id, 'stage' => 'price_negotiation'],
                    [
                        'user_id' => $estimator->id,
                        'proposed_amount_idr' => 785000000,
                        'client_notes' => 'Klien menyetujui efisiensi material lantai dan meminta simulasi cicilan KPR bank rekanan.',
                        'admin_response' => 'Penawaran disepakati pada angka Rp 785.000.000 dengan skema KPR Indent Konstruksi Bank Mandiri DP 20%.',
                    ]
                );
            }

            // Tiket 3: Proyek Sedang Berjalan & Progress Tracking Mandor (Poin 7)
            if ($rfps->count() >= 3) {
                $rfp3 = $rfps->get(2);
                $rfp3->update([
                    'status' => 'deal',
                    'payment_scheme' => 'cash_tempo',
                    'deal_amount_idr' => 1250000000,
                    'deal_date' => now()->subDays(45),
                    'assigned_to_user_id' => $projectManager->id,
                    'admin_last_viewed_at' => now()->subDay(),
                ]);

                // Jurnal Harian Mandor (Poin 7: Visual Pembanding Render vs Nyata)
                ConstructionProgressLog::firstOrCreate(
                    ['inquiry_rfp_id' => $rfp3->id, 'day_number' => 1],
                    [
                        'log_date' => now()->subDays(45),
                        'stage_name' => 'Hari ke-1: Pembersihan Lahan & Pemasangan Bouwplank',
                        'description' => 'Pembersihan semak dan perataan tanah selesai. Pengukuran presisi elevasi peil lantai dasar (+0.60 m) menggunakan theodolite digital, dilanjutkan pemasangan patok bouwplank kayu.',
                        'promised_render_image' => 'images/wallpaper_calculator_hd.jpg',
                        'actual_field_photo' => 'images/before_renovation.jpg',
                        'progress_percentage' => 8.50,
                        'logged_by_name' => 'Mandor Supardi (Pengawas Lapangan)',
                    ]
                );

                ConstructionProgressLog::firstOrCreate(
                    ['inquiry_rfp_id' => $rfp3->id, 'day_number' => 15],
                    [
                        'log_date' => now()->subDays(30),
                        'stage_name' => 'Hari ke-15: Penggalian Footplat & Pengecoran Sloof K-275',
                        'description' => 'Penggalian pondasi cakar ayam sedalam 1.8 meter selesai 100%. Pengecoran beton bertulang sloof balok bawah menggunakan ready-mix K-275 telah melalui uji slump test 12±2 cm.',
                        'promised_render_image' => 'images/hero_architecture.jpg',
                        'actual_field_photo' => 'images/wallpaper_rfp_hd.jpg',
                        'progress_percentage' => 32.00,
                        'logged_by_name' => 'Mandor Supardi (Pengawas Lapangan)',
                    ]
                );

                ConstructionProgressLog::firstOrCreate(
                    ['inquiry_rfp_id' => $rfp3->id, 'day_number' => 35],
                    [
                        'log_date' => now()->subDays(10),
                        'stage_name' => 'Hari ke-35: Pengecoran Plat Lantai 2 & Kolom Struktur',
                        'description' => 'Perakitan bekisting bondek dan pembesian plat lantai 2 tuntas. Pengecoran monolithic balok dan plat lantai 2 menggunakan concrete pump lancar tanpa cacat rongga udara.',
                        'promised_render_image' => 'images/wallpaper_projects_hd.jpg',
                        'actual_field_photo' => 'images/project_commercial.jpg',
                        'progress_percentage' => 64.50,
                        'logged_by_name' => 'Hendra Kusuma, S.T. (Project Manager)',
                    ]
                );

                // Fitur Komplain Pelanggan (Poin 8)
                ProjectComplaint::firstOrCreate(
                    ['complaint_ticket' => 'CMP-2610-001'],
                    [
                        'inquiry_rfp_id' => $rfp3->id,
                        'category' => 'posisi_sanitasi_wc',
                        'title' => 'Penyesuaian Posisi Kran Wastafel Kamar Mandi Utama',
                        'description' => 'Pipa inlet air kran wastafel pada master bedroom sedikit bergeser 15 cm dari gambar kerja awal denah arsitektur. Mohon disesuaikan sebelum dinding dipasang granit tile.',
                        'photo_proof' => 'images/project_interior.jpg',
                        'urgency' => 'medium',
                        'status' => 'repair_in_progress',
                        'admin_solution_notes' => 'Tim pipa MEP telah diperintahkan membongkar jalur inlet 15 cm ke arah kiri sesuai koordinat DED. Perbaikan dijadwalkan selesai dalam 1 hari kerja sebelum plesteran.',
                    ]
                );
            }
        }

        // 4. Update Projects dengan Kebijakan Privasi Data Hunian (Poin 10)
        Project::where('project_type', 'residential')->update([
            'is_residential' => true,
            'client_privacy_consented' => false, // Default: Alamat dan identitas disamarkan demi privasi!
        ]);

        Project::where('project_type', '!=', 'residential')->update([
            'is_residential' => false,
            'client_privacy_consented' => true, // Properti komersial/kantor publik
        ]);
    }
}
