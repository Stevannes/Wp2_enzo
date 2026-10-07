<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRfpRequest;
use App\Models\InquiryRfp;
use App\Models\RfpAttachment;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InquiryRfpController extends Controller
{
    /**
     * Show RFP Submission Form (Wireframe 4).
     */
    public function create(Request $request): View
    {
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        $settings = SiteSetting::query()->pluck('setting_value', 'setting_key')->all();

        // Optional prefilled parameters from calculator or service pages
        $prefill = [
            'project_category' => $request->query('category', ''),
            'planned_area_sqm' => $request->query('area', ''),
            'estimated_budget_idr' => $request->query('budget', ''),
            'notes' => $request->query('notes', ''),
        ];

        return view('rfp.create', compact('services', 'settings', 'prefill'));
    }

    /**
     * Store new RFP tender submission and handle multi-file attachments.
     */
    public function store(StoreInquiryRfpRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Generate standardized ticket number: e.g. RFP-2610-001
        $prefix = 'RFP-'.date('ym').'-';
        $todayCount = InquiryRfp::where('rfp_number', 'like', "{$prefix}%")->count();
        $rfpNumber = $prefix.str_pad((string) ($todayCount + 1), 3, '0', STR_PAD_LEFT);

        // Ensure unique rfp_number
        while (InquiryRfp::where('rfp_number', $rfpNumber)->exists()) {
            $todayCount++;
            $rfpNumber = $prefix.str_pad((string) ($todayCount + 1), 3, '0', STR_PAD_LEFT);
        }

        $rfp = InquiryRfp::create([
            'rfp_number' => $rfpNumber,
            'full_name' => $validated['full_name'],
            'company_name' => $validated['company_name'] ?? null,
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'project_category' => $validated['project_category'],
            'site_location' => $validated['site_location'],
            'estimated_budget_idr' => $validated['estimated_budget_idr'] ?? null,
            'planned_area_sqm' => $validated['planned_area_sqm'] ?? null,
            'project_notes' => $validated['project_notes'] ?? null,
            'source_channel' => $validated['source_channel'] ?? 'website',
            'status' => 'submitted',
        ]);

        // Process attachments if provided
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file && $file->isValid()) {
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $safeFileName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)).'-'.Str::random(6).'.'.$extension;
                    $filePath = $file->storeAs('rfp_attachments', $safeFileName, 'public');

                    RfpAttachment::create([
                        'inquiry_rfp_id' => $rfp->id,
                        'original_filename' => $originalName,
                        'file_path' => $filePath,
                        'file_type' => $extension,
                        'file_size_bytes' => $file->getSize(),
                    ]);
                }
            }
        }

        return redirect()->route('rfp.track', ['rfp_number' => $rfpNumber])
            ->with('success', 'Pengajuan RFP berhasil dikirim! Simpan Nomor Tiket Anda untuk memantau status tender.');
    }

    /**
     * Track RFP submission status (Wireframe 4 - Tracking view).
     */
    public function track(Request $request): View
    {
        $rfpNumber = $request->query('rfp_number');
        $rfp = null;
        $searched = false;

        if ($rfpNumber) {
            $rfpNumber = trim($rfpNumber);
            $rfp = InquiryRfp::query()
                ->with('attachments')
                ->where('rfp_number', $rfpNumber)
                ->first();
            $searched = true;
        }

        $settings = SiteSetting::query()->pluck('setting_value', 'setting_key')->all();

        return view('rfp.track', compact('rfp', 'rfpNumber', 'searched', 'settings'));
    }
}
