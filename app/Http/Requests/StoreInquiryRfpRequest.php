<?php

namespace App\Http\Requests;

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
            'site_location' => ['required', 'string', 'max:255'],
            'estimated_budget_idr' => ['nullable', 'numeric', 'min:0'],
            'planned_area_sqm' => ['nullable', 'numeric', 'min:0'],
            'project_notes' => ['nullable', 'string', 'max:5000'],
            'source_channel' => ['nullable', 'string', 'max:50'],
            'attachments' => ['nullable', 'array', 'max:5'],
            'attachments.*' => ['nullable', 'file', 'max:25600'], // 25MB max
        ];
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
            'site_location' => 'Lokasi Proyek',
            'estimated_budget_idr' => 'Plafon Anggaran',
            'planned_area_sqm' => 'Perkiraan Luas Bangunan',
            'project_notes' => 'Catatan Proyek',
            'attachments.*' => 'Berkas Lampiran Tender',
        ];
    }
}
