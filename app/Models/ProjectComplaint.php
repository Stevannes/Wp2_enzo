<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectComplaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'inquiry_rfp_id',
        'complaint_ticket',
        'category',
        'title',
        'description',
        'photo_proof',
        'urgency',
        'status',
        'admin_solution_notes',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function inquiryRfp(): BelongsTo
    {
        return $this->belongsTo(InquiryRfp::class);
    }
}
