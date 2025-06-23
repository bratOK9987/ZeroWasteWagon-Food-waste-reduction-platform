<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZeroWasteWagon</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
    <header class="flex justify-between items-center p-6 bg-green-500 text-white">
        <h1 class="text-3xl">ZeroWasteWagon</h1>
        <div class="space-x-4 flex items-center">
            <a href="/about-us" class="hover:underline">About Us</a>
            <a href="/about-us" class="hover:underline">Log out</a>
        </div>
    </header>

    <div class="container mx-auto px-4 py-8">
        
    <div class="text-center">
    <h2 class="text-3xl mb-4 font-bold text-blue-600 relative">
        <span style="border-bottom: 3px solid #00FF00;">Current Offers</span>
    </h2>
</div>

        @foreach($data as $el)

        <a href="{{ route('smth', ['partner_id' => 1]) }}" class="font-bold">|{{ $el->venue_name }}|</a>

        
        @endforeach

    <script>
        document.getElementById('loginDropdown').addEventListener('click', function() {
            document.getElementById('dropdownContent').classList.toggle('hidden');
        });
    </script>
</body>
</html>
