<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConstructionProgressLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'inquiry_rfp_id',
        'day_number',
        'log_date',
        'stage_name',
        'description',
        'promised_render_image',
        'actual_field_photo',
        'progress_percentage',
        'logged_by_name',
    ];

    protected $casts = [
        'day_number' => 'integer',
        'log_date' => 'date',
        'progress_percentage' => 'float',
    ];

    public function inquiryRfp(): BelongsTo
    {
        return $this->belongsTo(InquiryRfp::class);
    }
}
