<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RfpAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'inquiry_rfp_id',
        'original_filename',
        'file_path',
        'file_type',
        'file_size_bytes',
    ];

    protected function casts(): array
    {
        return [
            'file_size_bytes' => 'integer',
        ];
    }

    /** @return BelongsTo<InquiryRfp, $this> */
    public function inquiry(): BelongsTo
    {
        return $this->belongsTo(InquiryRfp::class, 'inquiry_rfp_id');
    }
}
