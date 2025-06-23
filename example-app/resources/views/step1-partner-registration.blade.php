<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step 1: Partner Registration</title>
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
            <h2 class="text-2xl font-bold mb-6 text-center">@lang('main.inv_code')</h2>
            @if ($errors->any())
            <div id="invitation_code_error" style="color: red; display: none;"></div>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Whoops!</strong>
                    <span class="block sm:inline">{{ $errors->first() }}</span>
                </div>
            @endif
            <form action="{{ route('partner.registration.step1.post') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <input type="text" name="invitation_code" placeholder="Invitation Code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                
                <div class="flex justify-center">
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">@lang('main.next')</button>
                </div>
            </form>
        </div>
    </div>
</body>
    <script>
    document.getElementById('invitation_code').addEventListener('input', function(e) {
        const input = e.target;
        const errorDiv = document.getElementById('invitation_code_error');
        if (input.value.length !== 6) {
            errorDiv.textContent = "The invitation code must be exactly 6 characters.";
            errorDiv.style.display = 'block';
        } else {
            errorDiv.textContent = "";
            errorDiv.style.display = 'none';
        }
    });
    </script>
</html>
