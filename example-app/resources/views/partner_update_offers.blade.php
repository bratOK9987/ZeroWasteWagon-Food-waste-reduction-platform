<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Offer - Partner Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .active {
            background-color: white; /* Override background color */
            color: black; /* Change text color for visibility */
            border: 2px solid gray; /* Ensure visibility */
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
    <h1 class="text-3xl font-bold text-green-700 mb-4">Edit your Offer</h1>

            <!-- Error Messages -->
            @if ($errors->any())
            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                Error updating the offer. Please check your inputs.
            </div>
            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Success Message -->
            @if (session('success'))
            <div class="bg-green-500 text-white font-bold rounded-t px-4 py-2">
                {{ session('success') }}
            </div>
            @endif

            <div>
                <a href="{{ route('offers.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Back to List of Offers</a>
                <a href="{{ route('partner.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">@lang('main.return_to_dashboard')</a>
            </div>
        <form action="{{ route('offers.update', $offer->id) }}" method="POST" enctype="multipart/form-data" class="w-full max-w-lg">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">@lang('main.pa_offer_name')</label>
                <input type="text" name="name" id="name" value="{{ $offer->name }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">@lang('main.pa_offer_description')</label>
                <textarea id="description" name="description" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">{{ $offer->description }}</textarea>
            </div>

            <!-- Price -->
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">@lang('main.pa_offer_price')</label>
                <input type="number" id="price" name="price" step="0.01" value="{{ $offer->price }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
            </div>

            <!-- Quantity -->
            <div class="mb-4">
                <label for="quantity" class="block text-sm font-medium text-gray-700">@lang('main.pa_offer_quantity')</label>
                <input type="number" id="quantity" name="quantity" step="1" value="{{ $offer->quantity }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
            </div>

            <!-- Image Upload -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">@lang('main.pa_offer_image')</label>
                <input type="file" id="image" name="image" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                @error('image')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                <div class="mt-1">
                    <img src="{{ asset('storage/' . $offer->image_path) }}" alt="Current Offer Image" class="w-20 h-20 object-cover">
                </div>
            </div>

            <!-- Cuisine Type -->
            <div class="mb-4">
                <label for="cuisine_type" class="block text-sm font-medium text-gray-700">@lang('main.cuisine_type')</label>
                <select id="cuisine_type" name="cuisine_type" class="mt-1 block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    <option value="">@lang('main.cuisine_select')</option>
                    <option value="Italian" {{ $offer->cuisine_type == 'Italian' ? 'selected' : '' }}>@lang('main.it')</option>
                    <option value="Mexican" {{ $offer->cuisine_type == 'Mexican' ? 'selected' : '' }}>@lang('main.me')</option>
                    <option value="Chinese" {{ $offer->cuisine_type == 'Chinese' ? 'selected' : '' }}>@lang('main.ch')</option>
                    <option value="Indian" {{ $offer->cuisine_type == 'Indian' ? 'selected' : '' }}>@lang('main.ind')</option>
                    <option value="French" {{ $offer->cuisine_type == 'French' ? 'selected' : '' }}>@lang('main.fr')</option>
                </select>
            </div>

            <!-- Caloric Content -->
            <div class="mb-4">
                <label for="caloric_content" class="block text-sm font-medium text-gray-700">@lang('main.caloric_content')</label>
                <input type="number" id="caloric_content" name="caloric_content" value="{{ $offer->caloric_content }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
            </div>

            <!-- Dietary Restrictions Buttons -->
            <div class="mb-4">
    <label for="dietary_restrictions" class="block text-sm font-medium text-gray-700">@lang('main.restrictions')</label>
    <div class="flex flex-wrap gap-2">
        @php
            $dietary_restrictions = json_decode($offer->dietary_restrictions, true);
        @endphp

        <!-- Vegan -->
        <button type="button" class="dietary-btn bg-green-500 text-white rounded px-4 py-2 shadow inline-flex items-center {{ in_array('vegan', $dietary_restrictions ?? []) ? 'active' : '' }}" onclick="toggleCheckbox('vegan')" id="btn_vegan">
            <i class="fas fa-leaf mr-2"></i> @lang('main.vegan')
            <input type="checkbox" id="vegan" name="dietary_restrictions[]" value="vegan" hidden {{ in_array('vegan', $dietary_restrictions ?? []) ? 'checked' : '' }}>
        </button>

        <!-- Gluten-free -->
        <button type="button" class="dietary-btn bg-blue-500 text-white rounded px-4 py-2 shadow inline-flex items-center {{ in_array('gluten_free', $dietary_restrictions ?? []) ? 'active' : '' }}" onclick="toggleCheckbox('gluten_free')" id="btn_gluten_free">
            <i class="fas fa-bread-slice mr-2"></i> @lang('main.gluten')
            <input type="checkbox" id="gluten_free" name="dietary_restrictions[]" value="gluten_free" hidden {{ in_array('gluten_free', $dietary_restrictions ?? []) ? 'checked' : '' }}>
        </button>

        <!-- Vegetarian -->
        <button type="button" class="dietary-btn bg-orange-500 text-white rounded px-4 py-2 shadow inline-flex items-center {{ in_array('vegetarian', $dietary_restrictions ?? []) ? 'active' : '' }}" onclick="toggleCheckbox('vegetarian')" id="btn_vegetarian">
            <i class="fas fa-carrot mr-2"></i> @lang('main.vegeterian')
            <input type="checkbox" id="vegetarian" name="dietary_restrictions[]" value="vegetarian" hidden {{ in_array('vegetarian', $dietary_restrictions ?? []) ? 'checked' : '' }}>
        </button>

        <!-- Keto -->
        <button type="button" class="dietary-btn bg-red-500 text-white rounded px-4 py-2 shadow inline-flex items-center {{ in_array('keto', $dietary_restrictions ?? []) ? 'active' : '' }}" onclick="toggleCheckbox('keto')" id="btn_keto">
            <i class="fas fa-bacon mr-2"></i> Keto
            <input type="checkbox" id="keto" name="dietary_restrictions[]" value="keto" hidden {{ in_array('keto', $dietary_restrictions ?? []) ? 'checked' : '' }}>
        </button>

        <!-- Paleo -->
        <button type="button" class="dietary-btn bg-yellow-600 text-white rounded px-4 py-2 shadow inline-flex items-center {{ in_array('paleo', $dietary_restrictions ?? []) ? 'active' : '' }}" onclick="toggleCheckbox('paleo')" id="btn_paleo">
            <i class="fas fa-drumstick-bite mr-2"></i> Paleo
            <input type="checkbox" id="paleo" name="dietary_restrictions[]" value="paleo" hidden {{ in_array('paleo', $dietary_restrictions ?? []) ? 'checked' : '' }}>
        </button>

        <!-- Dairy-free -->
        <button type="button" class="dietary-btn bg-teal-500 text-white rounded px-4 py-2 shadow inline-flex items-center {{ in_array('dairy_free', $dietary_restrictions ?? []) ? 'active' : '' }}" onclick="toggleCheckbox('dairy_free')" id="btn_dairy_free">
            <i class="fas fa-cheese mr-2"></i> @lang('main.dairy')
            <input type="checkbox" id="dairy_free" name="dietary_restrictions[]" value="dairy_free" hidden {{ in_array('dairy_free', $dietary_restrictions ?? []) ? 'checked' : '' }}>
        </button>
    </div>
</div>
<script>
    function toggleCheckbox(value) {
        var checkbox = document.getElementById(value);
        var button = document.getElementById('btn_' + value);
        if (checkbox) {
            checkbox.checked = !checkbox.checked; // Toggle the state of the checkbox
            button.classList.toggle('active'); // Toggle a class that changes the appearance
        }
    }
</script>

            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">@lang('main.update')</button>
        </form>
    </div>

    <footer class="text-center p-6 bg-gray-800 text-white">
        @lang('main.footer')
    </footer>
</body>
</html>
