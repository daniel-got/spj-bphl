<x-layout.app title="Verifikasi Bundel SPJ - SPJ BPHL 4">

    <div class="flex flex-1 w-full">
        <x-layout.sidebar />

        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <main class="grow flex flex-col px-6 py-10">
        <div class="max-w-5xl mx-auto w-full">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('verifikasi.spj.index') }}"
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full border border-border-custom bg-surface text-text-main hover:bg-background transition duration-150 shadow-xs"
                        title="Kembali">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-extrabold tracking-tight text-text-main">
                            Verifikasi Bundel SPJ
                        </h1>
                        <p class="text-xs text-muted mt-0.5">Periksa seluruh dokumen Rincian Biaya, SPD, dan SPT</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <x-data.status-badge status="{{ $rincian->status ?? 'diajukan' }}" class="text-xs px-3 py-1" />
                </div>
            </div>

            <div class="space-y-6">

                {{-- Status Card --}}
                <x-layout.card title="Status Pengajuan SPJ">
                    <div class="mt-4 flex flex-col md:flex-row md:items-center gap-4">
                        <div class="flex-shrink-0">
                            <x-data.status-badge status="{{ $rincian->status ?? 'diajukan' }}" />
                        </div>
                        <div class="flex-1">
                            @if($rincian->status === 'disetujui')
                                <p class="text-sm font-medium text-green-700 bg-green-50 p-3 rounded-lg border border-green-200">
                                    SPJ ini telah Anda setujui dan proses pencairan dana dapat dilanjutkan.
                                </p>
                            @elseif($rincian->status === 'diajukan')
                                <p class="text-sm text-text-main bg-blue-50 p-3 rounded-lg border border-blue-200">
                                    Dokumen diajukan oleh Staf PPK. Harap periksa lampiran dan rincian biaya di bawah sebelum verifikasi.
                                </p>
                            @elseif(in_array($rincian->status, ['direvisi', 'ditolak']))
                                <div class="text-sm text-yellow-800 bg-yellow-50 p-3 rounded-lg border border-yellow-200">
                                    <p class="font-semibold mb-1">Catatan Anda sebelumnya:</p>
                                    <p class="italic">{{ $rincian->catatan_verifikator ?? 'Tidak ada catatan' }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </x-layout.card>

                {{-- Lampiran PDF --}}
                @if($rincian->lampiran)
                <x-layout.card title="Dokumen Lampiran">
                    <div class="mt-4">
                        <a href="{{ Storage::url($rincian->lampiran) }}" target="_blank"
                            class="inline-flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-4 py-3 rounded-lg transition-colors border border-gray-300 w-full md:w-auto">
                            <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/></svg>
                            Lihat Dokumen Bukti Lampiran (PDF)
                        </a>
                        <p class="text-xs text-muted mt-2">Pastikan untuk memeriksa kesesuaian kwitansi hotel, tiket, atau nota lainnya dengan rincian biaya.</p>
                    </div>
                </x-layout.card>
                @endif

                {{-- Card 1: Informasi Dokumen & Pegawai --}}
                <x-layout.card title="Informasi Dokumen SPD & Pegawai">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <div>
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Nomor SPD</span>
                            <p class="text-sm font-bold text-text-main mt-1">{{ $rincian->nomor_spd }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-muted uppercase tracking-wider">Tanggal SPD</span>
                            <p class="text-sm font-medium text-text-main mt-1">
                                {{ $rincian->tgl_spd ? \Carbon\Carbon::parse($rincian->tgl_spd)->format('d F Y') : '-' }}
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
                <x-layout.card title="Detail Rincian Biaya Pengeluaran">
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
                                $totalTransport = 0;
                                $totalPenginapan = 0;
                                
                                foreach ($rincianBiaya as $i => $baris) {
                                    $totalTransport += (int) ($baris['biaya_transport'] ?? 0);
                                    $totalPenginapan += (int) ($baris['hotel_ril'] ?? 0);
                                    
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
                            
                            <x-data.table :headers="$headersBiaya" :rows="$rowsBiaya" :striped="false">
                                <tfoot class="bg-gray-50 font-bold border-t border-border-custom">
                                    <tr>
                                        <td colspan="2" class="px-4 py-3 text-right text-text-main">Total Transport: Rp {{ number_format($totalTransport, 0, ',', '.') }}</td>
                                        <td colspan="2" class="px-4 py-3 text-right text-text-main">Total Penginapan: Rp {{ number_format($totalPenginapan, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="px-4 py-3 text-right text-primary text-lg border-t border-border-custom">
                                            Total Keseluruhan: Rp {{ number_format($totalTransport + $totalPenginapan, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </x-data.table>
                        </div>
                    @else
                        <p class="text-sm text-muted mt-4 italic">Belum ada data rincian biaya yang diinputkan.</p>
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

                {{-- Card 4: Action Form untuk Verifikasi (Hanya Tampil Jika Belum Disetujui/Ditolak) --}}
                <x-layout.card title="Aksi Verifikasi SPJ">
                    <p class="text-sm text-muted mt-2 mb-4">
                        Pastikan seluruh pengeluaran sudah sesuai dengan bukti lampiran. Berikan catatan jika Anda meminta staf PPK untuk merevisi.
                    </p>

                    <x-form.verification-actions 
                        actionUrl="{{ route('verifikasi.spj.update-status', $rincian->id) }}" 
                        currentStatus="{{ $rincian->status }}"
                        catatan="{{ $rincian->catatan_verifikator }}" 
                    />
                </x-layout.card>

            </div>
        </div>
    </main>

            <x-layout.footer />
        </div>
    </div>

</x-layout.app>
