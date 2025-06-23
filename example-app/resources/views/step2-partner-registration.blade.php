<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step 2: Partner Registration</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <header class="flex justify-between items-center p-6 bg-green-500 text-white">
        <h1 class="text-3xl font-sans">ZeroWasteWagon</h1>
        <div class="space-x-4 flex items-center">
            <a href="/about-us" class="hover:underline">About Us</a>
            <a href="{{ route('locale', 'lt') }}" class="hover:underline">Lietuvių</a>
            <a href="{{ route('locale', 'en') }}" class="hover:underline">English</a>
    </header>
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center">@lang('main.ve_info')</h2>
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Whoops!</strong>
                    <span class="block sm:inline">{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('partner.registration.step2.post') }}" method="POST">
                @csrf
                <div class="mb-4">

                    <input type="text" name="venue_country" placeholder="Venue Country" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>

                </div>
                <div class="mb-4">
                    <input type="text" name="venue_city" placeholder="Venue City" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required maxlength="255">
                </div>
                <div class="mb-4">
                    <input type="text" name="venue_name" placeholder="Venue Name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required maxlength="255">
                </div>
                <div class="mb-4">
                    <input type="text" name="venue_country" placeholder="@lang('main.country')" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required maxlength="255">
                </div>
                <div class="mb-4">
                    <input type="text" name="venue_city" placeholder="@lang('main.city')" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required maxlength="255">
                </div>
                <div class="mb-4">
                    <input type="text" name="venue_name" placeholder="@lang('main.ve_name')" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required maxlength="255">
                </div>
                <div class="mb-4">
                    <input type="text" name="venue_type" placeholder="@lang('main.ve_type')" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" maxlength="255">

                </div>
                <div class="flex justify-center">
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">@lang('main.next')</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
