<?php

namespace App\Http\Requests;

use App\Rules\SafeFileUploadRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreInquiryRfpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone_number' => ['required', 'string', 'max:50'],
            'project_category' => ['required', 'string', 'max:255'],
            'design_layout_id' => ['nullable', 'exists:design_layouts,id'],
            'payment_scheme' => ['nullable', 'string', 'in:cash,cash_tempo,kpr_bank'],
            'site_location' => ['required', 'string', 'max:255'],
            'estimated_budget_idr' => ['nullable', 'numeric', 'min:0', 'max:1000000000000'],
            'planned_area_sqm' => ['nullable', 'numeric', 'min:0', 'max:1000000'],
            'project_notes' => ['nullable', 'string', 'max:5000'],
            'source_channel' => ['nullable', 'string', 'max:50'],
            'attachments' => ['nullable', 'array', 'max:5'],
            'attachments.*' => [
                'nullable',
                'file',
                'max:25600', // 25MB max
                'mimes:pdf,dwg,dxf,zip,rar,7z,doc,docx,xls,xlsx,jpg,jpeg,png,webp',
                new SafeFileUploadRule,
            ],
            // Honeypot anti-bot field: must be empty
            'website_hp' => ['nullable', 'max:0'],
        ];
    }

    /**
     * Prepare inputs for validation (Trim & XSS Sanitization).
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'payment_scheme' => $this->input('payment_scheme') ?: 'cash_tempo',
            'full_name' => strip_tags(trim((string) $this->input('full_name'))),
            'company_name' => $this->input('company_name') ? strip_tags(trim((string) $this->input('company_name'))) : null,
            'email' => strtolower(trim((string) $this->input('email'))),
            'phone_number' => preg_replace('/[^0-9+]/', '', (string) $this->input('phone_number')),
            'site_location' => strip_tags(trim((string) $this->input('site_location'))),
            'project_notes' => $this->input('project_notes') ? strip_tags(trim((string) $this->input('project_notes'))) : null,
        ]);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'full_name' => 'Nama Lengkap',
            'company_name' => 'Nama Perusahaan',
            'email' => 'Alamat Email',
            'phone_number' => 'Nomor WhatsApp / Telepon',
            'project_category' => 'Kategori Pekerjaan',
            'design_layout_id' => 'Pilihan Layout Desain',
            'payment_scheme' => 'Skema Metode Pembayaran',
            'site_location' => 'Lokasi Proyek',
            'estimated_budget_idr' => 'Plafon Anggaran',
            'planned_area_sqm' => 'Perkiraan Luas Bangunan',
            'project_notes' => 'Catatan Proyek',
            'attachments.*' => 'Berkas Lampiran Tender',
            'website_hp' => 'Security Honeypot Verification',
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'website_hp.max' => 'Spam bot submission terdeteksi dan diblokir secara otomatis oleh firewall sistem.',
            'attachments.*.mimes' => 'Berkas lampiran hanya boleh berformat dokumen/arsitektur resmi: PDF, DWG, DXF, ZIP, RAR, 7Z, DOCX, XLSX, JPG, atau PNG.',
            'attachments.*.max' => 'Ukuran maksimal berkas lampiran adalah 25MB.',
        ];
    }
}
