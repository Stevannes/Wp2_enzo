<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EstimateCostRequest extends FormRequest
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
            'building_type' => ['required', 'string', 'in:residential_standard,residential_luxury,office,warehouse,shophouse'],
            'finish_grade' => ['required', 'string', 'in:standard,premium,luxury'],
            'area_sqm' => ['required', 'numeric', 'min:10', 'max:50000'],
            'floors' => ['required', 'integer', 'min:1', 'max:50'],
        ];
    }
}
