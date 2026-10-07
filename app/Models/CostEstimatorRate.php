<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostEstimatorRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_type',
        'finish_grade',
        'base_price_per_sqm',
        'multi_floor_multiplier',
        'specification_details',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'base_price_per_sqm' => 'decimal:2',
            'multi_floor_multiplier' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }
}
