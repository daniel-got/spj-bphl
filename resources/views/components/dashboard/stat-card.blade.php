@props([
    'title',
    'value',
    'description' => null,
    'icon' => null,
    'trend' => null, // misal: '+12%' atau '-3%'
    'trendUp' => null, // true/false, null = netral
    'color' => 'primary', // primary | success | warning | danger | info | secondary
])

@php
    $colorMap = [
        'primary' => 'bg-primary-light text-primary',
        'success' => 'bg-green-100 text-success',
        'warning' => 'bg-yellow-100 text-warning',
        'danger' => 'bg-red-100 text-danger',
        'info' => 'bg-blue-100 text-info',
        'secondary' => 'bg-secondary-light text-secondary',
    ];
    $iconBg = $colorMap[$color] ?? $colorMap['primary'];
@endphp

<div {{ $attributes->merge(['class' => 'bg-surface border border-border-custom rounded-xl p-6 shadow-sm']) }}>
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-muted uppercase tracking-wider">{{ $title }}</p>
            <p class="mt-2 text-4xl font-black text-text-main">{{ $value }}</p>

            @if ($description || $trend)
                <div class="mt-2 flex items-center gap-2">
                    @if ($trend)
                        <span
                            class="text-xs font-medium px-2 py-0.5 rounded-full
                            {{ $trendUp === true
                                ? 'bg-green-100 text-success'
                                : ($trendUp === false
                                    ? 'bg-red-100 text-danger'
                                    : 'bg-primary-light text-muted') }}">
                            {{ $trend }}
                        </span>
                    @endif
                    @if ($description)
                        <p class="text-sm text-muted">{{ $description }}</p>
                    @endif
                </div>
            @endif
        </div>

        @if ($icon)
            <div class="shrink-0 w-12 h-12 rounded-lg {{ $iconBg }} flex items-center justify-center">
                <x-utility.icon :name="$icon" class="w-6 h-6" />
            </div>
        @endif
    </div>
</div>
