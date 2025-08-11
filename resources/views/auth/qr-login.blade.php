@extends('layouts.app')

@section('title', 'QR Login')

@section('content')
<div class="max-w-md w-full mx-auto">
    <div class="bg-white rounded-2xl shadow-sm p-8 space-y-6">
        <div class="text-center space-y-3">
            <div class="mx-auto h-20 w-20 bg-blue-50 rounded-2xl flex items-center justify-center mb-2">
                <i class="fas fa-mobile-alt text-blue-500 text-3xl"></i>
            </div>
            <h1 class="text-2xl font-semibold text-gray-800">QR Code Login</h1>
            <p class="text-gray-500 text-sm">Scan with your mobile app</p>
        </div>

        <div class="flex flex-col items-center space-y-4">
            <div id="qr-code" class="w-56 h-56 bg-white p-4 rounded-xl border-2 border-gray-100 flex items-center justify-center">
                <div class="animate-pulse flex flex-col items-center">
                    <i class="fas fa-spinner fa-spin text-blue-500 text-xl mb-2"></i>
                    <span class="text-gray-400 text-sm">Generating QR Code...</span>
                </div>
            </div>

            <div class="text-center space-y-1.5">
                <div class="flex items-center justify-center text-amber-500 text-sm">
                    <i class="fas fa-clock mr-1.5"></i>
                    <span>Expires in 5 minutes</span>
                </div>
                <p class="text-xs text-gray-400">Make sure you're using the official mobile app</p>
            </div>
        </div>

        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-xs">
                <span class="px-2 bg-white text-gray-400">Or sign in manually</span>
            </div>
        </div>

        <div class="flex justify-center">
            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                <i class="fas fa-sign-in-alt mr-2 text-blue-500"></i> Manual Login
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
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
                width: 224,
                height: 224,
                colorDark: "#000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });

            // Add success styling
            qrElement.classList.add('shadow-inner');

            // Set timeout to refresh before expiration
            setTimeout(() => {
                window.location.reload();
            }, 4.5 * 60 * 1000); // Refresh at 4.5 minutes

        } catch (error) {
            qrElement.innerHTML = `
                <div class="text-center p-3 text-red-500 text-sm">
                    <i class="fas fa-exclamation-triangle text-xl mb-1.5"></i>
                    <p>Failed to generate QR code</p>
                </div>`;
            console.error('QR Code generation error:', error);
        }
    });
</script>
@endsection
