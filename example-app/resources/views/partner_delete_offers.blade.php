<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Offer - Partner Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-2xl font-bold text-red-600 mb-4">Confirm Offer Deletion</h1>
        <p>Are you sure you want to delete this offer?</p>
        <form action="{{ route('offers.destroy', $offer->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
            <a href="{{ route('offers.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</a>
        </form>
    </div>

    <footer class="text-center p-6 bg-gray-800 text-white">
        © 2024 ZeroWasteWagon. All rights reserved.
    </footer>
</body>
</html>
