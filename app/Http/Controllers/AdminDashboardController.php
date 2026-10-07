<?php

namespace App\Http\Controllers;

use App\Models\InquiryRfp;
use App\Models\Project;
use App\Models\RfpAttachment;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminDashboardController extends Controller
{
    /**
     * Display Lead Pipeline Tracker and Executive CMS Overview (Wireframe 5).
     */
    public function index(Request $request): View
    {
        $statusFilter = $request->query('status');

        $query = InquiryRfp::query()->with('attachments')->latest();

        if ($statusFilter && $statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        $rfps = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => InquiryRfp::count(),
            'submitted' => InquiryRfp::where('status', 'submitted')->count(),
            'contacted' => InquiryRfp::whereIn('status', ['in_review', 'contacted'])->count(),
            'survey_scheduled' => InquiryRfp::where('status', 'survey_scheduled')->count(),
            'rab_sent' => InquiryRfp::where('status', 'rab_sent')->count(),
            'deal' => InquiryRfp::where('status', 'deal')->count(),
            'pipeline_value' => (float) InquiryRfp::whereNotIn('status', ['rejected'])->sum('estimated_budget_idr'),
        ];

        $projects = Project::query()->with('images')->orderBy('sort_order')->get();
        $settings = SiteSetting::query()->pluck('setting_value', 'setting_key')->all();

        return view('admin.index', compact('rfps', 'stats', 'projects', 'statusFilter', 'settings'));
    }

    /**
     * Show single RFP tender detail.
     */
    public function rfpShow(int $id): View
    {
        $rfp = InquiryRfp::with('attachments')->findOrFail($id);
        $settings = SiteSetting::query()->pluck('setting_value', 'setting_key')->all();

        return view('admin.rfp-show', compact('rfp', 'settings'));
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
        $filePath = storage_path('app/public/'.$attachment->file_path);

        if (! file_exists($filePath)) {
            abort(404, 'Berkas lampiran tidak ditemukan di server.');
        }

        return response()->download($filePath, $attachment->original_filename);
    }
}
