<x-layout.app title="Verifikasi SPT - SPJ BPHL 4">

    <div class="flex flex-1 w-full">
        <x-layout.sidebar />

        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <main class="grow flex flex-col px-6 py-10">

                <div class="max-w-7xl mx-auto w-full">

                    {{-- Alert Notifikasi Sukses --}}
                    @if (session('success'))
                        <div class="mb-6">
                            <x-feedback.alert type="success" title="Berhasil!">
                                {{ session('success') }}
                            </x-feedback.alert>
                        </div>
                    @endif

                    {{-- Header Halaman --}}
                    <x-layout.page-header title="Verifikasi Dokumen SPT" subtitle="Daftar Surat Perintah Tugas yang Perlu Diverifikasi Pimpinan">
                    </x-layout.page-header>

                    {{-- Tabel Riwayat SPT --}}
                    <div class="mb-8">
                        @php
                            $isStatusDetailView = in_array(request('status'), ['disetujui', 'ditolak', 'direvisi']);
                            $activeFilters = 0;
                            if (request()->filled('search')) $activeFilters++;
                            if (request()->filled('status') && request('status') !== 'menunggu_tu') $activeFilters++;
                        @endphp

                        <x-layout.card>
                            <x-slot:header>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-lg font-semibold text-text-main">
                                        Daftar SPT 
                                        @if(request('status'))
                                            - Status: {{ ucfirst(request('status')) }}
                                        @else
                                            - Menunggu Verifikasi
                                        @endif
                                    </h3>
                                    @if($activeFilters > 0)
                                        <span class="text-xs bg-primary-light text-primary px-2 py-0.5 rounded-full">
                                            {{ $activeFilters }} filter aktif
                                        </span>
                                    @endif
                                </div>
                            </x-slot:header>

                            {{-- Filter & Pencarian --}}
                            <div class="mb-6 mt-2 border-b border-border-custom pb-6">
                                <form method="GET" action="{{ route('verifikasi.spt.index') }}" x-data x-on:input.debounce.500ms="$el.submit()">
                                    <div class="grid grid-cols-12 gap-4 items-end">
                                        <div class="col-span-12 md:col-span-5 flex flex-col gap-1">
                                            <label for="search" class="text-sm font-medium text-text-main">Pencarian</label>
                                            <x-form.search name="search" placeholder="Cari nomor SPT, nama..." :value="request('search')" />
                                        </div>
                                        <div class="col-span-6 md:col-span-3 flex flex-col gap-1">
                                            <x-form.select name="status" label="Status Dokumen" :options="[
                                                'menunggu_tu' => 'Menunggu TU',
                                                'menunggu_balai' => 'Menunggu Balai',
                                                'disetujui' => 'Telah Disetujui',
                                                'direvisi' => 'Direvisi (Dikembalikan)',
                                                'ditolak' => 'Ditolak'
                                            ]" :selected="request('status', 'menunggu_tu')" onchange="this.form.submit()" />
                                        </div>
                                        <div class="col-span-6 md:col-span-2 flex flex-col gap-1">
                                            <x-form.select name="per_page" label="Tampilkan" :options="[
                                                '10' => '10 Data',
                                                '25' => '25 Data',
                                                '50' => '50 Data',
                                            ]" :selected="request('per_page', 10)" onchange="this.form.submit()" />
                                        </div>
                                        <div class="col-span-12 md:col-span-2 flex flex-col gap-2 items-center md:items-start justify-end md:pb-1">
                                            <x-action.button-primary type="submit" class="w-full justify-center text-center ">
                                                Filter
                                            </x-action.button-primary>
                                            @if($activeFilters > 0)
                                                <a href="{{ route('verifikasi.spt.index') }}" class="text-sm text-muted hover:text-text-main underline">
                                                    Reset Filter
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- Pengaturan Header dan Isi Baris Tabel Berdasarkan Struktur Data SPT --}}
                            @php
                                $headers = [
                                    'No', 'Nomor SPT', 'Tgl SPT', 'Penanggung Jawab', 
                                    'Tujuan Kegiatan', 'Tempat Tujuan', 'Tgl. Berangkat', 'Status', 'Aksi'
                                ];

                                $iteration = 1;

                                $sptItems = ($spts ?? null) && method_exists($spts, 'items') ? $spts->items() : ($spts ?? []);

                                $rows = collect($sptItems)->map(function ($spt) use (&$iteration) {
                                    if (!is_object($spt)) {
                                        return null;
                                    }

                                    $destinations = $spt->tempat_tujuan;
                                    if (is_array($destinations)) {
                                        $destinationsText = implode(', ', $destinations);
                                    } else {
                                        $decoded = json_decode($destinations, true);
                                        $destinationsText = is_array($decoded) ? implode(', ', $decoded) : (string) $destinations;
                                    }
                                    $destinationsText = e($destinationsText);

                                    $tglSpt = $spt->tgl_spt ? \Carbon\Carbon::parse($spt->tgl_spt)->format('d/m/Y') : '-';
                                    $tglBerangkat = $spt->tgl_berangkat ? \Carbon\Carbon::parse($spt->tgl_berangkat)->format('d/m/Y') : '-';
                                    $namaPegawai = e($spt->penanggung_jawab ?? '-');

                                    $nomorSptLink = '<a href="' . route('verifikasi.spt.show', $spt->id) . '" class="text-primary hover:underline font-semibold" title="Lihat Rincian">' . e($spt->nomor_spt ?? '') . '</a>';

                                    $actions = [
                                        'detail' => route('verifikasi.spt.show', $spt->id),
                                    ];

                                    $statusBadge = \Illuminate\Support\Facades\Blade::render('<x-data.status-badge status="' . $spt->status . '" />');

                                    return [
                                        'cells' => [
                                            $iteration++,
                                            $nomorSptLink,
                                            $tglSpt,
                                            $namaPegawai,
                                            '<div class="max-w-[200px] whitespace-normal line-clamp-2" title="' . e($spt->tujuan_kegiatan ?? '') . '">' . e($spt->tujuan_kegiatan ?? '') . '</div>',
                                            '<div class="max-w-[150px] whitespace-normal line-clamp-2" title="' . $destinationsText . '">' . $destinationsText . '</div>',
                                            $tglBerangkat,
                                            $statusBadge,
                                        ],
                                        'actions' => $actions
                                    ];
                                })->filter()->toArray();
                            @endphp

                            <x-data.table :headers="$headers" :rows="$rows" :striped="true" />

                            <div class="mt-4 flex justify-between items-center text-xs text-muted">
                                <span>Menampilkan {{ count($rows) }} entri SPT.</span>
                                
                                @if(method_exists($spts, 'links'))
                                    {{ $spts->withQueryString()->links() }}
                                @endif
                            </div>
                        </x-layout.card>
                    </div>

                </div>

            </main>

            <x-layout.footer />
        </div>
    </div>

</x-layout.app>
