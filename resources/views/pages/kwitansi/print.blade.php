<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Kwitansi Bukti Pembayaran - {{ $kwitansi->nomor_kwitansi }}</title>
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            color: #111;
            margin: 0;
            padding: 20px;
            background: #f3f4f6;
        }

        .sheet {
            max-width: 950px;
            margin: 0 auto;
            background: #fff;
            border: 4px double black;
            padding: 25px 30px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 17px;
            text-decoration: underline;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        table.meta {
            width: 420px;
            margin-left: auto;
            margin-right: -30px;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.meta td {
            border: 1px solid #444;
            {{-- padding: 5px 10px; --}}
        }

        table.meta td:first-child {
            width: 45%;
        }

        table.meta td:last-child {
            border-right: none;
        }

        table.info {
            width: calc(100% + 30px);
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table.info td {
            {{-- padding: 5px 6px; --}} vertical-align: top;
        }

        .label {
            width: 190px;
            white-space: nowrap;
        }

        .colon {
            width: 15px;
        }

        .jumlah {
            font-weight: bold;
        }

        td.isian {
            position: relative;
            padding: 0;
            vertical-align: top;
        }
        .garis-container {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            z-index: 0;
            overflow: hidden;
        }
        .garis-baris {
            border-bottom: 1px solid #000;
            height: 25px;
            box-sizing: border-box;
            width: 100%;
        }
        .isian-text {
            position: relative;
            z-index: 1;
            line-height: 25px;
            padding: 0 6px;
        }

        .signature-area {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .signature-col {
            width: 320px;
        }

        .signature-col table td {
            padding: 2px 4px;
        }

        .bottom-area {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .bottom-col {
            width: 45%;
        }

        .sig-space {
            height: 50px;
        }

        .print-btn {
            display: block;
            max-width: 950px;
            margin: 0 auto 15px auto;
            text-align: right;
        }

        .print-btn button {
            padding: 8px 16px;
            background: #1e3a8a;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }

        .hr-black {
            border: none;
            border-top: 1px solid #000;
            margin: 20px -30px;
        }

        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            body {
                background: #fff;
                padding: 0;
            }

            .print-btn {
                display: none;
            }

        }
    </style>
</head>

<body>
    <div class="print-btn">
        <button onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
    </div>

    <div class="sheet">
        <div class="title">
            KUITANSI&nbsp;&nbsp;BUKTI&nbsp;&nbsp;PEMBAYARAN
        </div>

        <table class="meta">
            <tr>
                <td>TA</td>
                <td>: {{ $kwitansi->created_at->format('Y') }}</td>
            </tr>
            <tr>
                <td>Nomor Bukti</td>
                <td>: {{ $kwitansi->nomor_kwitansi }}</td>
            </tr>
            <tr>
                <td>Mata Anggaran</td>
                <td>: {{ $spd->kode_mak ?? '7279.BDB.001.052.C.524111' }}</td>
            </tr>
        </table>

        <table class="info">
            <tr>
                <td class="label">Sudah terima dari</td>
                <td class="colon">:</td>
                <td>
                    {{ $spd->ppk ?? 'Pejabat Pembuat Komitmen' }}<br />
                    Balai Pengelolaan Hutan Lestari Wilayah IV Jambi
                </td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>

            <tr>
                <td class="label" style="padding-top: 8px">Jumlah Uang</td>
                <td class="colon" style="padding-top: 8px">:</td>
                <td class="jumlah isian" style="border-top: 1px solid #000;">
                    <div class="garis-container">
                        @for($i=0; $i<5; $i++)
                            <div class="garis-baris"></div>
                        @endfor
                    </div>
                    <div class="isian-text">
                        Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="label" style="padding-top: 8px">Terbilang</td>
                <td class="colon" style="padding-top: 8px">:</td>
                <td class="isian">
                    <div class="garis-container">
                        @for($i=0; $i<10; $i++)
                            <div class="garis-baris"></div>
                        @endfor
                    </div>
                    <div class="isian-text">
                        {{ $terbilang }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="label" style="vertical-align: top; padding-top: 8px;">
                    Untuk Pembayaran
                </td>
                <td class="colon" style="vertical-align: top; padding-top: 8px;">:</td>
                <td class="isian">
                    <div class="garis-container">
                        @for($i=0; $i<15; $i++)
                            <div class="garis-baris"></div>
                        @endfor
                    </div>
                    <div class="isian-text">
                        {!! nl2br(e($kwitansi->untuk_pembayaran)) !!}
                    </div>
                </td>
            </tr>
        </table>

        <div class="signature-area">
            <div class="signature-col">
                Jambi, {{ $kwitansi->created_at->translatedFormat('d F Y') }}<br />
                Yang Berhak / Menerima,
                <div class="sig-space"></div>
                <table>
                    <tr>
                        <td class="label" style="width:50px">Nama</td>
                        <td>: {{ $spd->pegawai_ditugaskan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label" style="width:50px">Alamat</td>
                        <td>: BPHL Wilayah IV Jambi</td>
                    </tr>
                </table>
            </div>
        </div>

        <hr class="hr-black" />

        <div class="bottom-area">
            <div class="bottom-col">
                Setuju dibayarkan pada mata anggaran berkenaan,<br />
                {{ $spd->ppk ?? 'Pejabat Pembuat Komitmen' }},
                <div class="sig-space"></div>
                <strong>{{ $spd->nama_ppk ?? '-' }}</strong><br />
                NIP. {{ $spd->nip_ppk ?? '-' }}
            </div>
            <div class="bottom-col">
                Lunas dibayar tgl.<br />
                Bendahara Pengeluaran,
                <div class="sig-space"></div>
                <strong>{{ $bendahara?->pegawai?->nama_pegawai ?? '-' }}</strong><br />
                NIP. {{ $bendahara?->pegawai?->nip ?? '-' }}
            </div>
        </div>
    </div>
</body>

</html>
