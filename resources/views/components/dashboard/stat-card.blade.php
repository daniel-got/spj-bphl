@props([
    'title',
    'value',
    'description' => null,
    'icon'        => null,
    'trend'       => null,   // misal: '+12%' atau '-3%'
    'trendUp'     => null,   // true/false, null = netral
    'color'       => 'gray', // gray | blue | green | red | yellow
])

@php
$colorMap = [
    'gray'   => 'bg-gray-100 text-gray-600',
    'blue'   => 'bg-blue-100 text-blue-600',
    'green'  => 'bg-green-100 text-green-600',
    'red'    => 'bg-red-100 text-red-600',
    'yellow' => 'bg-yellow-100 text-yellow-600',
];
$iconBg = $colorMap[$color] ?? $colorMap['gray'];
@endphp

<div {{ $attributes->merge(['class' => 'bg-white border border-gray-200 rounded-xl p-6 shadow-sm']) }}>
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">{{ $title }}</p>
            <p class="mt-2 text-4xl font-black text-gray-900">{{ $value }}</p>

            @if($description || $trend)
                <div class="mt-2 flex items-center gap-2">
                    @if($trend)
                        <span class="text-xs font-medium px-2 py-0.5 rounded-full
                            {{ $trendUp === true ? 'bg-green-100 text-green-700' : ($trendUp === false ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-600') }}">
                            {{ $trend }}
                        </span>
                    @endif
                    @if($description)
                        <p class="text-sm text-gray-500">{{ $description }}</p>
                    @endif
                </div>
            @endif
        </div>

        @if($icon)
            <div class="flex-shrink-0 w-12 h-12 rounded-lg {{ $iconBg }} flex items-center justify-center">
                <x-utility.icon :name="$icon" class="w-6 h-6" />
            </div>
        @endif
    </div>
</div>
