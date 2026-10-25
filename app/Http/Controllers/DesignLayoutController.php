<?php

namespace App\Http\Controllers;

use App\Models\DesignLayout;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DesignLayoutController extends Controller
{
    /**
     * Poin 2 Evaluasi Dosen: Katalog Referensi Desain & Pemilihan Tata Letak (Layout Siap Pakai).
     */
    public function index(Request $request): View
    {
        $category = $request->query('category');
        $floors = $request->query('floors');
        $search = $request->query('q');

        $query = DesignLayout::query()->orderBy('sort_order');

        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        if ($floors && $floors !== 'all') {
            $query->where('floor_count', (int) $floors);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('building_type', 'like', "%{$search}%")
                    ->orWhere('specifications_summary', 'like', "%{$search}%");
            });
        }

        $layouts = $query->paginate(9)->withQueryString();

        $stats = [
            'total' => DesignLayout::count(),
            '1_floor' => DesignLayout::where('floor_count', 1)->count(),
            '2_floors' => DesignLayout::where('floor_count', 2)->count(),
        ];

        $settings = SiteSetting::query()->pluck('setting_value', 'setting_key')->all();

        return view('layouts_catalog.index', compact('layouts', 'category', 'floors', 'search', 'stats', 'settings'));
    }

    /**
     * Detail Denah & Spesifikasi Layout Arsitektur Siap Bangun.
     */
    public function show(string $slug): View
    {
        $layout = DesignLayout::where('slug', $slug)->firstOrFail();
        $relatedLayouts = DesignLayout::where('id', '!=', $layout->id)
            ->where('floor_count', $layout->floor_count)
            ->take(3)
            ->get();

        $settings = SiteSetting::query()->pluck('setting_value', 'setting_key')->all();

        return view('layouts_catalog.show', compact('layout', 'relatedLayouts', 'settings'));
    }
}
