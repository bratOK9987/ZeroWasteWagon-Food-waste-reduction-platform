<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZeroWasteWagon</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col justify-between bg-gray-100">

    <header class="flex justify-between items-center p-6 bg-green-500 text-white">
        <h1 class="text-3xl font-sans">ZeroWasteWagon</h1>
        <div class="space-x-4 flex items-center">
            <a href="/about-us" class="hover:underline">@lang('main.about')</a>
            <a href="{{ route('locale', 'lt') }}" class="hover:underline">Lietuvių</a>
            <a href="{{ route('locale', 'en') }}" class="hover:underline">English</a>
            <div class="relative" id="loginDropdown">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md shadow-lg hover:shadow-xl focus:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 transition duration-150 ease-in-out dropdown-btn">@lang('main.login')</button>
                <div class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-md  hover:shadow-xl focus:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 transition duration-150 ease-in-out shadow-xl hidden z-10" id="dropdownContent">
                    <div class="mb-3">
                        <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md shadow-lg hover:shadow-xl focus:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 transition duration-150 ease-in-out">@lang('main.user')</a>
                    </div>
                    <div>
                        <a href="{{ route('partner.login.form') }}"  class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md">@lang('main.partner')</a>
                
                     </div>    
                </div>
            </div>
        </div>
    </header>


    <div class="flex flex-col justify-center p-6 pb-12">
        <div class="mx-auto max-w-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" height="100px" width="100px" class="mx-auto text-green-600 w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
            </svg>
            <h2 class="mt-6 text-3xl font-bold text-gray-900">@lang('main.welcome')</h2> 
        </div>
        <div class="mt-5 p-1 mx-auto rounded-xl">
            <h2 class="mt-6 text-xl font-bold text-gray-900">@lang('main.join_us')</h2>
        </div>

        <div class="text-center flex max-w-md p-6 mx-auto space-x-4">
            <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md shadow-lg hover:shadow-xl focus:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 transition duration-150 ease-in-out">
                @lang('main.start_eating')
            </a>
            <a href="{{ route('partner.registration.step1') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md shadow-lg hover:shadow-xl focus:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 transition duration-150 ease-in-out">
                @lang('main.start_selling')
            </a>
        </div>
    </div>

    <!-- <div class="bg-white/80 backdrop-blur-xl mt-10 p-10 mx-auto rounded-xl shadow-xl">
       <h2 class="mt-6 text-xl font-bold text-gray-900">Join us on this journey toward a more sustainable future.</h2>
    </div> -->


    <!-- <div class="flex flex-col justify-center border border-green-700 bg-white/50 bacdrop-blur-xl p-6">
        <div class="border border-green-700 text-center mx-auto max-w-md p-10 bg-white/50 bacdrop-blur-xl mt-10 rounded-xl shadow-xl">
            <h2 class="text-3xl font-bold text-gray-900">Welcome to ZeroWasteWagon</h2>
            <p class="mb-4">Join us on this journey toward a more sustainable future.</p>
            <div class="flex text-center mx-auto space-x-4">
                <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md shadow-lg hover:shadow-xl focus:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 transition duration-150 ease-in-out">
                    Start Eating
                </a>
                <a href="{{ route('partner.registration.step1') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md shadow-lg hover:shadow-xl focus:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 transition duration-150 ease-in-out">
                    Start Selling
                </a>
            </div>
        </div>
    </div> -->

    <footer class="text-center p-6 bg-gray-800 text-white">
        @lang('main.footer')
    </footer>

    

    <script>
        document.getElementById('loginDropdown').addEventListener('click', function() {
            document.getElementById('dropdownContent').classList.toggle('hidden');
        });
    </script>
</body>
</html>
