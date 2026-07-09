<x-layout.app title="Kelola SPT Pegawai">
    <div class="flex flex-1 w-full">
        <x-layout.sidebar />

        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <main class="grow flex flex-col px-6 py-10 bg-background">
                <x-layout.breadcrumb :items="[['label' => 'Operasional'], ['label' => 'Kelola SPT Pegawai']]" />

                <div class="mt-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-foreground">Kelola SPT Pegawai</h1>
                            <p class="text-muted text-sm mt-1">Daftar semua SPT yang dibuat untuk pegawai-pegawai.</p>
                        </div>
                        <a href="{{ route('user.spt.create') }}" class="btn btn-primary">
                            <x-utility.icon name="plus" class="w-5 h-5 mr-2" />
                            Buat SPT Baru
                        </a>
                    </div>

                    {{-- Placeholder untuk Tabel Data --}}
                    <div class="bg-surface rounded-xl border border-border-custom p-12 text-center">
                        <x-utility.icon name="document-text" class="w-12 h-12 mx-auto text-muted/30 mb-4" />
                        <h3 class="text-lg font-medium text-foreground">Halaman Sedang Dikembangkan</h3>
                        <p class="text-muted max-w-sm mx-auto mt-2">
                            Halaman ini nantinya akan berisi daftar SPT seluruh pegawai yang bisa dikelola oleh Pembuat SPT.
                        </p>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-layout.app>
