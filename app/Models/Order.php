<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
    'buyer_id',
    'listing_id',
    'seller_id',
    'size',
    'color',
    'quantity',
    'total_price',
    'status',
    'phone',
    'city',
    'shipping_address', // <--- تأكد من كتابتها هنا بشكل صحيح
    'notes',
];

    public function listing(): BelongsTo {
        return $this->belongsTo(Ad::class, 'listing_id');
    }

    public function buyer(): BelongsTo {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class)->latest();
    }

    // خاصية سحرية لتلوين الحالة تلقائياً
    public function getStatusColorAttribute(): string {
        return match($this->status) {
            'pending'    => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
            'shipped'    => 'bg-purple-100 text-purple-800 border-purple-200',
            'delivered'  => 'bg-green-100 text-green-800 border-green-200',
            'completed'  => 'bg-green-100 text-green-800 border-green-200',
            'cancelled'  => 'bg-red-100 text-red-800 border-red-200',
            default      => 'bg-blue-100 text-blue-800 border-blue-200',
        };
    }

    public function getStatusLabelAttribute(): string {
        return match($this->status) {
            'pending' => '⏳ قيد الانتظار',
            'processing' => '⚙️ قيد التجهيز',
            'shipped' => '🚚 تم الشحن',
            'delivered', 'completed' => '✅ مكتمل',
            'cancelled' => '❌ ملغي',
            default => $this->status,
        };
    }
}