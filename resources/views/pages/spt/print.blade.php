<x-layout.print title="Surat Perintah Tugas (SPT)">
    <style id="page-style">
        @page {
            size: A4 portrait;
            margin: 0.5cm 1cm 0.75cm 2cm;
        }
    </style>
    <style>
        * {
            box-sizing: border-box;
        }

        @media print {

            html,
            body {
                margin: 0 !important;
                padding: 0 !important;
            }

            .no-print {
                display: none !important;
            }
        }


        .spt-container {
            font-family: "Bookman Old Style", serif;
            font-size: 12pt;
            /* Default */
            color: #000;
            line-height: 1.15;
            padding: 0;
            position: relative;
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
        }

        body.paper-a4 .spt-container {
            font-size: 12pt;
            line-height: 1.15;
        }

        body.paper-f4 .spt-container {
            font-size: 12pt;
            line-height: 1.2;
        }

        {{-- .footer-bssn { --}} {{--    margin-top: 10px; --}} {{--    width: 100%; --}} {{--    text-align: center; --}} {{--    font-size: 8pt; --}} {{--    line-height: 1.2; --}} {{--    color: #333; --}} {{--    padding-top: 8px; --}} {{--    page-break-inside: avoid; --}} {{-- } --}}

        /* Kop Surat Resmi Dinas */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .logo-col {
            width: 120px;
            text-align: center;
            vertical-align: middle;
        }

        .logo-col img {
            width: auto;
            height: 2.57cm;
            display: block;
            margin: 0 auto;
        }

        .kop-col {
            font-family: Arial, Helvetica, sans-serif;
            text-align: center;
            vertical-align: middle;
            padding-left: 5px;
        }

        .kop1 {
            font-size: 12pt;
            font-weight: bold;
        }

        .kop2 {
            font-size: 12pt;
            font-weight: bold;
            margin-top: 1px;
        }

        .kop3 {
            font-size: 13pt;
            font-weight: bold;
            margin-top: 1px;
        }

        .alamat {
            font-size: 8pt;
            margin-top: 4px;
            line-height: 1.2;
        }

        .garis1 {
            border-top: 3px solid black;
            margin-top: 6px;
        }

        .garis2 {
            border-top: 1px solid black;
            margin-top: 1.5px;
            margin-bottom: 5px;
        }

        /* Judul Dokumen */
        .judul-blok {
            text-align: center;
            margin-bottom: 5px;
        }

        .judul-blok h2 {
            font-size: 12pt;
            font-weight: bold;
            margin: 0;
        }

        .nomor-surat {
            margin-top: -3px;
            font-size: 12pt;
            text-align: center;
        }

        .kepala {
            font-weight: bold;
            font-size: 12pt;
            margin-top: 5px;
        }

        /* Tabel Utama */
        .surat-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 1px;
            margin-bottom: 5px;
        }

        .surat-table td {
            vertical-align: top;
            padding: 2px 0;
        }

        .lbl {
            width: 85px;
        }

        .ttk {
            width: 20px;
            text-align: center;
        }

        .cnt {
            width: auto;
        }

        ol {
            padding-left: 15px;
            margin: 0;
            width: 100%;
        }

        ol li {
            margin-bottom: 5px;
            text-align: justify;
        }

        .memberi {
            text-align: center;
            font-size: 12pt;
            margin: 2px 0;
            letter-spacing: 1px;
        }

        /* Sub Tabel Looping Pegawai */
        .pegawai-item-box {
            margin-bottom: 4px;
        }

        .sub-table {
            width: 100%;
            border-collapse: collapse;
        }

        .sub-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .sub-lbl {
            width: 120px;
        }

        .sub-ttk {
            width: 20px;
            text-align: center;
        }

        .sub-cnt {
            width: auto;
        }

        .penutup {
            margin-top: 5px;
            text-align: justify;
        }

        .ttd-table {
            margin-top: 5px;
            width: 100%;
            border-collapse: collapse;
            page-break-inside: avoid;
        }

        .ttd-space {
            height: 65px;
            display: flex;
            align-items: center;
        }

        .tembusan {
            clear: both;
            margin-top: 5px;
            page-break-inside: avoid;
        }
    </style>

    <div class="no-print"
        style="margin-bottom: 20px; text-align: center; padding: 15px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
        <button type="button" onclick="printA4()"
            style="padding: 8px 16px; background-color: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px; font-weight: bold;">🖨️
            Cetak (A4)</button>
        <button type="button" onclick="printF4()"
            style="padding: 8px 16px; background-color: #10b981; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">🖨️
            Cetak (F4)</button>
        <p style="font-size: 12px; color: #64748b; margin-top: 8px;">Pilih ukuran kertas sebelum mencetak. Jendela cetak
            akan otomatis terbuka.</p>
    </div>

    <div class="spt-container">
        <table class="header-table">
            <tr>
                <td class="logo-col">
                    <img src="{{ asset('logo.bphl.png') }}" alt="Logo BPHL">
                </td>
                <td class="kop-col">
                    <div class="kop1">KEMENTERIAN KEHUTANAN</div>
                    <div class="kop2">DIREKTORAT JENDERAL PENGELOLAAN HUTAN LESTARI</div>
                    <div class="kop3">BALAI PENGELOLAAN HUTAN LESTARI WILAYAH IV JAMBI</div>
                </td>
            </tr>
        </table>

        <div class="garis1"></div>
        <div class="garis2"></div>

        <div class="judul-blok">
            <h2>SURAT TUGAS</h2>
            <div class="nomor-surat">
                <span>Nomor : {{ $spt->nomor_spt }}</span>
            </div>
            <div class="kepala">KEPALA BALAI</div>
        </div>

        <table class="surat-table">
            <tr>
                <td class="lbl">Menimbang</td>
                <td class="ttk">:</td>
                <td class="cnt" style="text-align: justify;">
                    @if ($spt->jenis_tugas == 'administrasi')
                        <ol style="list-style-type: lower-alpha; padding-left: 15px;">
                            <li>bahwa untuk tertib administrasi dalam rangka kelancaran pelaksanaan tugas pokok dan
                                fungsi BPHL Wilayah IV Jambi tahun anggaran 2026, perlu didukung Surat Tugas;</li>
                            <li>bahwa sehubungan dengan butir a di atas, perlu diterbitkan Surat Tugas untuk
                                melaksanakan perjalanan dinas.</li>
                        </ol>
                    @else
                        {{-- Kategori Keuangan & Pelatihan menggunakan pola teks dinamis --}}
                        bahwa dalam rangka {{ $spt->tujuan_kegiatan }}, sehingga perlu ditugaskan pegawai untuk
                        mengikuti acara dimaksud dengan surat tugas.
                    @endif
                </td>
            </tr>

            <tr>
                <td class="lbl">Dasar</td>
                <td class="ttk">:</td>
                <td class="cnt">
                    <ol>
                        @if (!empty($spt->surat_dasar))
                            @php
                                $dasarPoints = explode("\n", $spt->surat_dasar);
                            @endphp
                            @foreach ($dasarPoints as $point)
                                @php $cleanPoint = trim(preg_replace('/^\d+\.\s*/', '', $point)); @endphp
                                @if ($cleanPoint !== '')
                                    <li>{{ $cleanPoint }}</li>
                                @endif
                            @endforeach
                        @else
                            <li>-</li>
                        @endif
                    </ol>
                </td>
            </tr>
        </table>

        <div class="memberi">MEMBERI TUGAS</div>

        <table class="surat-table">
            <tr>
                <td class="lbl">Kepada</td>
                <td class="ttk">:</td>
                <td class="cnt">
                    @php
                        $pegawais = is_string($spt->pegawai_ditugaskan)
                            ? json_decode($spt->pegawai_ditugaskan, true)
                            : $spt->pegawai_ditugaskan;
                        $pegawais = is_array($pegawais) ? $pegawais : [];
                    @endphp
                    <table style="width: 100%; border-collapse: collapse;">
                        @forelse($pegawais as $index => $pegawai)
                            <tr>
                                @if (count($pegawais) > 1)
                                    <td style="width: 20px; vertical-align: top; padding: 2px 0;">{{ $index + 1 }}.</td>
                                @endif
                                <td style="padding: 0;">
                                    <table class="sub-table" style="width: 100%; margin-bottom: 4px;">
                                        <tr>
                                            <td class="sub-lbl" style="width: 100px;">Nama/NIP</td>
                                            <td class="sub-ttk" style="width: 20px;">:</td>
                                            <td class="sub-cnt">{{ $pegawai['nama_pegawai'] ?? '-' }} / {{ $pegawai['nip'] ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="sub-lbl">Pangkat/Gol</td>
                                            <td class="sub-ttk">:</td>
                                            <td class="sub-cnt">{{ $pegawai['pangkat'] ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="sub-lbl">Jabatan</td>
                                            <td class="sub-ttk">:</td>
                                            <td class="sub-cnt">{{ $pegawai['jabatan'] ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        @empty
                            <tr><td>Tidak ada pejabat/pegawai yang ditugaskan.</td></tr>
                        @endforelse
                    </table>
                </td>
            </tr>

            <tr>
                <td class="lbl">Untuk</td>
                <td class="ttk">:</td>
                <td class="cnt">
                    <ol>
                        @if ($spt->jenis_tugas == 'pelatihan')
                            <li>Mengikuti {{ $spt->tujuan_kegiatan }} secara online menggunakan learning management
                                system LKPP;</li>
                            <li>Melaksanakan perjalanan dinas dalam rangka mengikuti fase klasikal (tatap muka)
                                {{ $spt->tujuan_kegiatan }} ke {{ $spt->tempat_tujuan }};</li>
                            <li>Setelah selesai melaksanakan tugas, segera membuat laporan kepada Kepala Balai.</li>
                        @elseif($spt->jenis_tugas == 'keuangan')
                            <li>Melaksanakan perjalanan dinas menghadiri undangan dalam rangka
                                {{ $spt->tujuan_kegiatan }} ke {{ $spt->tempat_tujuan }};</li>
                            <li>Setelah melaksanakan tugas agar segera membuat laporan.</li>
                        @else
                            <li>Melaksanakan perjalanan dinas {{ $spt->tujuan_kegiatan }} ke
                                {{ $spt->tempat_tujuan }};</li>
                            <li>Setelah selesai melaksanakan tugas, segera membuat laporan kepada Kepala Balai.</li>
                        @endif
                    </ol>
                </td>
            </tr>
            <tr>
                <td class="lbl">Waktu</td>
                <td class="ttk">:</td>
                <td class="cnt">
                    <div>Selama {{ $spt->lama_kegiatan }} hari pada tanggal
                        {{ \Carbon\Carbon::parse($spt->tgl_berangkat)->translatedFormat('d') }} s.d
                        {{ \Carbon\Carbon::parse($spt->tgl_kembali)->translatedFormat('d F Y') }}.</div>
                </td>
            </tr>
            <tr>
                <td class="lbl">Biaya</td>
                <td class="ttk">:</td>
                <td class="cnt">
                    <div>
                        @if ($spt->jenis_tugas == 'administrasi')
                            Biaya dibebankan pada DIPA Satker Balai Pengelolaan Hutan Lestari Wilayah IV Jambi Tahun
                            Anggaran 2026.
                        @else
                            Biaya yang timbul akibat kegiatan ini dibebankan pada dana DIPA BPHL Wilayah IV Jambi Tahun
                            Anggaran 2026.
                        @endif
                    </div>
                </td>
            </tr>
        </table>

        <p class="penutup">
            Demikian Surat Tugas ini dibuat untuk dapat dilaksanakan dengan @if ($spt->jenis_tugas == 'keuangan')
                sebaik-baiknya dan
            @endif penuh tanggung jawab.
        </p>

        <div class="footer-block" style="page-break-inside: avoid; margin-top: 15px;">
            <table class="ttd-table">
                <tr>
                    <td style="width: 50%;"></td>
                    <td style="width: 50%; padding-left: 30px;">
                        <div>Jambi, {{ \Carbon\Carbon::parse($spt->tgl_spt)->translatedFormat('d F Y') }}</div>
                        {{-- menggunakan variable srikandi agar support bsre --}}
                        <div style="margin-top: 4px;">Plh. Kepala Balai,</div>
                        <div class="ttd-space"> ${ttd_pengirim}</div>
                        <div>${nama_pengirim}</div>
                        <div>NIP.${nip_pengirim}</div>
                    </td>
                </tr>
            </table>

            <div class="tembusan">
                Tembusan :
                <ol style="padding-left: 15px; margin-top: 4px;">
                    <li>Sekretaris Direktorat Jenderal PHL</li>
                </ol>
            </div>
        </div>

        {{-- <div class="footer-bssn"> --}}
        {{--    Dokumen ini telah ditandatangani secara elektronik menggunakan sertifikat elektronik<br> --}}
        {{--    yang diterbitkan oleh Balai Besar Sertifikasi Elektronik (BSrE), Badan Siber dan Sandi Negara (BSSN). --}}
        {{-- </div> --}}
    </div>

    <script>
        function printA4() {
            document.body.classList.remove('paper-f4');
            document.body.classList.add('paper-a4');
            const styleEl = document.getElementById('page-style');
            if (styleEl) {
                styleEl.innerHTML = `@page { size: A4 portrait; margin: 0.5cm 1cm 0.75cm 2cm; }`;
            }
            window.print();
        }

        function printF4() {
            document.body.classList.remove('paper-a4');
            document.body.classList.add('paper-f4');
            const styleEl = document.getElementById('page-style');
            if (styleEl) {
                styleEl.innerHTML = `@page { size: 215.9mm 330.2mm portrait; margin: 0.5cm 1cm 0.75cm 2cm; }`;
            }
            window.print();
        }
    </script>
</x-layout.print>
