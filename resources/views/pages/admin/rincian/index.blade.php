<x-layout.app title="Kelola Data Rincian SPJ">
    <div id="kelola-rincian-root" class="flex">

        <x-layout.sidebar />

        <main class="flex-1 p-6 bg-background min-h-screen">
            <x-layout.breadcrumb :items="[['label' => 'Admin'], ['label' => 'Kelola Rincian SPJ']]" />

            <x-layout.page-header
                title="Kelola Rincian SPJ"
                description="Pantau dan kelola seluruh Surat Pertanggungjawaban (Rincian Biaya) yang ada di sistem."
            />

            {{-- Flash Messages --}}
            <div class="mt-4">
                @if (session('success'))
                    <x-feedback.alert type="success" title="Berhasil" :dismissible="true">
                        {{ session('success') }}
                    </x-feedback.alert>
                @endif
            </div>

            {{-- Stats --}}
            <div class="mt-4 grid grid-cols-2 sm:grid-cols-5 gap-3">
                <x-dashboard.stat-card title="Total" value="{{ $counts['all'] }}" color="gray" />
                <x-dashboard.stat-card title="Diajukan" value="{{ $counts['diajukan'] }}" color="blue" />
                <x-dashboard.stat-card title="Disetujui" value="{{ $counts['disetujui'] }}" color="green" />
                <x-dashboard.stat-card title="Direvisi" value="{{ $counts['direvisi'] }}" color="yellow" />
                <x-dashboard.stat-card title="Ditolak" value="{{ $counts['ditolak'] }}" color="red" />
            </div>

            {{-- Filter & Search --}}
            <div class="mt-4 flex flex-col sm:flex-row gap-3">
                <form method="GET" action="{{ route('admin.kelola-rincian.index') }}" class="flex flex-1 flex-wrap gap-2">
                    <x-form.search
                        name="search"
                        placeholder="Cari nomor SPD, NIP, atau tujuan..."
                        :value="request('search')"
                        class="flex-1"
                    />
                    <select name="status" class="border border-border-custom rounded-md px-3 py-2 text-sm text-text-main bg-surface focus:outline-none focus:ring-1 focus:ring-primary">
                        <option value="">Semua Status</option>
                        <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                        <option value="diajukan" @selected(request('status') === 'diajukan')>Diajukan</option>
                        <option value="disetujui" @selected(request('status') === 'disetujui')>Disetujui</option>
                        <option value="direvisi" @selected(request('status') === 'direvisi')>Direvisi</option>
                        <option value="ditolak" @selected(request('status') === 'ditolak')>Ditolak</option>
                    </select>
                    <x-action.button type="submit" class="bg-primary hover:bg-primary-hover text-white px-4 py-2 text-sm rounded-md">
                        Filter
                    </x-action.button>
                </form>
            </div>

            {{-- Tabel Rincian --}}
            <x-layout.card class="mt-4">
                <x-slot:header>
                    <div class="flex justify-between items-center px-6 py-4 border-b border-border-custom bg-surface">
                        <h3 class="text-base font-semibold text-text-main">
                            Daftar Rincian SPJ
                            <span class="ml-2 text-xs font-normal text-muted">({{ $rincians->total() }} total)</span>
                        </h3>
                    </div>
                </x-slot:header>

                <div class="p-0 overflow-x-auto">
                    @php
                        $headers = ['Nomor SPD', 'Pegawai', 'Tujuan Kegiatan', 'Status', 'Dibuat', 'Aksi'];

                        $rows = $rincians->map(function ($rincian) {
                            $statusBadge = \Illuminate\Support\Facades\Blade::render(
                                '<x-data.status-badge status="' . $rincian->status . '" />'
                            );

                            $aksi = [
                                ['label' => 'Detail', 'url' => route('admin.kelola-rincian.show', $rincian), 'icon' => 'eye'],
                            ];

                            if (in_array($rincian->status, ['draft', 'direvisi'])) {
                                $aksi[] = ['divider' => true];
                                $aksi[] = ['label' => 'Hapus', 'url' => route('admin.kelola-rincian.destroy', $rincian), 'icon' => 'trash', 'danger' => true];
                            }

                            $dropdownHtml = \Illuminate\Support\Facades\Blade::render(
                                '<x-action.action-menu :items="$items" />',
                                ['items' => $aksi]
                            );

                            return [
                                $rincian->nomor_spd ?? '-',
                                $rincian->pegawai_ditugaskan ?? '-',
                                $rincian->tujuan_kegiatan ?? '-',
                                $statusBadge,
                                $rincian->created_at?->format('d M Y') ?? '-',
                                $dropdownHtml,
                            ];
                        });
                    @endphp

                    <x-data.table :headers="$headers" :rows="$rows" :striped="true" />

                    @if ($rincians->isEmpty())
                        <x-data.empty-state title="Tidak ada data Rincian SPJ" description="Belum ada data rincian pertanggungjawaban yang terdaftar." />
                    @endif
                </div>

                <x-slot:footer>
                    <div class="px-6 py-4 border-t border-border-custom">
                        <x-navigation.pagination :paginator="$rincians" />
                    </div>
                </x-slot:footer>
            </x-layout.card>
        </main>
    </div>
</x-layout.app>
