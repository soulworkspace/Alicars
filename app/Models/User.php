<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * الحقول القابلة للتعبئة - Mass Assignable
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'whatsapp',
        'address',
        'avatar',
        'is_active',
        'last_login_at',
    ];

    /**
     * الحقول المخفية
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * تحويل أنواع البيانات (Casting)
     * ملاحظة: دمجنا كل شيء في الدالة لأنها الأسلوب الأحدث في Laravel 11
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | العلاقات (Relations)
    |--------------------------------------------------------------------------
    */
    public function store(): HasOne
    {
        return $this->hasOne(Store::class);
    }

    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function staffInvitations(): HasMany
    {
        return $this->hasMany(StaffInvitation::class, 'invited_by');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /*
    |--------------------------------------------------------------------------
    | منطق التحقق والأدوار (Roles & Logic)
    |--------------------------------------------------------------------------
    */
    
    // التحقق من الأدمن
    public function isAdmin(): bool
    {
        return $this->role === 'admin' || $this->hasRole('admin');
    }

    // التحقق من البائع (نستخدم 'vendor' كقيمة أساسية للتوافق مع الـ Migration)
    public function isVendor(): bool
    {
        return in_array($this->role, ['vendor', 'seller']) || $this->hasRole('vendor') || $this->hasRole('seller');
    }

    public function isSeller(): bool
    {
        return $this->isVendor();
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff' || $this->hasRole('staff');
    }

    public function isBuyer(): bool
    {
        return $this->role === 'buyer' || $this->hasRole('buyer');
    }

    public function hasStore(): bool
    {
        return $this->store()->exists();
    }

    public function canCreateStore(): bool
    {
        return !$this->hasStore() && ($this->isVendor() || $this->isAdmin());
    }

    public function getAdsCount(): int
    {
        return $this->ads()->count();
    }

    public function canCreateMoreAds(): bool
    {
        return $this->getAdsCount() < 30 || $this->isAdmin();
    }

    /*
    |--------------------------------------------------------------------------
    | أدوات التصفية والوظائف (Scopes & Helpers)
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function markLastLogin(): void
    {
        // تم استخدام update مباشرة لتجاوز مشاكل الـ save في بعض الحالات
        $this->update(['last_login_at' => now()]);
    }
}