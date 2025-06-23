<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Your Site Title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
        <!-- Your navigation -->
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <!-- Your footer -->
    </footer>
</body>
</html>
