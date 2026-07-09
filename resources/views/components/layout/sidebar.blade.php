@props([
    'items' => [], // Opsional. Jika kosong, otomatis pakai config('navigation.sidebar')
    'collapsed' => false,
])

@php
    // Gunakan items dari props jika dikirim, fallback ke config jika tidak ada
    $menuItems = !empty($items) ? $items : config('navigation.sidebar', []);

    // Filter berdasarkan role user jika item memiliki kunci 'roles'
    if (auth()->check()) {
        $userRole = auth()->user()->role;
        $menuItems = array_filter($menuItems, function ($item) use ($userRole) {
            if (!isset($item['roles'])) {
                return true;
            }
            return in_array($userRole, $item['roles']);
        });
    }

    // Tandai item aktif berdasarkan URL saat ini
    $menuItems = array_map(function ($item) {
        if (isset($item['url'])) {
            $item['active'] = request()->is(ltrim($item['url'], '/') ?: '/');
        } else {
            $item['active'] = false;
        }
        return $item;
    }, $menuItems);
@endphp

<aside
    {{ $attributes->merge(['class' => 'bg-surface border-r border-border-custom flex flex-col sticky top-0 h-screen transition-all duration-300 ' . ($collapsed ? 'w-16' : 'w-64')]) }}>

    {{-- Logo / Brand --}}
    <div class="h-16 flex items-center px-4 border-b border-border-custom">
        {{-- @if (!$collapsed) --}}
        {{--    <span class="text-sm font-bold text-primary truncate">SPJ BPHL 4 Jambi</span> --}}
        {{-- @else --}}
        {{--    <span class="text-primary font-bold text-lg">S</span> --}}
        {{-- @endif --}}
        <img class="h-8 w-auto" src="{{ asset('nav-banner.png') }}" alt="BPHL 4 Jambi">
    </div>

    @auth
    @if (!$collapsed)
    <div class="px-4 py-4 border-b border-border-custom bg-surface/50">
        <div class="flex items-center gap-3">
            <x-utility.avatar :name="Auth::user()->name ?? 'User'" size="md" />
            <div class="min-w-0 flex-1">
                <p class="text-sm font-bold text-text-main truncate">
                    {{ Auth::user()?->pegawai?->nama_pegawai ?? Auth::user()->name ?? 'User' }}
                </p>
                @if (Auth::user()?->pegawai?->nip)
                    <p class="text-[11px] font-medium text-muted truncate mt-0.5">NIP. {{ Auth::user()->pegawai->nip }}</p>
                @endif
                <p class="text-[11px] text-primary truncate mt-0.5 font-medium">
                    {{ Auth::user()?->pegawai?->jabatan ?? Auth::user()?->roleLabel() ?? 'Pegawai' }}
                </p>
            </div>
        </div>
    </div>
    @else
    <div class="flex justify-center py-4 border-b border-border-custom bg-surface/50">
        <x-utility.avatar :name="Auth::user()->name ?? 'User'" size="md" />
    </div>
    @endif
    @endauth

    {{-- Navigation Items --}}
    <nav class="flex-1 py-4 space-y-1 px-2 overflow-y-auto" aria-label="Sidebar Navigation">
        @foreach ($menuItems as $item)
            @if (isset($item['header']))
                @if (!$collapsed)
                    <div class="px-3 pt-4 pb-1 text-xs font-semibold text-muted/60 uppercase tracking-wider">
                        {{ $item['header'] }}
                    </div>
                @else
                    <div class="h-px bg-border-custom my-4 mx-2"></div>
                @endif
            @else
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
            @endif
        @endforeach
    </nav>

    {{-- Logout Button --}}
    <div class="px-2 pb-4 pt-2 border-t border-border-custom">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-error hover:bg-error-light/10 transition-colors duration-150"
                title="{{ $collapsed ? 'Keluar' : '' }}">
                <x-utility.icon name="logout" class="w-5 h-5 shrink-0" />
                @if (!$collapsed)
                    <span class="truncate">Keluar</span>
                @endif
            </button>
        </form>
    </div>

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
