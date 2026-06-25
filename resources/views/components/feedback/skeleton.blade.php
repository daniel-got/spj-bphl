@props([
    'type'  => 'text', // text | card | table | list | circle
    'count' => 1,
    'lines' => 3,      // khusus type 'text' dan 'list'
])

@php
function skeletonBase(): string {
    return 'bg-border-custom rounded animate-pulse'; // Menggunakan border-custom sebagai warna skeleton base
}
@endphp

@for($i = 0; $i < $count; $i++)
    @if($type === 'card')
        <div class="bg-surface border border-border-custom rounded-xl p-6 space-y-3" {{ $attributes }}>
            <div class="h-4 {{ skeletonBase() }} w-1/3"></div>
            <div class="h-8 {{ skeletonBase() }} w-1/2"></div>
            <div class="h-3 {{ skeletonBase() }} w-2/3"></div>
        </div>

    @elseif($type === 'table')
        <div class="space-y-2" {{ $attributes }}>
            <div class="h-9 {{ skeletonBase() }} w-full"></div>
            @for($r = 0; $r < $lines; $r++)
                <div class="h-12 {{ skeletonBase() }} w-full opacity-{{ 100 - $r * 15 }}"></div>
            @endfor
        </div>

    @elseif($type === 'list')
        <div class="space-y-3" {{ $attributes }}>
            @for($r = 0; $r < $lines; $r++)
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full {{ skeletonBase() }} flex-shrink-0"></div>
                    <div class="flex-1 space-y-1.5">
                        <div class="h-3 {{ skeletonBase() }} w-3/4"></div>
                        <div class="h-3 {{ skeletonBase() }} w-1/2"></div>
                    </div>
                </div>
            @endfor
        </div>

    @elseif($type === 'circle')
        <div class="w-10 h-10 rounded-full {{ skeletonBase() }}" {{ $attributes }}></div>

    @else {{-- text --}}
        <div class="space-y-2" {{ $attributes }}>
            @for($r = 0; $r < $lines; $r++)
                <div class="h-3 {{ skeletonBase() }} {{ $loop->last ? 'w-2/3' : 'w-full' }}"></div>
            @endfor
        </div>
    @endif
@endfor
