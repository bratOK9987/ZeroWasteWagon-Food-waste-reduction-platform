<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Models\ActiveOrder;
use App\Models\HistoryOfOrder; 
use Illuminate\Support\Facades\Auth;
use Log;

class PaymentController extends Controller
{
        public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Total Cart Value',
                    ],
                    'unit_amount' => $request->total * 100, 
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success'),
            'cancel_url' => route('payment.cancel'),
        ]);

        return response()->json(['id' => $session->id]);
    }


    public function success(Request $request)
    {
        $user = Auth::user();

        // Retrieve all active orders for the user
        $activeOrders = ActiveOrder::where('user_id', $user->id)->get();

        foreach ($activeOrders as $activeOrder) {
            // Copy active orders to history of orders
            HistoryOfOrder::create([
                'user_id' => $activeOrder->user_id,
                'offer_id' => $activeOrder->offer_id,
                'quantity' => $activeOrder->quantity,
                'paid' => true
            ]);

            // Update ActiveOrder as paid
            $activeOrder->update(['paid' => true]);

            
             $activeOrder->delete();
        }

        // Redirect to a success page
        return view('success', ['message' => 'Thank you for your purchase! Your order has been processed successfully.']);
    }

    public function cancel()
    {
        return view('cancel');
    }
}
