<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Models\Partner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Services\GeocodingService;
use App\Models\HistoryOfOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\PickupTime;

class PartnerController extends Controller
{
    /**
     * Display the initial form for registration, where partners input their invitation code.
     */
    public function showStep1Form()
    {
        return view('step1-partner-registration');
    }

    /**
     * Process the invitation code submitted by the partner.
     * Validate the existence and unused status of the code in the database.
     * Mark the invitation as used and store the invitation code in the session.
     * Redirect to the next registration step.
     */
    public function validateInvitation(Request $request)
    {
        $request->validate([
            'invitation_code' => 'required|exists:invitations,invitation_code,used,false'
        ], [
            'invitation_code.required' => 'The invitation code is required to proceed.',
            'invitation_code.exists' => 'The provided invitation code is invalid or has already been used.'
        ]);

        $invitation = Invitation::where('invitation_code', $request->invitation_code)->first();
        $invitation->used = true;
        $invitation->save();

        session(['invitation_code' => $request->invitation_code]);

        return redirect()->route('partner.registration.step2');
    }

    /**
     * Show the form for venue information input.
     * Check if the invitation code is stored in the session.
     */
    public function showStep2Form()
    {
        if (!session()->has('invitation_code')) {
            return redirect()->route('partner.registration.step1')->with('error', 'Invitation code is required.');
        }
        return view('step2-partner-registration');
    }

    /**
     * Validate and store venue information in the session.
     * Redirect to the next step for finalizing registration details.
     */
    public function registerStep2(Request $request)
    {
        $validatedData = $request->validate([
            'venue_country' => 'required|string|max:255',
            'venue_city' => 'required|string|max:255',
            'venue_name' => 'required|string|max:255',
            'venue_type' => 'nullable|string|max:255',
        ]);

        session($validatedData);

        return redirect()->route('partner.registration.step3');
    }

    /**
     * Display the final form to collect contact information.
     * Ensure that venue information has been properly set in the session.
     */
    public function showStep3Form()
    {
        if (!session()->has('venue_name')) {
            return redirect()->route('partner.registration.step2')->with('error', 'Venue information is required.');
        }
        return view('step3-partner-registration');
    }

    /**
     * Finalize the registration by validating contact information.
     * Attempt to geocode the venue address.
     * Create the partner record in the database.
     * Clear session variables related to the registration process.
     * Redirect to the home page with a success message.
     */
    public function registerStep3(Request $request, GeocodingService $geocodingService)
    {
        $validatedData = $request->validate([
            'website' => 'nullable|url|max:255',
            'address' => 'required|string|max:255',
            'venue_phone_number' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:partners',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $location = $geocodingService->geocodeAddress($validatedData['address']);

        if (!$location) {
            return back()->withErrors('Failed to geocode address. Please check and try again.');
        }

        Partner::create([
            'venue_type' => session('venue_type'),
            'venue_name' => session('venue_name'),
            'address' => $validatedData['address'],
            'latitude' => $location['lat'], // Save latitude
            'longitude' => $location['lon'], // Save longitude
            'website' => $validatedData['website'],
            'venue_phone_number' => $validatedData['venue_phone_number'],
            'venue_city' => session('venue_city'),
            'venue_country' => session('venue_country'),
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Clear session data related to registration
        Session::forget(['invitation_code', 'venue_type', 'venue_name', 'venue_city', 'venue_country']);

        return redirect('/')->with('success', 'Partner registration successful and location geocoded.');
    }
        
        public function viewOrders()
    {
        $partnerId = auth()->user()->id; 

        $orders = HistoryOfOrder::whereHas('offer', function ($query) use ($partnerId) {
            $query->where('partner_id', $partnerId);
        })->with(['user', 'offer'])->get();

        return view('orders', compact('orders'));
    }

    public function account()
    {
        $partner = Auth::guard('partner')->user();
        $pickupTimes = $partner->pickupTimes()->get()->keyBy('day_of_week');
        return view('partner_account', compact('partner', 'pickupTimes'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $partner = Auth::guard('partner')->user();

        if (!Hash::check($request->current_password, $partner->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'The provided password does not match your current password.',
            ]);
        }

        $partner->password = Hash::make($request->new_password);
        $partner->save();

        return redirect()->route('partner.account')->with('success', 'Password updated successfully.');
    }

    public function updateAccountInfo(Request $request, GeocodingService $geocodingService)
    {
        $partner = Auth::guard('partner')->user();

        $request->validate([
            'venue_name' => 'required|string|max:255',
            'venue_phone_number' => 'required|string|max:255',
            'venue_city' => 'required|string|max:255',
            'venue_country' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        // Geocode the address
        $location = $geocodingService->geocodeAddress($request->address);

        if (!$location) {
            return back()->withErrors('Failed to geocode address. Please check and try again.');
        }

        $partner->venue_name = $request->venue_name;
        $partner->venue_phone_number = $request->venue_phone_number;
        $partner->venue_city = $request->venue_city;
        $partner->venue_country = $request->venue_country;
        $partner->address = $request->address;
        $partner->latitude = $location['lat'];
        $partner->longitude = $location['lon'];
        $partner->save();

        return redirect()->route('partner.account')->with('success', 'Account information updated successfully.');
    }
    

    public function updatePickupTimes(Request $request)
    {
        $partner = Auth::guard('partner')->user();
        $pickupTimesData = $request->input('pickup_times', []);

        foreach ($pickupTimesData as $day => $times) {
            $partner->pickupTimes()->updateOrCreate(
                ['day_of_week' => $day],
                ['start_time' => $times['start_time'], 'end_time' => $times['end_time']]
            );
        }

        return redirect()->route('partner.account')->with('success', 'Pickup times updated successfully.');
    }

    public function getPickupTimesForToday() {
        $today = now()->format('l'); // Get today's day of the week (e.g., 'Monday')
        $pickupTimes = PickupTime::where('day_of_week', $today)->with('partner')->get();
        return response()->json($pickupTimes);
    }
    
    
}
