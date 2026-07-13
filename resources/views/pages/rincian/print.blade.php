<x-layout.print title="Rincian Biaya Perjalanan Dinas & Perhitungan SPD Rampung">
    <style>
        @media print {
            .no-print { display: none !important; }
        }
        body.paper-a4 @page { size: A4; margin: 15mm; }
        body.paper-f4 @page { size: 215.9mm 330.2mm; margin: 15mm; }
    </style>

    <div class="no-print" style="margin-bottom: 20px; text-align: center; padding: 15px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
        <button type="button" onclick="document.body.classList.remove('paper-f4'); document.body.classList.add('paper-a4'); window.print();" style="padding: 8px 16px; background-color: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px; font-weight: bold;">🖨️ Cetak (A4)</button>
        <button type="button" onclick="document.body.classList.remove('paper-a4'); document.body.classList.add('paper-f4'); window.print();" style="padding: 8px 16px; background-color: #10b981; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">🖨️ Cetak (F4)</button>
        <p style="font-size: 12px; color: #64748b; margin-top: 8px;">Pilih ukuran kertas sebelum mencetak. Jendela cetak akan otomatis terbuka.</p>
    </div>

    @php
        $uangHarianRate = $uangHarianRate ?? 0;
        $lamaKegiatan = $rincian->spd->lama_kegiatan ?? 0;
        $uangHarianTotal = $uangHarianRate * $lamaKegiatan;
        
        $transportTotal = 0;
        $hotelTotal = 0;
        if (is_array($rincian->rincian_biaya)) {
            foreach ($rincian->rincian_biaya as $item) {
                $transportTotal += (int) ($item['biaya_transport'] ?? 0);
                $hotelTotal += (int) ($item['hotel_ril'] ?? 0);
            }
        }
        
        $totalKeseluruhan = $uangHarianTotal + $transportTotal + $hotelTotal;
    @endphp
    <div class="container">
        <div class="header-title">RINCIAN BIAYA PERJALANAN DINAS</div>

        <div class="meta-info">
            <table cellspacing="0" cellpadding="0">
                <tr>
                    <td>Lampiran SPD Nomor</td>
                    <td>:</td>
                    <td>{{ $rincian->nomor_spd }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>{{ \Carbon\Carbon::parse($rincian->tgl_spd)->translatedFormat('d F Y') }}</td>
                </tr>
            </table>
        </div>

        <table class="main-table">
            <thead>
                <tr>
                    <th width="5%">NO.</th>
                    <th width="50%">PERINCIAN BIAYA</th>
                    <th width="25%">JUMLAH</th>
                    <th width="20%">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1.</td>
                    <td>
                        Uang Harian :<br />
                        <span style="display: inline-block; margin-left: 20px">
                            {{ $lamaKegiatan }} hari x Rp. {{ number_format($uangHarianRate, 0, ',', '.') }}
                        </span>
                    </td>
                    <td style="vertical-align: bottom">
                        <table width="100%" style="border: none; margin: 0; padding: 0">
                            <tr>
                                <td style="border: none; padding: 0; width: 20px;">Rp.</td>
                                <td style="border: none; padding: 0; text-align: right;">
                                    {{ number_format($uangHarianTotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="text-center">2.</td>
                    <td>
                        Transportasi :<br />
                        <span style="display: inline-block; margin-left: 20px">
                            {{ $rincian->berangkat_dari }} - {{ $rincian->tempat_tujuan }} (PP)
                        </span>
                    </td>
                    <td style="vertical-align: bottom">
                        <table width="100%" style="border: none; margin: 0; padding: 0">
                            <tr>
                                <td style="border: none; padding: 0; width: 20px;">Rp.</td>
                                <td style="border: none; padding: 0; text-align: right;">
                                    {{ number_format($transportTotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="text-center">3.</td>
                    <td>
                        Penginapan :<br />
                        <span style="display: inline-block; margin-left: 20px">
                            {{ $lamaKegiatan > 1 ? $lamaKegiatan - 1 : 1 }} x Rp. {{ number_format( ($lamaKegiatan > 1 ? $hotelTotal / ($lamaKegiatan - 1) : $hotelTotal), 0, ',', '.') }},-
                        </span>
                    </td>
                    <td style="vertical-align: bottom">
                        <table width="100%" style="border: none; margin: 0; padding: 0">
                            <tr>
                                <td style="border: none; padding: 0; width: 20px;">Rp.</td>
                                <td style="border: none; padding: 0; text-align: right;">
                                    {{ number_format($hotelTotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right" style="font-weight: bold; padding-right: 20px">
                        Jumlah
                    </td>
                    <td style="font-weight: bold">
                        <table width="100%" style="border: none; margin: 0; padding: 0">
                            <tr>
                                <td style="border: none; padding: 0; width: 20px;">Rp.</td>
                                <td style="border: none; padding: 0; text-align: right;">
                                    {{ number_format($totalKeseluruhan, 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <div class="terbilang">
            Terbilang : = {{ \App\Helpers\TerbilangHelper::format($totalKeseluruhan) }} =
        </div>

        <table class="signature-section" cellspacing="0" cellpadding="0">
            <tr>
                <td></td>
                <td style="padding-bottom: 15px">
                    Jambi, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                </td>
            </tr>
            <tr>
                <td>
                    Telah dibayar sejumlah<br />
                    <strong>Rp. {{ number_format($totalKeseluruhan, 0, ',', '.') }},-</strong><br />
                    ( {{ \App\Helpers\TerbilangHelper::format($totalKeseluruhan) }} )<br /><br />
                    Bendahara Pengeluaran,
                </td>
                <td>
                    Telah menerima jumlah uang sebesar<br />
                    <strong>Rp. {{ number_format($totalKeseluruhan, 0, ',', '.') }},-</strong><br />
                    ( {{ \App\Helpers\TerbilangHelper::format($totalKeseluruhan) }} )<br /><br />
                    Yang Menerima,
                </td>
            </tr>
            <tr>
                <td class="signature-space"></td>
                <td class="signature-space"></td>
            </tr>
            <tr>
                <td>
                    <span class="bold-name">Narhot Elisma, SE</span><br />
                    NIP. 19840128 201402 2 001
                </td>
                <td>
                    <span class="bold-name">{{ $rincian->pegawai_ditugaskan }}</span><br />
                    NIP. {{ $rincian->nip_pegawai }}
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        <div class="rampung-section">
            <div style="font-weight: bold; text-decoration: underline; margin-bottom: 15px; font-size: 15px;">
                Perhitungan SPD Rampung
            </div>

            <table class="rampung-table" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="35%">Ditetapkan sejumlah</td>
                    <td width="2%">:</td>
                    <td width="63%">Rp. {{ number_format($totalKeseluruhan, 0, ',', '.') }},-</td>
                </tr>
                <tr>
                    <td>Yang telah dibayar semula</td>
                    <td>:</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Sisa kurang / lebih</td>
                    <td>:</td>
                    <td>Rp. {{ number_format($totalKeseluruhan, 0, ',', '.') }},-</td>
                </tr>
            </table>

            <table class="signature-section" style="margin-top: 30px" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="50%"></td>
                    <td width="50%">
                        Pejabat Pembuat Komitmen 3,<br />
                        <div style="height: 80px"></div>
                        <span class="bold-name">{{ $rincian->nama_ppk }}</span><br />
                        NIP. {{ $rincian->nip_ppk }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</x-layout.print>
