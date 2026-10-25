<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'google_id', 'phone_number', 'company_name', 'avatar', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function assignedInquiryRfps(): HasMany
    {
        return $this->hasMany(InquiryRfp::class, 'assigned_to_user_id');
    }

    public function customerInquiryRfps(): HasMany
    {
        return $this->hasMany(InquiryRfp::class, 'user_id');
    }

    public function rfpNegotiationLogs(): HasMany
    {
        return $this->hasMany(RfpNegotiationLog::class);
    }
}
