<x-layout.app title="Detail SPD - SPJ BPHL 4">

    <main class="grow flex flex-col px-6 py-10">

        <div class="max-w-5xl mx-auto w-full">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('user.spd.index') }}"
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full border border-border-custom bg-surface text-text-main hover:bg-background transition duration-150 shadow-xs"
                        title="Kembali">
                        <x-utility.icon name="arrow-left" class="w-5 h-5" />
                    </a>
                    <div>
                        <h1 class="text-2xl font-extrabold tracking-tight text-text-main">
                            Detail SPD
                        </h1>
                        <p class="text-xs text-muted mt-0.5">Detail parameter dan status surat perjalanan dinas secara rinci</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 flex-wrap">
                    <a href="{{ route('user.spd.print', $spd->id) }}" target="_blank"
                        class="inline-flex items-center gap-1.5 border border-border-custom bg-surface hover:bg-background text-text-main text-xs font-semibold px-4 py-2 rounded-lg shadow-sm transition-colors duration-150" title="Cetak SPD">
                        <x-utility.icon name="printer" class="w-4 h-4 text-muted" />
                        Cetak SPD
                    </a>
                    @can('update', $spd)
                        @if(!$spd->rincian || in_array($spd->rincian->status, [\App\Models\Rincian::STATUS_DRAFT, \App\Models\Rincian::STATUS_REVISED]))
                            <a href="{{ route('user.spd.edit', $spd->id) }}"
                                class="inline-flex items-center gap-1.5 border border-primary text-primary hover:bg-primary-light text-xs font-semibold px-4 py-2 rounded-lg transition-colors duration-150">
                                <x-utility.icon name="pencil" class="w-4 h-4" />
                                Edit SPD
                            </a>
                            <x-feedback.confirm-dialog
                                id="confirm-hapus-{{ $spd->id }}"
                                title="Hapus SPD?"
                                message="Data SPD yang dihapus tidak dapat dikembalikan."
                                confirm-label="Ya, Hapus"
                                cancel-label="Batal"
                                action="{{ route('user.spd.destroy', $spd->id) }}"
                                method="DELETE"
                            />
                            <x-action.button
                                onclick="openModal('confirm-hapus-{{ $spd->id }}')"
                                class="text-danger border-danger hover:bg-danger/10 px-4 py-2 text-xs font-semibold"
                            >
                                <x-utility.icon name="trash" class="w-4 h-4" />
                                Hapus
                            </x-action.button>
                        @endif
                    @endcan
                    @if($spd->rincian)
                        <x-data.status-badge status="{{ $spd->rincian->status }}" class="text-xs px-3 py-1" />
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Menunggu Rincian</span>
                    @endif
                </div>
            </div>

            <div class="space-y-6">

                {{-- Status & Validasi Card --}}
                <x-layout.card title="Status & Validasi Pertanggungjawaban">
                    <div class="overflow-x-auto mt-4">
                        @php
                            $statusBadge = $spd->rincian 
                                ? '<x-data.status-badge status="' . $spd->rincian->status . '" />'
                                : '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Menunggu Rincian</span>';

                            $keterangan = '';
                            if ($spd->rincian && $spd->rincian->status === 'disetujui') {
                                $keterangan = '<span class="text-xs text-muted italic">Tidak membutuhkan catatan alasan tambahan (Disetujui penuh oleh Verifikator).</span>';
                            } elseif ($spd->rincian && in_array($spd->rincian->status, ['direvisi', 'ditolak']) && !empty($spd->rincian->catatan_verifikator)) {
                                $keterangan = '<span class="font-bold text-xs text-text-main bg-background border border-border-custom px-3 py-2 rounded-lg block max-w-2xl leading-relaxed">' . e($spd->rincian->catatan_verifikator) . '</span>';
                            } else {
                                $keterangan = '<span class="text-xs text-muted italic">Belum ada rincian catatan status.</span>';
                            }

                            $headers = ['Status Pertanggungjawaban', 'Detail Alasan / Keterangan'];
                            $rows = [
                                [
                                    'cells' => [$statusBadge, $keterangan]
                                ]
                            ];
                        @endphp
                        <x-data.table :headers="$headers" :rows="$rows" :striped="false" />
                    </div>
                </x-layout.card>

                {{-- Card 1: Informasi Dokumen & Pegawai --}}
                <x-layout.card title="Informasi Dokumen & Pegawai">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <div>
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Nomor SPD</span>
                            <p class="text-sm font-bold text-text-main mt-1">{{ $spd->nomor_spd }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Tanggal SPD</span>
                            <p class="text-sm font-medium text-text-main mt-1">
                                {{ $spd->tgl_spd instanceof \Carbon\Carbon ? $spd->tgl_spd->format('d F Y') : ($spd->tgl_spd ? \Carbon\Carbon::parse($spd->tgl_spd)->format('d F Y') : '-') }}
                            </p>
                        </div>
                        <div class="md:col-span-2 border-t border-border-custom pt-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <span class="text-xs font-semibold text-muted uppercase tracking-wider">Nama Pegawai</span>
                                <p class="text-sm font-bold text-text-main mt-1">{{ $spd->pegawai_ditugaskan }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-muted uppercase tracking-wider">NIP Pegawai</span>
                                <p class="text-sm font-medium text-text-main mt-1">{{ $spd->nip_pegawai }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-muted uppercase tracking-wider">Pangkat / Golongan</span>
                                <p class="text-sm font-medium text-text-main mt-1">{{ $spd->pangkat_pegawai ?? '-' }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-muted uppercase tracking-wider">Jabatan</span>
                                <p class="text-sm font-medium text-text-main mt-1">{{ $spd->jabatan_pegawai ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </x-layout.card>

                {{-- Card 2: Perjalanan & Lokasi Tujuan --}}
                <x-layout.card title="Perjalanan & Lokasi Tujuan">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <div class="md:col-span-2">
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Maksud / Tujuan Kegiatan</span>
                            <p class="text-sm font-medium text-text-main mt-1 leading-relaxed">{{ $spd->tujuan_kegiatan }}</p>
                        </div>
                        <div class="md:col-span-2 border-t border-border-custom pt-4">
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Tempat Tujuan</span>
                            <div class="flex flex-wrap gap-2 mt-2">
                                @php
                                    $destinations = $spd->tempat_tujuan;
                                    if (is_array($destinations)) {
                                        $destinationList = $destinations;
                                    } else {
                                        $decoded = json_decode($destinations, true);
                                        $destinationList = is_array($decoded) ? $decoded : array_filter(array_map('trim', explode(',', $destinations)));
                                    }
                                @endphp
                                @forelse($destinationList as $dest)
                                    <span class="inline-flex items-center gap-1 bg-background border border-border-custom text-text-main text-xs font-medium px-3 py-1.5 rounded-lg shadow-2xs">
                                        <x-utility.icon name="location-marker" class="w-3.5 h-3.5 text-muted" />
                                        {{ $dest }}
                                    </span>
                                @empty
                                    <span class="text-sm text-muted italic">-</span>
                                @endforelse
                            </div>
                        </div>
                        <div class="md:col-span-2 border-t border-border-custom pt-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <span class="text-xs font-semibold text-muted uppercase tracking-wider">Berangkat Dari</span>
                                <p class="text-sm font-medium text-text-main mt-1">{{ $spd->berangkat_dari }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-muted uppercase tracking-wider">Tanggal Berangkat</span>
                                <p class="text-sm font-medium text-text-main mt-1">
                                    {{ $spd->tgl_berangkat instanceof \Carbon\Carbon ? $spd->tgl_berangkat->format('d/m/Y') : ($spd->tgl_berangkat ? \Carbon\Carbon::parse($spd->tgl_berangkat)->format('d/m/Y') : '-') }}
                                </p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-muted uppercase tracking-wider">Tanggal Kembali</span>
                                <p class="text-sm font-medium text-text-main mt-1">
                                    {{ $spd->tgl_kembali instanceof \Carbon\Carbon ? $spd->tgl_kembali->format('d/m/Y') : ($spd->tgl_kembali ? \Carbon\Carbon::parse($spd->tgl_kembali)->format('d/m/Y') : '-') }}
                                </p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-muted uppercase tracking-wider">Waktu / Durasi</span>
                                <p class="text-sm font-bold text-text-main mt-1">{{ $spd->lama_kegiatan }} Hari</p>
                            </div>
                        </div>
                    </div>
                </x-layout.card>

                {{-- Card 3: Rincian Anggaran & Penandatangan --}}
                <x-layout.card title="Anggaran & Pejabat Pembuat Komitmen (PPK)">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                        <div>
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Kode MAK</span>
                            <p class="text-sm font-medium text-text-main mt-1">{{ $spd->kode_mak }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Jenis Perjalanan</span>
                            <p class="text-sm font-medium text-text-main mt-1">{{ $spd->jenis_perjalanan }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Alat Angkut</span>
                            @php
                                $vehicles = $spd->alat_angkut;
                                if (is_array($vehicles)) {
                                    $vehiclesText = implode(', ', $vehicles);
                                } else {
                                    $decoded = json_decode($vehicles, true);
                                    $vehiclesText = is_array($decoded) ? implode(', ', $decoded) : (string) $vehicles;
                                }
                            @endphp
                            <p class="text-sm font-medium text-text-main mt-1">{{ $vehiclesText ?: '-' }}</p>
                        </div>
                        <div class="md:col-span-3 border-t border-border-custom pt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <span class="text-xs font-semibold text-muted uppercase tracking-wider">Pejabat Pembuat</span>
                                <p class="text-sm font-medium text-text-main mt-1">{{ $spd->ppk ?? '-' }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-muted uppercase tracking-wider">Nama PPK</span>
                                <p class="text-sm font-bold text-text-main mt-1">{{ $spd->nama_ppk ?? '-' }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-muted uppercase tracking-wider">NIP PPK</span>
                                <p class="text-sm font-medium text-text-main mt-1">{{ $spd->nip_ppk ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </x-layout.card>

            </div>

        </div>

    </main>

    <x-layout.footer />

</x-layout.app>
