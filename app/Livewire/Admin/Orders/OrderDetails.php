<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Livewire\Component;

class OrderDetails extends Component
{
    public Order $order;
    public $status;

    public function mount(Order $order)
{
    $user = auth()->user();

    // السماح للأدمن بالدخول دائماً
    if (strtolower($user->role) !== 'admin' && 
        $user->id !== $order->seller_id && 
        $user->id !== $order->buyer_id) {
        abort(403, 'لا تملك صلاحية الوصول لهذا الطلب');
    }

    $this->order = $order;
}

    /**
     * تحديث الحالة فوراً عند تغييرها في الواجهة
     */
    public function updatedStatus($value)
    {
        $this->order->update([
            'status' => $value
        ]);

        session()->flash('success', 'تم تحديث حالة الطلب بنجاح.');
    }

    public function render()
    {
        return view('livewire.admin.orders.order-details')
            ->layout('layouts.app');
    }
}