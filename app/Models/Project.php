<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'title',
        'slug',
        'client_name',
        'project_type',
        'location',
        'building_area_sqm',
        'land_area_sqm',
        'completion_year',
        'duration',
        'status',
        'challenge_description',
        'solution_description',
        'is_featured',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'building_area_sqm' => 'decimal:2',
            'land_area_sqm' => 'decimal:2',
            'completion_year' => 'integer',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /** @return BelongsTo<Service, $this> */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /** @return HasMany<ProjectImage, $this> */
    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class);
    }

    /** @return HasMany<Testimonial, $this> */
    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }

    /**
     * @param  Builder<Project>  $query
     * @return Builder<Project>
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }
}
