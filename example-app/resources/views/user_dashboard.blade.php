<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - ZeroWasteWagon</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider/distribute/nouislider.min.css">
    <style>
        .modal-close {
            padding: 1rem;
            margin: -1rem -1rem -1rem auto;
        }

        #offerModal {
            z-index: 1050; /* Keeps the original z-index for the offer modal */
        }

        #confirmationModal {
            z-index: 1100; /* Higher than the offer modal to ensure visibility on top */
        }

        #offerModal .modal-close i, #confirmationModal .modal-close i {
            font-size: 1.5rem;
        }

        #map {
            height: 400px;
            z-index: 500; /* Lower than modals */
        }

        .custom-icon {
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            font-size: 1.5em;
            color: #2A3F54;
        }

        .user-icon {
            font-size: 1.8em;
            color: #4A90E2;
        }
        
        /* Centering the modal more effectively */
        #confirmationModal .modal-content {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 30%; 
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.5);
        }

        /* Make the map sticky */
        .sticky-map {
            position: -webkit-sticky;
            position: sticky;
            top: 20px; 
            height: calc(100vh - 40px); 
        }
        
        /* Wider dropdown for better usability */
        .dropdown-menu {
            width: 300px;
            z-index: 1000;
        }

        .slider-values {
            display: flex;
            justify-content: space-between;
        }

        .slider-values span {
            font-weight: bold;
        }

        /* Align buttons to the center */
        .button-container {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }
    </style>
</head>
<body class="bg-gray-50">
    <header class="flex justify-between items-center p-6 bg-green-500 text-white">
        <h1 class="text-3xl">ZeroWasteWagon</h1>
        <div class="space-x-4 flex items-center">
        <button onclick="window.location.href='{{ route('user.account') }}'" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    @lang('main.acount_info')
                </button>
            <a href="{{ route('locale', 'lt') }}" class="hover:underline">Lietuvių</a>
            <a href="{{ route('locale', 'en') }}" class="hover:underline">English</a>
            <a href="/" class="hover:underline">Log out</a>
        </div>
    </header>

    <div class="container mx-auto p-4">
        <div class="mb-4">
            <div class="button-container">
                <!-- Search input with reduced width -->
                <input type="text" id="search-input" class="flex-grow leading-normal w-1/4 h-10 border-grey-light rounded px-3" placeholder="@lang('main.search')" style="flex: none;">
                <!-- Search button -->
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-search"></i>
                </button>
                <!-- Filter button -->
                <div class="relative">
                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="toggleDropdown('filter-menu')">
                        <i class="fas fa-filter"></i> @lang('main.filter')
                    </button>
                    <div id="filter-menu" class="dropdown-menu hidden absolute bg-white border rounded shadow-lg">
                        <div class="p-4">
                            <label for="price-range" class="block">@lang('main.price_range')</label>
                            <div id="price-range"></div>
                            <div class="slider-values">
                                <span id="min-price-value"></span>
                                <span id="max-price-value"></span>
                            </div>
                            <label for="caloric-range" class="block mt-4">@lang('main.content')</label>
                            <div id="caloric-range"></div>
                            <div class="slider-values">
                                <span id="min-caloric-value"></span>
                                <span id="max-caloric-value"></span>
                            </div>
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4" onclick="applyFilters()">@lang('main.apply_fiters')</button>
                        </div>
                    </div>
                </div>
                <!-- Sort button -->
                <div class="relative">
                    <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded" onclick="toggleDropdown('sort-menu')">
                        <i class="fas fa-sort"></i> @lang('main.sort')
                    </button>
                    <div id="sort-menu" class="dropdown-menu hidden absolute bg-white border rounded shadow-lg">
                        <div class="p-4">
                            <button class="block w-full text-left" onclick="sortVenuesByDistance()">@lang('main.distance')</button>
                        </div>
                    </div>
                </div>
                <!-- Refresh button -->
                <button id="refresh-button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-sync"></i> @lang('main.refresh')
                </button>
                <!-- View Cart button -->
                <button onclick="window.location.href='/cart'" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    @lang('main.view_cart')
                </button>
                <!-- Order History button -->
                <button onclick="window.location.href='{{ route('user.order-history') }}'" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    @lang('main.order_history')
                </button>
            </div>
        </div>

        <!-- Venues and their offers -->
        <div class="flex flex-col md:flex-row md:space-x-4">
            <div id="venues-container" class="w-full md:w-1/2">
                <!-- Venues list -->
                @foreach ($venues as $venue)
                    @if ($venue->offers->count() > 0)
                        <div id="venue-{{ $venue->id }}" class="venue-item bg-white p-4 rounded-lg shadow mb-4" data-lat="{{ $venue->latitude }}" data-lng="{{ $venue->longitude }}">
                            <h2 class="font-bold text-lg venue-name">{{ $venue->venue_name }}</h2>
                            <p class="text-gray-600">{{ $venue->address }}</p>
                            <p class="text-gray-600 distance"></p>
                            <div id="pickup-times-{{ $venue->id }}" class="text-gray-600">Loading pickup times...</div>
                            <!-- Offers for each venue -->
                            <div class="mt-4 space-y-4">
                                @foreach ($venue->offers as $offer)
                                    <div class="offer-item flex items-center justify-between border-t border-gray-200 pt-2" data-price="{{ $offer->price }}" data-caloric="{{ $offer->caloric_content }}">
                                        <div class="flex items-center">
                                            <img src="{{ asset('storage/' . $offer->image_path) }}" alt="{{ $offer->name }}" class="w-16 h-16 object-cover rounded mr-4"> 
                                            <div>
                                                <h3 class="text-md font-bold offer-name">{{ $offer->name }}</h3>
                                                <p class="text-sm flex items-center">
                                                    <i class="fas fa-box-open mr-2"></i> 
                                                    {{ $offer->quantity }} available
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right flex items-center">
                                            <p class="text-lg text-green-500 font-bold mr-4">{{ number_format($offer->price, 2) }}€</p>
                                            <button class="mr-2 text-lg" onclick="addToCart({{ $offer->id }})">
                                                <i class="fas fa-cart-plus text-blue-500 hover:text-blue-700 cursor-pointer"></i>
                                            </button>
                                            <input type="number" value="1" min="1" max="{{ $offer->quantity }}" class="quantity-field" id="quantity-{{ $offer->id }}">

                                            <button class="text-lg" onclick='openModal({
                                                id: {{ $offer->id }},
                                                image: "{{ asset('storage/' . $offer->image_path) }}",
                                                name: "{{ $offer->name }}",
                                                description: "{{ $offer->description }}",
                                                quantity: "{{ $offer->quantity }}",
                                                price: "{{ number_format($offer->price, 2) }}",
                                                cuisine_type: "{{ $offer->cuisine_type }}",
                                                caloric_content: "{{ $offer->caloric_content }}",
                                                dietary_restrictions: @json($offer->dietary_restrictions)
                                            })'>
                                                <i class="fas fa-info-circle text-gray-500 hover:text-gray-700 cursor-pointer"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <!-- Right Column for Map -->
            <div class="w-full md:w-1/2 sticky-map">
                <div id="map"></div>
            </div>
        </div>
    </div>
    
    <!-- the modal here -->
    <div id="confirmationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full" onclick="closeConfirmationModal()">
        <div class="relative top-20 mx-auto p-5 border w-1/3 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center pb-3">
                <p class="text-2xl font-bold">Continue Shopping?</p>
                <div class="modal-close cursor-pointer z-50" onclick="closeConfirmationModal()">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="text-center p-5">
                <button onclick="closeConfirmationModal()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Continue Shopping
                </button>
                <button onclick="window.location.href='/cart'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4">
                    Go to Cart
                </button>
            </div>
        </div>
    </div>

    <footer class="text-center p-6 bg-gray-800 text-white mt-6">
        © 2024 ZeroWasteWagon. All rights reserved.
    </footer>
    
    <!-- Modal-->
    <div id="offerModal" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full" onclick="closeModal(event)">
        <!-- Modal content -->
        <div class="relative top-20 mx-auto p-5 border w-1/3 shadow-lg rounded-md bg-white">
            <!-- Close button (X icon) -->
            <div class="flex justify-between items-center pb-3">
                <p class="text-2xl font-bold">Offer Details</p>
                <div class="modal-close cursor-pointer z-50" onclick="closeModal(event)">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <!-- Dynamic content will be loaded here -->
            <div id="modalContent"></div>
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.7.0/nouislider.min.js"></script>
    <script>
    var map;  // Declare map in the global scope
    var userLat, userLng;
    var markers = {};
    var priceSlider, caloricSlider;

    function initMap() {
        map = L.map('map');  // Initialize map here

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        function addVenueMarkers() {
            @foreach ($venues as $venue)
                var venueIcon = L.divIcon({
                    className: 'custom-icon',
                    html: '<i class="fas fa-map-marker-alt"></i>' // using a Font Awesome icon
                });

                var marker = L.marker([{{ $venue->latitude }}, {{ $venue->longitude }}], {icon: venueIcon}).addTo(map);
                marker.bindPopup('<strong>{{ $venue->venue_name }}</strong><br>{{ $venue->address }}');
                markers[{{ $venue->id }}] = marker;
            @endforeach
        }

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                userLat = position.coords.latitude;
                userLng = position.coords.longitude;
                map.setView([userLat, userLng], 13);

                var userIcon = L.divIcon({
                    className: 'user-icon',
                    html: '<i class="fas fa-user-circle"></i>' 
                });

                L.marker([userLat, userLng], {icon: userIcon}).addTo(map)
                    .bindPopup("You are here.").openPopup();

                addVenueMarkers();
                attachHoverEventToVenues();
                calculateDistances();
            }, function(error) {
                console.error("Geolocation error: " + error.message);
                alert("Geolocation error: " + error.message);
                var firstVenueLat = @json($venues->first()->latitude ?? 51.505);
                var firstVenueLng = @json($venues->first()->longitude ?? -0.09);
                map.setView([firstVenueLat, firstVenueLng], 13);
                addVenueMarkers();
                attachHoverEventToVenues();
            });
        } else {
            alert("Geolocation is not supported by this browser.");
            console.error("Geolocation is not supported by this browser.");
            var firstVenueLat = @json($venues->first()->latitude ?? 51.505);
            var firstVenueLng = @json($venues->first()->longitude ?? -0.09);
            map.setView([firstVenueLat, firstVenueLng], 13);
            addVenueMarkers();
            attachHoverEventToVenues();
        }
    }

    function calculateDistances() {
        document.querySelectorAll('.venue-item').forEach(item => {
            var lat = parseFloat(item.getAttribute('data-lat'));
            var lng = parseFloat(item.getAttribute('data-lng'));
            var distance = calculateDistance(userLat, userLng, lat, lng);
            item.querySelector('.distance').textContent = `Distance: ${distance.toFixed(2)} km`;
        });
    }

    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Radius of the Earth in km
        const dLat = deg2rad(lat2 - lat1);
        const dLon = deg2rad(lon2 - lon1);
        const a = 
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c; // Distance in km
    }

    function deg2rad(deg) {
        return deg * (Math.PI / 180);
    }

    function attachHoverEventToVenues() {
        document.querySelectorAll('.venue-item').forEach(item => {
            item.addEventListener('mouseover', function() {
                var lat = this.getAttribute('data-lat');
                var lng = this.getAttribute('data-lng');
                map.setView([lat, lng], 15);
            });
        });
    }

    function toggleDropdown(menuId) {
        document.getElementById(menuId).classList.toggle('hidden');
    }

    function sortVenuesByDistance() {
        const venuesArray = Array.from(document.querySelectorAll('.venue-item'));
        venuesArray.sort((a, b) => {
            const latA = parseFloat(a.getAttribute('data-lat'));
            const lngA = parseFloat(a.getAttribute('data-lng'));
            const latB = parseFloat(b.getAttribute('data-lat'));
            const lngB = parseFloat(b.getAttribute('data-lng'));
            const distanceA = calculateDistance(userLat, userLng, latA, lngA);
            const distanceB = calculateDistance(userLat, userLng, latB, lngB);
            return distanceA - distanceB;
        });
        const venuesContainer = document.getElementById('venues-container');
        venuesContainer.innerHTML = '';
        venuesArray.forEach(venue => {
            venuesContainer.appendChild(venue);
        });

        // Close the sort dropdown menu
        document.getElementById('sort-menu').classList.add('hidden');
    }

    function initializeSliders() {
        const offers = document.querySelectorAll('.offer-item');
        const prices = Array.from(offers).map(offer => parseFloat(offer.getAttribute('data-price')));
        const calorics = Array.from(offers).map(offer => parseFloat(offer.getAttribute('data-caloric')));
        const minPrice = Math.min(...prices);
        const maxPrice = Math.max(...prices);
        const minCaloric = Math.min(...calorics);
        const maxCaloric = Math.max(...calorics);

        // Check if sliders are already initialized
        if (priceSlider && caloricSlider) {
            priceSlider.noUiSlider.updateOptions({
                range: {
                    min: minPrice,
                    max: maxPrice
                }
            });
            caloricSlider.noUiSlider.updateOptions({
                range: {
                    min: minCaloric,
                    max: maxCaloric
                }
            });
        } else {
            priceSlider = document.getElementById('price-range');
            noUiSlider.create(priceSlider, {
                start: [minPrice, maxPrice],
                connect: true,
                range: {
                    min: minPrice,
                    max: maxPrice
                },
                tooltips: false,
                format: {
                    to: value => value.toFixed(2),
                    from: value => parseFloat(value)
                }
            });
            priceSlider.noUiSlider.on('update', function (values, handle) {
                document.getElementById('min-price-value').innerText = values[0];
                document.getElementById('max-price-value').innerText = values[1];
            });

            caloricSlider = document.getElementById('caloric-range');
            noUiSlider.create(caloricSlider, {
                start: [minCaloric, maxCaloric],
                connect: true,
                range: {
                    min: minCaloric,
                    max: maxCaloric
                },
                tooltips: false,
                format: {
                    to: value => value.toFixed(0),
                    from: value => parseFloat(value)
                }
            });
            caloricSlider.noUiSlider.on('update', function (values, handle) {
                document.getElementById('min-caloric-value').innerText = values[0];
                document.getElementById('max-caloric-value').innerText = values[1];
            });
        }
    }

    function applyFilters() {
        const priceRange = priceSlider.noUiSlider.get();
        const minPrice = parseFloat(priceRange[0]);
        const maxPrice = parseFloat(priceRange[1]);

        const caloricRange = caloricSlider.noUiSlider.get();
        const minCaloric = parseFloat(caloricRange[0]);
        const maxCaloric = parseFloat(caloricRange[1]);

        document.querySelectorAll('.offer-item').forEach(item => {
            const price = parseFloat(item.getAttribute('data-price'));
            const caloric = parseFloat(item.getAttribute('data-caloric'));

            if (
                (isNaN(minPrice) || price >= minPrice) &&
                (isNaN(maxPrice) || price <= maxPrice) &&
                (isNaN(minCaloric) || caloric >= minCaloric) &&
                (isNaN(maxCaloric) || caloric <= maxCaloric)
            ) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });

        // Close the filter dropdown menu
        document.getElementById('filter-menu').classList.add('hidden');
    }

    function filterVenuesBySearch(query) {
        const normalizedQuery = query.toLowerCase();

        document.querySelectorAll('.venue-item').forEach(venue => {
            const venueName = venue.querySelector('.venue-name').textContent.toLowerCase();
            let offerMatches = false;

            venue.querySelectorAll('.offer-item').forEach(offer => {
                const offerName = offer.querySelector('.offer-name').textContent.toLowerCase();
                if (venueName.includes(normalizedQuery) || offerName.includes(normalizedQuery)) {
                    offer.style.display = '';
                    offerMatches = true;
                } else {
                    offer.style.display = 'none';
                }
            });

            if (venueName.includes(normalizedQuery) || offerMatches) {
                venue.style.display = '';
            } else {
                venue.style.display = 'none';
            }
        });
    }

    function openModal(offer) {
        document.getElementById('offerModal').classList.remove('hidden');

        const dietaryRestrictions = offer.dietary_restrictions ? JSON.parse(offer.dietary_restrictions) : [];
        let dietaryRestrictionsHtml = '';
        if (dietaryRestrictions.length > 0) {
            dietaryRestrictionsHtml = `<p><strong>Dietary:</strong> ${dietaryRestrictions.join(', ')}</p>`;
        }

        const modalContent = `
            <img src="${offer.image}" alt="${offer.name}" class="w-full h-64 object-cover rounded-t-lg mb-4">
            <h3 class="text-lg font-bold">${offer.name}</h3>
            <p>${offer.description}</p>
            <p><strong>Quantity:</strong> ${offer.quantity} available</p>
            <p><strong>Price:</strong> €${offer.price}</p>
            <p><strong>Cuisine Type:</strong> ${offer.cuisine_type}</p>
            <p><strong>Caloric Content:</strong> ${offer.caloric_content} calories</p>
            ${dietaryRestrictionsHtml}
            <input type="number" value="1" min="1" max="${offer.quantity}" class="quantity-field" id="modal-quantity-${offer.id}">
            <button class="mr-2 text-lg" onclick="addToCart(${offer.id}, 'modal-quantity-${offer.id}')">
                <i class="fas fa-cart-plus text-blue-500 hover:text-blue-700 cursor-pointer"> Add to Cart</i>
            </button>
        `;
        document.getElementById('modalContent').innerHTML = modalContent;
    }

    function addToCart(offerId, quantityFieldId = null) {
        var quantity = quantityFieldId ? document.getElementById(quantityFieldId).value : document.getElementById('quantity-' + offerId).value;
        fetch('/user/add-to-cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ offerId, quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Display the confirmation modal on successful add
                document.getElementById('confirmationModal').classList.remove('hidden');
            } else {
                alert('Failed to add item to cart.');
            }
        })
        .catch(error => {
            console.error('Error adding item to cart:', error);
            alert('Error adding item to cart.');
        });
    }

    function closeConfirmationModal() {
        document.getElementById('confirmationModal').classList.add('hidden');
    }

    function closeModal(event) {
        // Close the modal only if the user clicks on the modal background or the close button
        if (event.target === document.getElementById('offerModal') || event.target.closest('.modal-close')) {
            document.getElementById('offerModal').classList.add('hidden');
        }
    }

    document.getElementById('refresh-button').addEventListener('click', function() {
        fetch('/user/dashboard', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            const venuesContainer = document.getElementById('venues-container');
            venuesContainer.innerHTML = ''; // Clear existing content

            data.forEach(venue => {
                if (venue.offers.length > 0) {
                    let venueHTML = `
                        <div id="venue-${venue.id}" class="venue-item bg-white p-4 rounded-lg shadow mb-4" data-lat="${venue.latitude}" data-lng="${venue.longitude}">
                            <h2 class="font-bold text-lg venue-name">${venue.venue_name}</h2>
                            <p class="text-gray-600">${venue.address}</p>
                            <p class="text-gray-600 distance"></p>
                            <div class="mt-4 space-y-4">`;

                    venue.offers.forEach(offer => {
                        venueHTML += `
                            <div class="offer-item flex items-center justify-between border-t border-gray-200 pt-2" data-price="${offer.price}" data-caloric="${offer.caloric_content}">
                                <div class="flex items-center">
                                    <img src="/storage/${offer.image_path}" alt="${offer.name}" class="w-16 h-16 object-cover rounded mr-4">
                                    <div>
                                        <h3 class="text-md font-bold offer-name">${offer.name}</h3>
                                        <p class="text-sm flex items-center">
                                            <i class="fas fa-box-open mr-2"></i>
                                            ${offer.quantity} available
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right flex items-center">
                                    <p class="text-lg text-green-500 font-bold mr-4">${parseFloat(offer.price).toFixed(2)}€</p>
                                    <button class="mr-2 text-lg" onclick="addToCart(${offer.id})">
                                        <i class="fas fa-cart-plus text-blue-500 hover:text-blue-700 cursor-pointer"></i>
                                    </button>
                                    <input type="number" value="1" min="1" max="${offer.quantity}" class="quantity-field" id="quantity-${offer.id}">
                                    <button class="text-lg" onclick='openModal({
                                        id: ${offer.id},
                                        image: "/storage/${offer.image_path}",
                                        name: "${offer.name}",
                                        description: "${offer.description}",
                                        quantity: "${offer.quantity}",
                                        price: "${parseFloat(offer.price).toFixed(2)}",
                                        cuisine_type: "${offer.cuisine_type}",
                                        caloric_content: "${offer.caloric_content}",
                                        dietary_restrictions: ${JSON.stringify(offer.dietary_restrictions)}
                                    })'>
                                        <i class="fas fa-info-circle text-gray-500 hover:text-gray-700 cursor-pointer"></i>
                                    </button>
                                </div>
                            </div>`;
                    });

                    venueHTML += `
                            </div>
                        </div>`;
                    
                    venuesContainer.innerHTML += venueHTML;
                }
            });

            attachHoverEventToVenues();
            calculateDistances();
            initializeSliders();
        })
        .catch(error => {
            console.error('Error refreshing venues and offers:', error);
            alert('Failed to refresh content. Please try again.');
        });
    });

    document.getElementById('search-input').addEventListener('input', function() {
        filterVenuesBySearch(this.value);
    });
    function fetchPickupTimesForToday() {
        fetch('/pickup-times-today', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            document.querySelectorAll('[id^="pickup-times-"]').forEach(element => {
                element.innerHTML = 'No pickups today'; // Default message for all venues
            });

            data.forEach(pickupTime => {
                const venueElement = document.getElementById(`pickup-times-${pickupTime.partner_id}`);
                if (venueElement) {
                    if (pickupTime.start_time && pickupTime.end_time) {
                        venueElement.innerHTML = `Pickup Time: ${pickupTime.start_time} - ${pickupTime.end_time}`;
                    } else {
                        venueElement.innerHTML = 'Pickup Time: No pickups today';
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error fetching pickup times:', error);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        initMap();
        initializeSliders();
        fetchPickupTimesForToday();
    });
    </script>

</body>
</html>

