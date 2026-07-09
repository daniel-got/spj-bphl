@php
    $isPembuatSpt = Auth::check() && Auth::user()->role === 'pembuat_spt';
    $isPembuatSptMenuOpen = request()->routeIs('pembuat_spt.*')
        || request()->routeIs('user.spt.create')
        || request()->routeIs('user.spt.edit');
@endphp

<aside class="bg-surface border-r border-border-custom flex flex-col sticky top-0 h-screen w-64 transition-all duration-300">

    {{-- Logo / Brand --}}
    <div class="h-16 flex items-center px-4 border-b border-border-custom">
        <img class="h-8 w-auto" src="{{ asset('nav-banner.png') }}" alt="BPHL 4 Jambi">
    </div>

    @auth
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
    @endauth

    {{-- Navigation Items --}}
    <nav class="flex-1 py-4 space-y-1 px-2 overflow-y-auto" aria-label="Sidebar Navigation">

        {{-- Dashboard --}}
        <a href="#" {{-- href="{{ route('user.dashboard') }}" --}}
            class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                {{ request()->routeIs('user.dashboard') ? 'bg-primary text-white' : 'text-muted hover:bg-primary-light hover:text-primary' }}">
            <x-utility.icon name="home" class="w-5 h-5 shrink-0" />
            <span class="truncate">Dashboard</span>
        </a>

        {{-- Data SPT --}}
        <a href="{{ route('user.spt.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                {{ request()->routeIs('user.spt.index') || request()->routeIs('user.spt.show') ? 'bg-primary text-white' : 'text-muted hover:bg-primary-light hover:text-primary' }}">
            <x-utility.icon name="document-text" class="w-5 h-5 shrink-0" />
            <span class="truncate">Data SPT</span>
        </a>

        {{-- Accordion Pembuat SPT — hanya muncul untuk role pembuat_spt, tepat di bawah Data SPT --}}
        @if ($isPembuatSpt)
            <div x-data="{ open: {{ $isPembuatSptMenuOpen ? 'true' : 'false' }} }">
                {{-- Toggle --}}
                <button
                    @click="open = !open"
                    class="w-full flex items-center justify-between gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                        {{ $isPembuatSptMenuOpen ? 'bg-primary/10 text-primary' : 'text-muted hover:bg-primary-light hover:text-primary' }}"
                >
                    <span class="flex items-center gap-3">
                        <x-utility.icon name="pencil-square" class="w-5 h-5 shrink-0" />
                        <span class="truncate">Pembuat SPT</span>
                    </span>
                    <x-utility.icon
                        name="chevron-down"
                        class="w-4 h-4 shrink-0 transition-transform duration-200"
                        ::class="open ? 'rotate-180' : ''"
                    />
                </button>

                {{-- Submenu --}}
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
                    <a href="{{ route('pembuat_spt.index') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                            {{ request()->routeIs('pembuat_spt.index') ? 'bg-primary/10 text-primary font-semibold' : 'text-muted hover:bg-primary-light hover:text-primary' }}">
                        <x-utility.icon name="chart-bar" class="w-4 h-4 shrink-0" />
                        <span>Dashboard SPT</span>
                    </a>
                    <a href="{{ route('user.spt.create') }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                            {{ request()->routeIs('user.spt.create') ? 'bg-primary/10 text-primary font-semibold' : 'text-muted hover:bg-primary-light hover:text-primary' }}">
                        <x-utility.icon name="plus-circle" class="w-4 h-4 shrink-0" />
                        <span>Buat SPT Baru</span>
                    </a>
                </div>
            </div>
        @endif

        {{-- Data SPD --}}
        <a href="{{ route('user.spd.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                {{ request()->routeIs('user.spd.*') ? 'bg-primary text-white' : 'text-muted hover:bg-primary-light hover:text-primary' }}">
            <x-utility.icon name="document-text" class="w-5 h-5 shrink-0" />
            <span class="truncate">Data SPD</span>
        </a>

        {{-- Data Rincian --}}
        <a href="{{ route('user.rincian.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                {{ request()->routeIs('user.rincian.*') ? 'bg-primary text-white' : 'text-muted hover:bg-primary-light hover:text-primary' }}">
            <x-utility.icon name="document-text" class="w-5 h-5 shrink-0" />
            <span class="truncate">Data Rincian</span>
        </a>

    </nav>

    {{-- Footer: Info User & Logout --}}
    <div class="p-4 border-t border-border-custom">
        <div class="space-y-2">
            <div class="flex items-center gap-3 px-2">
                <x-utility.avatar :name="Auth::user()->name ?? 'User'" size="sm" />
                <div class="min-w-0">
                    <p class="text-sm font-medium text-text-main truncate">{{ Auth::user()->name ?? 'User' }}</p>
                    <p class="text-xs text-muted truncate">{{ Auth::user()?->roleLabel() ?? 'Pegawai' }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-2 px-2 py-2 text-sm text-muted hover:text-danger hover:bg-red-50 rounded-md transition-colors">
                    <x-utility.icon name="arrow-right-on-rectangle" class="w-4 h-4" />
                    Keluar
                </button>
            </form>
        </div>
    </div>

</aside>
