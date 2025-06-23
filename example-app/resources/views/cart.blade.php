<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('main.cart')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        #timer {
            display: inline-block;
            font-size: 16px;
            color: #dc3545; /* Red color for urgency */
        }
        .tooltip-icon {
            cursor: help;
            color: #007bff; /* Bootstrap primary color */
        }
    </style>
</head>
<body class="bg-gray-50">
    <header class="flex justify-between items-center p-6 bg-green-500 text-white">

        <h1 class="text-3xl">Shopping Cart</h1>

        <a href="/" class="hover:underline text-white">Home</a>

        <h1 class="text-3xl">@lang('main.cart')</h1>
        <a href="{{ route('locale', 'lt') }}" class="hover:underline">Lietuvių</a>
        <a href="{{ route('locale', 'en') }}" class="hover:underline">English</a>
        <a href="{{ route('dashboard') }}" class="hover:underline text-white">@lang('main.home')</a>

    </header>

    <div class="container mx-auto mt-4 p-4 bg-white shadow-md rounded">
        @php $total = 0; @endphp
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if($items->isNotEmpty())
            <div class="overflow-x-auto relative">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3 px-6">Product</th>
                            <th scope="col" class="py-3 px-6">Quantity</th>
                            <th scope="col" class="py-3 px-6">Price</th>
                            <th scope="col" class="py-3 px-6">Subtotal</th>
                            <th scope="col" class="py-3 px-6">
                                <span class="time-left-header" data-bs-toggle="tooltip" data-bs-placement="top" title="The item is active for 10 minutes or until you pay" style="cursor: pointer; text-decoration: underline; text-decoration-style: dotted;">
                                    Time Left
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $index => $item)
                            @php
                                $subtotal = $item['price'] * $item['quantity'];
                                $total += $subtotal;
                                $expiryTime = \Carbon\Carbon::createFromTimestamp($item['created_at'])->addMinutes(10)->timestamp;
                            @endphp
                            <tr class="bg-white border-b" id="item-{{ $item['id'] }}">
                                <td class="py-4 px-6">{{ $item['name'] }}</td>
                                <td class="py-4 px-6">{{ $item['quantity'] }}</td>
                                <td class="py-4 px-6">€{{ number_format($item['price'], 2) }}</td>
                                <td class="py-4 px-6">€{{ number_format($subtotal, 2) }}</td>
                                <td class="py-4 px-6"><div id="timer-{{ $item['id'] }}" data-expiry="{{ $expiryTime }}"></div></td>
                            </tr>
                        @endforeach
                        <tr class="bg-white border-b" id="total-row">
                            <td colspan="4" class="text-right py-4 px-6 font-medium">Total</td>
                            <td class="py-4 px-6 font-medium" id="total-amount">€{{ number_format($total, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-end mt-4" id="checkout-section">
                <button id="checkout-button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Proceed to Checkout
                </button>
                <a href="/user/dashboard" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">
                    @lang('main.back')
                </a>
            </div>
        @else
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                @lang('main.empty')
                <a href="/user/dashboard" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">
                    @lang('main.back')
                </a>
            </div>
        @endif
    </div>

    <script>
        var stripe = Stripe('{{ config('services.stripe.key') }}'); 
        var activeTimers = 0;

        document.getElementById('checkout-button').addEventListener('click', function(e) {
            e.preventDefault();
            fetch('{{ route("payment.create-checkout-session") }}', { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ total: '{{ $total }}' })
            }).then(function(response) {
                return response.json();
            }).then(function(session) {
                return stripe.redirectToCheckout({ sessionId: session.id });
            }).catch(function(error) {
                console.error('Error:', error);
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            var timers = document.querySelectorAll('[id^="timer-"]');
            activeTimers = timers.length;
            timers.forEach(function(timerElement) {
                var expiryTime = timerElement.getAttribute('data-expiry') * 1000;
                initializeTimer(timerElement.id, expiryTime, timerElement.id.split('-')[1]);
            });
        });

        function initializeTimer(timerId, expiryTime, itemId) {
            var timer = document.getElementById(timerId);
            var x = setInterval(function() {
                var now = new Date().getTime();
                var distance = expiryTime - now;
                if (distance < 0) {
                    clearInterval(x);
                    timer.innerHTML = "EXPIRED";
                    removeExpiredItem(itemId); // Remove the item from the UI and the backend
                    activeTimers--;
                    location.reload(); // Refresh the page after each item expires
                } else {
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    timer.innerHTML = minutes + "m " + seconds + "s ";
                }
            }, 1000);
        }

        function removeExpiredItem(itemId) {
            fetch(`/cart/remove/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            }).then(function(response) {
                if (response.ok) {
                    document.getElementById('item-' + itemId).remove();
                } else {
                    console.error('Failed to remove item from the backend.');
                }
            }).catch(function(error) {
                console.error('Error:', error);
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }); 
    </script>
</body>
</html>
