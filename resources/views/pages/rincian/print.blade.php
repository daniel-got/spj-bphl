<x-layout.print title="Rincian Biaya Perjalanan Dinas & Perhitungan SPD Rampung">
    @php
        $uangHarianTotal = 1110000; // Statis sementara
        $transportTotal = $rincian->biaya_transport ?? 0;
        $hotelTotal = $rincian->hotel_ril ?? 0;
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
                            3.0 hari x Rp. 370.000 (Statis Sementara)
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
                            {{ $rincian->lama_kegiatan - 1 }} x Rp. {{ number_format( ($rincian->lama_kegiatan > 1 ? $hotelTotal / ($rincian->lama_kegiatan - 1) : $hotelTotal), 0, ',', '.') }},-
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
