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
                    
                    <a href="{{ route('user.rincian.printLampiran', $rincian->id) }}" target="_blank"
                       class="inline-flex items-center gap-1.5 border border-border-custom bg-surface hover:bg-background text-text-main text-xs font-semibold px-4 py-2 rounded-lg shadow-sm transition-colors duration-150"
                       title="Cetak Lampiran">
                        <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        Cetak Lampiran
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
                        $transportData = $rincianBiaya['transport'] ?? [];
                        $penginapanData = $rincianBiaya['penginapan'] ?? [];
                    @endphp
                    
                    <div class="mt-4 space-y-8">
                        {{-- Bagian Transportasi --}}
                        <div>
                            <h4 class="text-sm font-bold text-text-main mb-3 border-b border-border-custom pb-2">A. Biaya Transportasi</h4>
                            
                            @if (!empty($transportData))
                                @foreach ($transportData as $kategori => $items)
                                    <div class="mb-4">
                                        <h5 class="text-xs font-semibold text-text-main mb-2">Kategori: {{ $kategori }}</h5>
                                        <div class="overflow-x-auto">
                                            <table class="w-full text-sm text-left text-text-main border border-border-custom">
                                                <thead class="text-xs text-muted uppercase bg-surface">
                                                    <tr>
                                                        <th class="px-4 py-2 border-b border-border-custom w-10 text-center">#</th>
                                                        <th class="px-4 py-2 border-b border-border-custom">Lokasi Awal</th>
                                                        <th class="px-4 py-2 border-b border-border-custom">Lokasi Tujuan</th>
                                                        <th class="px-4 py-2 border-b border-border-custom text-right">Biaya (Rp)</th>
                                                        <th class="px-4 py-2 border-b border-border-custom text-center">Lampiran</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $totalTransport = 0; @endphp
                                                    @foreach ($items as $index => $item)
                                                        @php 
                                                            $biaya = $item['biaya'] ?? 0;
                                                            $totalTransport += $biaya;
                                                        @endphp
                                                        <tr class="bg-background border-b border-border-custom hover:bg-surface">
                                                            <td class="px-4 py-2 text-center">{{ $index + 1 }}</td>
                                                            <td class="px-4 py-2">{{ $item['lokasi_awal'] ?? '-' }}</td>
                                                            <td class="px-4 py-2">{{ $item['lokasi_tujuan'] ?? '-' }}</td>
                                                            <td class="px-4 py-2 text-right">Rp {{ number_format($biaya, 0, ',', '.') }}</td>
                                                            <td class="px-4 py-2 text-center">
                                                                @if (!empty($item['lampiran']))
                                                                    <button type="button" onclick="openLampiranModal('{{ Storage::url($item['lampiran']) }}')" class="text-xs text-primary hover:underline flex items-center justify-center gap-1 mx-auto">
                                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                                        Lihat
                                                                    </button>
                                                                @else
                                                                    <span class="text-xs text-muted">-</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr class="bg-surface font-semibold">
                                                        <td colspan="3" class="px-4 py-2 text-right">Total {{ $kategori }}:</td>
                                                        <td class="px-4 py-2 text-right">Rp {{ number_format($totalTransport, 0, ',', '.') }}</td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-sm text-muted italic">Tidak ada data biaya transportasi.</p>
                            @endif
                        </div>

                        {{-- Bagian Penginapan --}}
                        <div>
                            <h4 class="text-sm font-bold text-text-main mb-3 border-b border-border-custom pb-2">B. Biaya Hotel / Penginapan</h4>
                            
                            @if (!empty($penginapanData))
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm text-left text-text-main border border-border-custom">
                                        <thead class="text-xs text-muted uppercase bg-surface">
                                            <tr>
                                                <th class="px-4 py-2 border-b border-border-custom w-10 text-center">#</th>
                                                <th class="px-4 py-2 border-b border-border-custom">Keterangan</th>
                                                <th class="px-4 py-2 border-b border-border-custom text-center">Rate (%)</th>
                                                <th class="px-4 py-2 border-b border-border-custom text-right">Biaya (Rp)</th>
                                                <th class="px-4 py-2 border-b border-border-custom text-center">Lampiran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $totalPenginapan = 0; @endphp
                                            @foreach ($penginapanData as $index => $item)
                                                @php 
                                                    $biaya = $item['hotel_ril'] ?? 0;
                                                    $totalPenginapan += $biaya;
                                                @endphp
                                                <tr class="bg-background border-b border-border-custom hover:bg-surface">
                                                    <td class="px-4 py-2 text-center">{{ $index + 1 }}</td>
                                                    <td class="px-4 py-2">{{ $item['keterangan'] ?? '-' }}</td>
                                                    <td class="px-4 py-2 text-center">{{ $item['penginapan_persen'] ?? '-' }}%</td>
                                                    <td class="px-4 py-2 text-right">Rp {{ number_format($biaya, 0, ',', '.') }}</td>
                                                    <td class="px-4 py-2 text-center">
                                                        @if (!empty($item['lampiran']))
                                                            <button type="button" onclick="openLampiranModal('{{ Storage::url($item['lampiran']) }}')" class="text-xs text-primary hover:underline flex items-center justify-center gap-1 mx-auto">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943-9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                                Lihat
                                                            </button>
                                                        @else
                                                            <span class="text-xs text-muted">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr class="bg-surface font-semibold">
                                                <td colspan="3" class="px-4 py-2 text-right">Total Penginapan:</td>
                                                <td class="px-4 py-2 text-right">Rp {{ number_format($totalPenginapan, 0, ',', '.') }}</td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-sm text-muted italic">Tidak ada data biaya penginapan.</p>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-8 border-t border-border-custom pt-4">
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

    {{-- Modal Lampiran --}}
    <div id="lampiran-modal" class="fixed inset-0 z-50 hidden bg-black/60 flex items-center justify-center backdrop-blur-sm transition-opacity duration-300 opacity-0 p-4">
        <div class="bg-background rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] flex flex-col transform scale-95 transition-transform duration-300">
            <div class="flex items-center justify-between p-4 border-b border-border-custom">
                <h3 class="text-lg font-bold text-text-main">Preview Lampiran</h3>
                <button onclick="closeLampiranModal()" class="text-muted hover:text-text-main transition bg-surface rounded-md p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="flex-1 overflow-auto p-4 flex items-center justify-center bg-surface-muted min-h-[400px]">
                {{-- Konten disisipkan via JS --}}
                <div id="lampiran-content" class="w-full h-full flex items-center justify-center"></div>
            </div>
            <div class="p-4 border-t border-border-custom flex justify-end gap-3">
                <a id="lampiran-download-btn" href="#" target="_blank" download class="inline-flex items-center gap-2 px-4 py-2 border border-border-custom bg-surface rounded-md text-sm font-semibold text-text-main hover:bg-background transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download File
                </a>
                <button onclick="closeLampiranModal()" class="px-4 py-2 border border-border-custom rounded-md text-sm font-semibold text-text-main hover:bg-surface transition">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function openLampiranModal(url) {
            const modal = document.getElementById('lampiran-modal');
            const content = document.getElementById('lampiran-content');
            const btnDownload = document.getElementById('lampiran-download-btn');
            
            // Set link download
            btnDownload.href = url;
            
            // Cek ekstensi file
            const ext = url.split('.').pop().toLowerCase();
            
            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                content.innerHTML = `<img src="${url}" class="max-w-full max-h-full object-contain rounded-lg shadow-sm" alt="Lampiran" />`;
            } else if (ext === 'pdf') {
                content.innerHTML = `<iframe src="${url}" class="w-full h-[600px] border-0 rounded-lg shadow-sm"></iframe>`;
            } else {
                content.innerHTML = `
                    <div class="text-center p-8 bg-background border border-border-custom rounded-lg shadow-sm">
                        <svg class="w-12 h-12 text-muted mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <p class="text-sm font-medium text-text-main mb-2">Preview tidak tersedia untuk format file ini.</p>
                        <a href="${url}" target="_blank" class="text-primary text-sm hover:underline font-semibold">Klik di sini untuk mengunduh</a>
                    </div>
                `;
            }
            
            // Tampilkan modal dengan animasi
            modal.classList.remove('hidden');
            // Sedikit delay agar transisi jalan
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.querySelector('.bg-background').classList.remove('scale-95');
                modal.querySelector('.bg-background').classList.add('scale-100');
            }, 10);
            
            // Cegah scroll di body
            document.body.style.overflow = 'hidden';
        }
        
        function closeLampiranModal() {
            const modal = document.getElementById('lampiran-modal');
            
            modal.classList.add('opacity-0');
            modal.querySelector('.bg-background').classList.remove('scale-100');
            modal.querySelector('.bg-background').classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.getElementById('lampiran-content').innerHTML = ''; // bersihkan konten
                document.body.style.overflow = ''; // kembalikan scroll body
            }, 300);
        }
        
        // Tutup modal jika klik di luar box
        document.getElementById('lampiran-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLampiranModal();
            }
        });
        
        // Tutup modal dengan tombol escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('lampiran-modal').classList.contains('hidden')) {
                closeLampiranModal();
            }
        });
    </script>

    <x-layout.footer />

</x-layout.app>
