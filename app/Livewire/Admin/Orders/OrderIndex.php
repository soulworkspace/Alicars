<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order; // 1. تأكد من استيراد المودل الخاص بالطلب

class OrderIndex extends Component 
{
    use WithPagination;

    public function render()
    {
        // 2. جلب الطلبات مع الترقيم (مثلاً 10 في كل صفحة)
        // واستخدام ->latest() لترتيبها من الأحدث
        $orders = Order::latest()->paginate(10);

        // 3. تمرير المتغير $orders إلى صفحة العرض
        return view('livewire.admin.orders.order-index', [
            'orders' => $orders
        ])->layout('layouts.app'); 
    }
}