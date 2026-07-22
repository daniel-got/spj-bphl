@props([
    'items' => [], // Opsional. Jika kosong, otomatis pakai config('navigation.sidebar')
    'collapsed' => false,
])

@php
    // Gunakan items dari props jika dikirim, fallback ke config jika tidak ada
    $menuItems = !empty($items) ? $items : config('navigation.sidebar', []);

    // Filter berdasarkan role user jika item memiliki kunci 'roles'
    if (auth()->check()) {
        $userRoles = auth()->user()->roles ?? [];
        $menuItems = array_filter($menuItems, function ($item) use ($userRoles) {
            if (!isset($item['roles'])) {
                return true;
            }
            return count(array_intersect($userRoles, $item['roles'])) > 0;
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
            @elseif (isset($item['sub_items']))
                @php
                    $isActive = false;
                    foreach($item['sub_items'] as $subItem) {
                        $pattern = ltrim($subItem['url'], '/') ?: '/';
                        if (request()->is($pattern) || request()->is($pattern . '/*')) {
                            $isActive = true;
                            break;
                        }
                    }
                @endphp
                <div x-data="{ open: {{ $isActive ? 'true' : 'false' }} }">
                    <button
                        @click="open = !open"
                        class="w-full flex items-center justify-between gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                            {{ $isActive ? 'bg-primary/10 text-primary' : 'text-muted hover:bg-primary-light hover:text-primary' }}"
                        title="{{ $collapsed ? $item['label'] : '' }}"
                    >
                        <span class="flex items-center gap-3">
                            @if (isset($item['icon']))
                                <x-utility.icon :name="$item['icon']" class="w-5 h-5 shrink-0" />
                            @endif
                            @if (!$collapsed)
                                <span class="truncate">{{ $item['label'] }}</span>
                            @endif
                        </span>
                        @if (!$collapsed)
                            <x-utility.icon
                                name="chevron-down"
                                class="w-4 h-4 shrink-0 transition-transform duration-200"
                                ::class="open ? 'rotate-180' : ''"
                            />
                        @endif
                    </button>

                    @if (!$collapsed)
                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1"
                        class="mt-1 ml-4 pl-3 border-l-2 border-primary-light space-y-0.5"
                    >
                        @foreach ($item['sub_items'] as $subItem)
                            @php
                                $pattern = ltrim($subItem['url'], '/') ?: '/';
                                $isSubActive = request()->is($pattern) || request()->is($pattern . '/*');
                            @endphp
                            <a href="{{ $subItem['url'] ?? '#' }}"
                                class="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                                    {{ $isSubActive ? 'bg-primary/10 text-primary font-semibold' : 'text-muted hover:bg-primary-light hover:text-primary' }}">
                                @if (isset($subItem['icon']))
                                    <x-utility.icon :name="$subItem['icon']" class="w-4 h-4 shrink-0" />
                                @endif
                                <span>{{ $subItem['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                    @endif
                </div>
            @else
                @php
                    $pattern = isset($item['url']) ? ltrim($item['url'], '/') : '';
                    $isActive = $item['active'] ?? false;
                    if ($pattern && (request()->is($pattern) || request()->is($pattern . '/*'))) {
                        $isActive = true;
                    }
                @endphp
                <a href="{{ $item['url'] ?? '#' }}" title="{{ $collapsed ? $item['label'] : '' }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                        {{ $isActive ? 'bg-primary text-white' : 'text-muted hover:bg-primary-light hover:text-primary' }}">
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
