<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZeroWasteWagon-Partner Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <header class="flex justify-between items-center p-6 bg-green-500 text-white">
        <h1 class="text-3xl">ZeroWasteWagon</h1>
        <div class="space-x-4 flex items-center">
            <a href="{{ route('locale', 'lt') }}" class="hover:underline">Lietuvių</a>
            <a href="{{ route('locale', 'en') }}" class="hover:underline">English</a>
            <a href="{{ route('partner.account') }}" class="hover:underline">@lang('main.acount_info')</a>
            <a href="/" class="hover:underline">@lang('main.logout')</a>

        </div>
    </header>

    <div class="container mx-auto px-4 py-8">
        <div class="text-center">
            <h2 class="text-2xl mb-4">@lang('main.pa_dashboard')</h2>
            <p class="mb-4">@lang('main.pa_dash_description')</p>
            <div class="space-x-4 mt-4">
                <a href="{{ route('offers.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">@lang('main.new_offer')</a>
                <a href="{{ route('offers.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">@lang('main.view_offers')</a>
                <a href="{{ route('partner.orders') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">@lang('main.view_orders')</a>
            </div>
        </div>
    </div>

    <footer class="text-center p-6 bg-gray-800 text-white">
        @lang('main.footer')
    </footer>
</body>
</html>
