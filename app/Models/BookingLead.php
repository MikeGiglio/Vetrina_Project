<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingLead extends Model
{
    protected $fillable = [
        'name',
        'arrival',
        'departure',
        'nights',
        'arrival_time',
        'guests',
        'ip_address',
        'status',
        'notes',
    ];

    public function blockedDates()
    {
        return $this->hasMany(\App\Models\BlockedDate::class, 'lead_id');
    }

    protected function casts(): array
    {
        return [
            'arrival'   => 'date',
            'departure' => 'date',
        ];
    }
}
