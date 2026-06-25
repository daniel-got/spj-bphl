@props([
    'items'  => [], // [['label' => 'Edit', 'url' => '#', 'icon' => null, 'danger' => false]]
    'label'  => 'Aksi',
    'align'  => 'right', // left | right
])

<div class="relative inline-block text-left" x-data="{ open: false }">
    <x-action.button
        @click="open = !open"
        @click.outside="open = false"
        class="border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 px-3 py-2 text-sm gap-1"
    >
        {{ $label }}
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </x-action.button>

    <div
        x-show="open"
        x-transition
        class="absolute z-10 mt-1 w-48 bg-white border border-gray-200 rounded-lg shadow-lg py-1
            {{ $align === 'right' ? 'right-0' : 'left-0' }}"
    >
        @foreach($items as $item)
            @if(isset($item['divider']) && $item['divider'])
                <hr class="my-1 border-gray-100">
            @else
                <a
                    href="{{ $item['url'] ?? '#' }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm transition-colors
                        {{ ($item['danger'] ?? false)
                            ? 'text-red-600 hover:bg-red-50'
                            : 'text-gray-700 hover:bg-gray-50' }}"
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
