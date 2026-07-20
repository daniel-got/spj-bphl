<x-layout.app title="Detail Rincian Biaya - SPJ BPHL 4">

    <main class="grow flex flex-col px-6 py-10">

        <div class="max-w-5xl mx-auto w-full">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('user.rincian.index') }}"
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full border border-border-custom bg-surface text-text-main hover:bg-background transition duration-150 shadow-xs"
                        title="Kembali">
                        <x-utility.icon name="arrow-left" class="w-5 h-5" />
                    </a>
                    <div>
                        <h1 class="text-2xl font-extrabold tracking-tight text-text-main">
                            Detail Rincian Biaya
                        </h1>
                        <p class="text-xs text-muted mt-0.5">Detail informasi Rincian Biaya Perjalanan Dinas</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 flex-wrap">
                    <a href="{{ route('user.rincian.print', $rincian->id) }}" target="_blank"
                       class="inline-flex items-center gap-1.5 border border-border-custom bg-surface hover:bg-background text-text-main text-xs font-semibold px-4 py-2 rounded-lg shadow-sm transition-colors duration-150"
                       title="Cetak Rincian">
                        <x-utility.icon name="printer" class="w-4 h-4 text-muted" />
                        Cetak Rincian
                    </a>
                    @can('update', $rincian)
                        @if(in_array($rincian->status, [\App\Models\Rincian::STATUS_DRAFT, \App\Models\Rincian::STATUS_REVISED]))
                            <a href="{{ route('user.rincian.edit', $rincian->id) }}"
                                class="inline-flex items-center gap-1.5 border border-primary text-primary hover:bg-primary-light text-xs font-semibold px-4 py-2 rounded-lg transition-colors duration-150">
                                <x-utility.icon name="pencil" class="w-4 h-4" />
                                Edit SPJ
                            </a>
                            <form action="{{ route('user.rincian.submit', $rincian->id) }}" method="POST" class="inline-block">
                                @csrf
                                <x-action.button-primary type="submit" onclick="return confirm('Apakah Anda yakin ingin mengajukan SPJ ini untuk diverifikasi?')">
                                    <x-utility.icon name="paper-airplane" class="w-4 h-4" />
                                    Ajukan SPJ
                                </x-action.button-primary>
                            </form>
                            <x-feedback.confirm-dialog
                                id="confirm-hapus-{{ $rincian->id }}"
                                title="Hapus Rincian SPJ?"
                                message="Data Rincian SPJ yang dihapus tidak dapat dikembalikan."
                                confirm-label="Ya, Hapus"
                                cancel-label="Batal"
                                action="{{ route('user.rincian.destroy', $rincian->id) }}"
                                method="DELETE"
                            />
                            <x-action.button
                                onclick="openModal('confirm-hapus-{{ $rincian->id }}')"
                                class="text-danger border-danger hover:bg-danger/10 px-4 py-2 text-xs font-semibold"
                            >
                                <x-utility.icon name="trash" class="w-4 h-4" />
                                Hapus
                            </x-action.button>
                        @endif
                    @endcan
                    <x-data.status-badge status="{{ $rincian->status ?? 'draft' }}" class="text-xs px-3 py-1" />
                </div>
            </div>

            <div class="space-y-6">

                {{-- Status & Validasi Card --}}
                <x-layout.card title="Status & Validasi">
                    <div class="overflow-x-auto mt-4">
                        @php
                            $statusBadge = '<x-data.status-badge status="' . ($rincian->status ?? 'draft') . '" />';

                            $keterangan = '';
                            if ($rincian->status === 'disetujui') {
                                $keterangan = '<span class="text-xs text-muted italic">Tidak membutuhkan catatan alasan tambahan (Disetujui penuh oleh PPK).</span>';
                            } elseif (in_array($rincian->status, ['direvisi', 'ditolak']) && !empty($rincian->catatan_verifikator)) {
                                $keterangan = '<span class="font-bold text-xs text-text-main bg-background border border-border-custom px-3 py-2 rounded-lg block max-w-2xl leading-relaxed">' . e($rincian->catatan_verifikator) . '</span>';
                            } else {
                                $keterangan = '<span class="text-xs text-muted italic">Belum ada rincian catatan status.</span>';
                            }

                            $headersStatus = ['Status Rincian', 'Detail Alasan / Keterangan'];
                            $rowsStatus = [
                                [
                                    'cells' => [$statusBadge, $keterangan]
                                ]
                            ];
                        @endphp
                        <x-data.table :headers="$headersStatus" :rows="$rowsStatus" :striped="false" />
                    </div>
                </x-layout.card>

                {{-- Card 1: Informasi Dokumen & Pegawai --}}
                <x-layout.card title="Informasi Dokumen & Pegawai">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <div>
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Nomor SPD</span>
                            <p class="text-sm font-bold text-text-main mt-1">{{ $rincian->nomor_spd }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Tanggal SPD</span>
                            <p class="text-sm font-medium text-text-main mt-1">
                                {{ $rincian->tgl_spd instanceof \Carbon\Carbon ? $rincian->tgl_spd->format('d F Y') : ($rincian->tgl_spd ? \Carbon\Carbon::parse($rincian->tgl_spd)->format('d F Y') : '-') }}
                            </p>
                        </div>
                        <div class="md:col-span-2 border-t border-border-custom pt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-xs font-semibold text-muted uppercase tracking-wider">Nama Pegawai Ditugaskan</span>
                                <p class="text-sm font-bold text-text-main mt-1">{{ $rincian->pegawai_ditugaskan }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-muted uppercase tracking-wider">NIP Pegawai</span>
                                <p class="text-sm font-medium text-text-main mt-1">{{ $rincian->nip_pegawai }}</p>
                            </div>
                        </div>
                    </div>
                </x-layout.card>

                {{-- Card 2: Perjalanan & Lokasi Tujuan --}}
                <x-layout.card title="Perjalanan & Lokasi Tujuan">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <div class="md:col-span-2">
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Maksud / Tujuan Kegiatan</span>
                            <p class="text-sm font-medium text-text-main mt-1 leading-relaxed">{{ $rincian->tujuan_kegiatan }}</p>
                        </div>
                        <div class="md:col-span-2 border-t border-border-custom pt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-xs font-semibold text-muted uppercase tracking-wider">Berangkat Dari</span>
                                <p class="text-sm font-medium text-text-main mt-1">{{ $rincian->berangkat_dari }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-muted uppercase tracking-wider">Tempat Tujuan</span>
                                <p class="text-sm font-medium text-text-main mt-1">{{ $rincian->tempat_tujuan }}</p>
                            </div>
                        </div>
                    </div>
                </x-layout.card>

                {{-- Card 3: Rincian Biaya Dinamis --}}
                <x-layout.card title="Detail Rincian Biaya">
                    @php
                        $rincianBiaya = $rincian->rincian_biaya ?? [];
                    @endphp
                    @if (!empty($rincianBiaya))
                        <div class="overflow-x-auto mt-4">
                            @php
                                $headersBiaya = [
                                    '#', 
                                    'Biaya Transport', 
                                    'Penginapan (%)', 
                                    ['label' => 'Biaya Hotel / Penginapan', 'class' => 'text-right']
                                ];
                                
                                $rowsBiaya = [];
                                foreach ($rincianBiaya as $i => $baris) {
                                    $rowsBiaya[] = [
                                        'cells' => [
                                            '<span class="text-muted font-medium">' . ($i + 1) . '</span>',
                                            'Rp ' . number_format($baris['biaya_transport'] ?? 0, 0, ',', '.'),
                                            ($baris['penginapan'] ?? '-') . '%',
                                            '<div class="text-right">Rp ' . number_format($baris['hotel_ril'] ?? 0, 0, ',', '.') . '</div>'
                                        ]
                                    ];
                                }
                            @endphp
                            
                            <x-data.table :headers="$headersBiaya" :rows="$rowsBiaya" :striped="false" />
                        </div>
                    @else
                        <p class="text-sm text-muted mt-4 italic">Belum ada data rincian biaya.</p>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6 border-t border-border-custom pt-4">
                        <div>
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Kode MAK</span>
                            <p class="text-sm font-medium text-text-main mt-1">{{ $rincian->kode_mak }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Pejabat Pembuat</span>
                            <p class="text-sm font-medium text-text-main mt-1">{{ $rincian->ppk ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Nama PPK</span>
                            <p class="text-sm font-medium text-text-main mt-1">{{ $rincian->nama_ppk ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">NIP PPK</span>
                            <p class="text-sm font-medium text-text-main mt-1">{{ $rincian->nip_ppk ?? '-' }}</p>
                        </div>
                    </div>
                </x-layout.card>

            </div>

        </div>

    </main>

    <x-layout.footer />

</x-layout.app>
