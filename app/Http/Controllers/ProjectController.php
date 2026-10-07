<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display portfolio catalogue with interactive filters and search (Wireframe 2).
     */
    public function index(Request $request): View
    {
        $category = $request->query('category');
        $status = $request->query('status');
        $search = $request->query('q');

        $query = Project::query()->with(['images', 'service']);

        if ($category && $category !== 'all') {
            $query->where('project_type', $category);
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('client_name', 'like', "%{$search}%");
            });
        }

        $projects = $query->orderBy('sort_order')->orderByDesc('completion_year')->paginate(9)->withQueryString();
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();

        $stats = [
            'total' => Project::count(),
            'commercial' => Project::where('project_type', 'commercial')->count(),
            'residential' => Project::where('project_type', 'residential')->count(),
            'industrial' => Project::where('project_type', 'industrial')->count(),
        ];

        $settings = SiteSetting::query()->pluck('setting_value', 'setting_key')->all();

        return view('projects.index', compact('projects', 'services', 'stats', 'settings', 'category', 'status', 'search'));
    }

    /**
     * Display single project case study with gallery and Before/After slider.
     */
    public function show(string $slug): View
    {
        $project = Project::query()
            ->with(['images' => fn ($q) => $q->orderBy('sort_order'), 'service', 'testimonials'])
            ->where('slug', $slug)
            ->firstOrFail();

        $beforeImage = $project->images->firstWhere('type', 'before');
        $afterImage = $project->images->firstWhere('type', 'after');
        $galleryImages = $project->images->where('type', 'gallery');

        $relatedProjects = Project::query()
            ->with(['images', 'service'])
            ->where('id', '!=', $project->id)
            ->where(function ($q) use ($project) {
                $q->where('service_id', $project->service_id)
                    ->orWhere('project_type', $project->project_type);
            })
            ->take(3)
            ->get();

        $settings = SiteSetting::query()->pluck('setting_value', 'setting_key')->all();

        return view('projects.show', compact('project', 'beforeImage', 'afterImage', 'galleryImages', 'relatedProjects', 'settings'));
    }
}
