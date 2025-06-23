<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner Account Information</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <header class="flex justify-between items-center p-6 bg-green-500 text-white">
        <h1 class="text-3xl">Account Information</h1>
        <a href="{{ route('partner.dashboard') }}" class="hover:underline text-white">Home</a>
    </header>

    <div class="container mx-auto mt-4 p-4 bg-white shadow-md rounded">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-2xl mb-4">Account Details</h2>
        <form action="{{ route('partner.update-account-info') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="venue_name" class="block text-gray-700">Venue Name</label>
                <input type="text" name="venue_name" id="venue_name" class="border rounded w-full py-2 px-3 mt-1" value="{{ $partner->venue_name }}" required>
                @error('venue_name')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="venue_phone_number" class="block text-gray-700">Phone Number</label>
                <input type="text" name="venue_phone_number" id="venue_phone_number" class="border rounded w-full py-2 px-3 mt-1" value="{{ $partner->venue_phone_number }}" required>
                @error('venue_phone_number')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="venue_city" class="block text-gray-700">City</label>
                <input type="text" name="venue_city" id="venue_city" class="border rounded w-full py-2 px-3 mt-1" value="{{ $partner->venue_city }}" required>
                @error('venue_city')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="venue_country" class="block text-gray-700">Country</label>
                <input type="text" name="venue_country" id="venue_country" class="border rounded w-full py-2 px-3 mt-1" value="{{ $partner->venue_country }}" required>
                @error('venue_country')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="address" class="block text-gray-700">Address</label>
                <input type="text" name="address" id="address" class="border rounded w-full py-2 px-3 mt-1" value="{{ $partner->address }}" required>
                @error('address')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Account Info</button>
        </form>

        <h2 class="text-2xl mt-6 mb-4">Pickup Times</h2>
        <form action="{{ route('partner.update-pickup-times') }}" method="POST">
            @csrf
            @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                <div class="mb-4">
                    <label class="block text-gray-700">{{ $day }}</label>
                    <div class="flex space-x-2">
                        <input type="time" name="pickup_times[{{ $day }}][start_time]" class="border rounded py-2 px-3 mt-1" value="{{ $pickupTimes[$day]->start_time ?? '' }}" step="1800">
                        <input type="time" name="pickup_times[{{ $day }}][end_time]" class="border rounded py-2 px-3 mt-1" value="{{ $pickupTimes[$day]->end_time ?? '' }}" step="1800">
                    </div>
                </div>
            @endforeach
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Pickup Times</button>
        </form>

        <h2 class="text-2xl mt-6 mb-4">Change Password</h2>
        <form action="{{ route('partner.update-password') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="current_password" class="block text-gray-700">Current Password</label>
                <input type="password" name="current_password" id="current_password" class="border rounded w-full py-2 px-3 mt-1" required>
                @error('current_password')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="new_password" class="block text-gray-700">New Password</label>
                <input type="password" name="new_password" id="new_password" class="border rounded w-full py-2 px-3 mt-1" required>
                @error('new_password')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="new_password_confirmation" class="block text-gray-700">Confirm New Password</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="border rounded w-full py-2 px-3 mt-1" required>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Password</button>
        </form>
    </div>
    <footer class="text-center p-6 bg-gray-800 text-white mt-6">
        © 2024 ZeroWasteWagon. All rights reserved.
    </footer>
</body>
</html>
