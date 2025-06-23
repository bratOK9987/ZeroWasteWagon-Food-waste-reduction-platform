<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FoodOffer;  
use App\Models\ActiveOrder; 

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $offerId = $request->input('offerId');
        $requestedQuantity = (int) $request->input('quantity');

        // Retrieve the offer and check stock
        $offer = FoodOffer::findOrFail($offerId);
        if ($offer->quantity < $requestedQuantity) {
            return response()->json(['success' => false, 'message' => 'Not enough stock available']);
        }

        // Deduct the quantity from the stock
        $offer->decrement('quantity', $requestedQuantity);

        // Add to active_orders
        ActiveOrder::create([
            'user_id' => Auth::id(),
            'offer_id' => $offerId,
            'quantity' => $requestedQuantity
        ]);

        return response()->json(['success' => true, 'message' => 'Item added to cart successfully']);
    }

        public function showCart()
    {
        $userId = Auth::id(); // Ensure you have the user logged in

        // Retrieve all active orders for the user
        $activeOrders = ActiveOrder::with('offer')->where('user_id', $userId)->get();

        $items = $activeOrders->map(function ($order) {
            return [
                'id' => $order->id,
                'name' => $order->offer->name,
                'price' => $order->offer->price,
                'image_path' => $order->offer->image_path,
                'quantity' => $order->quantity,
                'created_at' => $order->created_at->timestamp // Pass the timestamp
            ];
        });

        return view('cart', ['items' => $items]);
    }


    public function removeFromCart($id)
    {
        $order = ActiveOrder::find($id);
        if ($order && !$order->paid) {
            $order->offer->increment('quantity', $order->quantity);
            $order->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
    

}
