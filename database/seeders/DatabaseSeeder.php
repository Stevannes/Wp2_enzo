<?php

namespace Database\Seeders;

use App\Models\CostEstimatorRate;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin Enzo',
            'email' => 'enzo.ng7786@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Site Settings
        $settings = [
            ['setting_key' => 'company_name', 'setting_value' => 'Enzo Contractor', 'group' => 'company'],
            ['setting_key' => 'company_tagline', 'setting_value' => 'Build With Trust & Quality', 'group' => 'company'],
            ['setting_key' => 'company_description', 'setting_value' => 'Building Construction and Interior', 'group' => 'company'],
            ['setting_key' => 'company_vision', 'setting_value' => 'Menjadi perusahaan konstruksi terdepan yang inovatif, berorientasi pada keberlanjutan, serta memberikan solusi pembangunan berkualitas tinggi dengan mengutamakan kepuasan klien.', 'group' => 'company'],
            ['setting_key' => 'address', 'setting_value' => 'Jalan Karya Baru No. 56A, Parit Tokaya, Kec. Pontianak Selatan, 78115', 'group' => 'contact'],
            ['setting_key' => 'phone', 'setting_value' => '0813-4859-3725', 'group' => 'contact'],
            ['setting_key' => 'email', 'setting_value' => 'enzo.ng7786@gmail.com', 'group' => 'contact'],
            ['setting_key' => 'whatsapp', 'setting_value' => '6281348593725', 'group' => 'contact'],
            ['setting_key' => 'instagram', 'setting_value' => '@enzocontractor', 'group' => 'social_media'],
            ['setting_key' => 'instagram_url', 'setting_value' => 'https://www.instagram.com/enzocontractor', 'group' => 'social_media'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::create($setting);
        }

        // Services
        $services = [
            [
                'name' => 'Konstruksi Komersial & Perkantoran',
                'slug' => 'konstruksi-komersial',
                'icon' => 'building',
                'short_description' => 'Gedung, Ruko, Rumah Sakit, dan fasilitas komersial lainnya.',
                'full_description' => 'Enzo Contractor berpengalaman dalam pembangunan gedung perkantoran, ruko, pusat perbelanjaan, dan fasilitas komersial lainnya dengan standar kualitas tinggi dan ketepatan waktu yang menjadi prioritas utama kami.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Residensial & Design-and-Build',
                'slug' => 'residensial-design-build',
                'icon' => 'home',
                'short_description' => 'Rumah Mewah, Vila, Townhouse dari konsep hingga kunci serah.',
                'full_description' => 'Layanan terintegrasi dari desain arsitektur hingga konstruksi tuntas. Kami membangun hunian impian Anda — mulai dari rumah mewah, vila, hingga townhouse dengan sentuhan desain modern dan material premium.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Industri & Pergudangan',
                'slug' => 'industri-pergudangan',
                'icon' => 'warehouse',
                'short_description' => 'Gudang Rangka Baja, Pabrik, dan fasilitas industri.',
                'full_description' => 'Solusi konstruksi industri mencakup pembangunan gudang, pabrik, dan fasilitas industri lainnya dengan struktur baja berkualitas tinggi, dirancang untuk efisiensi dan daya tahan jangka panjang.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Renovasi & Interior Fit-Out',
                'slug' => 'renovasi-interior',
                'icon' => 'paintbrush',
                'short_description' => 'Peremajaan Fasad, Interior Kantor, Hotel, dan area komersial.',
                'full_description' => 'Transformasi ruang Anda dengan layanan renovasi menyeluruh dan interior fit-out profesional. Dari peremajaan fasad bangunan hingga desain interior kantor, hotel, dan area komersial.',
                'sort_order' => 4,
            ],
            [
                'name' => 'Pekerjaan Sipil & Infrastruktur',
                'slug' => 'pekerjaan-sipil',
                'icon' => 'road',
                'short_description' => 'Jalan, Drainase, Perataan Tanah, dan infrastruktur umum.',
                'full_description' => 'Layanan pekerjaan sipil dan infrastruktur mencakup pembangunan jalan, sistem drainase, perataan tanah, dan proyek infrastruktur lainnya dengan peralatan modern dan tenaga ahli berpengalaman.',
                'sort_order' => 5,
            ],
            [
                'name' => 'Interior dan Eksterior',
                'slug' => 'interior-eksterior',
                'icon' => 'palette',
                'short_description' => 'Desain dan pengerjaan interior serta eksterior bangunan.',
                'full_description' => 'Layanan desain dan pengerjaan interior serta eksterior bangunan yang menyeluruh, menciptakan ruang yang estetis, fungsional, dan sesuai dengan kebutuhan dan gaya hidup Anda.',
                'sort_order' => 6,
            ],
        ];

        foreach ($services as $serviceData) {
            Service::create($serviceData);
        }

        // Sample Projects
        $projects = [
            [
                'service_id' => 1,
                'title' => 'Gedung Kantor Modern Pontianak',
                'slug' => 'gedung-kantor-modern-pontianak',
                'client_name' => 'PT Mitra Sejahtera',
                'project_type' => 'commercial',
                'location' => 'Pontianak, Kalimantan Barat',
                'building_area_sqm' => 850,
                'completion_year' => 2025,
                'duration' => '10 Bulan',
                'status' => 'completed',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'service_id' => 2,
                'title' => 'Rumah Mewah Minimalis Parit Tokaya',
                'slug' => 'rumah-mewah-minimalis-parit-tokaya',
                'client_name' => 'Bapak Hendri',
                'project_type' => 'residential',
                'location' => 'Pontianak Selatan',
                'building_area_sqm' => 320,
                'land_area_sqm' => 400,
                'completion_year' => 2026,
                'duration' => '8 Bulan',
                'status' => 'completed',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'service_id' => 3,
                'title' => 'Gudang Logistik Kubu Raya',
                'slug' => 'gudang-logistik-kubu-raya',
                'client_name' => 'CV Berkah Logistik',
                'project_type' => 'industrial',
                'location' => 'Kubu Raya, Kalimantan Barat',
                'building_area_sqm' => 1200,
                'completion_year' => 2025,
                'duration' => '6 Bulan',
                'status' => 'completed',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'service_id' => 4,
                'title' => 'Renovasi Interior Kafe & Restoran',
                'slug' => 'renovasi-interior-kafe-restoran',
                'client_name' => 'Kafe Nusantara',
                'project_type' => 'commercial',
                'location' => 'Pontianak Kota',
                'building_area_sqm' => 180,
                'completion_year' => 2026,
                'duration' => '3 Bulan',
                'status' => 'completed',
                'is_featured' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($projects as $projectData) {
            $p = Project::create($projectData);
            if ($p->id === 1) {
                ProjectImage::create([
                    'project_id' => $p->id,
                    'image_path' => 'images/project_commercial.jpg',
                    'caption' => 'Fasad Modern Komersial Pontianak',
                    'type' => 'gallery',
                    'sort_order' => 1,
                ]);
            } elseif ($p->id === 2) {
                ProjectImage::create([
                    'project_id' => $p->id,
                    'image_path' => 'images/project_residential.jpg',
                    'caption' => 'Hunian Tropis Mewah Parit Tokaya',
                    'type' => 'gallery',
                    'sort_order' => 1,
                ]);
            } elseif ($p->id === 3) {
                ProjectImage::create([
                    'project_id' => $p->id,
                    'image_path' => 'images/project_industrial.jpg',
                    'caption' => 'Struktur Baja Gudang Logistik',
                    'type' => 'gallery',
                    'sort_order' => 1,
                ]);
            } elseif ($p->id === 4) {
                ProjectImage::create([
                    'project_id' => $p->id,
                    'image_path' => 'images/project_interior.jpg',
                    'caption' => 'Interior Fit-Out Modern',
                    'type' => 'gallery',
                    'sort_order' => 1,
                ]);
                ProjectImage::create([
                    'project_id' => $p->id,
                    'image_path' => 'images/before_renovation.jpg',
                    'caption' => 'Kondisi Awal Bangunan Sebelum Renovasi',
                    'type' => 'before',
                    'sort_order' => 2,
                ]);
                ProjectImage::create([
                    'project_id' => $p->id,
                    'image_path' => 'images/after_renovation.jpg',
                    'caption' => 'Hasil Revitalisasi Fasad Arsitektural Modern Enzo',
                    'type' => 'after',
                    'sort_order' => 3,
                ]);
            }
        }

        // Testimonials
        $testimonials = [
            [
                'project_id' => 1,
                'client_name' => 'Budi Santoso',
                'client_role' => 'Direktur',
                'company_name' => 'PT Mitra Sejahtera',
                'testimonial_text' => 'Enzo Contractor menyelesaikan proyek gedung kantor kami tepat waktu dengan kualitas yang sangat memuaskan. Tim mereka profesional dan komunikatif. Sangat merekomendasikan!',
                'rating' => 5,
                'is_approved' => true,
            ],
            [
                'project_id' => 2,
                'client_name' => 'Hendri Wijaya',
                'client_role' => 'Pemilik Rumah',
                'company_name' => null,
                'testimonial_text' => 'Rumah impian kami terwujud berkat Enzo Contractor. Detail pekerjaannya rapi, materialnya berkualitas, dan hasilnya melebihi ekspektasi kami. Terima kasih Enzo!',
                'rating' => 5,
                'is_approved' => true,
            ],
            [
                'project_id' => 3,
                'client_name' => 'Andi Pratama',
                'client_role' => 'Manajer Operasional',
                'company_name' => 'CV Berkah Logistik',
                'testimonial_text' => 'Pembangunan gudang kami berjalan lancar dan sesuai jadwal. Struktur baja yang digunakan sangat kokoh. Enzo Contractor memahami kebutuhan industri dengan baik.',
                'rating' => 5,
                'is_approved' => true,
            ],
        ];

        foreach ($testimonials as $testimonialData) {
            Testimonial::create($testimonialData);
        }

        // Cost Estimator Rates
        $rates = [
            ['building_type' => 'residential_standard', 'finish_grade' => 'standard', 'base_price_per_sqm' => 3500000, 'multi_floor_multiplier' => 1.15, 'specification_details' => 'Pondasi batu kali, dinding bata merah plester aci, atap baja ringan, lantai keramik 40x40, cat ekonomis.'],
            ['building_type' => 'residential_standard', 'finish_grade' => 'premium', 'base_price_per_sqm' => 5000000, 'multi_floor_multiplier' => 1.15, 'specification_details' => 'Pondasi cakar ayam, dinding bata ringan, atap baja ringan genteng flat, lantai granit 60x60, cat premium.'],
            ['building_type' => 'residential_luxury', 'finish_grade' => 'luxury', 'base_price_per_sqm' => 8000000, 'multi_floor_multiplier' => 1.20, 'specification_details' => 'Pondasi bore pile, dinding ALC, atap dak beton, lantai marmer import, cat Dulux Weathershield, smart home system.'],
            ['building_type' => 'warehouse', 'finish_grade' => 'standard', 'base_price_per_sqm' => 2500000, 'multi_floor_multiplier' => 1.10, 'specification_details' => 'Struktur baja WF, dinding zincalume, atap spandek, lantai cor beton hardener, pintu rolling door.'],
            ['building_type' => 'office', 'finish_grade' => 'premium', 'base_price_per_sqm' => 6000000, 'multi_floor_multiplier' => 1.18, 'specification_details' => 'Struktur beton bertulang, dinding partisi gypsum & kaca tempered, raised floor, plafon akustik, MEP lengkap.'],
            ['building_type' => 'shophouse', 'finish_grade' => 'standard', 'base_price_per_sqm' => 4000000, 'multi_floor_multiplier' => 1.12, 'specification_details' => 'Pondasi cakar ayam, dinding bata ringan, atap dak, lantai granit 60x60, fasad ACP.'],
        ];

        foreach ($rates as $rate) {
            CostEstimatorRate::create($rate);
        }
    }
}
