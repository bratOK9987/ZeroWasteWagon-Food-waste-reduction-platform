<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Information</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <header class="flex justify-between items-center p-6 bg-green-500 text-white">
        <h1 class="text-3xl">Account Information</h1>
        <a href="{{ route('dashboard') }}" class="hover:underline text-white">Home</a>
    </header>

    <div class="container mx-auto mt-4 p-4 bg-white shadow-md rounded">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-2xl mb-4">Account Details</h2>
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>

        <h2 class="text-2xl mt-6 mb-4">Change Password</h2>
        <form action="{{ route('user.update-password') }}" method="POST">
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
</body>
</html>
