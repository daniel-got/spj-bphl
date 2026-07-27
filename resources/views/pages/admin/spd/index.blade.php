<x-layout.app title="Kelola Data SPD">
    <div id="kelola-spd-root" class="flex">

        <x-layout.sidebar />

        <main class="flex-1 p-6 bg-background min-h-screen">
            <x-layout.breadcrumb :items="[['label' => 'Admin'], ['label' => 'Kelola Data SPD']]" />

            <x-layout.page-header
                title="Kelola Data SPD"
                description="Pantau dan kelola seluruh Surat Perjalanan Dinas yang ada di sistem."
            />

            {{-- Flash Messages --}}
            <div class="mt-4">
                @if (session('success'))
                    <x-feedback.alert type="success" title="Berhasil" :dismissible="true">
                        {{ session('success') }}
                    </x-feedback.alert>
                @endif
            </div>

            {{-- Filter & Search --}}
            <div class="mt-4 flex flex-col sm:flex-row gap-3">
                <form method="GET" action="{{ route('admin.kelola-spd.index') }}" class="flex flex-1 gap-2">
                    <x-form.search
                        name="search"
                        placeholder="Cari nomor SPD atau NIP pegawai..."
                        :value="request('search')"
                        class="flex-1"
                    />
                    <x-action.button type="submit" class="bg-primary hover:bg-primary-hover text-white px-4 py-2 text-sm rounded-md">
                        Cari
                    </x-action.button>
                </form>
            </div>

            {{-- Tabel SPD --}}
            <x-layout.card class="mt-4">
                <x-slot:header>
                    <div class="flex justify-between items-center px-6 py-4 border-b border-border-custom bg-surface">
                        <h3 class="text-base font-semibold text-text-main">
                            Daftar SPD
                            <span class="ml-2 text-xs font-normal text-muted">({{ $spds->total() }} total)</span>
                        </h3>
                    </div>
                </x-slot:header>

                <div class="p-0 overflow-x-auto">
                    @php
                        $headers = ['Nomor SPD', 'Tgl. SPD', 'NIP Pegawai', 'Nama Pegawai', 'Jenis Perjalanan', 'Status SPJ', 'Aksi'];

                        $rows = $spds->map(function ($spd) {
                            $statusLabel = $spd->rincian?->status ?? 'Belum ada SPJ';
                            $statusBadge = \Illuminate\Support\Facades\Blade::render(
                                '<x-data.status-badge status="' . ($spd->rincian?->status ?? 'inactive') . '" />'
                            );

                            $aksi = [
                                ['label' => 'Detail', 'url' => route('admin.kelola-spd.show', $spd), 'icon' => 'eye'],
                            ];

                            if (! $spd->rincian || in_array($spd->rincian->status, ['draft', 'direvisi'])) {
                                $aksi[] = ['divider' => true];
                                $aksi[] = ['label' => 'Hapus', 'url' => route('admin.kelola-spd.destroy', $spd), 'icon' => 'trash', 'danger' => true];
                            }

                            $dropdownHtml = \Illuminate\Support\Facades\Blade::render(
                                '<x-action.action-menu :items="$items" />',
                                ['items' => $aksi]
                            );

                            return [
                                $spd->nomor_spd ?? '-',
                                $spd->tgl_spd?->format('d M Y') ?? '-',
                                $spd->nip_pegawai ?? '-',
                                $spd->pegawai_ditugaskan ?? '-',
                                ucwords(str_replace('_', ' ', $spd->jenis_perjalanan ?? '-')),
                                $statusBadge,
                                $dropdownHtml,
                            ];
                        });
                    @endphp

                    <x-data.table :headers="$headers" :rows="$rows" :striped="true" />

                    @if ($spds->isEmpty())
                        <x-data.empty-state title="Tidak ada data SPD" description="Belum ada Surat Perjalanan Dinas yang terdaftar di sistem." />
                    @endif
                </div>

                <x-slot:footer>
                    <div class="px-6 py-4 border-t border-border-custom">
                        <x-navigation.pagination :paginator="$spds" />
                    </div>
                </x-slot:footer>
            </x-layout.card>
        </main>
    </div>
</x-layout.app>
