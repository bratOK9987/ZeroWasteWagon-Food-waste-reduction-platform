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

        <div class="px-2 py-4 w-full flex justify-center">
            <div class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <div class="flex items-center justify-between py-4 px-6">
                    <div class="flex items-center">
                        <img src="{{ asset('storage/' . $el->image_path) }}" alt="Offer Image" class="w-40 h-40 object-cover">
                        <div class="ml-4">
                            <h1 class="font-bold">{{ $el->name }}</h1>
                            <div class="menu-item">
                                <h2>{{ $el->description }}</h2>
                                <p>Left only: {{ $el->quantity }}</p>
                                <p class="font-bold text-red-500">{{ $el->price }}€</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center py-4">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>


        @endforeach




    <!-- <footer class="text-center p-6 bg-gray-800 text-white"> -->
        <!-- © 2024 ZeroWasteWagon. All rights reserved. -->
    <!-- </footer> -->

    <script>
        document.getElementById('loginDropdown').addEventListener('click', function() {
            document.getElementById('dropdownContent').classList.toggle('hidden');
        });
    </script>
</body>
</html>
