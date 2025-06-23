<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User registration</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-gray-100">
    <header class="flex justify-between items-center p-6 bg-green-500 text-white">
        <h1 class="text-3xl font-sans">ZeroWasteWagon</h1>
        <div class="space-x-4 flex items-center">
            <a href="/about-us" class="hover:underline">About Us</a>
            <a href="{{ route('locale', 'lt') }}" class="hover:underline">Lietuvių</a>
            <a href="{{ route('locale', 'en') }}" class="hover:underline">English</a>
    </header>
    
    <div class="flex flex-col justify-center p-6 pb-12">
        <div class="mx-auto max-w-md p-6">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" height="85px" width="85px" class="mx-auto text-green-600 w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            <h2 class="mt-6 text-3xl font-bold text-gray-900">@lang('main.user_create_acc')</h2> 
        </div>
    </div>


    <div class="pb-12 flex items-center justify-center">
        <div class="bg-white/80 p-8 rounded-sl shadow-md shodow-xl backdrop-blur-lg w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center">@lang('main.user_info')</h2>
            <ul>
                @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
            <form action="{{ route('register') }}" method="post" autocomplete="off">
                @csrf
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-gray-700">@lang('main.name')</label>
                    <div class="mb-4">
                        <input type="text" name="name" placeholder="John Doe" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2" required>
                    </div>
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-gray-700">Email</label>
                    <div class="mb-4">
                        <input type="text" name="email" placeholder="Email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2" required>
                    </div>
                </div>

                <div>
                    <label for="Password" class="mb-2 block text-sm font-medium text-gray-700">@lang('main.password')</label>
                    <div class="mb-4">
                        <input type="password" name="password" placeholder="password123"  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2" required>
                    </div>
                </div>

                <div>
                    <label for="Repeat your password" class="mb-2 block text-sm font-medium text-gray-700">@lang('main.password_re')</label>
                    <div class="mb-4">
                        <input type="password" name="password_confirmation" placeholder="password123" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2" required>
                    </div>
                </div>

                <div class="flex justify-center">
                    <button type="submit" class="mb-3 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md shadow-lg hover:shadow-xl focus:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 transition duration-150 ease-in-out">@lang('main.register')</button>
                </div>
            </form>
            <a href="/login" class="flex justify-center hover:underline">@lang('main.user_have_account')</a>
        </div>
    </div>
    
</body>

</html>
