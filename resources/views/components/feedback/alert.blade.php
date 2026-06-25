@props([
    'type'        => 'info',    // info | success | warning | error
    'title'       => null,
    'dismissible' => false,
])

@php
$typeMap = [
    'info'    => ['bg' => 'bg-blue-50',   'border' => 'border-blue-200',  'text' => 'text-blue-800',  'icon' => 'information-circle'],
    'success' => ['bg' => 'bg-green-50',  'border' => 'border-green-200', 'text' => 'text-green-800', 'icon' => 'check-circle'],
    'warning' => ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-200','text' => 'text-yellow-800','icon' => 'exclamation'],
    'error'   => ['bg' => 'bg-red-50',    'border' => 'border-red-200',   'text' => 'text-red-800',   'icon' => 'x-circle'],
];
$style = $typeMap[$type] ?? $typeMap['info'];
@endphp

<div
    {{ $attributes->merge(['class' => "flex gap-3 p-4 rounded-lg border {$style['bg']} {$style['border']}"])  }}
    role="alert"
    {{ $dismissible ? 'x-data="{ show: true }" x-show="show"' : '' }}
>
    <x-utility.icon :name="$style['icon']" class="w-5 h-5 flex-shrink-0 mt-0.5 {{ $style['text'] }}" />

    <div class="flex-1">
        @if($title)
            <p class="text-sm font-semibold {{ $style['text'] }}">{{ $title }}</p>
        @endif
        <div class="text-sm {{ $style['text'] }} {{ $title ? 'mt-0.5' : '' }}">
            {{ $slot }}
        </div>
    </div>

    @if($dismissible)
        <button @click="show = false" type="button" class="{{ $style['text'] }} opacity-60 hover:opacity-100 transition-opacity">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    @endif
</div>
