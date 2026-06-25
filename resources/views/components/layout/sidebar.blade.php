@props([
    'items' => [],     // [['label' => 'Menu', 'url' => '#', 'icon' => 'home', 'active' => false]]
    'collapsed' => false,
])

<aside {{ $attributes->merge(['class' => 'bg-white border-r border-gray-200 flex flex-col min-h-screen transition-all duration-300 ' . ($collapsed ? 'w-16' : 'w-64')]) }}>

    {{-- Logo / Brand --}}
    <div class="h-16 flex items-center px-4 border-b border-gray-200">
        @if(!$collapsed)
            <span class="text-sm font-bold text-gray-800 truncate">SPJ BPHL 4 Jambi</span>
        @endif
    </div>

    {{-- Navigation Items --}}
    <nav class="flex-1 py-4 space-y-1 px-2">
        @foreach($items as $item)
            <a
                href="{{ $item['url'] ?? '#' }}"
                class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                    {{ ($item['active'] ?? false)
                        ? 'bg-gray-900 text-white'
                        : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}"
            >
                @if(isset($item['icon']))
                    <x-utility.icon :name="$item['icon']" class="w-5 h-5 flex-shrink-0" />
                @endif
                @if(!$collapsed)
                    <span class="truncate">{{ $item['label'] }}</span>
                @endif
            </a>
        @endforeach
    </nav>

    {{-- Footer slot --}}
    @isset($footer)
        <div class="p-4 border-t border-gray-200">
            {{ $footer }}
        </div>
    @endisset
</aside>
