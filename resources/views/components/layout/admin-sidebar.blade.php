<x-layout.sidebar :items="[
    [
        'label' => 'Dashboard',
        'url' => route('admin.dashboard'),
        'icon' => 'home',
        'active' => request()->routeIs('admin.dashboard'),
    ],
    [
        'label' => 'Kelola Pegawai',
        'url' => route('admin.kelolaPegawai'),
        'icon' => 'users',
        'active' => request()->routeIs('admin.kelolaPegawai') || request()->routeIs('admin.kelolaPegawai.*'),
    ],
    [
        'label' => 'Kelola Dokumen',
        'url' => '#',
        'icon' => 'document-text',
        'active' => request()->routeIs('admin.dokumen.*'),
    ],
]">
    <x-slot:footer>
        <div class="space-y-2">
            <div class="flex items-center gap-3 px-2">
                <x-utility.avatar :name="Auth::user()->name ?? 'User'" size="sm" />
                <div class="min-w-0">
                    <p class="text-sm font-medium text-text-main truncate">{{ Auth::user()->name ?? 'User' }}</p>
                    <p class="text-xs text-muted truncate">{{ Auth::user()?->roleLabel() ?? 'Admin' }}</p>
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
    </x-slot:footer>
</x-layout.sidebar>
