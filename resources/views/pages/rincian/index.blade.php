<x-layout.app title="Data Rincian Biaya - SPJ BPHL 4">
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
            <x-layout.page-header title="Data Rincian Biaya" subtitle="Daftar Rincian Biaya Perjalanan Dinas">
                <x-slot:actions>
                    <a href="{{ route('user.rincian.create') }}"
                        class="inline-flex items-center justify-center bg-primary hover:bg-primary-hover text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors duration-150 h-[38px]">
                        + Tambah Baru
                    </a>
                </x-slot:actions>
            </x-layout.page-header>

            {{-- Stats Section --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <x-dashboard.stat-card title="Total Rincian" value="{{ $counts['all'] ?? 0 }}" description="Total data semua Rincian"
                    icon="document-text" color="blue" href="{{ route('user.rincian.index') }}" />
                <x-dashboard.stat-card title="Disetujui" value="{{ $counts['disetujui'] ?? 0 }}"
                    description="Total Rincian disetujui" icon="check-circle" color="green"
                    href="{{ route('user.rincian.index', ['status' => 'disetujui']) }}" />
                <x-dashboard.stat-card title="Direvisi" value="{{ $counts['direvisi'] ?? 0 }}"
                    description="Total Rincian perlu direvisi" icon="exclamation-circle" color="yellow"
                    href="{{ route('user.rincian.index', ['status' => 'direvisi']) }}" />
                <x-dashboard.stat-card title="Ditolak" value="{{ $counts['ditolak'] ?? 0 }}" description="Total Rincian ditolak"
                    icon="x-circle" color="red" href="{{ route('user.rincian.index', ['status' => 'ditolak']) }}" />
            </div>

            {{-- Tabel Riwayat Rincian --}}
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
                                <span>Status Rincian :</span>
                                <span
                                    class="inline-flex items-center px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-lg border {{ $statusColorClass }} shadow-2xs">
                                    {{ request('status') }}
                                </span>
                            </h3>
                        </x-slot:header>
                    @else
                        @php
                            $titleString =
                                'Riwayat Rincian Biaya' . (request('status') ? ' - Status: ' . ucfirst(request('status')) : '');
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

                    {{-- Filter & Pencarian didalam Card Riwayat --}}
                    <div class="mb-6 mt-2 border-b border-border-custom pb-6">
                        <form method="GET" action="{{ route('user.rincian.index') }}">
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

                            $rows = collect(isset($rincians) ? $rincians->items() : [])->map(function ($rincian, $index) use ($rincians) {
                                $tglDiajukan = $rincian->created_at ? $rincian->created_at->format('d/m/Y') : '-';
                                $tglDiperiksa = $rincian->updated_at ? $rincian->updated_at->format('d/m/Y') : '-';
                                $catatan = $rincian->status === 'disetujui'
                                    ? '<span class="text-xs text-muted italic">Tidak butuh alasan</span>'
                                    : e($rincian->catatan_verifikator ?? '-');
                                $verifikator = e($rincian->nama_ppk ?? ($rincian->ppk ?? '-'));

                                $nomorSpdLink = '<a href="' . route('user.rincian.show', $rincian->id) . '" class="text-primary hover:underline font-semibold" title="Lihat Rincian">' . e($rincian->nomor_spd ?? '') . '</a>';

                                $aksiButtons = '
                                <div class="flex items-center gap-2">
                                    <a href="' . route('user.rincian.print', $rincian->id) . '" target="_blank" class="inline-flex items-center justify-center bg-gray-50 hover:bg-gray-200 text-gray-700 text-xs font-semibold p-1.5 rounded transition-colors duration-150 border border-gray-200/50" title="Cetak"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg></a>
                                    <a href="' . route('user.rincian.show', $rincian->id) . '" class="inline-flex items-center bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white text-xs font-semibold px-2.5 py-1 rounded transition-colors duration-150 border border-blue-200/50" title="Detail">Detail</a>
                                    <a href="' . route('user.rincian.edit', $rincian->id) . '" class="inline-flex items-center bg-yellow-50 hover:bg-yellow-600 text-yellow-700 hover:text-white text-xs font-semibold px-2.5 py-1 rounded transition-colors duration-150 border border-yellow-200/50" title="Edit">Edit</a>
                                </div>';

                                return [
                                    ($rincians->firstItem() ?? 1) + $index,
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
                                'Nama Pegawai',
                                'NIP',
                                'Tujuan Kegiatan',
                                'Tempat Tujuan',
                                'Waktu (Hari)',
                                'Jenis Perjalanan',
                                'Biaya Transport',
                                'Hotel Ril',
                                'Status',
                                'Aksi',
                            ];

                            $rows = collect(isset($rincians) ? $rincians->items() : [])->map(function ($rincian, $index) use ($rincians) {
                                $nomorSpdLink = '<a href="' . route('user.rincian.show', $rincian->id) . '" class="text-primary hover:underline font-semibold" title="Lihat Rincian">' . e($rincian->nomor_spd ?? '') . '</a>';

                                $statusMap = [
                                    'draft' => ['label' => 'Draft', 'class' => 'bg-gray-100 text-gray-800'],
                                    'diajukan' => ['label' => 'Diajukan', 'class' => 'bg-blue-100 text-blue-800'],
                                    'direvisi' => ['label' => 'Direvisi', 'class' => 'bg-orange-100 text-orange-800'],
                                    'disetujui' => ['label' => 'Disetujui', 'class' => 'bg-green-100 text-green-800'],
                                    'ditolak' => ['label' => 'Ditolak', 'class' => 'bg-red-100 text-red-800'],
                                ];
                                $config = $statusMap[$rincian->status] ?? ['label' => ucfirst($rincian->status ?? 'Unknown'), 'class' => 'bg-gray-100 text-gray-800'];
                                $badgeHtml = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold ' . $config['class'] . '">' . $config['label'] . '</span>';

                                $aksiButtons = '
                                <div class="flex items-center gap-2">
                                    <a href="' . route('user.rincian.print', $rincian->id) . '" target="_blank" class="inline-flex items-center justify-center bg-gray-50 hover:bg-gray-200 text-gray-700 text-xs font-semibold p-1.5 rounded transition-colors duration-150 border border-gray-200/50" title="Cetak"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg></a>
                                    <a href="' . route('user.rincian.show', $rincian->id) . '" class="inline-flex items-center bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white text-xs font-semibold px-2.5 py-1 rounded transition-colors duration-150 border border-blue-200/50" title="Detail">Detail</a>
                                    <a href="' . route('user.rincian.edit', $rincian->id) . '" class="inline-flex items-center bg-yellow-50 hover:bg-yellow-600 text-yellow-700 hover:text-white text-xs font-semibold px-2.5 py-1 rounded transition-colors duration-150 border border-yellow-200/50" title="Edit">Edit</a>
                                </div>';

                                return [
                                    ($rincians->firstItem() ?? 1) + $index,
                                    $nomorSpdLink,
                                    e($rincian->pegawai_ditugaskan ?? ''),
                                    e($rincian->nip_pegawai ?? ''),
                                    '<div class="max-w-xs whitespace-normal line-clamp-2" title="' . e($rincian->tujuan_kegiatan ?? '') . '">' . e($rincian->tujuan_kegiatan ?? '') . '</div>',
                                    '<div class="max-w-xs whitespace-normal line-clamp-2">' . e($rincian->tempat_tujuan ?? '') . '</div>',
                                    e($rincian->lama_kegiatan ?? '') . ' Hari',
                                    e($rincian->jenis_perjalanan ?? ''),
                                    'Rp ' . number_format($rincian->biaya_transport ?? 0, 0, ',', '.'),
                                    'Rp ' . number_format($rincian->hotel_ril ?? 0, 0, ',', '.'),
                                    $badgeHtml,
                                    $aksiButtons,
                                ];
                            });
                        }
                    @endphp

                    <x-data.table :headers="$headers" :rows="$rows" :striped="true" />

                    @if (isset($rincians) && $rincians->hasPages())
                        <div class="mt-4">
                            {{ $rincians->withQueryString()->links('components.navigation.pagination') }}
                        </div>
                    @elseif (isset($rincians))
                        <div class="mt-4 text-xs text-muted">
                            <span>Menampilkan {{ $rincians->count() }} entri.</span>
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
