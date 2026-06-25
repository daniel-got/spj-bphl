@props([
    'items'  => [], // [['label' => 'Edit', 'url' => '#', 'icon' => null, 'danger' => false]]
    'label'  => 'Aksi',
    'align'  => 'right', // left | right
])

<div class="relative inline-block text-left" x-data="{ open: false }">
    <x-action.button
        @click="open = !open"
        @click.outside="open = false"
        class="border border-border-custom bg-surface text-text-main hover:bg-primary-light px-3 py-2 text-sm gap-1"
    >
        {{ $label }}
        <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </x-action.button>

    <div
        x-show="open"
        x-transition
        class="absolute z-10 mt-1 w-48 bg-surface border border-border-custom rounded-lg shadow-lg py-1
            {{ $align === 'right' ? 'right-0' : 'left-0' }}"
    >
        @foreach($items as $item)
            @if(isset($item['divider']) && $item['divider'])
                <hr class="my-1 border-border-custom">
            @else
                <a
                    href="{{ $item['url'] ?? '#' }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm transition-colors
                        {{ ($item['danger'] ?? false)
                            ? 'text-danger hover:bg-red-50'
                            : 'text-text-main hover:bg-primary-light hover:text-primary' }}"
                >
                    @if(isset($item['icon']))
                        <x-utility.icon :name="$item['icon']" class="w-4 h-4 flex-shrink-0" />
                    @endif
                    {{ $item['label'] }}
                </a>
            @endif
        @endforeach
    </div>
</div>
