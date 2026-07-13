<x-layout.print title="Surat Perintah Tugas (SPT)">
    <style>
        @page {
            size: A4 portrait;
            margin: 0.8cm 2cm 1cm 2cm;
        }

        .spt-container {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt; 
            color: #000;
            line-height: 1.4;
            padding: 5px 0;
            position: relative;
        }

        .footer-bssn {
            margin-top: 40px;
            width: 100%;
            text-align: center;
            font-size: 8.5pt;
            line-height: 1.4;
            color: #333;
            padding-top: 8px;
            page-break-inside: avoid;
        }

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
            width: 110px; 
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .kop-col {
            text-align: center;
            vertical-align: middle;
            padding-left: 10px;
        }
        .kop1 { font-size: 14pt; font-weight: bold; }
        .kop2 { font-size: 11pt; font-weight: bold; margin-top: 1px; }
        .kop3 { font-size: 12pt; font-weight: bold; margin-top: 1px; }
        .alamat { font-size: 8.5pt; margin-top: 4px; line-height: 1.2; }

        .garis1 { border-top: 3px solid black; margin-top: 6px; }
        .garis2 { border-top: 1px solid black; margin-top: 1.5px; margin-bottom: 15px; }

        /* Judul Dokumen */
        .judul-blok {
            text-align: center;
            margin-bottom: 15px; 
        }
        .judul-blok h2 {
            font-size: 13pt;
            text-decoration: underline;
            font-weight: bold;
            margin: 0;
        }
        .nomor-surat {
            margin-top: 4px;
            font-size: 11pt;
            text-align: center;
        }
        .kepala { font-weight: bold; font-size: 11pt; margin-top: 8px; }

        /* Tabel Utama */
        .surat-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 5px;
        }
        .surat-table td {
            vertical-align: top;
            padding: 5px 0; 
        }
        .lbl { width: 110px; font-weight: bold; }
        .ttk { width: 20px; text-align: center; }
        .cnt { width: auto; }

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
            font-weight: bold;
            font-size: 11pt;
            margin: 15px 0; 
            letter-spacing: 1px;
        }

        /* Sub Tabel Looping Pegawai */
        .pegawai-item-box {
            margin-bottom: 8px;
        }
        .sub-table {
            width: 100%;
            border-collapse: collapse;
        }
        .sub-table td {
            padding: 2px 0;
            vertical-align: top;
        }
        .sub-lbl { width: 150px; }
        .sub-ttk { width: 20px; text-align: center; }
        .sub-cnt { width: auto; }

        .penutup {
            margin-top: 20px; 
            text-align: justify;
        }

        .ttd-table {
            margin-top: 25px; 
            width: 100%;
            border-collapse: collapse;
            page-break-inside: avoid; 
        }
        .ttd-space {
            height: 55px; 
        }
        
        .tembusan {
            clear: both;
            margin-top: 30px; 
            page-break-inside: avoid;
        }
    </style>

    <div class="spt-container">
        <table class="header-table">
            <tr>
                <td class="logo-col">
                    <img src="{{ asset('logo.bphl.png}" alt="Logo BPHL">
                </td>
                <td class="kop-col">
                    <div class="kop1">KEMENTERIAN KEHUTANAN</div>
                    <div class="kop2">DIREKTORAT JENDERAL PENGELOLAAN HUTAN LESTARI</div>
                    <div class="kop3">BALAI PENGELOLAAN HUTAN LESTARI WILAYAH IV JAMBI</div>
                    <div class="alamat">
                        Jl. Arif Rahman Hakim No.10 Telanaipura Kota Jambi 36124<br>
                        Telepon (0741) 60415
                    </div>
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
                    @if($spt->jenis_tugas == 'administrasi')
                        <ol style="list-style-type: lower-alpha; padding-left: 15px;">
                            <li>bahwa untuk tertib administrasi dalam rangka kelancaran pelaksanaan tugas pokok dan fungsi BPHL Wilayah IV Jambi tahun anggaran 2026, perlu didukung Surat Tugas;</li>
                            <li>bahwa sehubungan dengan butir a di atas, perlu diterbitkan Surat Tugas untuk melaksanakan perjalanan dinas.</li>
                        </ol>
                    @else
                        {{-- Kategori Keuangan & Pelatihan menggunakan pola teks dinamis --}}
                        bahwa dalam rangka {{ $spt->tujuan_kegiatan }}, sehingga perlu ditugaskan pegawai untuk mengikuti acara dimaksud dengan surat tugas.
                    @endif
                </td>
            </tr>
            
            <tr>
                <td class="lbl">Dasar</td>
                <td class="ttk">:</td>
                <td class="cnt">
                    <ol>
                        <li>Peraturan Menteri Kehutanan Republik Indonesia Nomor 6 Tahun 2025 Tentang Organisasi dan Tata Kerja Balai Pengelolaan Hutan Lestari tanggal 19 Maret 2025;</li>
                        
                        @if($spt->jenis_tugas == 'pelatihan')
                            <li>Surat Pengesahan Daftar Isian Pelaksanaan Anggaran (DIPA) Balai 143.06.2.693523/2026 Rev-6 tanggal 25 Mei 2026;</li>
                        @elseif($spt->jenis_tugas == 'keuangan')
                            <li>Surat Pengesahan Daftar Isian Pelaksanaan Anggaran (DIPA) Balai 143.06.2.693523/2026 Rev-6 tanggal 25 Mei 2026;</li>
                        @else
                            <li>Surat Pengesahan Daftar Isian Pelaksanaan Anggaran (DIPA) Satker Balai Pengelolaan Hutan Lestari 143.06.2.693523/2026 tanggal 1 Desember 2025;</li>
                        @endif

                        {{-- Poin 3 Otomatis Mengisi Surat Undangan/Nota Dinas jika diinput --}}
                        @if(!empty($spt->surat_dasar))
                            <li>{{ $spt->surat_dasar }}</li>
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
                    @forelse($spt->pegawais as $index => $pegawai)
                        <div class="pegawai-item-box">
                            <table class="sub-table">
                                <tr>
                                    <td class="sub-lbl">@if(count($spt->pegawais) > 1){{ $index + 1 }}. @endif Nama/NIP</td>
                                    <td class="sub-ttk">:</td>
                                    <td class="sub-cnt">{{ $pegawai->nama_pegawai }} / {{ $pegawai->nip ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="sub-lbl">&nbsp;&nbsp;&nbsp;&nbsp;Jabatan</td>
                                    <td class="sub-ttk">:</td>
                                    <td class="sub-cnt">{{ $pegawai->jabatan }}</td>
                                </tr>
                            </table>
                        </div>
                    @empty
                        <div>Tidak ada pejabat/pegawai yang ditugaskan.</div>
                    @endforelse
                </td>
            </tr>

            <tr>
                <td class="lbl">Untuk</td>
                <td class="ttk">:</td>
                <td class="cnt">
                    <ol>
                        @if($spt->jenis_tugas == 'pelatihan')
                            <li>Mengikuti {{ $spt->tujuan_kegiatan }} secara online menggunakan learning management system LKPP;</li>
                            <li>Melaksanakan perjalanan dinas dalam rangka mengikuti fase klasikal (tatap muka) {{ $spt->tujuan_kegiatan }} ke {{ $spt->tempat_tujuan }};</li>
                            <li>Setelah selesai melaksanakan tugas, segera membuat laporan kepada Kepala Balai.</li>
                        @elseif($spt->jenis_tugas == 'keuangan')
                            <li>Melaksanakan perjalanan dinas menghadiri undangan dalam rangka {{ $spt->tujuan_kegiatan }} ke {{ $spt->tempat_tujuan }};</li>
                            <li>Setelah melaksanakan tugas agar segera membuat laporan.</li>
                        @else
                            <li>Melaksanakan perjalanan dinas {{ $spt->tujuan_kegiatan }} ke {{ $spt->tempat_tujuan }};</li>
                            <li>Setelah selesai melaksanakan tugas, segera membuat laporan kepada Kepala Balai.</li>
                        @endif
                    </ol>
                </td>
            </tr>
            <tr>
                <td class="lbl">Waktu</td>
                <td class="ttk">:</td>
                <td class="cnt">
                    <div>Selama <strong>{{ $spt->lama_kegiatan }} hari</strong> pada tanggal {{ \Carbon\Carbon::parse($spt->tgl_berangkat)->translatedFormat('d') }} s.d {{ \Carbon\Carbon::parse($spt->tgl_kembali)->translatedFormat('d F Y') }}.</div>
                </td>
            </tr>
            <tr>
                <td class="lbl">Biaya</td>
                <td class="ttk">:</td>
                <td class="cnt">
                    <div>
                        @if($spt->jenis_tugas == 'administrasi')
                            Biaya dibebankan pada DIPA Satker Balai Pengelolaan Hutan Lestari Wilayah IV Jambi Tahun Anggaran 2026.
                        @else
                            Biaya yang timbul akibat kegiatan ini dibebankan pada dana DIPA BPHL Wilayah IV Jambi Tahun Anggaran 2026.
                        @endif
                    </div>
                </td>
            </tr>
        </table>

        <p class="penutup">
            Demikian Surat Tugas ini dibuat untuk dapat dilaksanakan dengan @if($spt->jenis_tugas == 'keuangan') sebaik-baiknya dan @endif penuh tanggung jawab.
        </p>

        <table class="ttd-table">
            <tr>
                <td style="width: 50%;"></td>
                <td style="width: 50%; padding-left: 30px;">
                    <div>Jambi, {{ \Carbon\Carbon::parse($spt->tgl_spt)->translatedFormat('d F Y') }}</div>
                    <div style="margin-top: 4px;">Kepala Balai,</div>
                    <div class="ttd-space"></div>
                    <div style="font-weight: bold; text-decoration: underline;">Andi Rohaendi, M.Si.</div>
                    <div>NIP. 19720302199403 1 003</div>
                </td>
            </tr>
        </table>

        <div class="tembusan">
            <strong>Tembusan :</strong>
            <ol style="padding-left: 15px; margin-top: 4px;">
                <li>Sekretaris Direktorat Jenderal PHL</li>
            </ol>
        </div>

        <div class="footer-bssn">
           Dokumen ini telah ditandatangani secara elektronik menggunakan sertifikat elektronik<br>
           yang diterbitkan oleh Balai Besar Sertifikasi Elektronik (BSrE), Badan Siber dan Sandi Negara (BSSN). 
        </div>
    </div>
</x-layout.print>