<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Offer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    .active {
        background-color: white !important; /* Override background color */
        color: black !important; /* Change text color for visibility */
        border: 2px solid; /* Optional: add border to maintain visibility */
    }
    </style>
</head>
<body class="bg-gray-100">
    <header class="flex justify-between items-center p-6 bg-green-500 text-white">
        <h1 class="text-3xl">ZeroWasteWagon</h1>
        <div class="space-x-4 flex items-center">
            <a href="{{ route('locale', 'lt') }}" class="hover:underline">Lietuvių</a>
            <a href="{{ route('locale', 'en') }}" class="hover:underline">English</a>
            <a href="#" class="hover:underline">@lang('main.acount_info')</a>
            <a href="/" class="hover:underline">@lang('main.logout')</a>
        </div>
    </header>
    <div class="container mx-auto p-8">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold text-green-700">@lang('main.create_offer_sescription')</h1>
            <a href="{{ route('partner.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">@lang('main.return_to_dashboard')</a>
        </div>
                <!-- Error Messages -->
            @if ($errors->any())
            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                Error creating the offer. Please check your inputs.
            </div>
            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('success'))
            <div class="bg-green-500 text-white font-bold rounded-t px-4 py-2">
                {{ session('success') }}
            </div>
            @endif

        <form action="{{ route('offers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="flex flex-wrap -mx-2">
                <!-- Left Column -->
                <div class="w-full md:w-1/2 px-2 mb-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">@lang('main.pa_offer_name')</label>
                        <input type="text" id="name" name="name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">@lang('main.pa_offer_description')</label>
                        <textarea id="description" name="description" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"></textarea>
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">@lang('main.pa_offer_price')</label>
                        <input type="number" id="price" name="price" step="0.01" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700">@lang('main.pa_offer_quantity')</label>
                        <input type="number" id="quantity" name="quantity" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700">@lang('main.pa_offer_image')</label>
                        <input type="file" id="image" name="image" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>
                </div>
                <!-- Right Column -->
                <div class="w-full md:w-1/2 px-2 mb-4">
                <div>
                <label for="cuisine_type" class="block text-sm font-medium text-gray-700">@lang('main.cuisine_type')</label>
                <select id="cuisine_type" name="cuisine_type" class="mt-1 block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                <option value="">@lang('main.cuisine_select')</option>
                <option value="Italian">@lang('main.it')</option>
                <option value="Mexican">@lang('main.me')</option>
                <option value="Chinese">@lang('main.ch')</option>
                <option value="Indian">@lang('main.ind')</option>
                <option value="French">@lang('main.fr')</option>
                </select>
                </div>
                <div class="mt-4">
                    <label for="dietary_restrictions" class="block text-sm font-medium text-gray-700">Dietary Restrictions:</label>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <!-- Stylized buttons for dietary restrictions -->
                        <button type="button" class="bg-green-500 text-white rounded px-4 py-2 shadow inline-flex items-center" onclick="toggleCheckbox('vegan')">
                            <i class="fas fa-leaf mr-2"></i> @lang('main.vegan')
                        </button>
                        <button type="button" class="bg-blue-500 text-white rounded px-4 py-2 shadow inline-flex items-center" onclick="toggleCheckbox('gluten_free')">
                            <i class="fas fa-bread-slice mr-2"></i> @lang('main.gluten')
                        </button>
                        <button type="button" class="bg-purple-500 text-white rounded px-4 py-2 shadow inline-flex items-center" onclick="toggleCheckbox('vegetarian')">
                            <i class="fas fa-carrot mr-2"></i> @lang('main.vegeterian')
                        </button>
                        <button type="button" class="bg-red-500 text-white rounded px-4 py-2 shadow inline-flex items-center" onclick="toggleCheckbox('keto')">
                            <i class="fas fa-bacon mr-2"></i> Keto
                        </button>
                        <button type="button" class="bg-yellow-500 text-white rounded px-4 py-2 shadow inline-flex items-center" onclick="toggleCheckbox('paleo')">
                            <i class="fas fa-drumstick-bite mr-2"></i> Paleo
                        </button>
                        <button type="button" class="bg-teal-500 text-white rounded px-4 py-2 shadow inline-flex items-center" onclick="toggleCheckbox('dairy_free')">
                            <i class="fas fa-cheese mr-2"></i> @lang('main.dairy')
                        </button>
                    </div>
                </div>
                <div>
                    <label for="caloric_content" class="block text-sm font-medium text-gray-700">@lang('main.caloric_content')</label>
                    <input type="number" id="caloric_content" name="caloric_content" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="@lang('main.kcal_paceholder')">
                </div>
            </div>
            <!-- Hidden checkboxes for form submission -->
<input type="checkbox" id="vegan" name="dietary_restrictions[]" value="vegan" hidden>
<input type="checkbox" id="gluten_free" name="dietary_restrictions[]" value="gluten_free" hidden>
<input type="checkbox" id="vegetarian" name="dietary_restrictions[]" value="vegetarian" hidden>
<input type="checkbox" id="keto" name="dietary_restrictions[]" value="keto" hidden>
<input type="checkbox" id="paleo" name="dietary_restrictions[]" value="paleo" hidden>
<input type="checkbox" id="dairy_free" name="dietary_restrictions[]" value="dairy_free" hidden>
            </div>
            <button type="submit" class="inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                @lang('main.submit_order')
            </button>
        </form>
    </div>
    <footer class="text-center p-6 bg-gray-800 text-white">
        @lang('main.footer')
    </footer>
    <script>
    function toggleCheckbox(value) {
        var checkbox = document.getElementById(value);
        var button = document.querySelector(`button[onclick="toggleCheckbox('${value}')"]`);
        if (checkbox) {
            checkbox.checked = !checkbox.checked; // Toggle the state of the checkbox
            button.classList.toggle('active'); // Toggle a class that changes the appearance
        }
    }
</script>
</body>
</html>
