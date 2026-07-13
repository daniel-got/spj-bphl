@props(['type' => 'button', 'color' => 'muted'])

@php
    $colorClasses = match($color) {
        'primary' => 'text-primary hover:text-primary-hover hover:bg-primary/10',
        'danger' => 'text-danger hover:text-red-700 hover:bg-danger/10',
        'success' => 'text-success hover:text-green-700 hover:bg-success/10',
        'warning' => 'text-warning hover:text-yellow-700 hover:bg-warning/10',
        default => 'text-muted hover:text-text-main hover:bg-background',
    };
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => "p-1.5 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-primary/50 flex items-center justify-center shrink-0 $colorClasses"]) }}
>
    {{ $slot }}
</button>
