<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffInvitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'invited_by',
        'email',
        'token',
        'permissions',
        'accepted_at',
        'expires_at',
    ];

    protected $casts = [
        'permissions' => 'array',
        'accepted_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function scopePending($query)
    {
        return $query->whereNull('accepted_at')
            ->where('expires_at', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }

    public function isAccepted(): bool
    {
        return !is_null($this->accepted_at);
    }

    public function isExpired(): bool
    {
        return $this->expires_at < now();
    }

    public function markAsAccepted(): void
    {
        $this->update(['accepted_at' => now()]);
    }
}
