@props([
    'title',
    'subtitle' => null,
])

<div {{ $attributes->merge(['class' => 'mb-6']) }}>
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-text-main">{{ $title }}</h1>
            @if($subtitle)
                <p class="mt-1 text-sm text-muted">{{ $subtitle }}</p>
            @endif
        </div>
        @isset($actions)
            <div class="flex items-center gap-2 flex-shrink-0">
                {{ $actions }}
            </div>
        @endisset
    </div>
</div>
