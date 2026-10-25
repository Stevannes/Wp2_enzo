<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InquiryRfp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rfp_number',
        'full_name',
        'company_name',
        'email',
        'phone_number',
        'project_category',
        'design_layout_id',
        'site_location',
        'estimated_budget_idr',
        'deal_amount_idr',
        'deal_date',
        'payment_scheme',
        'planned_area_sqm',
        'project_notes',
        'source_channel',
        'status',
        'assigned_to_user_id',
        'admin_last_viewed_at',
        'reminder_count',
        'last_reminder_at',
        'internal_admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'estimated_budget_idr' => 'decimal:2',
            'deal_amount_idr' => 'decimal:2',
            'planned_area_sqm' => 'decimal:2',
            'admin_last_viewed_at' => 'datetime',
            'last_reminder_at' => 'datetime',
            'deal_date' => 'date',
            'reminder_count' => 'integer',
        ];
    }

    /** @return HasMany<RfpAttachment, $this> */
    public function attachments(): HasMany
    {
        return $this->hasMany(RfpAttachment::class);
    }

    public function customerUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function designLayout(): BelongsTo
    {
        return $this->belongsTo(DesignLayout::class, 'design_layout_id');
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    public function negotiationLogs(): HasMany
    {
        return $this->hasMany(RfpNegotiationLog::class)->latest();
    }

    public function progressLogs(): HasMany
    {
        return $this->hasMany(ConstructionProgressLog::class)->orderBy('day_number');
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(ProjectComplaint::class)->latest();
    }

    public function getPaymentSchemeLabelAttribute(): string
    {
        return match ($this->payment_scheme) {
            'cash_tempo', null => 'Pembayaran Tunai Bertahap',
            'cash' => 'Tunai Keras (Cash)',
            'kpr_bank' => 'Kredit Pemilikan Rumah (KPR Bank)',
            default => 'Pembayaran Tunai Bertahap',
        };
    }

    /**
     * Poin 4 Evaluasi Dosen: Cek apakah tiket butuh pengingat admin.
     * Butuh perhatian jika berstatus 'submitted'/'in_review' dan belum dilihat admin dalam 6 jam.
     */
    public function needsAdminAttention(): bool
    {
        if (in_array($this->status, ['deal', 'rejected', 'completed'])) {
            return false;
        }

        if (is_null($this->admin_last_viewed_at)) {
            return true;
        }

        return $this->admin_last_viewed_at->lt(now()->subHours(6));
    }
}
