<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('orders')->select(['id', 'status', 'created_at'])->orderBy('id')->chunkById(500, function ($orders) {
            $now = now();
            $history = $orders->map(fn ($order) => [
                'order_id' => $order->id,
                'user_id' => null,
                'status' => $order->status ?: 'pending',
                'created_at' => $order->created_at ?: $now,
                'updated_at' => $order->created_at ?: $now,
            ])->all();

            if ($history !== []) {
                DB::table('order_status_histories')->insertOrIgnore($history);
            }
        });
    }

    public function down(): void
    {
        DB::table('order_status_histories')->whereNull('user_id')->delete();
    }
};
