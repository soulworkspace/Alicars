<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Component;
use App\Models\Order;

class OrderShow extends Component
{
    public Order $order;
    public $status;

    public function mount(Order $order)
    {
        $this->order = $order;
        $this->status = $order->status; // جلب الحالة الحالية
    }

    // هذه الدالة تعمل تلقائياً عند تغيير الـ Select في القالب
    public function updatedStatus($value)
    {
        $this->order->update([
            'status' => $value
        ]);

        session()->flash('success', 'تم تحديث حالة الطلب بنجاح إلى: ' . $value);
    }

    public function render()
{
    // قم بتغيير 'livewire.admin.orders.show' إلى الاسم الصحيح للملف
    return view('livewire.admin.orders.order-details')
            ->layout('layouts.app');
}
}