<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Support\Facades\DB;
use App\Notifications\OrderStatusUpdatedNotification;

class OrderShow extends Component
{
    public Order $order;
    public string $status = '';
    public string $note = '';

    public function mount(Order $order): void
    {
        abort_unless(auth()->user()->isAdmin() || $order->seller_id === auth()->id(), 403);

        $this->order = $order;
        $this->status = $order->status;
    }

    public function updatedStatus(string $value): void
    {
        $allowedStatuses = ['pending', 'processing', 'shipped', 'delivered', 'completed', 'cancelled'];

        if (! in_array($value, $allowedStatuses, true)) {
            $this->status = $this->order->status;
            return;
        }

        if ($value === $this->order->status) {
            return;
        }

        DB::transaction(function () use ($value) {
            // 1. تحديث الحالة في قاعدة البيانات
            $this->order->update(['status' => $value]);

            // 2. تسجيل التغيير في سجل الحالات
            OrderStatusHistory::create([
                'order_id' => $this->order->id,
                'user_id'  => auth()->id(),
                'status'   => $value,
                'note'     => $this->note ?: null,
            ]);
        });

        $this->order->refresh();
        $this->status = $this->order->status;
        $this->note = ''; // إعادة تعيين الملاحظة

        // 3. إرسال إشعار للمشتري
        if ($this->order->buyer) {
            $this->order->buyer->notify(new OrderStatusUpdatedNotification($this->order));
        }

        // 4. إطلاق الأحداث والتنبيهات للواجهة
        $this->dispatch('status-updated', message: 'تم حفظ حالة الطلب بنجاح وإشعار العميل.');
        session()->flash('success', 'تم تحديث حالة الطلب وتسجيل التغيير.');
    }

    public function render()
{
    // تحميل العلاقات المتاحة في موديل Order بدقة
    $this->order->load(['buyer', 'listing', 'statusHistories.user']);

    return view('livewire.admin.orders.order-details', [
        'order' => $this->order
    ])->layout('layouts.admin');
}
}