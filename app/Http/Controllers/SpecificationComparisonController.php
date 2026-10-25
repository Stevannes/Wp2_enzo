<?php

namespace App\Http\Controllers;

use App\Models\CostEstimatorRate;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;

class SpecificationComparisonController extends Controller
{
    /**
     * Poin 3 Evaluasi Dosen: Matriks Komparatif Spesifikasi Teknis Material Rinci.
     */
    public function index(): View
    {
        $rates = CostEstimatorRate::where('is_active', true)->get();
        $settings = SiteSetting::query()->pluck('setting_value', 'setting_key')->all();

        // Data Matriks Komparasi Rinci Material & Struktur Konstruksi
        $specMatrix = [
            [
                'category' => '1. Struktur Pondasi & Kolom',
                'icon' => 'layers',
                'items' => [
                    [
                        'name' => 'Jenis Pondasi Utama',
                        'standard' => 'Pondasi Batu Kali + Footplat Setempat',
                        'premium' => 'Cakar Ayam Bertulang K-275 + Strauss Pile',
                        'luxury' => 'Tiang Pancang / Bore Pile Dalam K-350',
                    ],
                    [
                        'name' => 'Mutu Beton Struktur (Kolom & Balok)',
                        'standard' => 'Ready Mix K-225 (Uji Slump SNI)',
                        'premium' => 'Ready Mix K-275 / K-300 + Deformed Bar BJTD 40',
                        'luxury' => 'High Strength Concrete K-350 / K-400 Anti-Gempa',
                    ],
                    [
                        'name' => 'Besi Tulangan Pokok',
                        'standard' => 'Besi Polos SNI D10 / D12 mm',
                        'premium' => 'Besi Ulir SNI D13 / D16 mm Bersertifikat',
                        'luxury' => 'Besi Ulir Penuh Krakatau Steel D16 / D19 mm',
                    ],
                ],
            ],
            [
                'category' => '2. Penutup Lantai & Dinding',
                'icon' => 'grid',
                'items' => [
                    [
                        'name' => 'Material Lantai Utama',
                        'standard' => 'Keramik Glazed SNI 40x40 / 50x50 cm',
                        'premium' => 'Granite Tile Homogeneous 60x60 / 80x80 cm (Indogress/Essenza)',
                        'luxury' => 'Marmer Import Italia / Spanyol Slab Utuh',
                    ],
                    [
                        'name' => 'Dinding Utama & Plesteran',
                        'standard' => 'Bata Merah / Hebel 10cm, Plester Aci',
                        'premium' => 'Bata Ringan Hebel AAC, Mortar Utama, Cat Jotun/Dulux Weathershield',
                        'luxury' => 'Double Wall Akustik, Insulasi Thermal, Cat San Deco / Wall Panel Wood',
                    ],
                    [
                        'name' => 'Kusen Pintu & Jendela',
                        'standard' => 'Kayu Kamper Lokal / Aluminium Standar 3 Inch',
                        'premium' => 'Aluminium Alexindo / YKK 4 Inch Powder Coating',
                        'luxury' => 'Kusen UPVC Euromax / Thermal-Break System Anti-Bising',
                    ],
                ],
            ],
            [
                'category' => '3. Rangka Atap & Penutup Atap',
                'icon' => 'home',
                'items' => [
                    [
                        'name' => 'Rangka Atap',
                        'standard' => 'Baja Ringan Galvalum C75 tebal 0.70 mm',
                        'premium' => 'Baja Ringan Zincalume C75 tebal 0.75-1.00 mm Bluescope',
                        'luxury' => 'Baja Ringan Heavy-Duty 1.00 mm / Rangka Baja Berat WF + Kayu Ulin',
                    ],
                    [
                        'name' => 'Jenis & Merek Genteng / Seng',
                        'standard' => 'Genteng Metal Berpasir Rainbow / Sakura Roof',
                        'premium' => 'Genteng Flat Beton Monier / Kanmuri Glazur / Spandek Insulasi',
                        'luxury' => 'Genteng Keramik Import Glazur M-Class / Dak Beton Waterproof Sika',
                    ],
                    [
                        'name' => 'Peredam Panas & Suara (Insulasi)',
                        'standard' => 'Aluminium Foil Single Side',
                        'premium' => 'Aluminium Foil Double Side + Glasswool / Bubble 4mm',
                        'luxury' => 'Polyurethane (PU) Foam Spray 30mm Insulasi Akustik Maksimal',
                    ],
                ],
            ],
            [
                'category' => '4. Fasilitas Pendukung & MEP (Mekanikal Elektrikal Plumbing)',
                'icon' => 'zap',
                'items' => [
                    [
                        'name' => 'Kelistrikan & Titik Lampu',
                        'standard' => 'Daya 1.300 VA, Kabel Eterna SNI, Saklar Broco',
                        'premium' => 'Daya 2.200 / 3.500 VA, Kabel Supreme, Saklar Schneider / Panasonic',
                        'luxury' => 'Daya 5.500+ VA, 3 Phase, Smart Home Automation System (Bticino)',
                    ],
                    [
                        'name' => 'Instalasi Air & Sanitasi',
                        'standard' => 'Pipa PVC Rucika Wavin D/AW, Bio Septic Tank 800 L',
                        'premium' => 'Pipa PPR Air Panas/Dingin, Pompa Booster Shimizu, Biofilter Tank 1.500 L',
                        'luxury' => 'Water Treatment Filtration, Solar Water Heater 200L, Bio Septic Tank 2.500 L',
                    ],
                    [
                        'name' => 'Perlengkapan Sanitair',
                        'standard' => 'Kloset Duduk Toto Standard, Kran American Standard',
                        'premium' => 'Kloset Toto Eco-Washer, Wastafel Gantung, Shower Set Panas/Dingin',
                        'luxury' => 'Smart Toilet Kohler / Grohe Automatic Sensor, Bathtub Whirlpool',
                    ],
                    [
                        'name' => 'Fasilitas Carport & Halaman',
                        'standard' => 'Rabat Beton Cor Polos, Saluran Terbuka',
                        'premium' => 'Rabat Beton Sikat Motif + Kanopi Besi Hollow Rangka Double',
                        'luxury' => 'Granit Outdoor Andesit Flamed + Kanopi Kaca Tempered Low-E 10mm',
                    ],
                ],
            ],
        ];

        return view('specifications.index', compact('specMatrix', 'rates', 'settings'));
    }
}
