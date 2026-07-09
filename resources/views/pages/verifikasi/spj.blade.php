<x-layout.app title="Verifikasi SPJ">
    <div class="flex flex-1 w-full">
        <x-layout.sidebar />

        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <main class="grow flex flex-col px-6 py-10 bg-background">
                <x-layout.breadcrumb :items="[['label' => 'Operasional'], ['label' => 'Verifikasi SPJ']]" />

                <div class="mt-8">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-foreground">Verifikasi SPJ</h1>
                        <p class="text-muted text-sm mt-1">Daftar Laporan Pertanggungjawaban (SPJ) yang perlu diverifikasi.</p>
                    </div>

                    {{-- Placeholder untuk Tabel Data --}}
                    <div class="bg-surface rounded-xl border border-border-custom p-12 text-center">
                        <x-utility.icon name="shield-check" class="w-12 h-12 mx-auto text-muted/30 mb-4" />
                        <h3 class="text-lg font-medium text-foreground">Halaman Verifikasi SPJ</h3>
                        <p class="text-muted max-w-sm mx-auto mt-2">
                            Daftar dokumen SPJ yang menunggu verifikasi dari Verifikator atau Pimpinan.
                        </p>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-layout.app>
