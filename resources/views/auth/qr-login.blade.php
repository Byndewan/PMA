@extends('layouts.app')

@section('title', 'QR Login')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">QR Login</h1>

    <div class="text-center mb-4">
        <div id="qr-code" class="mx-auto w-48 h-48 bg-gray-100 mb-4 flex items-center justify-center">
            <div class="animate-pulse text-gray-500">Generating QR Code...</div>
        </div>
        <p class="text-sm text-gray-600 mb-4">Scan with your mobile app</p>
        <p class="text-xs text-gray-500">This code will expire in 5 minutes</p>
    </div>

    <div class="text-center">
        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Manual Login</a>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const qrElement = document.getElementById('qr-code');
        const qrUrl = "{{ $qrUrl }}";

        try {
            new QRCode(qrElement, {
                text: qrUrl,
                width: 192,
                height: 192,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });

            qrElement.innerHTML = '';

            setTimeout(() => {
                window.location.reload();
            }, 300000);

        } catch (error) {
            qrElement.innerHTML = '<div class="text-red-500">Failed to generate QR code</div>';
            console.error('QR Code generation error:', error);
        }
    });
</script>
@endpush
@endsection
