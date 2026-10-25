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
        'is_residential',
        'client_privacy_consented',
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
            'is_residential' => 'boolean',
            'client_privacy_consented' => 'boolean',
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

    /**
     * Poin 10 Evaluasi Dosen: Kebijakan Privasi Data Hunian Pelanggan.
     * Alamat detail disamarkan jika tipe residensial dan belum mendapat izin tertulis.
     */
    public function getMaskedLocationAttribute(): string
    {
        if ($this->is_residential && ! $this->client_privacy_consented) {
            // Ambil nama kota/kabupaten saja
            $parts = explode(',', $this->location);

            return trim(end($parts)) ?: 'Area Residensial Terlindungi';
        }

        return $this->location;
    }

    public function getMaskedClientNameAttribute(): string
    {
        if ($this->is_residential && ! $this->client_privacy_consented) {
            return 'Klien Residensial (Privasi Terjaga)';
        }

        return $this->client_name ?: 'Klien Enzo Contractor';
    }
}
