<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner Offers</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <header class="flex justify-between items-center p-6 bg-green-500 text-white">
        <h1 class="text-3xl">ZeroWasteWagon</h1>
        <div class="space-x-4 flex items-center">
            <a href="{{ route('locale', 'lt') }}" class="hover:underline">Lietuvių</a>
            <a href="{{ route('locale', 'en') }}" class="hover:underline">English</a>
            <a href="#" class="hover:underline">Account Info</a>
            <a href="/" class="hover:underline">Logout</a>
        </div>
    </header>

    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold text-green-700 mb-4">Published Offers</h1>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Image</th>
                    <th class="py-2 px-4 border-b">Name</th>
                    <th class="py-2 px-4 border-b">Description</th>
                    <th class="py-2 px-4 border-b">Price</th>
                    <th class="py-2 px-4 border-b">Quantity</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($publishedOffers as $offer)
                    <tr>
                        <td class="py-2 px-4 border-b">
                            <img src="{{ asset('storage/' . $offer->image_path) }}" alt="Offer Image" class="w-20 h-20 object-cover">
                        </td>
                        <td class="py-2 px-4 border-b">{{ $offer->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $offer->description }}</td>
                        <td class="py-2 px-4 border-b">{{ $offer->price }}</td>
                        <td class="py-2 px-4 border-b">{{ $offer->quantity }}</td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('offers.edit', $offer->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Edit</a>
                            <form action="{{ route('offers.unpublish', $offer->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Unpublish</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h1 class="text-3xl font-bold text-green-700 mt-8 mb-4">Unpublished Offers</h1>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Image</th>
                    <th class="py-2 px-4 border-b">Name</th>
                    <th class="py-2 px-4 border-b">Description</th>
                    <th class="py-2 px-4 border-b">Price</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($unpublishedOffers as $offer)
                    <tr>
                        <td class="py-2 px-4 border-b">
                            <img src="{{ asset('storage/' . $offer->image_path) }}" alt="Offer Image" class="w-20 h-20 object-cover">
                        </td>
                        <td class="py-2 px-4 border-b">{{ $offer->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $offer->description }}</td>
                        <td class="py-2 px-4 border-b">{{ $offer->price }}</td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('offers.edit', $offer->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Edit</a>
                            <form action="{{ route('offers.publish', $offer->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="number" name="quantity" placeholder="Enter Quantity" class="mt-1 block w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm mb-2" required>
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">Publish</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <footer class="text-center p-6 bg-gray-800 text-white">
        &copy; 2024 ZeroWasteWagon. All rights reserved.
    </footer>
</body>
</html>
