<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailCampaign extends Model
{
    protected $fillable = [
        'subject',
        'body',
        'body_format',
        'created_by',
        'total_recipients',
        'sent_count',
        'failed_count',
        'status',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'started_at'  => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function progressPercent(): int
    {
        if ($this->total_recipients <= 0) {
            return 0;
        }
        return (int) floor((($this->sent_count + $this->failed_count) / $this->total_recipients) * 100);
    }

    public function isDone(): bool
    {
        return in_array($this->status, ['sent', 'failed'], true);
    }
}
