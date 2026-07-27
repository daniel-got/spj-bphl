<x-layout.app title="Detail Rincian SPJ — Admin">
    <div class="flex">

        <x-layout.sidebar />

        <main class="flex-1 p-6 bg-background min-h-screen">
            <x-layout.breadcrumb :items="[
                ['label' => 'Admin'],
                ['label' => 'Kelola Rincian SPJ', 'url' => route('admin.kelola-rincian.index')],
                ['label' => $rincian->nomor_spd ?? 'Detail'],
            ]" />

            {{-- Header --}}
            <div class="flex items-center justify-between mt-4 mb-6">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.kelola-rincian.index') }}"
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full border border-border-custom bg-surface text-text-main hover:bg-background transition duration-150 shadow-xs"
                        title="Kembali">
                        <x-utility.icon name="arrow-left" class="w-5 h-5" />
                    </a>
                    <div>
                        <h1 class="text-xl font-extrabold tracking-tight text-text-main">
                            Detail Rincian SPJ — {{ $rincian->nomor_spd ?? '-' }}
                        </h1>
                        <p class="text-xs text-muted mt-0.5">Tampilan Admin — Akses penuh</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <x-data.status-badge status="{{ $rincian->status }}" />

                    @if (in_array($rincian->status, ['draft', 'direvisi']))
                        <x-feedback.confirm-dialog
                            id="confirm-hapus-rincian"
                            title="Hapus Rincian SPJ?"
                            message="Data rincian yang dihapus tidak dapat dikembalikan."
                            confirm-label="Ya, Hapus"
                            cancel-label="Batal"
                            action="{{ route('admin.kelola-rincian.destroy', $rincian->id) }}"
                            method="DELETE"
                        />
                        <x-action.button
                            onclick="openModal('confirm-hapus-rincian')"
                            class="bg-danger hover:bg-red-700 text-white px-3 py-1.5 text-xs font-semibold rounded-md flex items-center gap-1.5"
                        >
                            <x-utility.icon name="trash" class="w-4 h-4" />
                            Hapus Rincian
                        </x-action.button>
                    @endif
                </div>
            </div>

            <div class="space-y-5 max-w-5xl">

                {{-- Info Ringkas Pegawai & SPD --}}
                <x-layout.card title="Informasi Pegawai & SPD">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                        <div>
                            <p class="text-xs text-muted">Nama Pegawai</p>
                            <p class="text-sm font-semibold text-text-main mt-0.5">{{ $rincian->pegawai_ditugaskan }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-muted">NIP</p>
                            <p class="text-sm font-semibold text-text-main mt-0.5">{{ $rincian->nip_pegawai }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-muted">Nomor SPD</p>
                            <p class="text-sm font-semibold text-text-main mt-0.5">{{ $rincian->nomor_spd }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-muted">Tujuan Kegiatan</p>
                            <p class="text-sm font-semibold text-text-main mt-0.5">{{ $rincian->tujuan_kegiatan }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-muted">Tempat Tujuan</p>
                            <p class="text-sm font-semibold text-text-main mt-0.5">{{ $rincian->tempat_tujuan }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-muted">Jenis Perjalanan</p>
                            <p class="text-sm font-semibold text-text-main mt-0.5">{{ ucwords(str_replace('_', ' ', $rincian->jenis_perjalanan)) }}</p>
                        </div>
                    </div>
                </x-layout.card>

                {{-- Rekap Biaya --}}
                <x-layout.card title="Rekap Biaya Perjalanan Dinas">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-6">
                        <div class="p-4 rounded-lg bg-primary-light border border-primary/20">
                            <p class="text-xs text-primary font-medium">Total Biaya Transportasi</p>
                            <p class="text-xl font-bold text-primary mt-1">
                                Rp {{ number_format($rincian->biaya_transport, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="p-4 rounded-lg bg-secondary-light border border-secondary/20">
                            <p class="text-xs text-secondary font-medium">Total Biaya Penginapan (Riil)</p>
                            <p class="text-xl font-bold text-secondary mt-1">
                                Rp {{ number_format($rincian->hotel_ril, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </x-layout.card>

                {{-- Catatan Verifikator --}}
                @if ($rincian->catatan_verifikator)
                    <x-feedback.alert type="{{ in_array($rincian->status, ['direvisi', 'ditolak']) ? 'warning' : 'info' }}" title="Catatan Verifikator">
                        {{ $rincian->catatan_verifikator }}
                    </x-feedback.alert>
                @endif

                {{-- Link ke SPD --}}
                @if ($rincian->spd)
                    <div class="flex justify-end">
                        <a href="{{ route('admin.kelola-spd.show', $rincian->spd->id) }}"
                            class="inline-flex items-center gap-1.5 text-xs text-primary hover:underline font-medium">
                            <x-utility.icon name="arrow-top-right-on-square" class="w-4 h-4" />
                            Lihat Detail SPD Terkait
                        </a>
                    </div>
                @endif

            </div>
        </main>
    </div>
</x-layout.app>
