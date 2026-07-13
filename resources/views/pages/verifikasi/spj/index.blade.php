<x-layout.app title="Verifikasi SPJ - SPJ BPHL 4">

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
                    <x-layout.page-header title="Verifikasi Dokumen SPJ" subtitle="Daftar Bundel Surat Pertanggungjawaban (SPJ) yang Perlu Diverifikasi">
                    </x-layout.page-header>

                    {{-- Tabel Riwayat SPJ --}}
                    <div class="mb-8">
                        @php
                            $isStatusDetailView = in_array(request('status'), ['disetujui', 'ditolak', 'direvisi']);
                        @endphp

                        <x-layout.card>
                            <x-slot:header>
                                <h3 class="text-lg font-semibold text-text-main">
                                    Daftar SPJ 
                                    @if(request('status'))
                                        - Status: {{ ucfirst(request('status')) }}
                                    @else
                                        - Menunggu Verifikasi
                                    @endif
                                </h3>
                            </x-slot:header>

                            {{-- Filter & Pencarian --}}
                            <div class="mb-6 mt-2 border-b border-border-custom pb-6">
                                <form method="GET" action="{{ route('verifikasi.spj.index') }}">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                                        <div class="flex flex-col gap-1">
                                            <label for="search" class="text-sm font-medium text-text-main">Pencarian</label>
                                            <x-form.search name="search" placeholder="Cari nomor SPD, NIP..." :value="request('search')" />
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <x-form.select name="status" label="Status Dokumen" :options="[
                                                'diajukan' => 'Menunggu Verifikasi (Diajukan)',
                                                'disetujui' => 'Telah Disetujui',
                                                'direvisi' => 'Direvisi (Dikembalikan)',
                                                'ditolak' => 'Ditolak'
                                            ]" :selected="request('status', 'diajukan')" onchange="this.form.submit()" />
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <x-form.select name="per_page" label="Tampilkan" :options="[
                                                '10' => '10 Data',
                                                '25' => '25 Data',
                                                '50' => '50 Data',
                                            ]" :selected="request('per_page', 10)" onchange="this.form.submit()" />
                                        </div>
                                        <div class="flex gap-2">
                                            <x-action.button-primary type="submit" class="w-full justify-center text-center h-[38px]">
                                                Filter
                                            </x-action.button-primary>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- Pengaturan Header dan Isi Baris Tabel Berdasarkan Struktur Data Rincian --}}
                            @php
                                $headers = [
                                    'No', 'Nomor SPD', 'Pegawai Ditugaskan', 'Tujuan Kegiatan', 
                                    'Total Biaya Transport', 'Total Penginapan', 'Status', 'Aksi'
                                ];

                                $iteration = 1;

                                $rincianItems = ($rincians ?? null) && method_exists($rincians, 'items') ? $rincians->items() : ($rincians ?? []);

                                $rows = collect($rincianItems)->map(function ($r) use (&$iteration) {
                                    if (!is_object($r)) {
                                        return null;
                                    }

                                    // Hitung total dari JSON rincian_biaya
                                    $rincianBiaya = $r->rincian_biaya ?? [];
                                    $totalTransport = 0;
                                    $totalPenginapan = 0;
                                    foreach ($rincianBiaya as $item) {
                                        $totalTransport += (int) ($item['biaya_transport'] ?? 0);
                                        $totalPenginapan += (int) ($item['hotel_ril'] ?? 0);
                                    }

                                    $nomorSpdLink = '<a href="' . route('verifikasi.spj.show', $r->id) . '" class="text-primary hover:underline font-semibold" title="Lihat Rincian SPJ">' . e($r->nomor_spd ?? '') . '</a>';

                                    $actions = [
                                        'detail' => route('verifikasi.spj.show', $r->id),
                                    ];

                                    $statusBadge = \Illuminate\Support\Facades\Blade::render('<x-data.status-badge status="' . $r->status . '" />');

                                    return [
                                        'cells' => [
                                            $iteration++,
                                            $nomorSpdLink,
                                            '<div class="font-medium text-text-main">' . e($r->pegawai_ditugaskan ?? '-') . '</div><div class="text-xs text-muted">' . e($r->nip_pegawai ?? '-') . '</div>',
                                            '<div class="max-w-[200px] whitespace-normal line-clamp-2" title="' . e($r->tujuan_kegiatan ?? '') . '">' . e($r->tujuan_kegiatan ?? '') . '</div>',
                                            'Rp ' . number_format($totalTransport, 0, ',', '.'),
                                            'Rp ' . number_format($totalPenginapan, 0, ',', '.'),
                                            $statusBadge,
                                        ],
                                        'actions' => $actions
                                    ];
                                })->filter()->toArray();
                            @endphp

                            <x-data.table :headers="$headers" :rows="$rows" :striped="true" />

                            <div class="mt-4 flex justify-between items-center text-xs text-muted">
                                <span>Menampilkan {{ count($rows) }} entri SPJ.</span>
                                
                                @if(method_exists($rincians, 'links'))
                                    {{ $rincians->withQueryString()->links() }}
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
