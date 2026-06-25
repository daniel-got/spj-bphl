@props([
    'name',             // nama lengkap untuk inisial & alt
    'src'   => null,    // URL foto, opsional
    'size'  => 'md',    // xs | sm | md | lg | xl
    'shape' => 'circle' // circle | square
])

@php
$sizeMap = [
    'xs' => ['wrapper' => 'w-6 h-6',   'text' => 'text-xs'],
    'sm' => ['wrapper' => 'w-8 h-8',   'text' => 'text-xs'],
    'md' => ['wrapper' => 'w-10 h-10', 'text' => 'text-sm'],
    'lg' => ['wrapper' => 'w-12 h-12', 'text' => 'text-base'],
    'xl' => ['wrapper' => 'w-16 h-16', 'text' => 'text-lg'],
];
$dim    = $sizeMap[$size] ?? $sizeMap['md'];
$radius = $shape === 'square' ? 'rounded-lg' : 'rounded-full';

// Buat inisial dari nama
$parts    = explode(' ', trim($name));
$initials = strtoupper(substr($parts[0], 0, 1) . (count($parts) > 1 ? substr(end($parts), 0, 1) : ''));

// Warna konsisten berdasarkan nama (menggunakan warna palette kita)
$colors = ['bg-primary', 'bg-secondary', 'bg-success', 'bg-warning', 'bg-danger', 'bg-info'];
$color  = $colors[crc32($name) % count($colors)];
@endphp

<div {{ $attributes->merge(['class' => "inline-flex items-center justify-center flex-shrink-0 {$dim['wrapper']} {$radius} overflow-hidden"]) }}>
    @if($src)
        <img src="{{ $src }}" alt="{{ $name }}" class="w-full h-full object-cover">
    @else
        <div class="w-full h-full flex items-center justify-center {{ $color }} text-white font-semibold {{ $dim['text'] }}">
            {{ $initials }}
        </div>
    @endif
</div>
