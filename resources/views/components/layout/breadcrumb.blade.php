@props([
    'items' => [], // [['label' => 'Beranda', 'url' => '/'], ['label' => 'SPT']]
])

<nav {{ $attributes->merge(['class' => 'flex items-center space-x-1 text-sm text-muted']) }} aria-label="Breadcrumb">
    @foreach($items as $item)
        @if(!$loop->last)
            <a href="{{ $item['url'] ?? '#' }}" class="hover:text-primary transition-colors">
                {{ $item['label'] }}
            </a>
            <span class="text-border-custom">/</span>
        @else
            <span class="text-text-main font-medium" aria-current="page">{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>
