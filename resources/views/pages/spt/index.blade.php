<x-layout.app title="Data SPT - SPJ BPHL 4">

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
                    <x-layout.page-header title="Data SPT" subtitle="Daftar Surat Perintah Tugas">
                        @if (Auth::user()->role === 'admin')
                            <x-slot:actions>
                                <a href="{{ route('user.spt.create') }}"
                                    class="inline-flex items-center justify-center bg-primary hover:bg-primary-hover text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors duration-150 h-[38px]">
                                    + Tambah Baru
                                </a>
                            </x-slot:actions>
                        @endif
                    </x-layout.page-header>

                    {{-- Tabel Riwayat SPT --}}
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
                                        $statusColorClass = $statusTitleColors[request('status')] ?? 'bg-gray-50 text-text-main border-border-custom';
                                    @endphp
                                    <h3 class="text-lg font-semibold text-text-main flex items-center gap-2.5">
                                        <span>Status SPT :</span>
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-lg border {{ $statusColorClass }} shadow-2xs">
                                            {{ request('status') }}
                                        </span>
                                    </h3>
                                </x-slot:header>
                            @else
                                @php
                                    $titleString = 'Riwayat SPT' . (request('status') ? ' - Status: ' . ucfirst(request('status')) : '');
                                @endphp
                                <x-slot:header>
                                    <h3 class="text-lg font-semibold text-text-main">{{ $titleString }}</h3>
                                </x-slot:header>
                            @endif

                            {{-- Filter & Pencarian didalam Card Riwayat SPT --}}
                            <div class="mb-6 mt-2 border-b border-border-custom pb-6">
                                <form method="GET" action="{{ route('user.spt.index') }}">
                                    <input type="hidden" name="status" value="{{ request('status') }}">

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                                        <div class="flex flex-col gap-1">
                                            <label for="search" class="text-sm font-medium text-text-main">Pencarian</label>
                                            <x-form.search name="search" placeholder="Cari nomor SPT, nama pegawai..." :value="request('search')" />
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <x-form.select name="per_page" label="Tampilkan" :options="[
                                                '10' => '10 Data',
                                                '25' => '25 Data',
                                                '50' => '50 Data',
                                            ]" :selected="request('per_page', 10)" onchange="this.form.submit()" />
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="submit" class="bg-primary hover:bg-primary-hover text-white text-sm font-semibold px-5 py-2 rounded-md transition-colors duration-150 cursor-pointer border border-transparent w-full justify-center text-center h-[38px]">
                                                Filter
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- Pengaturan Header dan Isi Baris Tabel Berdasarkan Struktur Data SPT --}}
                            @php
                                $headers = [
                                    'No', 'Nomor SPT', 'Tgl SPT', 'Nama Pegawai', 'NIP', 'Pangkat/Golongan', 'Jabatan',
                                    'Tujuan Kegiatan', 'Tempat Tujuan', 'Tgl. Berangkat', 'Tgl. Kembali', 'Lama (Hari)', 'Kode MAK', 'Aksi'
                                ];

                                // Menggunakan index manual agar loop aman dari error tipe data swap
                                $iteration = 1;

                                // PENTING: $spts adalah objek Paginator, BUKAN array/collection biasa.
                                // Jika collect() dipanggil langsung ke Paginator, Laravel memanggil toArray()
                                // bawaan Paginator yang isinya metadata (current_page, total, data, dll),
                                // bukan daftar item SPT-nya langsung. Ini yang membuat tabel selalu kosong.
                                // Solusinya: ambil dulu isi datanya lewat ->items().
                                $sptItems = ($spts ?? null) && method_exists($spts, 'items') ? $spts->items() : ($spts ?? []);

                                $rows = collect($sptItems)->map(function ($spt) use (&$iteration) {
                                    // Antisipasi jika data yang dilempar bukan objek Model
                                    if (!is_object($spt)) {
                                        return null;
                                    }

                                    // Decode array / JSON Tempat Tujuan
                                    $destinations = $spt->tempat_tujuan;
                                    if (is_array($destinations)) {
                                        $destinationsText = implode(', ', $destinations);
                                    } else {
                                        $decoded = json_decode($destinations, true);
                                        $destinationsText = is_array($decoded) ? implode(', ', $decoded) : (string) $destinations;
                                    }
                                    $destinationsText = e($destinationsText);

                                    // Format Tanggal
                                    $tglSpt = $spt->tgl_spt ? \Carbon\Carbon::parse($spt->tgl_spt)->format('d/m/Y') : '-';
                                    $tglBerangkat = $spt->tgl_berangkat ? \Carbon\Carbon::parse($spt->tgl_berangkat)->format('d/m/Y') : '-';
                                    $tglKembali = $spt->tgl_kembali ? \Carbon\Carbon::parse($spt->tgl_kembali)->format('d/m/Y') : '-';

                                    // Menampilkan penanggung jawab saja sesuai permintaan issue
                                    $namaPegawai = $spt->penanggung_jawab ?? '-';
                                    $nipPegawai = '-';
                                    $pangkatPegawai = '-';
                                    $jabatanPegawai = '-';

                                    // Ambil detail penanggung jawab dari JSON jika ada untuk melengkapi NIP dll
                                    $pegawaiData = $spt->pegawai_ditugaskan;
                                    if (is_string($pegawaiData)) {
                                        $pegawaiData = json_decode($pegawaiData, true);
                                    }

                                    if (is_array($pegawaiData)) {
                                        foreach ($pegawaiData as $pegawai) {
                                            if (is_array($pegawai) && ($pegawai['peran'] ?? '') === 'Penanggung Jawab') {
                                                $nipPegawai = $pegawai['nip'] ?? '-';
                                                $pangkatPegawai = $pegawai['pangkat'] ?? '-';
                                                $jabatanPegawai = $pegawai['jabatan'] ?? '-';
                                                break;
                                            }
                                        }
                                    }

                                    // Link Detail pada Nomor SPT
                                    $nomorSptLink = '<a href="' . route('user.spt.show', $spt->id) . '" class="text-primary hover:underline font-semibold" title="Lihat Rincian">' . e($spt->nomor_spt ?? '') . '</a>';

                                    // Edit hanya untuk admin — pembuat_spt punya tombol Edit di dashboard-nya sendiri
                                    $hasAccess = Auth::user()->role === 'admin';
                                    $editLink = $hasAccess
                                        ? '<a href="' . route('user.spt.edit', $spt->id) . '" class="inline-flex items-center gap-1 text-xs font-semibold text-primary hover:text-primary-hover" title="Edit SPT">Edit</a>'
                                        : '<span class="text-muted text-xs">-</span>';

                                    return [
                                        $iteration++,
                                        $nomorSptLink,
                                        $tglSpt,
                                        e($namaPegawai),
                                        e($nipPegawai),
                                        e($pangkatPegawai),
                                        e($jabatanPegawai),
                                        '<div class="max-w-xs whitespace-normal line-clamp-2" title="' . e($spt->tujuan_kegiatan ?? '') . '">' . e($spt->tujuan_kegiatan ?? '') . '</div>',
                                        '<div class="max-w-xs whitespace-normal" title="' . $destinationsText . '">' . $destinationsText . '</div>',
                                        $tglBerangkat,
                                        $tglKembali,
                                        e($spt->lama_kegiatan ?? '') . ' Hari',
                                        e($spt->kode_mak ?? '-'),
                                        $editLink
                                    ];
                                })->filter()->toArray();
                            @endphp

                            {{-- Render Component Table --}}
                            <x-data.table :headers="$headers" :rows="$rows" :striped="true" />

                            {{-- Footer Keterangan Data --}}
                            <div class="mt-4 text-xs text-muted">
                                <span>Menampilkan {{ count($rows) }} entri SPT.</span>
                            </div>
                        </x-layout.card>
                    </div>

                </div>

            </main>

            <x-layout.footer />
        </div>
    </div>

</x-layout.app>
