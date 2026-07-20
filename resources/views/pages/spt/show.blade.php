<x-layout.app title="Detail spt - SPJ BPHL 4">


    <main class="grow flex flex-col px-6 py-10">

        <div class="max-w-5xl mx-auto w-full">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('user.spt.index') }}"
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full border border-border-custom bg-surface text-text-main hover:bg-background transition duration-150 shadow-xs"
                        title="Kembali">
                        <x-utility.icon name="arrow-left" class="w-5 h-5" />
                    </a>
                    <div>
                        <h1 class="text-2xl font-extrabold tracking-tight text-text-main">
                            Detail SPT
                        </h1>
                        @php
                            $isPembuatAsli = auth()->id() === (int) $spt->pembuat_id;
                            $isAdmin = auth()->user()->isAdmin();
                            $isPembuat = $isPembuatAsli || $isAdmin;
                            $isEditable = in_array($spt->status, [\App\Models\Spt::STATUS_DRAFT, \App\Models\Spt::STATUS_REVISED]);
                        @endphp
                        @if($isPembuatAsli)
                            <p class="text-xs text-primary mt-0.5 font-medium">Anda adalah pembuat SPT ini</p>
                        @elseif($isAdmin)
                            <p class="text-xs text-primary mt-0.5 font-medium">Anda login sebagai Admin (Hak Akses Penuh)</p>
                        @else
                            <p class="text-xs text-muted mt-0.5">SPT yang ditugaskan kepada Anda</p>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('user.spt.generatePdf', $spt->id) }}" target="_blank"
                        class="inline-flex items-center gap-1.5 border border-border-custom bg-surface hover:bg-background text-text-main text-xs font-semibold px-4 py-2 rounded-lg shadow-sm transition-colors duration-150">
                        <x-utility.icon name="printer" class="w-4 h-4 text-muted" />
                        Print SPT
                    </a>
                    <x-data.status-badge status="{{ $spt->status ?? 'draft' }}" class="text-xs px-3 py-1" />
                </div>
            </div>

            <div class="space-y-6">

                {{-- Status & Validasi Card --}}
                <x-layout.card title="Status & Validasi Pertanggungjawaban">
                    <div class="overflow-x-auto mt-4">
                        @php
                            $statusBadge = '<x-data.status-badge status="' . ($spt->status ?? 'draft') . '" />';

                            $keterangan = '';
                            if ($spt->status === 'disetujui') {
                                $keterangan = '<span class="text-xs text-muted italic">Tidak membutuhkan catatan alasan tambahan (Disetujui penuh oleh PPK).</span>';
                            } elseif (in_array($spt->status, ['direvisi', 'ditolak']) && !empty($spt->alasan)) {
                                $keterangan = '<span class="font-bold text-xs text-text-main bg-background border border-border-custom px-3 py-2 rounded-lg block max-w-2xl leading-relaxed">' . e($spt->alasan) . '</span>';
                            } else {
                                $keterangan = '<span class="text-xs text-muted italic">Belum ada rincian catatan status.</span>';
                            }

                            $headersStatus = ['Status SPT', 'Detail Alasan / Keterangan'];
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

                            <div class="mt-3">
                                @php
                                    $headersPegawai = ['Nama Pegawai', 'Peran SPT', 'NIP', 'Pangkat / Golongan', 'Jabatan'];
                                    
                                    $rowsPegawai = array_map(function($pegawai) {
                                        $peranClass = ($pegawai['peran'] ?? 'Anggota') === 'Penanggung Jawab' 
                                            ? 'bg-amber-100 text-amber-700' 
                                            : 'bg-slate-100 text-slate-600';
                                            
                                        $peranBadge = '<span class="px-2 py-0.5 rounded text-[10px] font-semibold ' . $peranClass . '">' . e($pegawai['peran'] ?? 'Anggota') . '</span>';
                                        
                                        return [
                                            'cells' => [
                                                '<span class="font-bold text-text-main">' . e($pegawai['nama_pegawai'] ?? '-') . '</span>',
                                                $peranBadge,
                                                '<span class="font-medium text-text-main">' . e($pegawai['nip'] ?? '-') . '</span>',
                                                '<span class="font-medium text-text-main">' . e($pegawai['pangkat'] ?? '-') . '</span>',
                                                '<span class="font-medium text-text-main">' . e($pegawai['jabatan'] ?? '-') . '</span>'
                                            ]
                                        ];
                                    }, $pegawaiList);
                                @endphp
                                
                                @if(empty($rowsPegawai))
                                    <p class="text-sm text-muted italic">Belum ada pegawai yang ditugaskan.</p>
                                @else
                                    <x-data.table :headers="$headersPegawai" :rows="$rowsPegawai" :striped="false" />
                                @endif
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

                {{-- Tombol Aksi Operasional — hanya untuk Pembuat & Admin, selama status masih dapat diubah --}}
                @if($isPembuat && $isEditable)
                    <x-layout.card>
                        {{-- Konfirmasi Hapus --}}
                        <x-feedback.confirm-dialog
                            id="confirm-hapus-spt-{{ $spt->id }}"
                            title="Hapus SPT?"
                            message="Data SPT yang dihapus tidak dapat dikembalikan."
                            confirm-label="Ya, Hapus"
                            cancel-label="Batal"
                            action="{{ route('user.spt.destroy', $spt->id) }}"
                            method="DELETE"
                        />
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-bold text-text-main">Aksi Operasional</p>
                                <p class="text-xs text-muted mt-0.5">Pilih tindakan untuk SPT ini sebelum diajukan ke verifikator.</p>
                            </div>
                            <div class="flex items-center gap-2 flex-wrap">
                                {{-- Hapus --}}
                                <x-action.button
                                    onclick="openModal('confirm-hapus-spt-{{ $spt->id }}')"
                                    class="text-danger border-danger hover:bg-danger/10 px-4 py-2 text-xs font-semibold">
                                    <x-utility.icon name="trash" class="w-4 h-4" />
                                    Hapus SPT
                                </x-action.button>

                                {{-- Edit --}}
                                <a href="{{ route('user.spt.edit', $spt->id) }}"
                                    class="inline-flex items-center gap-1.5 border border-primary text-primary hover:bg-primary-light text-xs font-semibold px-4 py-2 rounded-lg transition-colors duration-150">
                                    <x-utility.icon name="pencil" class="w-4 h-4" />
                                    Edit SPT
                                </a>

                                {{-- Ajukan --}}
                                <form action="{{ route('user.spt.submit', $spt->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <x-action.button-primary
                                        type="submit"
                                        onclick="return confirm('Yakin ingin mengajukan SPT ini ke verifikator?')">
                                        <x-utility.icon name="paper-airplane" class="w-4 h-4" />
                                        Ajukan SPT
                                    </x-action.button-primary>
                                </form>
                            </div>
                        </div>
                    </x-layout.card>
                @endif

            </div>

        </div>

    </main>

</x-layout.app>