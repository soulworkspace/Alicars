<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeaturedAd extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_id',
        'position',
        'sort_order',
        'starts_at',
        'ends_at',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now());
    }

    public function scopeHeader($query)
    {
        return $query->where('position', 'header');
    }

    public function scopeSidebar($query)
    {
        return $query->where('position', 'sidebar');
    }

    public function scopeCategory($query)
    {
        return $query->where('position', 'category');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function isExpired(): bool
    {
        return $this->ends_at < now();
    }
}
