<x-layout.app title="Verifikasi SPT">
    <div class="flex flex-1 w-full">
        <x-layout.sidebar />

        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <main class="grow flex flex-col px-6 py-10 bg-background">
                <x-layout.breadcrumb :items="[['label' => 'Operasional'], ['label' => 'Verifikasi SPT']]" />

                <div class="mt-8">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-foreground">Verifikasi SPT</h1>
                        <p class="text-muted text-sm mt-1">Daftar SPT yang memerlukan persetujuan atau verifikasi Anda.</p>
                    </div>

                    {{-- Placeholder untuk Tabel Data --}}
                    <div class="bg-surface rounded-xl border border-border-custom p-12 text-center">
                        <x-utility.icon name="check-badge" class="w-12 h-12 mx-auto text-muted/30 mb-4" />
                        <h3 class="text-lg font-medium text-foreground">Halaman Verifikasi SPT</h3>
                        <p class="text-muted max-w-sm mx-auto mt-2">
                            Daftar SPT yang menunggu persetujuan pimpinan akan muncul di sini.
                        </p>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-layout.app>
