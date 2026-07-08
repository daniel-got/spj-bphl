@props([
    'items' => [], // Opsional. Jika kosong, otomatis pakai config('navigation.sidebar')
    'collapsed' => false,
])

@php
    // Gunakan items dari props jika dikirim, fallback ke config jika tidak ada
    $menuItems = !empty($items) ? $items : config('navigation.sidebar', []);

    // Tandai item aktif berdasarkan URL saat ini
    $menuItems = array_map(function ($item) {
        $item['active'] = request()->is(ltrim($item['url'], '/') ?: '/');
        return $item;
    }, $menuItems);
@endphp

<aside
    {{ $attributes->merge(['class' => 'bg-surface border-r border-border-custom flex flex-col min-h-screen transition-all duration-300 ' . ($collapsed ? 'w-16' : 'w-64')]) }}>

    {{-- Logo / Brand --}}
    <div class="h-16 flex items-center px-4 border-b border-border-custom">
        {{-- @if (!$collapsed) --}}
        {{--    <span class="text-sm font-bold text-primary truncate">SPJ BPHL 4 Jambi</span> --}}
        {{-- @else --}}
        {{--    <span class="text-primary font-bold text-lg">S</span> --}}
        {{-- @endif --}}
        <img class="h-8 w-auto" src="{{ asset('nav-banner.png') }}" alt="BPHL 4 Jambi">

    </div>

    {{-- Navigation Items --}}
    <nav class="flex-1 py-4 space-y-1 px-2" aria-label="Sidebar Navigation">
        @foreach ($menuItems as $item)
            <a href="{{ $item['url'] ?? '#' }}" title="{{ $collapsed ? $item['label'] : '' }}"
                class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                    {{ $item['active'] ?? false ? 'bg-primary text-white' : 'text-muted hover:bg-primary-light hover:text-primary' }}">
                @if (isset($item['icon']))
                    <x-utility.icon :name="$item['icon']" class="w-5 h-5 shrink-0" />
                @endif
                @if (!$collapsed)
                    <span class="truncate">{{ $item['label'] }}</span>
                @endif
            </a>
        @endforeach
    </nav>

    {{-- Before Footer Slot (opsional, misal accordion menu) --}}
    @isset($beforeFooter)
        {{ $beforeFooter }}
    @endisset

    {{-- Footer Slot (opsional, misal info user) --}}
    @isset($footer)
        <div class="p-4 border-t border-border-custom">
            {{ $footer }}
        </div>
    @endisset

</aside>
