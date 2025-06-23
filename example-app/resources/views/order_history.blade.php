<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Order History</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .order-group {
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .order-date {
            background-color: #f8f8f8;
            padding: 15px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.1em;
            font-weight: bold;
        }
        .order-details {
            display: none;
            margin-top: 10px;
        }
        .order-summary {
            background-color: #e0e0e0;
            padding: 15px;
            margin-top: 10px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1em;
            border-top: 1px solid #ccc;
        }
        .order-info {
            display: none;
            margin-top: 10px;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .order-info img {
            max-width: 150px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .order-info p {
            margin: 5px 0;
        }
        .order-info-left,
        .order-info-right {
            width: 48%;
        }
        .order-info-right a {
            color: blue;
            text-decoration: underline;
        }
    </style>
</head>
<body class="bg-gray-100">
    <header class="flex justify-between items-center p-6 bg-green-500 text-white">
        <h1 class="text-3xl">Order History</h1>
        <a href="{{ route('dashboard') }}" class="hover:underline text-white">Home</a>
    </header>
    <div class="container mx-auto p-8">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold text-green-700">Your Order History</h1>
            <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Return to Dashboard</a>
        </div>
        <div>
            @if($orders->isNotEmpty())
                @php
                    $groupedOrders = $orders->groupBy(function($order) {
                        return \Carbon\Carbon::parse($order->created_at)->format('Y-m-d');
                    })->sortKeysDesc();
                @endphp
                @foreach ($groupedOrders as $date => $orders)
                    <div class="order-group">
                        <div class="order-date" onclick="toggleOrderDetails('{{ $date }}')">
                            <strong>{{ $date }}</strong>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="order-details" id="details-{{ $date }}">
                            @foreach ($orders as $order)
                                <div class="order-summary" onclick="toggleOrderInfo('{{ $order->id }}')">
                                    <span>{{ $order->offer->name }}</span>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="order-info" id="info-{{ $order->id }}">
                                    <div class="order-info-left">
                                        <p><strong>Offer Name:</strong> {{ $order->offer->name }}</p>
                                        <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
                                        <p><strong>Total Price:</strong> {{ number_format($order->offer->price * $order->quantity, 2) }}€</p>
                                        <p><strong>Offer Description:</strong> {{ $order->offer->description }}</p>
                                        <p><strong>Offer Image:</strong></p>
                                        <img src="{{ asset('storage/' . $order->offer->image_path) }}" alt="{{ $order->offer->name }}">
                                        <p><strong>Order Time:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('H:i:s') }}</p>
                                    </div>
                                    <div class="order-info-right">
                                        <p><strong>Venue Name:</strong> {{ $order->offer->partner->venue_name }}</p>
                                        <p><strong>Venue Address:</strong> <a href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($order->offer->partner->address) }}" target="_blank">Open in Google Maps: {{ $order->offer->partner->address }}</a></p>
                                        <div id="pickup-times-{{ $order->offer->partner->id }}-{{ $order->id }}" class="text-gray-600">Loading pickup times...</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                    You have no order history.
                </div>
            @endif
        </div>
    </div>
    <footer class="text-center p-6 bg-gray-800 text-white">
        © 2024 ZeroWasteWagon. All rights reserved.
    </footer>

    <script>
        function toggleOrderDetails(date) {
            var detailsElement = document.getElementById('details-' + date);
            var icon = detailsElement.previousElementSibling.querySelector('i');
            var isVisible = detailsElement.style.display === 'block';

            document.querySelectorAll('.order-details').forEach(function(element) {
                element.style.display = 'none';
            });
            document.querySelectorAll('.order-date i').forEach(function(iconElement) {
                iconElement.classList.remove('fa-chevron-up');
                iconElement.classList.add('fa-chevron-down');
            });

            if (!isVisible) {
                detailsElement.style.display = 'block';
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            }
        }

        function toggleOrderInfo(orderId) {
            var infoElement = document.getElementById('info-' + orderId);
            var icon = infoElement.previousElementSibling.querySelector('i');
            var isVisible = infoElement.style.display === 'block';

            document.querySelectorAll('.order-info').forEach(function(element) {
                element.style.display = 'none';
            });
            document.querySelectorAll('.order-summary i').forEach(function(iconElement) {
                iconElement.classList.remove('fa-chevron-up');
                iconElement.classList.add('fa-chevron-down');
            });

            if (!isVisible) {
                infoElement.style.display = 'block';
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
    fetchPickupTimesForOrders();
});

function fetchPickupTimesForOrders() {
    const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
    if (!csrfTokenElement) {
        console.error('CSRF token not found.');
        return;
    }
    const csrfToken = csrfTokenElement.getAttribute('content');

    fetch('/pickup-times-today', {
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        data.forEach(pickupTime => {
            document.querySelectorAll(`[id^="pickup-times-${pickupTime.partner_id}"]`).forEach(element => {
                if (pickupTime.start_time && pickupTime.end_time) {
                    element.innerHTML = `Pickup Time: ${pickupTime.start_time} - ${pickupTime.end_time}`;
                } else {
                    element.innerHTML = 'Pickup Time: No pickups today';
                }
            });
        });

        document.querySelectorAll('[id^="pickup-times-"]').forEach(element => {
            if (element.innerHTML === 'Loading pickup times...') {
                element.innerHTML = 'Pickup Time: No pickups today';
            }
        });
    })
    .catch(error => {
        console.error('Error fetching pickup times:', error);
    });
}
    </script>
</body>
</html>
