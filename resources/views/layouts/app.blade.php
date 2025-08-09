<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Management - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('partials.navbar')

    <div class="container mx-auto px-4 py-6">
        <!-- Header Halaman -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                @yield('page-title')
            </h1>

            <!-- Tombol Aksi -->
            <div class="flex space-x-2">
                @yield('page-actions')
            </div>
        </div>

        <!-- Konten Utama -->
        <div class="bg-white rounded-lg shadow p-6">
            @yield('content')
        </div>
    </div>
</body>
</html>
