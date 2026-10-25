<?php

namespace Database\Seeders;

use App\Models\InquiryRfp;
use App\Models\RfpAttachment;
use Illuminate\Database\Seeder;

class InquiryRfpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rfp1 = InquiryRfp::create([
            'rfp_number' => 'RFP-2610-001',
            'full_name' => 'Ir. Budi Santoso, M.T.',
            'company_name' => 'PT Graha Mega Persada',
            'email' => 'budi@graha-megapersada.co.id',
            'phone_number' => '081234567890',
            'project_category' => 'Industri & Pergudangan Baja',
            'site_location' => 'Kawasan Industri KIIC, Karawang Barat',
            'estimated_budget_idr' => 12000000000,
            'planned_area_sqm' => 2400,
            'project_notes' => 'Pembangunan gudang logistik rangka baja WF bentang 32 meter bebas kolom, lantai cor hardener kapasitas beban 5 ton/m2.',
            'source_channel' => 'website',
            'status' => 'submitted',
            'internal_admin_notes' => 'Tender masuk via portal web. Menunggu evaluasi kelengkapan gambar CAD.',
        ]);

        RfpAttachment::create([
            'inquiry_rfp_id' => $rfp1->id,
            'original_filename' => 'TOR_Pabrik_Karawang_Rev02.pdf',
            'file_path' => 'rfp_attachments/sample_tor.pdf',
            'file_type' => 'pdf',
            'file_size_bytes' => 4404019,
        ]);

        $rfp2 = InquiryRfp::create([
            'rfp_number' => 'RFP-2610-002',
            'full_name' => 'Ibu Clarissa Tan',
            'company_name' => 'Private Residence',
            'email' => 'clarissa.tan@gmail.com',
            'phone_number' => '081899887766',
            'project_category' => 'Residensial & Design-and-Build',
            'site_location' => 'Pantai Indah Kapuk (PIK) 2, Jakarta Utara',
            'estimated_budget_idr' => 5500000000,
            'planned_area_sqm' => 650,
            'project_notes' => 'Desain rumah mewah 3 lantai dengan mezzanine, kolam renang overflow, fasad travertine, dan instalasi smart home.',
            'source_channel' => 'calculator',
            'status' => 'survey_scheduled',
            'internal_admin_notes' => 'Sudah ditelepon oleh Pak Ahmad. Survey lokasi disepakati hari Sabtu jam 10.00 WIB bersama arsitek.',
        ]);

        $rfp3 = InquiryRfp::create([
            'rfp_number' => 'RFP-2610-003',
            'full_name' => 'Hendra Saputra',
            'company_name' => 'PT Nusantara Medika Gemilang',
            'email' => 'hendra@nusantaragroup.com',
            'phone_number' => '081122334455',
            'project_category' => 'Konstruksi Komersial & Perkantoran',
            'site_location' => 'Kawasan Bisnis Sudirman, Jakarta Pusat',
            'estimated_budget_idr' => 24500000000,
            'planned_area_sqm' => 3500,
            'project_notes' => 'Pembangunan gedung klinik & kantor 6 lantai dengan fasilitas basement parkir dan elevator bed medis.',
            'source_channel' => 'website',
            'status' => 'rab_sent',
            'internal_admin_notes' => 'Proposal teknis dan RAB BOQ Final telah dikirimkan via email dan kurir fisik.',
        ]);

        $rfp4 = InquiryRfp::create([
            'rfp_number' => 'RFP-2610-004',
            'full_name' => 'Ahmad Fauzan',
            'company_name' => 'CV Berkah Logistik Khatulistiwa',
            'email' => 'fauzan@berkahlogistik.id',
            'phone_number' => '085266778899',
            'project_category' => 'Industri & Pergudangan Baja',
            'site_location' => 'Kubu Raya, Pontianak, Kalimantan Barat',
            'estimated_budget_idr' => 3800000000,
            'planned_area_sqm' => 1200,
            'project_notes' => 'Gudang distribusi baja tahap 2 dengan fasilitas kantor operasional 2 lantai.',
            'source_channel' => 'referral',
            'status' => 'deal',
            'internal_admin_notes' => 'SPK ditandatangani. Uang muka 20% telah diterima. Mobilisasi alat berat dimulai minggu depan.',
        ]);
    }
}
