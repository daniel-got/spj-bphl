<x-layout.print title="Rincian Biaya Perjalanan Dinas & Perhitungan SPD Rampung">
    <style id="page-style">
        @page {
            size: A4 portrait;
            margin: 15mm;
        }
    </style>
    <style>
        @media print {
            body { font-size: 12px !important; }
            .no-print { display: none !important; }
            .divider { margin: 15px 0 10px 0 !important; }
            .terbilang { margin-bottom: 15px !important; }
            .rampung-section { margin-top: 10px !important; }
        }
        .signature-space {
            height: 50px;
        }
    </style>

    <div class="no-print" style="margin-bottom: 20px; text-align: center; padding: 15px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
        <button type="button" onclick="printA4()" style="padding: 8px 16px; background-color: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px; font-weight: bold;">🖨️ Cetak (A4)</button>
        <button type="button" onclick="printF4()" style="padding: 8px 16px; background-color: #10b981; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">🖨️ Cetak (F4)</button>
        <p style="font-size: 12px; color: #64748b; margin-top: 8px;">Pilih ukuran kertas sebelum mencetak. Jendela cetak akan otomatis terbuka.</p>
    </div>

    <script>
        function printA4() {
            document.body.classList.remove('paper-f4');
            document.body.classList.add('paper-a4');
            const styleEl = document.getElementById('page-style');
            if (styleEl) {
                styleEl.innerHTML = `@page { size: A4 portrait; margin: 15mm; }`;
            }
            window.print();
        }

        function printF4() {
            document.body.classList.remove('paper-a4');
            document.body.classList.add('paper-f4');
            const styleEl = document.getElementById('page-style');
            if (styleEl) {
                styleEl.innerHTML = `@page { size: 215.9mm 330.2mm portrait; margin: 15mm; }`;
            }
            window.print();
        }
    </script>

    @php
        $uangHarianRate = $uangHarianRate ?? 0;
        $lamaKegiatan = $rincian->spd->lama_kegiatan ?? 0;
        $uangHarianTotal = $uangHarianRate * $lamaKegiatan;
        
        $transportTotal = $rincian->biaya_transport;
        $hotelTotal = $rincian->hotel_ril;
        
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
                <!-- 1. Uang Harian -->
                <tr>
                    <td class="text-center" style="vertical-align: top;">1.</td>
                    <td style="vertical-align: top; padding: 0;">
                        <table width="100%" style="border: none; margin: 0; padding: 0;">
                            <tr><td style="border: none; padding: 5px;"><strong>Uang Harian</strong></td></tr>
                            <tr>
                                <td style="border: none; padding: 5px 5px 5px 15px;">
                                    - {{ $lamaKegiatan }} hari x Rp. {{ number_format($uangHarianRate, 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="vertical-align: top; padding: 0;">
                        <table width="100%" style="border: none; margin: 0; padding: 0;">
                            <tr>
                                <td style="border: none; padding: 5px; width: 20px; font-weight: bold;">Rp.</td>
                                <td style="border: none; padding: 5px; text-align: right; font-weight: bold;">
                                    {{ number_format($uangHarianTotal, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td style="border: none; padding: 5px; width: 20px;"></td>
                                <td style="border: none; padding: 5px; text-align: right;">
                                    {{ number_format($uangHarianTotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td></td>
                </tr>

                <!-- 2. Transportasi -->
                <tr>
                    <td class="text-center" style="vertical-align: top;">2.</td>
                    <td style="vertical-align: top; padding: 0;">
                        <table width="100%" style="border: none; margin: 0; padding: 0;">
                            <tr><td style="border: none; padding: 5px;"><strong>Transportasi</strong></td></tr>
                            @php
                                $transportData = $rincian->rincian_biaya['transport'] ?? [];
                            @endphp
                            @foreach($transportData as $kategori => $items)
                                <tr>
                                    <td style="border: none; padding: 2px 5px 2px 15px;">
                                        {{ chr(96 + $loop->iteration) }}. {{ $kategori }}:
                                    </td>
                                </tr>
                                @foreach($items as $item)
                                    <tr>
                                        <td style="border: none; padding: 2px 5px 2px 30px; font-size: 0.9em; color: #444;">
                                            - {{ $item['lokasi_awal'] ?? '' }} &rarr; {{ $item['lokasi_tujuan'] ?? '' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </table>
                    </td>
                    <td style="vertical-align: top; padding: 0;">
                        <table width="100%" style="border: none; margin: 0; padding: 0;">
                            <tr>
                                <td style="border: none; padding: 5px; width: 20px; font-weight: bold;">Rp.</td>
                                <td style="border: none; padding: 5px; text-align: right; font-weight: bold;">
                                    {{ number_format($transportTotal, 0, ',', '.') }}
                                </td>
                            </tr>
                            @foreach($transportData as $kategori => $items)
                                @php $catTotal = collect($items)->sum('biaya'); @endphp
                                <tr>
                                    <td style="border: none; padding: 2px 5px; width: 20px;"></td>
                                    <td style="border: none; padding: 2px 5px; text-align: right;">
                                        {{ number_format($catTotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @foreach($items as $item)
                                    <tr>
                                        <td style="border: none; padding: 2px 5px; width: 20px;"></td>
                                        <td style="border: none; padding: 2px 5px; text-align: right; font-size: 0.9em; color: #444;">
                                            {{ number_format($item['biaya'] ?? 0, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </table>
                    </td>
                    <td></td>
                </tr>

                <!-- 3. Uang Penginapan -->
                <tr>
                    <td class="text-center" style="vertical-align: top;">3.</td>
                    <td style="vertical-align: top; padding: 0;">
                        <table width="100%" style="border: none; margin: 0; padding: 0;">
                            <tr><td style="border: none; padding: 5px;"><strong>Uang Penginapan</strong></td></tr>
                            @php
                                $penginapanData = $rincian->rincian_biaya['penginapan'] ?? [];
                                $durasi = $lamaKegiatan > 1 ? $lamaKegiatan - 1 : 1;
                            @endphp
                            @foreach($penginapanData as $item)
                                @php
                                    $persen = $item['penginapan_persen'] ?? 100;
                                    $hotelRil = $item['hotel_ril'] ?? 0;
                                    $nilaiPerHari = $hotelRil / $durasi;
                                    $rateDbup = $persen > 0 ? $nilaiPerHari / ($persen / 100) : 0;
                                @endphp
                                <tr>
                                    <td style="border: none; padding: 2px 5px 2px 15px; font-size: 0.9em;">
                                        - {{ $durasi }} x Rp. {{ number_format($nilaiPerHari, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: none; padding: 2px 5px 2px 15px; font-size: 0.9em; color: #444;">
                                        - {{ $persen }}% x Rp. {{ number_format($rateDbup, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                    <td style="vertical-align: top; padding: 0;">
                        <table width="100%" style="border: none; margin: 0; padding: 0;">
                            <tr>
                                <td style="border: none; padding: 5px; width: 20px; font-weight: bold;">Rp.</td>
                                <td style="border: none; padding: 5px; text-align: right; font-weight: bold;">
                                    {{ number_format($hotelTotal, 0, ',', '.') }}
                                </td>
                            </tr>
                            @foreach($penginapanData as $item)
                                <tr>
                                    <td style="border: none; padding: 2px 5px; width: 20px;"></td>
                                    <td style="border: none; padding: 2px 5px; text-align: right; font-size: 0.9em;">
                                        {{ number_format($item['hotel_ril'] ?? 0, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: none; padding: 2px 5px; width: 20px;"></td>
                                    <td style="border: none; padding: 2px 5px; text-align: right; font-size: 0.9em;"></td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                    <td></td>
                </tr>

                <!-- Total -->
                <tr>
                    <td colspan="2" class="text-right" style="font-weight: bold; padding-right: 20px">
                        Jumlah
                    </td>
                    <td style="font-weight: bold; vertical-align: top">
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
                <tr>
                    <td></td>
                    <td colspan="3" style="font-style: italic;">
                        Terbilang: = {{ \App\Helpers\TerbilangHelper::format($totalKeseluruhan) }} =
                    </td>
                </tr>
            </tbody>
        </table>

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

            <table class="signature-section" style="margin-top: 15px" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="50%"></td>
                    <td width="50%">
                        Pejabat Pembuat Komitmen 3,<br />
                        <div class="signature-space"></div>
                        <span class="bold-name">{{ $rincian->nama_ppk }}</span><br />
                        NIP. {{ $rincian->nip_ppk }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</x-layout.print>
