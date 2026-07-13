<x-layout.app title="Detail Rincian Biaya - SPJ BPHL 4">

    <x-layout.navbar />

    <main class="grow flex flex-col px-6 py-10">

        <div class="max-w-5xl mx-auto w-full">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('user.rincian.index') }}"
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full border border-border-custom bg-surface text-text-main hover:bg-background transition duration-150 shadow-xs"
                        title="Kembali">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-extrabold tracking-tight text-text-main">
                            Detail Rincian Biaya
                        </h1>
                        <p class="text-xs text-muted mt-0.5">Detail informasi Rincian Biaya Perjalanan Dinas</p>
                    </div>
                </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('user.rincian.print', $rincian->id) }}" target="_blank"
                       class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-150 shadow-sm"
                       title="Cetak Rincian">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Cetak Rincian
                    </a>
                    <x-data.status-badge status="{{ $rincian->status ?? 'draft' }}" class="text-xs px-3 py-1" />
                </div>
            </div>

            <div class="space-y-6">

                {{-- Status & Validasi Card --}}
                <x-layout.card title="Status & Validasi">
                    <div class="overflow-x-auto mt-4">
                        <table class="min-w-full divide-y divide-border-custom text-sm">
                            <thead class="bg-background text-muted uppercase text-[10px] font-bold tracking-wider">
                                <tr>
                                    <th class="px-4 py-3 text-left w-1/4">Status Rincian</th>
                                    <th class="px-4 py-3 text-left">Detail Alasan / Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-custom bg-surface">
                                <tr>
                                    <td class="px-4 py-4">
                                        <x-data.status-badge status="{{ $rincian->status ?? 'draft' }}" />
                                    </td>
                                    <td class="px-4 py-4 text-text-main">
                                        @if($rincian->status === 'disetujui')
                                            <span class="text-xs text-muted italic">Tidak membutuhkan catatan alasan tambahan (Disetujui penuh oleh PPK).</span>
                                        @elseif(in_array($rincian->status, ['direvisi', 'ditolak']) && !empty($rincian->catatan_verifikator))
                                            <span class="font-bold text-xs text-text-main bg-background border border-border-custom px-3 py-2 rounded-lg block max-w-2xl leading-relaxed">{{ $rincian->catatan_verifikator }}</span>
                                        @else
                                            <span class="text-xs text-muted italic">Belum ada rincian catatan status.</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                            <table class="min-w-full divide-y divide-border-custom text-sm">
                                <thead class="bg-background text-muted uppercase text-[10px] font-bold tracking-wider">
                                    <tr>
                                        <th class="px-4 py-3 text-left w-12">#</th>
                                        <th class="px-4 py-3 text-left">Biaya Transport</th>
                                        <th class="px-4 py-3 text-left">Penginapan (%)</th>
                                        <th class="px-4 py-3 text-right">Biaya Hotel / Penginapan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border-custom bg-surface">
                                    @foreach ($rincianBiaya as $i => $baris)
                                        <tr>
                                            <td class="px-4 py-3 text-muted font-medium">{{ $i + 1 }}</td>
                                            <td class="px-4 py-3 text-text-main">
                                                Rp {{ number_format($baris['biaya_transport'] ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-3 text-text-main">
                                                {{ $baris['penginapan'] ?? '-' }}%
                                            </td>
                                            <td class="px-4 py-3 text-text-main text-right">
                                                Rp {{ number_format($baris['hotel_ril'] ?? 0, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
