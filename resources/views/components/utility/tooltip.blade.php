@props([
    'text',
    'position' => 'top', // top | bottom | left | right
])

@php
$positionMap = [
    'top'    => 'bottom-full left-1/2 -translate-x-1/2 mb-2',
    'bottom' => 'top-full left-1/2 -translate-x-1/2 mt-2',
    'left'   => 'right-full top-1/2 -translate-y-1/2 mr-2',
    'right'  => 'left-full top-1/2 -translate-y-1/2 ml-2',
];
$pos = $positionMap[$position] ?? $positionMap['top'];
@endphp

<div class="relative inline-flex group" {{ $attributes->only('class') }}>
    {{-- Trigger --}}
    {{ $slot }}

    {{-- Tooltip bubble --}}
    <div
        role="tooltip"
        class="absolute z-50 pointer-events-none {{ $pos }}
            opacity-0 group-hover:opacity-100
            transition-opacity duration-150 ease-in-out
            whitespace-nowrap px-2.5 py-1.5 text-xs font-medium
            bg-text-main text-surface rounded-md shadow-md"
    >
        {{ $text }}
    </div>
</div>
