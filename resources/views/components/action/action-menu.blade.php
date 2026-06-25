@props([
    'items' => [], // [['label' => 'Edit', 'url' => '#', 'icon' => null, 'danger' => false]]
])

{{-- Three-dot menu button --}}
<div class="relative inline-block" x-data="{ open: false }">
    <button
        @click="open = !open"
        @click.outside="open = false"
        type="button"
        class="p-1.5 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors"
        aria-label="Menu aksi"
    >
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
        </svg>
    </button>

    <div
        x-show="open"
        x-transition
        class="absolute right-0 z-10 mt-1 w-44 bg-white border border-gray-200 rounded-lg shadow-lg py-1"
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
