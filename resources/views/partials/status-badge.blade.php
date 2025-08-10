@props(['status'])

@php
    $styles = [
        'queue' => 'bg-gray-100 text-gray-800',
        'process' => 'bg-amber-100 text-amber-800',
        'done' => 'bg-green-100 text-green-800',
        'taken' => 'bg-blue-100 text-blue-800',
        'active' => 'bg-green-100 text-green-800',
        'inactive' => 'bg-gray-100 text-gray-800',
        'pending' => 'bg-amber-100 text-amber-800',
        'approved' => 'bg-green-100 text-green-800',
        'rejected' => 'bg-red-100 text-red-800'
    ];

    $labels = [
        'queue' => 'Antri',
        'process' => 'Diproses',
        'done' => 'Selesai',
        'taken' => 'Diambil',
        'active' => 'Aktif',
        'inactive' => 'Nonaktif',
        'pending' => 'Pending',
        'approved' => 'Approved',
        'rejected' => 'Rejected'
    ];
@endphp

<span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $styles[$status] ?? 'bg-gray-100 text-gray-800' }} inline-flex items-center">
    {{ $labels[$status] ?? ucfirst($status) }}
</span>
