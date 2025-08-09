@props(['status'])

@php
    $styles = [
        'active' => 'bg-green-100 text-green-800',
        'inactive' => 'bg-red-100 text-red-800',
        'pending' => 'bg-yellow-100 text-yellow-800',
        'approved' => 'bg-blue-100 text-blue-800'
    ];
@endphp

<span class="px-3 py-1 rounded-full text-xs {{ $styles[$status] ?? 'bg-gray-100' }}">
    {{ ucfirst($status) }}
</span>
