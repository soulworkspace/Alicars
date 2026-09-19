<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * السماح للأدمن بكل شيء دائماً (Super Override)
     */
    public function before(User $user, $ability)
    {
        if (strtolower($user->role) === 'admin') {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return true; // السماح للجميع بالعرض حالياً لحل المشكلة
    }

    public function view(User $user, Order $order): bool
    {
        return true; // السماح بعرض التفاصيل
    }
}