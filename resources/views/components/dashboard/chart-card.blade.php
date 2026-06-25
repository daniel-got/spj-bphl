@props([
    'title',
    'subtitle' => null,
    'height'   => 'h-64',
])

<div {{ $attributes->merge(['class' => 'bg-surface border border-border-custom rounded-xl p-6 shadow-sm']) }}>
    <div class="flex items-start justify-between mb-4">
        <div>
            <h3 class="text-sm font-semibold text-text-main">{{ $title }}</h3>
            @if($subtitle)
                <p class="text-xs text-muted mt-0.5">{{ $subtitle }}</p>
            @endif
        </div>
        @isset($actions)
            <div>{{ $actions }}</div>
        @endisset
    </div>

    {{-- Chart area: isi dengan slot atau library chart (Chart.js, dll) --}}
    <div class="{{ $height }} flex items-center justify-center">
        @if($slot->isNotEmpty())
            {{ $slot }}
        @else
            <div class="text-center text-muted">
                <svg class="w-10 h-10 mx-auto mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <p class="text-sm">Masukkan chart di sini</p>
            </div>
        @endif
    </div>
</div>
