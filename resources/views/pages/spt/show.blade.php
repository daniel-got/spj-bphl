<x-layout.app title="Detail spt - SPJ BPHL 4">


    <main class="grow flex flex-col px-6 py-10">

        <div class="max-w-5xl mx-auto w-full">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('user.spt.index') }}"
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full border border-border-custom bg-surface text-text-main hover:bg-background transition duration-150 shadow-xs"
                        title="Kembali">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-extrabold tracking-tight text-text-main">
                            Detail spt
                        </h1>
                        <p class="text-xs text-muted mt-0.5">Detail parameter dan status surat perjalanan dinas secara rinci</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('user.spt.edit', $spt->id) }}"
                        class="inline-flex items-center justify-center bg-primary hover:bg-primary-hover text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors duration-150">
                        Edit SPT
                    </a>
                    <x-data.status-badge status="{{ $spt->status ?? 'draft' }}" class="text-xs px-3 py-1" />
                </div>
            </div>

            <div class="space-y-6">

                {{-- Status & Validasi Card --}}
                <x-layout.card title="Status & Validasi Pertanggungjawaban">
                    <div class="overflow-x-auto mt-4">
                        <table class="min-w-full divide-y divide-border-custom text-sm">
                            <thead class="bg-background text-muted uppercase text-[10px] font-bold tracking-wider">
                                <tr>
                                    <th class="px-4 py-3 text-left w-1/4">Status spt</th>
                                    <th class="px-4 py-3 text-left">Detail Alasan / Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-custom bg-surface">
                                <tr>
                                    <td class="px-4 py-4">
                                        <x-data.status-badge status="{{ $spt->status ?? 'draft' }}" />
                                    </td>
                                    <td class="px-4 py-4 text-text-main">
                                        @if($spt->status === 'disetujui')
                                            <span class="text-xs text-muted italic">Tidak membutuhkan catatan alasan tambahan (Disetujui penuh oleh PPK).</span>
                                        @elseif(in_array($spt->status, ['direvisi', 'ditolak']) && !empty($spt->alasan))
                                            <span class="font-bold text-xs text-text-main bg-background border border-border-custom px-3 py-2 rounded-lg block max-w-2xl leading-relaxed">{{ $spt->alasan }}</span>
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
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Nomor spt</span>
                            <p class="text-sm font-bold text-text-main mt-1">{{ $spt->nomor_spt }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Tanggal spt</span>
                            <p class="text-sm font-medium text-text-main mt-1">
                                {{ $spt->tgl_spt instanceof \Carbon\Carbon ? $spt->tgl_spt->format('d F Y') : ($spt->tgl_spt ? \Carbon\Carbon::parse($spt->tgl_spt)->format('d F Y') : '-') }}
                            </p>
                        </div>

                        {{-- Daftar Pegawai yang Ditugaskan: decode dari kolom JSON pegawai_ditugaskan.
                             Kolom ini berisi ARRAY berisi 1 atau lebih pegawai, masing-masing punya
                             key nama_pegawai, nip, pangkat, jabatan. Ditampilkan sebagai kartu per
                             pegawai supaya rapi & mendukung banyak pegawai sekaligus. --}}
                        <div class="md:col-span-2 border-t border-border-custom pt-4">
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Pegawai yang Ditugaskan</span>

                            @php
                                $pegawaiData = $spt->pegawai_ditugaskan;
                                if (is_string($pegawaiData)) {
                                    $pegawaiData = json_decode($pegawaiData, true);
                                }
                                $pegawaiList = is_array($pegawaiData) ? $pegawaiData : [];
                            @endphp

                            <div class="mt-3 space-y-3">
                                @forelse($pegawaiList as $pegawai)
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-background border border-border-custom rounded-lg px-4 py-3">
                                        <div>
                                            <span class="text-[10px] font-semibold text-muted uppercase tracking-wider">Nama Pegawai</span>
                                            <p class="text-sm font-bold text-text-main mt-0.5">{{ $pegawai['nama_pegawai'] ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <span class="text-[10px] font-semibold text-muted uppercase tracking-wider">NIP</span>
                                            <p class="text-sm font-medium text-text-main mt-0.5">{{ $pegawai['nip'] ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <span class="text-[10px] font-semibold text-muted uppercase tracking-wider">Pangkat / Golongan</span>
                                            <p class="text-sm font-medium text-text-main mt-0.5">{{ $pegawai['pangkat'] ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <span class="text-[10px] font-semibold text-muted uppercase tracking-wider">Jabatan</span>
                                            <p class="text-sm font-medium text-text-main mt-0.5">{{ $pegawai['jabatan'] ?? '-' }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-muted italic">Belum ada pegawai yang ditugaskan.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </x-layout.card>

                {{-- Card 2: Perjalanan & Lokasi Tujuan --}}
                <x-layout.card title="Perjalanan & Lokasi Tujuan">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <div class="md:col-span-2">
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Maksud / Tujuan Kegiatan</span>
                            <p class="text-sm font-medium text-text-main mt-1 leading-relaxed">{{ $spt->tujuan_kegiatan }}</p>
                        </div>
                        <div class="md:col-span-2 border-t border-border-custom pt-4">
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Tempat Tujuan</span>
                            <div class="flex flex-wrap gap-2 mt-2">
                                @php
                                    $destinations = $spt->tempat_tujuan;
                                    if (is_array($destinations)) {
                                        $destinationList = $destinations;
                                    } else {
                                        $decoded = json_decode($destinations, true);
                                        $destinationList = is_array($decoded) ? $decoded : array_filter(array_map('trim', explode(',', $destinations)));
                                    }
                                @endphp
                                @forelse($destinationList as $dest)
                                    <span class="inline-flex items-center gap-1 bg-background border border-border-custom text-text-main text-xs font-medium px-3 py-1.5 rounded-lg shadow-2xs">
                                        <svg class="w-3.5 h-3.5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
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
                                <p class="text-sm font-medium text-text-main mt-1">{{ $spt->berangkat_dari ?? '-' }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-muted uppercase tracking-wider">Tanggal Berangkat</span>
                                <p class="text-sm font-medium text-text-main mt-1">
                                    {{ $spt->tgl_berangkat instanceof \Carbon\Carbon ? $spt->tgl_berangkat->format('d/m/Y') : ($spt->tgl_berangkat ? \Carbon\Carbon::parse($spt->tgl_berangkat)->format('d/m/Y') : '-') }}
                                </p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-muted uppercase tracking-wider">Tanggal Kembali</span>
                                <p class="text-sm font-medium text-text-main mt-1">
                                    {{ $spt->tgl_kembali instanceof \Carbon\Carbon ? $spt->tgl_kembali->format('d/m/Y') : ($spt->tgl_kembali ? \Carbon\Carbon::parse($spt->tgl_kembali)->format('d/m/Y') : '-') }}
                                </p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-muted uppercase tracking-wider">Waktu / Durasi</span>
                                <p class="text-sm font-bold text-text-main mt-1">{{ $spt->lama_kegiatan }} Hari</p>
                            </div>
                        </div>
                    </div>
                </x-layout.card>

                {{-- Card 3: Rincian Anggaran & Penandatangan --}}
                <x-layout.card title="Anggaran & Pejabat Pembuat Komitmen (PPK)">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                        <div>
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Kode MAK</span>
                            <p class="text-sm font-medium text-text-main mt-1">{{ $spt->kode_mak }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Jenis Perjalanan</span>
                            <p class="text-sm font-medium text-text-main mt-1">{{ $spt->jenis_perjalanan ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Alat Angkut</span>
                            <p class="text-sm font-medium text-text-main mt-1">{{ $spt->alat_angkut ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-3 border-t border-border-custom pt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <span class="text-xs font-semibold text-muted uppercase tracking-wider">Pejabat Pembuat</span>
                                <p class="text-sm font-medium text-text-main mt-1">{{ $spt->ppk ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </x-layout.card>

            </div>

        </div>

    </main>

</x-layout.app>