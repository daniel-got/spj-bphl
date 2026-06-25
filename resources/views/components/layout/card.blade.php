@props([
    'title'    => null,
    'subtitle' => null,
])

<div {{ $attributes->merge(['class' => 'bg-surface border border-border-custom rounded-xl shadow-sm overflow-hidden']) }}>
    
    {{-- Card Header --}}
    @if($title || $subtitle || isset($header))
        <div class="px-6 py-4 border-b border-border-custom">
            @if(isset($header))
                {{ $header }}
            @else
                @if($title)
                    <h3 class="text-lg font-semibold text-text-main">{{ $title }}</h3>
                @endif
                @if($subtitle)
                    <p class="mt-1 text-sm text-muted">{{ $subtitle }}</p>
                @endif
            @endif
        </div>
    @endif

    {{-- Card Body --}}
    <div class="p-6">
        {{ $slot }}
    </div>

    {{-- Card Footer --}}
    @isset($footer)
        <div class="px-6 py-4 border-t border-border-custom bg-background">
            {{ $footer }}
        </div>
    @endisset

</div>
