<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    // خاصية سحرية لتلوين الحالة تلقائياً
    public function getStatusColorAttribute(): string {
        return match($this->status) {
            'pending'    => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'completed'  => 'bg-green-100 text-green-800 border-green-200',
            'cancelled'  => 'bg-red-100 text-red-800 border-red-200',
            default      => 'bg-blue-100 text-blue-800 border-blue-200',
        };
    }

    public function getStatusLabelAttribute(): string {
        return match($this->status) {
            'pending'   => 'انتظار',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي',
            default     => 'معالجة',
        };
    }
}