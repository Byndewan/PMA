@props([
    'status',
    'colors' => [
        'queue' => 'bg-gray-100 text-gray-800',
        'process' => 'bg-yellow-100 text-yellow-800',
        'done' => 'bg-green-100 text-green-800',
        'taken' => 'bg-blue-100 text-blue-800',
        'pending' => 'bg-gray-100 text-gray-800',
        'approved' => 'bg-green-100 text-green-800',
        'rejected' => 'bg-red-100 text-red-800',
        'cancelled' => 'bg-gray-200 text-gray-800'
    ],
    'labels' => [
        'queue' => 'Antri',
        'process' => 'Diproses',
        'done' => 'Selesai',
        'taken' => 'Diambil',
        'pending' => 'Menunggu',
        'approved' => 'Disetujui',
        'rejected' => 'Ditolak',
        'cancelled' => 'Dibatalkan'
    ],
    'icon' => false,
    'size' => 'md' // sm, md, lg
])

@php
    $sizeClasses = [
        'sm' => 'px-2 py-0.5 text-xs',
        'md' => 'px-3 py-1 text-sm',
        'lg' => 'px-4 py-1.5 text-base'
    ];

    $iconClasses = [
        'queue' => 'fa-clock',
        'process' => 'fa-cog fa-spin',
        'done' => 'fa-check-circle',
        'taken' => 'fa-check-double',
        'pending' => 'fa-hourglass-half',
        'approved' => 'fa-check-circle',
        'rejected' => 'fa-times-circle',
        'cancelled' => 'fa-ban'
    ];
@endphp

<span class="inline-flex items-center rounded-full font-medium {{ $sizeClasses[$size] }} {{ $colors[$status] ?? 'bg-gray-100 text-gray-800' }}">
    @if($icon)
        <i class="fas {{ $iconClasses[$status] ?? 'fa-circle' }} mr-1.5 text-[0.8em]"></i>
    @endif
    {{ $labels[$status] ?? ucfirst($status) }}
</span>
