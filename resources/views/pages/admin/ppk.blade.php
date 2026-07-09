<x-layout.app title="Kelola PPK">
    <div class="flex flex-1 w-full">
        <x-layout.sidebar />

        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <main class="grow flex flex-col px-6 py-10 bg-background">
                <x-layout.breadcrumb :items="[['label' => 'Administrasi'], ['label' => 'Kelola PPK']]" />

                <div class="mt-8">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-foreground">Kelola PPK</h1>
                        <p class="text-muted text-sm mt-1">Daftar Pejabat Pembuat Komitmen (PPK) penandatangan dokumen.</p>
                    </div>

                    {{-- Placeholder untuk Tabel Data --}}
                    <div class="bg-surface rounded-xl border border-border-custom p-12 text-center">
                        <x-utility.icon name="identification" class="w-12 h-12 mx-auto text-muted/30 mb-4" />
                        <h3 class="text-lg font-medium text-foreground">Halaman Kelola PPK</h3>
                        <p class="text-muted max-w-sm mx-auto mt-2">
                            Daftar pejabat yang berwenang menandatangani dokumen SPJ/SPD akan dikelola di sini.
                        </p>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-layout.app>
