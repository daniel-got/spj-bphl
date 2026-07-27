<x-layout.app title="Detail SPD — Admin">
    <div class="flex">

        <x-layout.sidebar />

        <main class="flex-1 p-6 bg-background min-h-screen">
            <x-layout.breadcrumb :items="[
                ['label' => 'Admin'],
                ['label' => 'Kelola SPD', 'url' => route('admin.kelola-spd.index')],
                ['label' => $spd->nomor_spd ?? 'Detail'],
            ]" />

            {{-- Header --}}
            <div class="flex items-center justify-between mt-4 mb-6">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.kelola-spd.index') }}"
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full border border-border-custom bg-surface text-text-main hover:bg-background transition duration-150 shadow-xs"
                        title="Kembali">
                        <x-utility.icon name="arrow-left" class="w-5 h-5" />
                    </a>
                    <div>
                        <h1 class="text-xl font-extrabold tracking-tight text-text-main">
                            Detail SPD — {{ $spd->nomor_spd ?? '-' }}
                        </h1>
                        <p class="text-xs text-muted mt-0.5">Tampilan Admin — Akses penuh tanpa batasan kepemilikan</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    @if ($spd->rincian)
                        <x-data.status-badge status="{{ $spd->rincian->status }}" />
                    @else
                        <x-data.badge label="Belum ada SPJ" color="gray" />
                    @endif

                    @if (!$spd->rincian || in_array($spd->rincian->status, ['draft', 'direvisi']))
                        <x-feedback.confirm-dialog
                            id="confirm-hapus-spd"
                            title="Hapus SPD?"
                            message="Data SPD dan rincian terkait yang dihapus tidak dapat dikembalikan."
                            confirm-label="Ya, Hapus"
                            cancel-label="Batal"
                            action="{{ route('admin.kelola-spd.destroy', $spd->id) }}"
                            method="DELETE"
                        />
                        <x-action.button
                            onclick="openModal('confirm-hapus-spd')"
                            class="bg-danger hover:bg-red-700 text-white px-3 py-1.5 text-xs font-semibold rounded-md flex items-center gap-1.5"
                        >
                            <x-utility.icon name="trash" class="w-4 h-4" />
                            Hapus SPD
                        </x-action.button>
                    @endif
                </div>
            </div>

            <div class="space-y-5 max-w-5xl">
                {{-- Informasi Dasar SPD --}}
                <x-layout.card title="Informasi SPD">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                        <div>
                            <p class="text-xs text-muted">Nomor SPD</p>
                            <p class="text-sm font-semibold text-text-main mt-0.5">{{ $spd->nomor_spd ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-muted">Tanggal SPD</p>
                            <p class="text-sm font-semibold text-text-main mt-0.5">{{ $spd->tgl_spd?->format('d F Y') ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-muted">Jenis Perjalanan</p>
                            <p class="text-sm font-semibold text-text-main mt-0.5">{{ ucwords(str_replace('_', ' ', $spd->jenis_perjalanan ?? '-')) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-muted">NIP Pegawai</p>
                            <p class="text-sm font-semibold text-text-main mt-0.5">{{ $spd->nip_pegawai ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-muted">Nama Pegawai</p>
                            <p class="text-sm font-semibold text-text-main mt-0.5">{{ $spd->pegawai_ditugaskan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-muted">Jabatan</p>
                            <p class="text-sm font-semibold text-text-main mt-0.5">{{ $spd->jabatan_pegawai ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-muted">Berangkat Dari</p>
                            <p class="text-sm font-semibold text-text-main mt-0.5">{{ $spd->berangkat_dari ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-muted">Tujuan Kegiatan</p>
                            <p class="text-sm font-semibold text-text-main mt-0.5">{{ $spd->tujuan_kegiatan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-muted">Dibuat Oleh</p>
                            <p class="text-sm font-semibold text-text-main mt-0.5">{{ $spd->pembuat?->name ?? '-' }}</p>
                        </div>
                    </div>
                </x-layout.card>

                {{-- Informasi SPT Terkait --}}
                @if ($spd->spt)
                    <x-layout.card title="SPT Terkait">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-6">
                            <div>
                                <p class="text-xs text-muted">Nomor SPT</p>
                                <p class="text-sm font-semibold text-text-main mt-0.5">{{ $spd->spt->nomor_spt }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-muted">Tgl. Berangkat — Kembali</p>
                                <p class="text-sm font-semibold text-text-main mt-0.5">
                                    {{ $spd->spt->tgl_berangkat?->format('d M Y') }} — {{ $spd->spt->tgl_kembali?->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                    </x-layout.card>
                @endif

                {{-- Rincian SPJ --}}
                @if ($spd->rincian)
                    <x-layout.card title="Rincian SPJ Terkait">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-6">
                            <div>
                                <p class="text-xs text-muted">Status SPJ</p>
                                <div class="mt-1">
                                    <x-data.status-badge status="{{ $spd->rincian->status }}" />
                                </div>
                            </div>
                            <div>
                                <p class="text-xs text-muted">Total Biaya Transport</p>
                                <p class="text-sm font-semibold text-text-main mt-0.5">
                                    Rp {{ number_format($spd->rincian->biaya_transport, 0, ',', '.') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-muted">Aksi Rincian</p>
                                <a href="{{ route('admin.kelola-rincian.show', $spd->rincian->id) }}"
                                    class="mt-1 inline-flex items-center gap-1.5 text-xs text-primary hover:underline font-medium">
                                    <x-utility.icon name="eye" class="w-4 h-4" />
                                    Lihat Detail Rincian
                                </a>
                            </div>
                        </div>
                    </x-layout.card>
                @else
                    <x-data.empty-state
                        title="Belum ada Rincian SPJ"
                        description="SPD ini belum memiliki data rincian biaya perjalanan dinas."
                    />
                @endif
            </div>
        </main>
    </div>
</x-layout.app>
