@props([
    'message',
    'type'     => 'info',  // info | success | warning | error
    'duration' => 4000,    // ms, 0 = tidak auto-close
])

@php
$typeMap = [
    'info'    => ['bg' => 'bg-gray-900', 'icon' => 'information-circle', 'iconColor' => 'text-blue-400'],
    'success' => ['bg' => 'bg-gray-900', 'icon' => 'check-circle',        'iconColor' => 'text-green-400'],
    'warning' => ['bg' => 'bg-gray-900', 'icon' => 'exclamation',         'iconColor' => 'text-yellow-400'],
    'error'   => ['bg' => 'bg-gray-900', 'icon' => 'x-circle',            'iconColor' => 'text-red-400'],
];
$style = $typeMap[$type] ?? $typeMap['info'];
@endphp

<div
    class="pointer-events-auto flex items-center gap-3 px-4 py-3 rounded-lg shadow-lg {{ $style['bg'] }} text-white max-w-sm w-full"
    x-data="{ show: true }"
    x-show="show"
    x-init="{{ $duration > 0 ? "setTimeout(() => show = false, $duration)" : '' }}"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <x-utility.icon :name="$style['icon']" class="w-5 h-5 flex-shrink-0 {{ $style['iconColor'] }}" />
    <p class="text-sm font-medium flex-1">{{ $message }}</p>
    <button @click="show = false" type="button" class="text-gray-400 hover:text-white transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
