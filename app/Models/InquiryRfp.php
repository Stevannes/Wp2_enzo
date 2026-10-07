<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InquiryRfp extends Model
{
    use HasFactory;

    protected $fillable = [
        'rfp_number',
        'full_name',
        'company_name',
        'email',
        'phone_number',
        'project_category',
        'site_location',
        'estimated_budget_idr',
        'planned_area_sqm',
        'project_notes',
        'source_channel',
        'status',
        'internal_admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'estimated_budget_idr' => 'decimal:2',
            'planned_area_sqm' => 'decimal:2',
        ];
    }

    /** @return HasMany<RfpAttachment, $this> */
    public function attachments(): HasMany
    {
        return $this->hasMany(RfpAttachment::class);
    }

    public function markAsContacted(): void
    {
        $this->update(['status' => 'contacted']);
    }

    public function markAsSurveyScheduled(): void
    {
        $this->update(['status' => 'survey_scheduled']);
    }
}
