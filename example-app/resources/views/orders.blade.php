<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner Orders</title>
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
    </style>
</head>
<body class="bg-gray-100">
    <header class="flex justify-between items-center p-6 bg-green-500 text-white">
        <h1 class="text-3xl">ZeroWasteWagon</h1>
        <div class="space-x-4 flex items-center">
            <a href="{{ route('locale', 'lt') }}" class="hover:underline">Lietuvių</a>
            <a href="{{ route('locale', 'en') }}" class="hover:underline">English</a>
            <a href="#" class="hover:underline">@lang('main.acount_info')</a>
            <a href="#" class="hover:underline">@lang('main.logout')</a>
        </div>
    </header>
    <div class="container mx-auto p-8">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold text-green-700">@lang('main.orders_from_your_store')</h1>
            <a href="{{ route('partner.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">@lang('main.return_to_dashboard')</a>
        </div>
        <div>
            @php
                $groupedOrders = $orders->groupBy(function($order) {
                    return \Carbon\Carbon::parse($order->created_at)->format('Y-m-d');
                });
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
                                <span>{{ $order->user->name }} - {{ $order->offer->name }}</span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="order-info" id="info-{{ $order->id }}">
                                <div class="order-info-left">
                                    <p><strong>@lang('main.pa_offer_name')</strong> {{ $order->offer->name }}</p>
                                    <p><strong>@lang('main.pa_offer_quantity')</strong> {{ $order->quantity }}</p>
                                    <p><strong>@lang('main.total_price')</strong> {{ number_format($order->offer->price * $order->quantity, 2) }}€</p>
                                    <p><strong>@lang('main.paid')</strong> {{ $order->paid ? 'Yes' : 'No' }}</p>
                                    <p><strong>@lang('main.pa_offer_description')</strong> {{ $order->offer->description }}</p>
                                    <p><strong>@lang('main.pa_offer_image')</strong></p>
                                    <img src="{{ asset('storage/' . $order->offer->image_path) }}" alt="{{ $order->offer->name }}">
                                    <p><strong>@lang('main.order_time')</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('H:i:s') }}</p>
                                </div>
                                <div class="order-info-right">
                                    <p><strong>@lang('main.user_name')</strong> {{ $order->user->name }}</p>
                                    <p><strong>@lang('main.user_email')</strong> {{ $order->user->email }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <footer class="text-center p-6 bg-gray-800 text-white">
        @lang('main.footer')
    </footer>

    <script>
        function toggleOrderDetails(date) {
            var detailsElement = document.getElementById('details-' + date);
            var icon = detailsElement.previousElementSibling.querySelector('i');
            if (detailsElement.style.display === 'none' || detailsElement.style.display === '') {
                detailsElement.style.display = 'block';
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                detailsElement.style.display = 'none';
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        }

        function toggleOrderInfo(orderId) {
            var infoElement = document.getElementById('info-' + orderId);
            var icon = infoElement.previousElementSibling.querySelector('i');
            if (infoElement.style.display === 'none' || infoElement.style.display === '') {
                infoElement.style.display = 'block';
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                infoElement.style.display = 'none';
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        }
    </script>
</body>
</html>
