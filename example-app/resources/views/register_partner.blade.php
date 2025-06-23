<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner Registration</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl mb-4">Partner Registration</h2>

        @if($errors->any())
        <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
            Whoops! Something went wrong.
        </div>
        <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('register.partner') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <!-- Venue Type (optional) -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="venue_type">Venue Type</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="venue_type" type="text" placeholder="Enter Venue Type">
            </div>

            <!-- Venue Name -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="venue_name">Venue Name</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="venue_name" type="text" placeholder="Enter Venue Name" required>
            </div>

            <!-- Address -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="address">Address</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="address" type="text" placeholder="Enter Address" required>
            </div>

            <!-- Website (optional) -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="website">Website</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="website" type="text" placeholder="Enter Website">
            </div>

            <!-- Venue Phone Number -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="venue_phone_number">Venue Phone Number</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="venue_phone_number" type="text" placeholder="Enter Venue Phone Number" required>
            </div>

            <!-- Venue City -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="venue_city">Venue City</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="venue_city" type="text" placeholder="Enter Venue City" required>
            </div>

            <!-- Venue Country -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="venue_country">Venue Country</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="venue_country" type="text" placeholder="Enter Venue Country" required>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="email" type="email" placeholder="Enter Email" required>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="password" type="password" placeholder="Enter Password" required>
            </div>

            <!-- Password Confirmation -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">Confirm Password</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="password_confirmation" type="password" placeholder="Enter Confirm Password" required>
            </div>

            <!-- Invitation Code -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="invitation_code">Invitation Code</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="invitation_code" type="text" placeholder="Enter Invitation Code" required>
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Register
                </button>
            </div>
        </form>
    </div>
</body>
</html>
