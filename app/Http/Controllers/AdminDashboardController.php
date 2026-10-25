<?php

namespace App\Http\Controllers;

use App\Models\ConstructionProgressLog;
use App\Models\InquiryRfp;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\RfpAttachment;
use App\Models\RfpNegotiationLog;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminDashboardController extends Controller
{
    /**
     * Display Lead Pipeline Tracker, Reminder Alerts, and Executive CMS Overview (Wireframe 5).
     */
    public function index(Request $request): View
    {
        $statusFilter = $request->query('status');

        $query = InquiryRfp::query()
            ->with(['attachments', 'assignedUser', 'designLayout', 'complaints'])
            ->latest();

        if ($statusFilter && $statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        $rfps = $query->paginate(15)->withQueryString();

        // Poin 4 Evaluasi Dosen: Hitung tiket yang belum direspon / butuh pengingat admin
        $unhandledRfps = InquiryRfp::query()
            ->whereIn('status', ['submitted', 'in_review'])
            ->where(function ($q) {
                $q->whereNull('admin_last_viewed_at')
                    ->orWhere('admin_last_viewed_at', '<', now()->subHours(6));
            })
            ->latest()
            ->get();

        $stats = [
            'total' => InquiryRfp::count(),
            'submitted' => InquiryRfp::where('status', 'submitted')->count(),
            'contacted' => InquiryRfp::whereIn('status', ['in_review', 'contacted'])->count(),
            'survey_scheduled' => InquiryRfp::where('status', 'survey_scheduled')->count(),
            'rab_sent' => InquiryRfp::where('status', 'rab_sent')->count(),
            'deal' => InquiryRfp::where('status', 'deal')->count(),
            'pipeline_value' => (float) InquiryRfp::whereNotIn('status', ['rejected'])->sum('estimated_budget_idr'),
            'unhandled_count' => $unhandledRfps->count(),
        ];

        $projects = Project::query()->with('images')->orderBy('sort_order')->get();
        $staffUsers = User::all();
        $settings = SiteSetting::query()->pluck('setting_value', 'setting_key')->all();

        return view('admin.index', compact('rfps', 'stats', 'projects', 'statusFilter', 'settings', 'unhandledRfps', 'staffUsers'));
    }

    /**
     * Show single RFP tender detail, negotiation history, and field progress logs.
     */
    public function rfpShow(int $id): View
    {
        $rfp = InquiryRfp::with([
            'attachments',
            'designLayout',
            'assignedUser',
            'negotiationLogs.user',
            'progressLogs',
            'complaints',
        ])->findOrFail($id);

        // Poin 4 Evaluasi Dosen: Tandai telah dilihat oleh Admin agar reminder otomatis berhenti
        $rfp->update([
            'admin_last_viewed_at' => now(),
        ]);

        $staffUsers = User::all();
        $settings = SiteSetting::query()->pluck('setting_value', 'setting_key')->all();

        return view('admin.rfp-show', compact('rfp', 'staffUsers', 'settings'));
    }

    /**
     * Poin 5 Evaluasi Dosen: Fitur Penugasan Staf / Penanggung Jawab Proyek (Task Assignment).
     */
    public function rfpAssign(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'assigned_to_user_id' => ['required', 'exists:users,id'],
        ]);

        $rfp = InquiryRfp::findOrFail($id);
        $rfp->update([
            'assigned_to_user_id' => $request->input('assigned_to_user_id'),
        ]);

        $assignedUser = User::find($request->input('assigned_to_user_id'));

        return back()->with('success', "Tiket {$rfp->rfp_number} berhasil ditugaskan kepada {$assignedUser->name}.");
    }

    /**
     * Poin 5 Evaluasi Dosen: Pencatatan Tahap Negosiasi Harga & Spesifikasi (Negotiation Log).
     */
    public function rfpNegotiate(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'stage' => ['required', 'string', 'in:initial_proposal,spec_clarification,price_negotiation,revised_boq,final_deal,rejected'],
            'proposed_amount_idr' => ['nullable', 'numeric', 'min:0'],
            'client_notes' => ['nullable', 'string', 'max:2000'],
            'admin_response' => ['required', 'string', 'max:2000'],
        ]);

        $rfp = InquiryRfp::findOrFail($id);

        RfpNegotiationLog::create([
            'inquiry_rfp_id' => $rfp->id,
            'user_id' => auth()->id() ?? User::first()?->id,
            'stage' => $request->input('stage'),
            'proposed_amount_idr' => $request->input('proposed_amount_idr'),
            'client_notes' => $request->input('client_notes'),
            'admin_response' => $request->input('admin_response'),
        ]);

        // Jika mencapai final_deal, otomatis set status deal dan catat deal_amount
        if ($request->input('stage') === 'final_deal') {
            $rfp->update([
                'status' => 'deal',
                'deal_amount_idr' => $request->input('proposed_amount_idr', $rfp->estimated_budget_idr),
                'deal_date' => now(),
            ]);
        }

        return back()->with('success', 'Catatan negosiasi berhasil ditambahkan ke rekam jejak tiket.');
    }

    /**
     * Poin 7 Evaluasi Dosen: Input Laporan Progres Harian Mandor & Foto Pembanding.
     */
    public function storeProgressLog(Request $request, int $id): RedirectResponse
    {
        $rfp = InquiryRfp::findOrFail($id);

        $request->validate([
            'day_number' => ['required', 'integer', 'min:1'],
            'stage_name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'progress_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'logged_by_name' => ['required', 'string', 'max:255'],
            'actual_field_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ]);

        $fieldPhotoPath = null;
        if ($request->hasFile('actual_field_photo')) {
            $photo = $request->file('actual_field_photo');
            $ext = strtolower($photo->getClientOriginalExtension());
            $safeName = Str::uuid()->toString().'.'.$ext;
            $fieldPhotoPath = $photo->storeAs('progress_photos', $safeName, 'public');
        }

        ConstructionProgressLog::create([
            'inquiry_rfp_id' => $rfp->id,
            'day_number' => (int) $request->input('day_number'),
            'log_date' => now(),
            'stage_name' => strip_tags(trim((string) $request->input('stage_name'))),
            'description' => strip_tags(trim((string) $request->input('description'))),
            'promised_render_image' => $rfp->designLayout?->render_3d_image ?? 'images/project_residential.jpg',
            'actual_field_photo' => $fieldPhotoPath ?? 'images/after_renovation.jpg',
            'progress_percentage' => (float) $request->input('progress_percentage'),
            'logged_by_name' => strip_tags(trim((string) $request->input('logged_by_name'))),
        ]);

        return back()->with('success', 'Jurnal laporan mandor lapangan berhasil ditambahkan!');
    }

    /**
     * Poin 9 & 10 Evaluasi Dosen: Publikasi Otomatis ke Portofolio Publik & Proteksi Privasi Hunian.
     */
    public function publishToPortfolio(Request $request, int $id): RedirectResponse
    {
        $rfp = InquiryRfp::findOrFail($id);

        $defaultService = Service::first() ?? Service::create([
            'name' => 'General Construction',
            'slug' => 'general-construction',
            'is_active' => true,
        ]);

        $isResidential = str_contains(strtolower($rfp->project_category ?? ''), 'residensial')
            || str_contains(strtolower($rfp->project_category ?? ''), 'rumah')
            || str_contains(strtolower($rfp->project_category ?? ''), 'villa');

        $project = Project::create([
            'service_id' => $defaultService->id,
            'title' => 'Pembangunan '.($rfp->project_category ?: 'Konstruksi').' — '.$rfp->rfp_number,
            'slug' => Str::slug($rfp->rfp_number.'-proyek-selesai-'.Str::random(4)),
            'client_name' => $rfp->full_name,
            'project_type' => $isResidential ? 'residential' : 'commercial',
            'is_residential' => $isResidential,
            'client_privacy_consented' => false, // Poin 10: Default proteksi privasi!
            'location' => $rfp->site_location,
            'building_area_sqm' => $rfp->planned_area_sqm ?? 200,
            'completion_year' => (int) date('Y'),
            'duration' => '6 Bulan',
            'status' => 'completed',
            'challenge_description' => 'Penyelesaian proyek sesuai jadwal dengan standar mutu rekayasa dan koordinasi rutin berkala.',
            'solution_description' => 'Aplikasi metode konstruksi presisi, pengujian material berkala, dan pengawasan zero-accident.',
            'is_featured' => true,
            'sort_order' => 10,
        ]);

        ProjectImage::create([
            'project_id' => $project->id,
            'image_path' => 'images/project_residential.jpg',
            'caption' => 'Hasil Akhir Serah Terima Kunci Proyek '.$rfp->rfp_number,
            'type' => 'gallery',
            'sort_order' => 1,
        ]);

        return back()->with('success', "Proyek dari tiket {$rfp->rfp_number} berhasil dipublikasikan ke Katalog Portofolio Publik dengan proteksi privasi alamat!");
    }

    /**
     * Update RFP status and internal notes.
     */
    public function rfpUpdateStatus(Request $request, int $id): RedirectResponse|JsonResponse
    {
        $request->validate([
            'status' => ['required', 'string', 'in:submitted,in_review,contacted,survey_scheduled,rab_sent,negotiation,deal,rejected'],
            'internal_admin_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $rfp = InquiryRfp::findOrFail($id);
        $rfp->update([
            'status' => $request->input('status'),
            'internal_admin_notes' => $request->input('internal_admin_notes', $rfp->internal_admin_notes),
            'admin_last_viewed_at' => now(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status RFP berhasil diperbarui.',
                'status' => $rfp->status,
            ]);
        }

        return back()->with('success', "Status tiket {$rfp->rfp_number} berhasil diperbarui menjadi {$rfp->status}.");
    }

    /**
     * Download RFP tender attachment safely.
     */
    public function downloadAttachment(int $id): BinaryFileResponse
    {
        $attachment = RfpAttachment::findOrFail($id);
        $storageBase = realpath(storage_path('app/public'));
        $targetPath = storage_path('app/public/'.$attachment->file_path);
        $realPath = realpath($targetPath);

        if (! $realPath || ! str_starts_with($realPath, $storageBase) || ! file_exists($realPath)) {
            abort(404, 'Berkas lampiran tidak ditemukan atau akses tidak sah.');
        }

        $safeOriginalName = basename($attachment->original_filename);

        return response()->download($realPath, $safeOriginalName, [
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
