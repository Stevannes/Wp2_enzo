<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstimateCostRequest;
use App\Models\CostEstimatorRate;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class CostEstimatorController extends Controller
{
    /**
     * Display interactive RAB Cost Estimator tool (Wireframe 3).
     */
    public function index(): View
    {
        $rates = CostEstimatorRate::query()
            ->where('is_active', true)
            ->get();

        $buildingTypes = [
            'residential_standard' => [
                'label' => 'Rumah Tinggal Standar',
                'description' => 'Hunian 1-2 lantai, minimalis modern atau klasik sederhana',
                'icon' => 'home',
            ],
            'residential_luxury' => [
                'label' => 'Rumah Mewah / Villa Eksklusif',
                'description' => 'Arsitektur premium, marmer, fasad mewah & smart home',
                'icon' => 'sparkles',
            ],
            'office' => [
                'label' => 'Gedung Kantor / Perkantoran',
                'description' => 'Struktur bertingkat, utilitas MEP lengkap, partisi komersial',
                'icon' => 'building-2',
            ],
            'warehouse' => [
                'label' => 'Gudang & Bangunan Industri Baja',
                'description' => 'Konstruksi baja WF, bentang lebar, lantai hardener',
                'icon' => 'warehouse',
            ],
            'shophouse' => [
                'label' => 'Ruko / Shophouse Komersial',
                'description' => 'Ruang usaha multifungsi 2-4 lantai, fasad komersial modern',
                'icon' => 'store',
            ],
        ];

        $finishGrades = [
            'standard' => [
                'label' => 'Standar Mutu SNI',
                'summary' => 'Finishing berkualitas andal & efisien anggaran',
                'tag' => 'Best Value',
            ],
            'premium' => [
                'label' => 'Premium High-Grade',
                'summary' => 'Granit tile 60-80cm, sanitair Toto, cat kelas atas',
                'tag' => 'Paling Populer',
            ],
            'luxury' => [
                'label' => 'Luxury / Super Eksekutif',
                'summary' => 'Marmer import, kaca low-E, sanitair Kohler, smart lighting',
                'tag' => 'Ultra Eksklusif',
            ],
        ];

        $settings = SiteSetting::query()->pluck('setting_value', 'setting_key')->all();

        return view('estimator.index', compact('rates', 'buildingTypes', 'finishGrades', 'settings'));
    }

    /**
     * Calculate cost via API endpoint for dynamic client-side estimation.
     */
    public function calculate(EstimateCostRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $rate = CostEstimatorRate::query()
            ->where('building_type', $validated['building_type'])
            ->where('finish_grade', $validated['finish_grade'])
            ->where('is_active', true)
            ->first();

        if (! $rate) {
            // Fallback rate if combination not specifically defined
            $rate = CostEstimatorRate::query()
                ->where('building_type', $validated['building_type'])
                ->where('is_active', true)
                ->first()
                ?? CostEstimatorRate::first();
        }

        $baseRate = (float) $rate->base_price_per_sqm;
        $floors = (int) $validated['floors'];
        $multiplier = (float) $rate->multi_floor_multiplier;
        $area = (float) $validated['area_sqm'];

        // Compound structural floor factor if multi-floor
        $floorCoefficient = $floors > 1 ? 1 + (($multiplier - 1) * ($floors - 1) * 0.75) : 1.0;
        $effectiveRatePerSqm = $baseRate * $floorCoefficient;

        $nominalCost = $area * $effectiveRatePerSqm;
        $minCost = round($nominalCost * 0.95, -5);
        $maxCost = round($nominalCost * 1.10, -5);

        return response()->json([
            'success' => true,
            'building_type' => $validated['building_type'],
            'finish_grade' => $validated['finish_grade'],
            'area_sqm' => $area,
            'floors' => $floors,
            'base_rate_per_sqm' => $baseRate,
            'effective_rate_per_sqm' => round($effectiveRatePerSqm),
            'min_cost' => $minCost,
            'max_cost' => $maxCost,
            'min_cost_formatted' => 'Rp '.number_format($minCost, 0, ',', '.'),
            'max_cost_formatted' => 'Rp '.number_format($maxCost, 0, ',', '.'),
            'specification' => $rate->specification_details,
        ]);
    }
}
