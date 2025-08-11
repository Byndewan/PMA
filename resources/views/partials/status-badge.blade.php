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
    @if($status === 'queue')
        <svg class="w-3 h-3 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    @elseif($status === 'process')
        <svg class="w-3 h-3 mr-1 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
        </svg>
    @elseif($status === 'done')
        <svg class="w-3 h-3 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
    @elseif($status === 'taken')
        <svg class="w-3 h-3 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
        </svg>
    @endif
    {{ $labels[$status] ?? ucfirst($status) }}
</span>
