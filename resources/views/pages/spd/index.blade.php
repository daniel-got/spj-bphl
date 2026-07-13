<x-layout.app title="Data SPD - SPJ BPHL 4">


    <div class="flex flex-1 w-full">
        <x-layout.sidebar />

        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <main class="grow flex flex-col px-6 py-10">

        <div class="max-w-7xl mx-auto w-full">

            @if (session('success'))
                <div class="mb-6">
                    <x-feedback.alert type="success" title="Berhasil!">
                        {{ session('success') }}
                    </x-feedback.alert>
                </div>
            @endif

            {{-- Header --}}
            <x-layout.page-header title="Data SPD" subtitle="Daftar Surat Perjalanan Dinas">
                <x-slot:actions>
                    <a href="{{ route('user.spd.create') }}"
                        class="inline-flex items-center justify-center bg-primary hover:bg-primary-hover text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors duration-150 ">
                        + Tambah Baru
                    </a>
                </x-slot:actions>
            </x-layout.page-header>

            {{-- Tabel Riwayat SPD --}}
            <div class="mb-8">
                <x-layout.card>
                    <x-slot:header>
                        <h3 class="text-lg font-semibold text-text-main">Riwayat SPD</h3>
                    </x-slot:header>

                    {{-- Filter & Pencarian didalam Card Riwayat SPD --}}
                    <div class="mb-6 mt-2 border-b border-border-custom pb-6">
                        <form method="GET" action="{{ route('user.spd.index') }}">

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                                <div class="flex flex-col gap-1">
                                    <label for="search" class="text-sm font-medium text-text-main">Pencarian</label>
                                    <x-form.search name="search" placeholder="Cari nomor SPD, nama pegawai..."
                                        :value="request('search')" />
                                </div>
                                <div class="flex flex-col gap-1">
                                    <x-form.select name="jenis_perjalanan" label="Jenis Perjalanan" :options="[
                                        '' => 'Semua Perjalanan',
                                        'Dalam Kota' => 'Dalam Kota',
                                        'Luar Kota' => 'Luar Kota',
                                    ]"
                                        :selected="request('jenis_perjalanan')" />
                                </div>
                                <div class="flex flex-col gap-1">
                                    <x-form.select name="per_page" label="Tampilkan" :options="[
                                        '10' => '10 Data',
                                        '25' => '25 Data',
                                        '50' => '50 Data',
                                    ]"
                                        :selected="request('per_page', 10)" onchange="this.form.submit()" />
                                </div>
                                <div class="flex gap-2">
                                        <x-action.button-primary type="submit" class="w-full justify-center text-center ">
                                            Filter
                                        </x-action.button-primary>
                                </div>
                            </div>
                        </form>
                    </div>

                    @php
                            $headers = [
                                'No',
                                'Nomor SPD',
                                'Tanggal SPD',
                                'Nama Pegawai',
                                'NIP',
                                'Pangkat/Golongan',
                                'Jabatan',
                                'Tujuan Kegiatan',
                                'Tempat Tujuan',
                                'Tgl. Berangkat',
                                'Tgl. Kembali',
                                'Waktu (Hari)',
                                'Kode MAK',
                                'Jenis Perjalanan',
                                'Berangkat Dari',
                                'Alat Angkut',
                                'Pejabat Pembuat (PPK)',
                                'Nama PPK',
                                'NIP PPK',
                                'Aksi',
                            ];

                            $rows = collect($spds->items() ?? [])->map(function ($spd, $index) use ($spds) {
                                $destinations = $spd->tempat_tujuan;
                                if (is_array($destinations)) {
                                    $destinationsText = implode(', ', $destinations);
                                } else {
                                    $decoded = json_decode($destinations, true);
                                    $destinationsText = is_array($decoded)
                                        ? implode(', ', $decoded)
                                        : (string) $destinations;
                                }
                                $destinationsText = e($destinationsText);

                                $vehicles = $spd->alat_angkut;
                                if (is_array($vehicles)) {
                                    $vehiclesText = implode(', ', $vehicles);
                                } else {
                                    $decoded = json_decode($vehicles, true);
                                    $vehiclesText = is_array($decoded)
                                        ? implode(', ', $decoded)
                                        : (string) $vehicles;
                                }
                                $vehiclesText = e($vehiclesText);

                                $tglSpd =
                                    $spd->tgl_spd instanceof \Carbon\Carbon
                                        ? $spd->tgl_spd->format('d/m/Y')
                                        : ($spd->tgl_spd
                                            ? \Carbon\Carbon::parse($spd->tgl_spd)->format('d/m/Y')
                                            : '-');
                                $tglBerangkat =
                                    $spd->tgl_berangkat instanceof \Carbon\Carbon
                                        ? $spd->tgl_berangkat->format('d/m/Y')
                                        : ($spd->tgl_berangkat
                                            ? \Carbon\Carbon::parse($spd->tgl_berangkat)->format('d/m/Y')
                                            : '-');
                                $tglKembali =
                                    $spd->tgl_kembali instanceof \Carbon\Carbon
                                        ? $spd->tgl_kembali->format('d/m/Y')
                                        : ($spd->tgl_kembali
                                            ? \Carbon\Carbon::parse($spd->tgl_kembali)->format('d/m/Y')
                                            : '-');

                                // Clickable Nomor SPD link to show detail view
                                $nomorSpdLink =
                                    '<a href="' .
                                    route('user.spd.show', $spd->id) .
                                    '" class="text-primary hover:underline font-semibold" title="Lihat Rincian">' .
                                    e($spd->nomor_spd ?? '') .
                                    '</a>';



                                $isReadonly = $spd->rincian && !in_array($spd->rincian->status, [\App\Models\Rincian::STATUS_DRAFT, \App\Models\Rincian::STATUS_REVISED]);
                                $canEdit = !$isReadonly && auth()->user()->can('update', $spd);
                                $canDelete = !$isReadonly && auth()->user()->can('delete', $spd);

                                $actions = [
                                    'detail' => route('user.spd.show', $spd->id),
                                    'print' => route('user.spd.print', $spd->id),
                                ];
                                
                                if ($canEdit) {
                                    $actions['edit'] = route('user.spd.edit', $spd->id);
                                }
                                
                                if ($canDelete) {
                                    $actions['delete'] = route('user.spd.destroy', $spd->id);
                                }

                                return [
                                    'cells' => [
                                        ($spds->firstItem() ?? 1) + $index,
                                        $nomorSpdLink,
                                        $tglSpd,
                                        e($spd->pegawai_ditugaskan ?? ''),
                                        e($spd->nip_pegawai ?? ''),
                                        e($spd->pangkat_pegawai ?? '-'),
                                        e($spd->jabatan_pegawai ?? '-'),
                                        '<div class="max-w-xs whitespace-normal line-clamp-2" title="' .
                                        e($spd->tujuan_kegiatan ?? '') .
                                        '">' .
                                        e($spd->tujuan_kegiatan ?? '') .
                                        '</div>',
                                        '<div class="max-w-xs whitespace-normal" title="' .
                                        $destinationsText .
                                        '">' .
                                        $destinationsText .
                                        '</div>',
                                        $tglBerangkat,
                                        $tglKembali,
                                        e($spd->lama_kegiatan ?? '') . ' Hari',
                                        e($spd->kode_mak ?? ''),
                                        e($spd->jenis_perjalanan ?? ''),
                                        e($spd->berangkat_dari ?? ''),
                                        $vehiclesText,
                                        e($spd->ppk ?? ''),
                                        e($spd->nama_ppk ?? ''),
                                        e($spd->nip_ppk ?? ''),
                                    ],
                                    'actions' => $actions
                                ];
                            });
                    @endphp

                    <x-data.table :headers="$headers" :rows="$rows" :striped="true" />

                    @if ($spds->hasPages())
                        <div class="mt-4">
                            {{ $spds->withQueryString()->links('components.navigation.pagination') }}
                        </div>
                    @else
                        <div class="mt-4 text-xs text-muted">
                            <span>Menampilkan {{ $spds->count() }} entri.</span>
                        </div>
                    @endif
                </x-layout.card>
            </div>

        </div>

            </main>

            <x-layout.footer />
        </div>
    </div>

</x-layout.app>
