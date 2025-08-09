<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Print Management System">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Print Management - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <div id="app" class="flex-grow">
        @include('partials.navbar')
        <main class="container mx-auto max-w-screen-lg py-8 px-4 sm:px-6 lg:px-8">
            @yield('content')
        </main>
        @include('partials.modal-container')
    </div>
    @stack('scripts')
</body>
</html>
