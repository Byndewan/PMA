@extends('layouts.app')

@section('title', 'QR Login')

@section('content')
<div class="max-w-md w-full mx-auto bg-white rounded-xl shadow-md overflow-hidden p-8 space-y-6 transition-all duration-300 hover:shadow-lg">
    <div class="text-center">
        <div class="mx-auto h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-mobile-alt text-blue-600 text-2xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">QR Code Login</h1>
        <p class="text-gray-500">Scan with your mobile app</p>
    </div>

    <div class="flex flex-col items-center space-y-4">
        <div id="qr-code" class="w-64 h-64 bg-white p-4 rounded-xl border-2 border-dashed border-gray-200 flex items-center justify-center">
            <div class="animate-pulse flex flex-col items-center">
                <i class="fas fa-spinner fa-spin text-blue-500 text-2xl mb-2"></i>
                <span class="text-gray-500">Generating QR Code...</span>
            </div>
        </div>

        <div class="text-center space-y-1">
            <div class="flex items-center justify-center text-yellow-500">
                <i class="fas fa-clock mr-2"></i>
                <span class="text-sm font-medium">Expires in 5 minutes</span>
            </div>
            <p class="text-xs text-gray-500">Make sure you're using the official mobile app</p>
        </div>
    </div>

    <div class="relative">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-white text-gray-500">Or sign in manually</span>
        </div>
    </div>

    <div class="flex justify-center">
        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
            <i class="fas fa-sign-in-alt mr-2 text-blue-500"></i> Manual Login
        </a>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const qrElement = document.getElementById('qr-code');
        const qrUrl = "{{ $qrUrl }}";

        try {
            // Clear loading state
            qrElement.innerHTML = '';

            // Generate QR code with better styling
            new QRCode(qrElement, {
                text: qrUrl,
                width: 256,
                height: 256,
                colorDark: "#1e40af",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });

            // Add success styling
            qrElement.classList.remove('border-dashed');
            qrElement.classList.add('border-solid', 'border-blue-100', 'shadow-inner');

            // Set timeout to refresh before expiration
            setTimeout(() => {
                window.location.reload();
            }, 4.5 * 60 * 1000); // Refresh at 4.5 minutes

        } catch (error) {
            qrElement.innerHTML = `
                <div class="text-center p-4 text-red-500">
                    <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                    <p>Failed to generate QR code</p>
                </div>`;
            console.error('QR Code generation error:', error);
        }
    });
</script>
@endpush
@endsection
