<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRfpRequest;
use App\Models\DesignLayout;
use App\Models\InquiryRfp;
use App\Models\ProjectComplaint;
use App\Models\RfpAttachment;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InquiryRfpController extends Controller
{
    /**
     * Show RFP Submission Form (Wireframe 4 & Poin 2, 6).
     */
    public function create(Request $request): View|RedirectResponse
    {
        $user = auth()->user();

        // Nomor ponsel wajib ada; jika tidak ada maka tidak bisa membuat RFP
        if (empty($user?->phone_number)) {
            return redirect()->route('customer.dashboard')
                ->with('error', 'Nomor telepon/WhatsApp wajib diisi pada profil akun Anda sebelum membuat pengajuan tender (RFP). Silakan lengkapi nomor telepon Anda terlebih dahulu.')
                ->with('open_profile_modal', true);
        }

        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        $layouts = DesignLayout::where('is_featured', true)->orderBy('sort_order')->get();
        $settings = SiteSetting::query()->pluck('setting_value', 'setting_key')->all();

        // Prefill parameters from authenticated client and optional layout/calculator query
        $selectedLayoutId = $request->query('layout_id');
        $prefill = [
            'full_name' => $user->name ?? '',
            'company_name' => $user->company_name ?? '',
            'email' => $user->email ?? '',
            'phone_number' => $user->phone_number ?? '',
            'project_category' => $request->query('category', ''),
            'planned_area_sqm' => $request->query('area', ''),
            'estimated_budget_idr' => $request->query('budget', ''),
            'notes' => $request->query('notes', ''),
            'design_layout_id' => $selectedLayoutId,
            'payment_scheme' => $request->query('scheme', 'cash_tempo'),
        ];

        return view('rfp.create', compact('services', 'layouts', 'settings', 'prefill'));
    }

    /**
     * Store new RFP tender submission and handle multi-file attachments.
     */
    public function store(StoreInquiryRfpRequest $request): RedirectResponse
    {
        $user = auth()->user();

        // Nomor ponsel wajib ada; jika tidak ada maka tidak bisa membuat RFP
        if (empty($user?->phone_number)) {
            return redirect()->route('customer.dashboard')
                ->with('error', 'Nomor telepon/WhatsApp wajib diisi pada profil akun Anda sebelum mengajukan tender (RFP). Silakan lengkapi nomor telepon Anda terlebih dahulu.')
                ->with('open_profile_modal', true);
        }

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
            'user_id' => auth()->id(),
            'rfp_number' => $rfpNumber,
            'full_name' => $validated['full_name'],
            'company_name' => $validated['company_name'] ?? null,
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'project_category' => $validated['project_category'],
            'design_layout_id' => $validated['design_layout_id'] ?? null,
            'payment_scheme' => $validated['payment_scheme'] ?? 'cash_tempo',
            'site_location' => $validated['site_location'],
            'estimated_budget_idr' => $validated['estimated_budget_idr'] ?? null,
            'planned_area_sqm' => $validated['planned_area_sqm'] ?? null,
            'project_notes' => $validated['project_notes'] ?? null,
            'source_channel' => $validated['source_channel'] ?? 'website',
            'status' => 'submitted',
            'admin_last_viewed_at' => null, // Butuh notifikasi pengingat admin! (Poin 4)
            'reminder_count' => 0,
        ]);

        // Process attachments if provided
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file && $file->isValid()) {
                    $originalName = strip_tags(basename($file->getClientOriginalName()));
                    $extension = strtolower($file->getClientOriginalExtension());
                    $safeFileName = Str::uuid()->toString().'.'.$extension;
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
     * Track RFP submission status & Client Construction Progress Portal (Poin 7 & 8).
     */
    public function track(Request $request): View
    {
        $rfpNumber = $request->query('rfp_number');
        $rfp = null;
        $searched = false;

        if ($rfpNumber) {
            $rfpNumber = strip_tags(trim((string) $rfpNumber));
            $rfp = InquiryRfp::query()
                ->with([
                    'attachments',
                    'designLayout',
                    'assignedUser',
                    'negotiationLogs.user',
                    'progressLogs',
                    'complaints',
                ])
                ->where('rfp_number', $rfpNumber)
                ->first();
            $searched = true;
        } elseif (auth()->check()) {
            // Auto-load latest RFP for authenticated customer if no specific ticket number searched
            $rfp = InquiryRfp::query()
                ->with([
                    'attachments',
                    'designLayout',
                    'assignedUser',
                    'negotiationLogs.user',
                    'progressLogs',
                    'complaints',
                ])
                ->where(function ($q) {
                    $q->where('user_id', auth()->id())
                        ->orWhere('email', auth()->user()->email);
                })
                ->latest()
                ->first();

            if ($rfp) {
                $rfpNumber = $rfp->rfp_number;
                $searched = true;
            }
        }

        $settings = SiteSetting::query()->pluck('setting_value', 'setting_key')->all();

        return view('rfp.track', compact('rfp', 'rfpNumber', 'searched', 'settings'));
    }

    /**
     * Poin 8 Evaluasi Dosen: Wadah Pengajuan Komplain / Keluhan Hasil Pengerjaan Lapangan.
     */
    public function storeComplaint(Request $request, int $id): RedirectResponse
    {
        $rfp = InquiryRfp::findOrFail($id);

        $request->validate([
            'category' => ['required', 'string', 'in:warna_cat_finishing,posisi_sanitasi_wc,retak_acian,kelistrikan_mep,atap_bocor,lainnya'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'urgency' => ['required', 'in:low,medium,high,emergency'],
            'photo_proof' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'], // 10MB
        ]);

        $ticket = 'CMP-'.date('ym').'-'.str_pad((string) (ProjectComplaint::count() + 1), 3, '0', STR_PAD_LEFT);

        $photoPath = null;
        if ($request->hasFile('photo_proof')) {
            $photo = $request->file('photo_proof');
            $ext = strtolower($photo->getClientOriginalExtension());
            $safeName = Str::uuid()->toString().'.'.$ext;
            $photoPath = $photo->storeAs('complaints', $safeName, 'public');
        }

        ProjectComplaint::create([
            'inquiry_rfp_id' => $rfp->id,
            'complaint_ticket' => $ticket,
            'category' => $request->input('category'),
            'title' => strip_tags(trim((string) $request->input('title'))),
            'description' => strip_tags(trim((string) $request->input('description'))),
            'photo_proof' => $photoPath,
            'urgency' => $request->input('urgency'),
            'status' => 'submitted',
        ]);

        return back()->with('success', "Keluhan Anda telah tercatat dengan Tiket #{$ticket}. Tim Quality Control kami akan segera menindaklanjuti ke lapangan.");
    }

    /**
     * Poin 9 Evaluasi Dosen: Input Testimoni Klien saat Proyek Selesai.
     */
    public function storeTestimonial(Request $request, int $id): RedirectResponse
    {
        $rfp = InquiryRfp::findOrFail($id);

        $request->validate([
            'review_content' => ['required', 'string', 'max:2000'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        Testimonial::create([
            'client_name' => $rfp->full_name,
            'client_title' => $rfp->company_name ?: 'Pemilik Hunian',
            'review_content' => strip_tags(trim((string) $request->input('review_content'))),
            'rating' => (int) $request->input('rating'),
            'is_approved' => true,
        ]);

        return back()->with('success', 'Terima kasih atas ulasan dan testimoni berharga Anda!');
    }
}
