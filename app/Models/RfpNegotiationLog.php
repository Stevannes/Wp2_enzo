<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RfpNegotiationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'inquiry_rfp_id',
        'user_id',
        'stage',
        'proposed_amount_idr',
        'client_notes',
        'admin_response',
    ];

    protected $casts = [
        'proposed_amount_idr' => 'float',
    ];

    public function inquiryRfp(): BelongsTo
    {
        return $this->belongsTo(InquiryRfp::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
