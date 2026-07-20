<x-layout.app title="Verifikasi Dokumen SPT - SPJ BPHL 4">

    <div class="flex flex-1 w-full">
        <x-layout.sidebar />

        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <main class="grow flex flex-col px-6 py-10">
        <div class="max-w-5xl mx-auto w-full">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('verifikasi.spt.index') }}"
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full border border-border-custom bg-surface text-text-main hover:bg-background transition duration-150 shadow-xs"
                        title="Kembali">
                        <x-utility.icon name="arrow-left" class="w-5 h-5" />
                    </a>
                    <div>
                        <h1 class="text-2xl font-extrabold tracking-tight text-text-main">
                            Verifikasi SPT
                        </h1>
                        <p class="text-xs text-muted mt-0.5">Periksa rincian sebelum menyetujui Dokumen SPT</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <x-data.status-badge status="{{ $spt->status ?? 'diajukan' }}" class="text-xs px-3 py-1" />
                </div>
            </div>

            <div class="space-y-6">

                {{-- Status Card --}}
                <x-layout.card title="Status Pengajuan Dokumen">
                    <div class="mt-4 flex flex-col md:flex-row md:items-center gap-4">
                        <div class="flex-shrink-0">
                            <x-data.status-badge status="{{ $spt->status ?? 'diajukan' }}" />
                        </div>
                        <div class="flex-1">
                            @if($spt->status === 'disetujui')
                                <p class="text-sm font-medium text-green-700 bg-green-50 p-3 rounded-lg border border-green-200">
                                    SPT ini telah Anda setujui dan sudah diteruskan kepada staf yang bertugas.
                                </p>
                            @elseif($spt->status === 'diajukan')
                                <p class="text-sm text-text-main bg-blue-50 p-3 rounded-lg border border-blue-200">
                                    Dokumen diajukan oleh Staf PPK. Harap periksa rincian di bawah sebelum mengambil tindakan.
                                </p>
                            @elseif(in_array($spt->status, ['direvisi', 'ditolak']))
                                <div class="text-sm text-yellow-800 bg-yellow-50 p-3 rounded-lg border border-yellow-200">
                                    <p class="font-semibold mb-1">Catatan Anda sebelumnya:</p>
                                    <p class="italic">{{ $spt->catatan_verifikator ?? 'Tidak ada catatan' }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </x-layout.card>

                {{-- Card 1: Informasi Dokumen & Pegawai (Reused from SPT Show) --}}
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
                                     <div class="grid grid-cols-1 md:grid-cols-5 gap-4 bg-background border border-border-custom rounded-lg px-4 py-3">
                                         <div>
                                             <span class="text-[10px] font-semibold text-muted uppercase tracking-wider">Nama Pegawai</span>
                                             <p class="text-sm font-bold text-text-main mt-0.5">{{ $pegawai['nama_pegawai'] ?? '-' }}</p>
                                         </div>
                                         <div>
                                             <span class="text-[10px] font-semibold text-muted uppercase tracking-wider">Peran SPT</span>
                                             <p class="text-sm font-bold text-primary mt-0.5">{{ $pegawai['peran'] ?? 'Anggota' }}</p>
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
                                        <x-utility.icon name="location-marker" class="w-3.5 h-3.5 text-muted" />
                                        {{ $dest }}
                                    </span>
                                @empty
                                    <span class="text-sm text-muted italic">-</span>
                                @endforelse
                            </div>
                        </div>
                        <div class="md:col-span-2 border-t border-border-custom pt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
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

                {{-- Card 3: Action Form untuk Verifikasi (Hanya Tampil Jika Status Masih Diajukan) --}}
                @if($spt->status === 'diajukan')
                    <x-layout.card title="Aksi Verifikasi SPT">
                        <p class="text-sm text-muted mt-2 mb-4">
                            Silakan pilih tindakan untuk dokumen ini. Berikan catatan jika Anda menolak atau mengembalikan (revisi) dokumen.
                        </p>

                        <x-form.verification-actions 
                            actionUrl="{{ route('verifikasi.spt.update-status', $spt->id) }}" 
                            currentStatus="{{ $spt->status }}"
                            catatan="{{ $spt->catatan_verifikator }}" 
                        />
                    </x-layout.card>
                @else
                    <x-layout.card title="Aksi Verifikasi SPT">
                        <p class="text-sm text-muted mt-2">
                            Dokumen ini sudah selesai diproses. Tidak ada tindakan lebih lanjut yang tersedia.
                        </p>
                    </x-layout.card>
                @endif

            </div>
        </div>
    </main>

            <x-layout.footer />
        </div>
    </div>

</x-layout.app>
