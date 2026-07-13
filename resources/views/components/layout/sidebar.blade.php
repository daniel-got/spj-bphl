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

{{-- 
  1. Menggunakan 'fixed top-0 left-0 h-screen' supaya mengunci posisi sidebar di layar.
  2. Menggunakan 'flex flex-col justify-between' agar bagian footer (Profil Mas Rusdi) dipaksa selalu mentok ke paling bawah.
--}}
<aside
    {{ $attributes->merge(['class' => 'bg-surface border-r border-border-custom flex flex-col fixed top-0 left-0 h-screen z-40 transition-all duration-300 ' . ($collapsed ? 'w-16' : 'w-64')]) }}>

    {{-- Logo / Brand (Tetap Diam di Atas) --}}
    <div class="h-16 flex items-center px-4 border-b border-border-custom shrink-0">
        {{-- @if (!$collapsed) --}}
        {{--    <span class="text-sm font-bold text-primary truncate">SPJ BPHL 4 Jambi</span> --}}
        {{-- @else --}}
        {{--    <span class="text-primary font-bold text-lg">S</span> --}}
        {{-- @endif --}}
        <img class="h-8 w-auto" src="{{ asset('nav-banner.png') }}" alt="BPHL 4 Jambi">
    </div>

    {{-- Container Menu (Bisa di-scroll mandiri kalau menunya kebanyakan, tanpa menggeser logo/footer) --}}
    <div class="flex-1 overflow-y-auto py-4 px-2 space-y-1">
        
        {{-- Navigation Items --}}
        <nav aria-label="Sidebar Navigation">
            @foreach ($menuItems as $item)
                <a href="{{ $item['url'] ?? '#' }}" title="{{ $collapsed ? $item['label'] : '' }}"
                    class="flex items-center gap-3 px-3 py-2 mb-1 rounded-md text-sm font-medium transition-colors duration-150
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
            <div class="mt-4">
                {{ $beforeFooter }}
            </div>
        @endisset

    </div>

    {{-- Footer Slot - Profil User & Keluar (Dipaksa Selalu Mentok Paling Bawah & Tidak Bergerak) --}}
    @isset($footer)
        <div class="p-4 border-t border-border-custom bg-surface shrink-0">
            {{ $footer }}
        </div>
    @endisset

</aside>