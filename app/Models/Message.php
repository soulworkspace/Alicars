<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_id',
        'sender_id',
        'sender_name',
        'sender_phone',
        'sender_email',
        'message',
        'type',
        'offer_amount',
        'status',
        'read_at',
    ];

    protected $casts = [
        'offer_amount' => 'decimal:2',
        'read_at' => 'datetime',
    ];

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    public function scopeInquiries($query)
    {
        return $query->where('type', 'inquiry');
    }

    public function scopeOffers($query)
    {
        return $query->where('type', 'offer');
    }

    public function scopeBuyRequests($query)
    {
        return $query->where('type', 'buy_request');
    }

    public function markAsRead(): void
    {
        $this->update([
            'status' => 'read',
            'read_at' => now(),
        ]);
    }

    public function markAsReplied(): void
    {
        $this->update(['status' => 'replied']);
    }

    public function getWhatsAppLinkAttribute(): ?string
    {
        if ($this->sender_phone) {
            $phone = preg_replace('/[^0-9]/', '', $this->sender_phone);
            return "https://wa.me/{$phone}";
        }
        return null;
    }
}
