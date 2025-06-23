<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodOffer;
use App\Models\Partner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class FoodOfferController extends Controller
{
    public function create()
    {
        return view('create_offer');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|max:255',
            'quantity' => 'required|integer|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cuisine_type' => 'nullable|string|max:255',
            'caloric_content' => 'nullable|integer|max:5000',
            'dietary_restrictions' => 'nullable|array',
            'dietary_restrictions.*' => 'string|max:255'
        ]);

        try {
            $imagePath = $request->file('image')->store('offer_images', 'public');
            $offer = new FoodOffer([
                'partner_id' => Auth::guard('partner')->user()->id,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'image_path' => $imagePath,
                'dietary_restrictions' => json_encode($request->dietary_restrictions),
                'cuisine_type' => $request->cuisine_type,
                'caloric_content' => $request->caloric_content,
            ]);
            $offer->save();

            return redirect()->route('partner.dashboard')->with('success', 'Offer created successfully.');
        } catch (\Exception $e) {
            \Log::error('Error creating offer:', ['error' => $e->getMessage()]);
            return back()->withErrors('Failed to create offer: ' . $e->getMessage())->withInput();
        }
    }

    public function allData() {
        $venues = Partner::with(['offers' => function ($query) {
            $query->where('quantity', '>', 0); // Only fetch offers that are available
        }])->get();

        return response()->json($venues);
    }

    public function venuesList()
    {
        return view('user_list_of_venues', ['data' => Partner::all()]);
    }

    public function list()
    {
        return view('user_list_of_offers');
    }

    public function getFoodOffersByPartner(Partner $id)
    {
        $foodOffers = FoodOffer::where('partner_id', $id->id)->get();

        return view('user_list_of_offers', ['data' => $foodOffers]);
    }

    public function dashboard(Request $request)
    {
        $venues = Partner::with(['offers' => function($query) {
            $query->where('quantity', '>', 0); // Filter offers to only include those available
        }])
        ->has('offers') // Ensure the venue has at least one offer
        ->get();

        $dietaryOptions = [
            'Vegan',
            'Vegetarian',
            'Gluten-Free',
            'Nut-Free',
            'Dairy-Free'
        ];
        if ($request->ajax()) {
            return response()->json($venues);
        }

        return view('user_dashboard', compact('venues', 'dietaryOptions'));
    }

        public function index()
    {
        $partnerId = Auth::guard('partner')->user()->id;
        $publishedOffers = FoodOffer::where('partner_id', $partnerId)->where('quantity', '>', 0)->get();
        $unpublishedOffers = FoodOffer::where('partner_id', $partnerId)->where('quantity', '=', 0)->get();

        return view('partner_list_offers', compact('publishedOffers', 'unpublishedOffers'));
    }

    public function edit(FoodOffer $offer)
    {
        return view('partner_update_offers', compact('offer'));
    }

    public function update(Request $request, FoodOffer $offer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|max:255',
            'quantity' => 'required|integer|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cuisine_type' => 'nullable|string|max:255',
            'caloric_content' => 'nullable|integer|max:5000',
            'dietary_restrictions' => 'nullable|array',
            'dietary_restrictions.*' => 'string|max:255',
        ]);

        $data = $request->except(['image', '_token', '_method']);

        if ($request->hasFile('image')) {
            if ($offer->image_path && Storage::exists('public/' . $offer->image_path)) {
                Storage::delete('public/' . $offer->image_path);
            }

            $imagePath = $request->file('image')->store('offer_images', 'public');
            $data['image_path'] = $imagePath;
        }

        if (isset($data['dietary_restrictions'])) {
            $data['dietary_restrictions'] = json_encode($data['dietary_restrictions']);
        }

        $offer->update($data);
        return redirect()->route('offers.index')->with('success', 'Offer updated successfully.');
    }

    public function destroy(FoodOffer $offer)
    {
        // No need to delete offers, they will be unpublished
        return redirect()->route('offers.index')->with('success', 'Offer deleted successfully.');
    }

    public function unpublish(FoodOffer $offer)
    {
        $offer->update(['quantity' => 0]);
        return redirect()->route('offers.index')->with('success', 'Offer unpublished successfully.');
    }

    public function publish(Request $request, FoodOffer $offer)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $offer->update(['quantity' => $request->quantity]);
        return redirect()->route('offers.index')->with('success', 'Offer published successfully.');
    }
    

    public function getLatestOffers()
    {
        $offers = FoodOffer::where('quantity', '>', 0)->get();
        return response()->json($offers);
    }
}
