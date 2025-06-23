<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ActiveOrder;
use Illuminate\Support\Facades\Log;

class ExpireOrders extends Command
{
    protected $signature = 'expire:orders';
    protected $description = 'Expire orders that have not been paid within 10 minutes';

    public function handle()
    {
        $expiredOrders = ActiveOrder::where('paid', false)
                                    ->where('created_at', '<', now()->subMinutes(10))
                                    ->get();

        foreach ($expiredOrders as $order) {
            $order->offer->increment('quantity', $order->quantity);
            $order->delete();
        }

        Log::info("Processed " . $expiredOrders->count() . " expired orders.");
        $this->info('Expired orders processed: ' . $expiredOrders->count());
    }
}
