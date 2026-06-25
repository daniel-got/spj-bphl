@props([
    'items' => [], // [['label' => 'Beranda', 'url' => '/'], ['label' => 'SPT']]
])

<nav {{ $attributes->merge(['class' => 'flex items-center space-x-1 text-sm text-gray-500']) }} aria-label="Breadcrumb">
    @foreach($items as $index => $item)
        @if(!$loop->last)
            <a href="{{ $item['url'] ?? '#' }}" class="hover:text-gray-700 transition-colors">
                {{ $item['label'] }}
            </a>
            <span class="text-gray-300">/</span>
        @else
            <span class="text-gray-900 font-medium" aria-current="page">{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>
