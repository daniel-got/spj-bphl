@props([
    'tabs'   => [], // [['label' => 'Semua', 'value' => 'all', 'count' => null]]
    'active' => null,
    'name'   => 'tab',
])

<div {{ $attributes->merge(['class' => 'border-b border-border-custom']) }}>
    <nav class="-mb-px flex space-x-1" role="tablist">
        @foreach($tabs as $tab)
            @php $isActive = ($active === ($tab['value'] ?? $tab['label'])); @endphp
            <a
                href="{{ $tab['url'] ?? '?' . $name . '=' . ($tab['value'] ?? $tab['label']) }}"
                role="tab"
                aria-selected="{{ $isActive ? 'true' : 'false' }}"
                class="flex items-center gap-2 px-4 py-3 text-sm font-medium border-b-2 transition-colors duration-150 whitespace-nowrap
                    {{ $isActive
                        ? 'border-primary text-primary'
                        : 'border-transparent text-muted hover:text-text-main hover:border-border-custom' }}"
            >
                {{ $tab['label'] }}
                @if(isset($tab['count']))
                    <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-medium rounded-full
                        {{ $isActive ? 'bg-primary text-white' : 'bg-background text-muted' }}">
                        {{ $tab['count'] }}
                    </span>
                @endif
            </a>
        @endforeach
    </nav>
</div>
