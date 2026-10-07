<?php

namespace App\Http\Controllers;

use App\Models\CostEstimatorRate;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Display the landing page (Wireframe 1 - PT MKP Style).
     */
    public function index(): View
    {
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $featuredProjects = Project::query()
            ->with(['images', 'service'])
            ->featured()
            ->orderBy('sort_order')
            ->get();

        // Project with before & after images for interactive slider showcase
        $beforeAfterProject = Project::query()
            ->whereHas('images', function ($query) {
                $query->where('type', 'before');
            })
            ->whereHas('images', function ($query) {
                $query->where('type', 'after');
            })
            ->with('images')
            ->first();

        // Fallback to project id 4 or first project if not found
        if (! $beforeAfterProject) {
            $beforeAfterProject = Project::with('images')->find(4) ?? Project::with('images')->first();
        }

        $testimonials = Testimonial::query()
            ->with('project')
            ->where('is_approved', true)
            ->take(6)
            ->get();

        $rates = CostEstimatorRate::query()
            ->where('is_active', true)
            ->get();

        $settings = SiteSetting::query()
            ->pluck('setting_value', 'setting_key')
            ->all();

        $stats = [
            'completed_projects' => Project::where('status', 'completed')->count() + 150, // Real + portfolio history
            'ongoing_projects' => Project::where('status', 'ongoing')->count() + 8,
            'client_satisfaction' => '99.4%',
            'experience_years' => 12,
            'safety_record' => '100% Zero Accident',
        ];

        return view('home', compact(
            'services',
            'featuredProjects',
            'beforeAfterProject',
            'testimonials',
            'rates',
            'settings',
            'stats'
        ));
    }
}
