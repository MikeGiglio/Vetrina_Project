<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EmailSubscriber extends Model
{
    protected $fillable = [
        'email',
        'name',
        'source',
        'consent_ip',
        'consent_at',
        'unsubscribe_token',
        'unsubscribed_at',
        'unsubscribed_ip',
    ];

    protected $casts = [
        'consent_at'      => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (EmailSubscriber $s) {
            if (! $s->unsubscribe_token) {
                $s->unsubscribe_token = Str::random(48);
            }
        });
    }

    public function scopeActive($q)
    {
        return $q->whereNull('unsubscribed_at');
    }

    public function unsubscribeUrl(): string
    {
        return url('/unsubscribe/' . $this->unsubscribe_token);
    }
}
