<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HistoryOfOrder;

class UserOrderController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // Get the currently authenticated user's ID

        // Retrieve all orders for the user from history_of_orders
        $orders = HistoryOfOrder::with('offer')
            ->where('user_id', $userId)
            ->get();

            return view('order_history', compact('orders')); // Update view path
    }
}
