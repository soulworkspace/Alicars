<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OrderDetails extends Component
{
    public Order $order;
    public string $status = '';

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
    $this->status = $order->status;
}

    /**
     * تحديث الحالة فوراً عند تغييرها في الواجهة
     */
    public function updatedStatus($value)
    {
        $allowedStatuses = ['pending', 'processing', 'shipped', 'delivered', 'completed', 'cancelled'];
        if (! in_array($value, $allowedStatuses, true) || $value === $this->order->status) {
            return;
        }

        DB::transaction(function () use ($value) {
            $this->order->update(['status' => $value]);
            OrderStatusHistory::create([
                'order_id' => $this->order->id,
                'user_id' => auth()->id(),
                'status' => $value,
            ]);
        });

        $this->order->refresh();
        $this->status = $this->order->status;
        session()->flash('success', 'تم تحديث حالة الطلب وتسجيل التغيير.');
    }

    public function render()
    {
        $this->order->load(['buyer', 'listing', 'statusHistories.user']);

        return view('livewire.admin.orders.order-details', ['order' => $this->order])
            ->layout('layouts.app');
    }
}