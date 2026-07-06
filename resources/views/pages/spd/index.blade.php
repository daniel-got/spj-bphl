<x-layout.app title="Data SPD - SPJ BPHL 4">


    <div class="flex flex-1 w-full">
        <x-layout.user-sidebar />
        
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
                        class="inline-flex items-center justify-center bg-primary hover:bg-primary-hover text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors duration-150 h-[38px]">
                        + Tambah Baru
                    </a>
                </x-slot:actions>
            </x-layout.page-header>

            {{-- Stats Section --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <x-dashboard.stat-card title="Total SPD" value="{{ $counts['all'] }}" description="Total data semua SPD"
                    icon="document-text" color="blue" href="{{ route('user.spd.index') }}" />
                <x-dashboard.stat-card title="Disetujui" value="{{ $counts['disetujui'] }}"
                    description="Total SPD disetujui" icon="check-circle" color="green"
                    href="{{ route('user.spd.index', ['status' => 'disetujui']) }}" />
                <x-dashboard.stat-card title="Direvisi" value="{{ $counts['direvisi'] }}"
                    description="Total SPD perlu direvisi" icon="exclamation-circle" color="yellow"
                    href="{{ route('user.spd.index', ['status' => 'direvisi']) }}" />
                <x-dashboard.stat-card title="Ditolak" value="{{ $counts['ditolak'] }}" description="Total SPD ditolak"
                    icon="x-circle" color="red" href="{{ route('user.spd.index', ['status' => 'ditolak']) }}" />
            </div>

            {{-- Tabel Riwayat SPD --}}
            <div class="mb-8">
                @php
                    $isStatusDetailView = in_array(request('status'), ['disetujui', 'ditolak', 'direvisi']);
                @endphp
                <x-layout.card>
                    @if ($isStatusDetailView)
                        <x-slot:header>
                            @php
                                $statusTitleColors = [
                                    'disetujui' => 'bg-green-50 text-green-700 border-green-200/80',
                                    'ditolak' => 'bg-red-50 text-red-700 border-red-200/80',
                                    'direvisi' => 'bg-yellow-50 text-yellow-700 border-yellow-200/80',
                                ];
                                $statusColorClass =
                                    $statusTitleColors[request('status')] ??
                                    'bg-gray-50 text-text-main border-border-custom';
                            @endphp
                            <h3 class="text-lg font-semibold text-text-main flex items-center gap-2.5">
                                <span>Status SPD :</span>
                                <span
                                    class="inline-flex items-center px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-lg border {{ $statusColorClass }} shadow-2xs">
                                    {{ request('status') }}
                                </span>
                            </h3>
                        </x-slot:header>
                    @else
                        @php
                            $titleString =
                                'Riwayat SPD' . (request('status') ? ' - Status: ' . ucfirst(request('status')) : '');
                        @endphp
                        <x-slot:header>
                            <h3 class="text-lg font-semibold text-text-main">{{ $titleString }}</h3>
                        </x-slot:header>
                    @endif

                    {{-- Active status filter badge --}}
                    @if (request('status') && !in_array(request('status'), ['disetujui', 'ditolak', 'direvisi']))
                        @php
                            $statusColors = [
                                'draft' => 'bg-gray-100 text-gray-800 border border-gray-200',
                                'diajukan' => 'bg-blue-100 text-blue-800 border border-blue-200',
                            ];
                            $activeColor = $statusColors[request('status')] ?? 'bg-primary-light text-primary';
                        @endphp
                        <div class="mb-4 flex items-center gap-2">
                            <span class="text-xs text-muted">Filter aktif:</span>
                            <span
                                class="inline-flex items-center {{ $activeColor }} text-xs font-semibold px-2.5 py-1 rounded-full">
                                Status: {{ ucfirst(request('status')) }}
                            </span>
                        </div>
                    @endif

                    {{-- Filter & Pencarian didalam Card Riwayat SPD --}}
                    <div class="mb-6 mt-2 border-b border-border-custom pb-6">
                        <form method="GET" action="{{ route('user.spd.index') }}">
                            <input type="hidden" name="status" value="{{ request('status') }}">

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
                                    <button type="submit"
                                        class="bg-primary hover:bg-primary-hover text-white text-sm font-semibold px-5 py-2 rounded-md transition-colors duration-150 cursor-pointer border border-transparent w-full justify-center text-center h-[38px]">
                                        Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    @php
                        $isStatusDetailView = in_array(request('status'), ['disetujui', 'ditolak', 'direvisi']);

                        if ($isStatusDetailView) {
                            $headers = [
                                'NO',
                                'No SPD',
                                'Tanggal Diajukan',
                                'Tanggal Diperiksa',
                                'Catatan',
                                'Verifikator',
                                'Aksi',
                            ];

                            $rows = collect($spds->items() ?? [])->map(function ($spd, $index) use ($spds) {
                                $tglDiajukan = $spd->created_at
                                    ? $spd->created_at->format('d/m/Y')
                                    : ($spd->tgl_spd
                                        ? \Carbon\Carbon::parse($spd->tgl_spd)->format('d/m/Y')
                                        : '-');
                                $tglDiperiksa = $spd->updated_at ? $spd->updated_at->format('d/m/Y') : '-';
                                $catatan =
                                    $spd->status === 'disetujui'
                                        ? '<span class="text-xs text-muted italic">Tidak butuh alasan</span>'
                                        : e($spd->alasan ?? '-');
                                $verifikator = e($spd->nama_ppk ?? ($spd->ppk ?? '-'));

                                $nomorSpdLink =
                                    '<a href="' .
                                    route('user.spd.show', $spd->id) .
                                    '" class="text-primary hover:underline font-semibold" title="Lihat Rincian">' .
                                    e($spd->nomor_spd ?? '') .
                                    '</a>';

                                $aksiButtons =
                                    '<div class="flex items-center gap-2">
                                    <a href="' .
                                    route('user.spd.show', $spd->id) .
                                    '" class="inline-flex items-center bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white text-xs font-semibold px-2.5 py-1 rounded transition-colors duration-150 border border-blue-200/50" title="Detail">
                                        Detail
                                    </a>
                                    <a href="' .
                                    route('user.spd.edit', $spd->id) .
                                    '" class="inline-flex items-center bg-yellow-50 hover:bg-yellow-600 text-yellow-700 hover:text-white text-xs font-semibold px-2.5 py-1 rounded transition-colors duration-150 border border-yellow-200/50" title="Edit">
                                        Edit
                                    </a>
                                </div>';

                                return [
                                    ($spds->firstItem() ?? 1) + $index,
                                    $nomorSpdLink,
                                    $tglDiajukan,
                                    $tglDiperiksa,
                                    $catatan,
                                    $verifikator,
                                    $aksiButtons,
                                ];
                            });
                        } else {
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
                                'Status',
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

                                $statusMap = [
                                    'draft' => ['label' => 'Draft', 'class' => 'bg-gray-100 text-gray-800'],
                                    'diajukan' => ['label' => 'Diajukan', 'class' => 'bg-blue-100 text-blue-800'],
                                    'direvisi' => [
                                        'label' => 'Direvisi',
                                        'class' => 'bg-orange-100 text-orange-800',
                                    ],
                                    'disetujui' => [
                                        'label' => 'Disetujui',
                                        'class' => 'bg-green-100 text-green-800',
                                    ],
                                    'ditolak' => ['label' => 'Ditolak', 'class' => 'bg-red-100 text-red-800'],
                                ];
                                $config = $statusMap[$spd->status] ?? [
                                    'label' => ucfirst($spd->status),
                                    'class' => 'bg-gray-100 text-gray-800',
                                ];
                                $badgeHtml =
                                    '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold ' .
                                    $config['class'] .
                                    '">' .
                                    $config['label'] .
                                    '</span>';

                                $aksiButtons =
                                    '<div class="flex items-center gap-2">
                                    <a href="' .
                                    route('user.spd.show', $spd->id) .
                                    '" class="inline-flex items-center bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white text-xs font-semibold px-2.5 py-1 rounded transition-colors duration-150 border border-blue-200/50" title="Detail">
                                        Detail
                                    </a>
                                    <a href="' .
                                    route('user.spd.edit', $spd->id) .
                                    '" class="inline-flex items-center bg-yellow-50 hover:bg-yellow-600 text-yellow-700 hover:text-white text-xs font-semibold px-2.5 py-1 rounded transition-colors duration-150 border border-yellow-200/50" title="Edit">
                                        Edit
                                    </a>
                                </div>';

                                $row = [
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
                                    $badgeHtml,
                                    $aksiButtons,
                                ];

                                return $row;
                            });
                        }
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
