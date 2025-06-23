<?php

namespace App\Http\Controllers;
use App\Models\HistoryOfOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Partner;
use App\Models\User;

class OrderController extends Controller
{
    public function index()
{
    // Assuming a Partner is logged in and their relationship with offers is set up correctly
    $partner = Auth::guard('partner')->user();
    $orders = HistoryOfOrder::whereHas('offer', function ($query) use ($partner) {
        $query->where('partner_id', $partner->id);
    })->with(['user', 'offer'])->get();

    return view('partners.orders', compact('orders'));
}
}
