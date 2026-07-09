<x-layout.app title="Master Tarif">
    <div class="flex flex-1 w-full">
        <x-layout.sidebar />

        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <main class="grow flex flex-col px-6 py-10 bg-background">
                <x-layout.breadcrumb :items="[['label' => 'Administrasi'], ['label' => 'Master Tarif']]" />

                <div class="mt-8">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-foreground">Master Tarif</h1>
                        <p class="text-muted text-sm mt-1">Kelola data tarif uang harian dan biaya pengadaan per provinsi/golongan.</p>
                    </div>

                    {{-- Placeholder untuk Tabel Data --}}
                    <div class="bg-surface rounded-xl border border-border-custom p-12 text-center">
                        <x-utility.icon name="currency-dollar" class="w-12 h-12 mx-auto text-muted/30 mb-4" />
                        <h3 class="text-lg font-medium text-foreground">Halaman Master Tarif</h3>
                        <p class="text-muted max-w-sm mx-auto mt-2">
                            Pengaturan uang harian per provinsi dan biaya pengadaan sesuai golongan akan dikelola di sini.
                        </p>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-layout.app>
