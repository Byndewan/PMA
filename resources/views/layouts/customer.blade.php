@extends('layouts.app')

@section('styles')
<style>
    .sidebar-link {
        @apply flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 transition rounded-lg;
    }
    .sidebar-link.active {
        @apply bg-blue-50 text-blue-600 font-medium;
    }
    .sidebar-link i {
        @apply mr-3 text-lg;
    }
</style>
@endsection

@section('content')
<div class="min-h-screen">

    <style>
        a {
            text-decoration: none !important;
        }
    </style>

    <!-- Page Heading -->
    @if(isset($header))
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            {{ $header }}
        </div>
    </header>
    @endif

    <!-- Page Content -->
    <main class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        @yield('customer_content')
    </main>
</div>
@endsection
