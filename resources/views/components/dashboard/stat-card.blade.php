@props([
    'title',
    'value',
    'description' => null,
    'icon' => null,
    'trend' => null, // misal: '+12%' atau '-3%'
    'trendUp' => null, // true/false, null = netral
    'color' => 'primary', // primary | success | warning | danger | info | secondary
    'href' => null, // Link tujuan
])

@php
    $colorMap = [
        'primary' => 'bg-primary-light text-primary',
        'success' => 'bg-green-100 text-success',
        'warning' => 'bg-yellow-100 text-warning',
        'danger' => 'bg-red-100 text-danger',
        'info' => 'bg-blue-100 text-info',
        'secondary' => 'bg-secondary-light text-secondary',
        'blue' => 'bg-blue-100 text-blue-700',
        'green' => 'bg-green-100 text-green-700',
        'yellow' => 'bg-yellow-100 text-yellow-700',
        'red' => 'bg-red-100 text-red-700',
    ];
    $iconBg = $colorMap[$color] ?? $colorMap['primary'];

    $bgMap = [
        'primary' => 'bg-surface',
        'secondary' => 'bg-surface',
        'info' => 'bg-blue-50/20',
        'success' => 'bg-green-50/20',
        'warning' => 'bg-yellow-50/20',
        'danger' => 'bg-red-50/20',
        'blue' => 'bg-blue-50/20',
        'green' => 'bg-green-50/20',
        'yellow' => 'bg-yellow-50/20',
        'red' => 'bg-red-50/20',
    ];
    $bgClass = $bgMap[$color] ?? 'bg-surface';

    $borderMap = [
        'primary' => 'border-border-custom',
        'secondary' => 'border-border-custom',
        'info' => 'border-blue-200',
        'success' => 'border-green-200',
        'warning' => 'border-yellow-200',
        'danger' => 'border-red-200',
        'blue' => 'border-blue-200',
        'green' => 'border-green-200',
        'yellow' => 'border-yellow-200',
        'red' => 'border-red-200',
    ];
    $borderColor = $borderMap[$color] ?? 'border-border-custom';

    $btnMap = [
        'primary' => 'bg-primary/10 hover:bg-primary text-primary hover:text-white',
        'secondary' => 'bg-secondary/10 hover:bg-secondary text-secondary hover:text-white',
        'info' => 'bg-blue-100 hover:bg-blue-600 text-blue-700 hover:text-white border border-blue-200/40',
        'success' => 'bg-green-100 hover:bg-green-600 text-green-700 hover:text-white border border-green-200/40',
        'warning' => 'bg-yellow-100 hover:bg-yellow-600 text-yellow-700 hover:text-white border border-yellow-200/40',
        'danger' => 'bg-red-100 hover:bg-red-600 text-red-700 hover:text-white border border-red-200/40',
        'blue' => 'bg-blue-100 hover:bg-blue-600 text-blue-700 hover:text-white border border-blue-200/40',
        'green' => 'bg-green-100 hover:bg-green-600 text-green-700 hover:text-white border border-green-200/40',
        'yellow' => 'bg-yellow-100 hover:bg-yellow-600 text-yellow-700 hover:text-white border border-yellow-200/40',
        'red' => 'bg-red-100 hover:bg-red-600 text-red-700 hover:text-white border border-red-200/40',
    ];
    $btnClasses = $btnMap[$color] ?? $btnMap['primary'];
@endphp

<div {{ $attributes->merge(['class' => "$bgClass border $borderColor rounded-xl p-6 shadow-sm relative group flex flex-col justify-between"]) }}>
    <div class="flex items-start justify-between w-full">
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

    @if($href)
        <div class="mt-4 pt-3 border-t border-border-custom/50 flex justify-end">
            <a href="{{ $href }}" class="inline-flex items-center {{ $btnClasses }} text-[11px] font-bold px-3 py-1.5 rounded-lg transition-all duration-150" title="Lihat Detail">
                Detail
            </a>
        </div>
    @endif
</div>
