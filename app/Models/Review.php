<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'name',
        'surname',
        'email',
        'rating',
        'text',
        'otp_code',
        'otp_expires_at',
        'otp_attempts',
        'email_verified_at',
        'is_approved',
        'consent_marketing',
    ];

    protected $casts = [
        'otp_expires_at'    => 'datetime',
        'email_verified_at' => 'datetime',
        'is_approved'       => 'boolean',
        'consent_marketing' => 'boolean',
        'rating'            => 'integer',
        'otp_attempts'      => 'integer',
    ];

    public function getFullNameAttribute(): string
    {
        return trim($this->name . ' ' . ($this->surname ?? ''));
    }

    public function getInitialsAttribute(): string
    {
        $first = mb_substr($this->name, 0, 1);
        $last  = $this->surname ? mb_substr($this->surname, 0, 1) : '';
        return mb_strtoupper($first . $last);
    }
}
