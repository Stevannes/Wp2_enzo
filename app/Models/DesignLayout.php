<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DesignLayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'building_type',
        'land_size_sqm',
        'building_size_sqm',
        'floor_count',
        'bedrooms',
        'bathrooms',
        'carport_capacity',
        'layout_plan_image',
        'render_3d_image',
        'estimated_price_idr',
        'specifications_summary',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'land_size_sqm' => 'float',
        'building_size_sqm' => 'float',
        'floor_count' => 'integer',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'carport_capacity' => 'integer',
        'estimated_price_idr' => 'float',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function inquiryRfps(): HasMany
    {
        return $this->hasMany(InquiryRfp::class);
    }
}
