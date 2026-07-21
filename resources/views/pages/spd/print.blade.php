<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Surat Perjalanan Dinas (SPD)</title>
    <style id="page-style">
        @page {
            @if (request('paper') === 'f4')
                size: 215mm 330mm portrait;
            @else
                size: A4 portrait;
            @endif
            margin: 8mm 10mm;
        }
    </style>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Tahoma, Arial, sans-serif;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* Reset table layout to stretch vertically to 100% sheet height */
        table {
            border-collapse: collapse;
            table-layout: fixed;
            width: 100%;
            max-width: 100%;
            height: 100%;
        }

        /* Override the extremely tall signature spacer rows from Excel template */
        .sheet-1 tr[style*="56.25pt"] {
            height: 35pt !important;
        }
        .sheet-2 tr[style*="56.25pt"] {
            height: 25pt !important;
        }
        /* Give text rows roughly 2px extra height to make them less tight */
        .sheet-1 tr[style*="14.4pt"] { height: 17.5pt !important; }
        .sheet-1 tr[style*="14.25pt"] { height: 17.5pt !important; }
        .sheet-2 tr[style*="14.4pt"] { height: 15pt !important; }
        .sheet-2 tr[style*="14.25pt"] { height: 15pt !important; }
        /* Shrink empty spacer rows to save vertical space so it fits exactly on 2 pages */
        tr[style*="8.9pt"] { height: 5pt !important; }
        tr[style*="9.3pt"] { height: 2pt !important; }

        td,
        span,
        div,
        tr,
        p {
            font-size: 9.5pt !important;
            line-height: 1.2 !important;
        }

        td {
            padding: 2.5px 4px 6px 4px !important;
            vertical-align: bottom;
            overflow: visible;
            word-wrap: break-word;
            white-space: nowrap;
        }

        td[rowspan] {
            white-space: normal;
        }

        .labelrow {
            display: flex;
            width: 100%;
        }
        .labelrow .label-col {
            flex: 0 0 75pt;
            white-space: nowrap;
            overflow: visible;
        }
        .labelrow .value-col {
            flex: 1 0 auto;
            white-space: nowrap;
            overflow: visible;
        }

        .sheet {
            page-break-after: always !important;
            page-break-inside: avoid !important;
            width: 100%;
            overflow: visible;
            box-sizing: border-box;
        }

        .sheet:last-child {
            page-break-after: auto !important;
        }

        body.no-borders table,
        body.no-borders tr,
        body.no-borders td,
        body.no-borders th {
            border-color: transparent !important;
        }

        /* Mode: Hanya cetak isian nilai saja (untuk overprint ke blangko fisik) */
        body.values-only {
            color: transparent !important;
        }
        
        body.values-only table,
        body.values-only tr,
        body.values-only td,
        body.values-only th {
            border-color: #fff !important; /* Prevents WebKit border collapse bug */
        }
        body.values-only .print-value,
        body.values-only .print-value * {
            color: #000 !important;
            visibility: visible !important;
        }

        /* FIX: Cegah printer memotong bounding box (auto-center) saat tabel transparan */
        body.values-only .sheet {
            position: relative;
        }
        body.values-only .sheet::before,
        body.values-only .sheet::after {
            content: '.';
            position: absolute;
            color: #fefefe !important; /* Warna hampir putih, printer akan membaca ini sebagai batas tinta */
            font-size: 1px;
            visibility: visible !important;
        }
        body.values-only .sheet::before {
            top: 0;
            left: 0;
        }
        body.values-only .sheet::after {
            bottom: 0;
            right: 0;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            /* Use vh to adapt exactly to the printable area of the physical page without overflowing */
            body.paper-a4 .sheet {
                /* height: 280mm; */
                /* max-height: 280mm; */
            }

            body.paper-a4 * {
                font-size: 8pt !important;
                line-height: 1.1 !important;
            }

            body.paper-a4 td {
                padding: 1.5px 3px !important;
            }

            body.paper-a4 .sheet-1 tr[style*="56.25pt"] { height: 35pt !important; } body.paper-a4 .sheet-2 tr[style*="56.25pt"] { height: 25pt !important; }

            body.paper-f4 .sheet {
                /* height: 310mm; */
                /* max-height: 310mm; */
            }

            body.paper-f4 * {
                font-size: 8pt !important;
                line-height: 1.1 !important;
            }

            body.paper-f4 td {
                padding: 1.5px 3px !important;
            }

            body.paper-f4 .sheet-1 tr[style*="56.25pt"] { height: 35pt !important; } body.paper-f4 .sheet-2 tr[style*="56.25pt"] { height: 25pt !important; }
        }
    </style>
</head>

<body class="paper-{{ request('paper', 'a4') }}">
    <div class="no-print"
        style="margin-bottom: 20px; text-align: center; padding: 15px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
        <button type="button" onclick="printA4()"
            style="padding: 8px 16px; background-color: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px; font-weight: bold;">🖨️
            Cetak (A4)</button>
        <button type="button" onclick="printF4()"
            style="padding: 8px 16px; background-color: #10b981; color: white; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px; font-weight: bold;">🖨️
            Cetak (F4)</button>
        <button type="button" onclick="toggleBorders()" id="btnToggleBorders"
            style="padding: 8px 16px; background-color: #f59e0b; color: white; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px; font-weight: bold;">📝
            Sembunyikan Garis Tabel</button>
        <button type="button" onclick="toggleValuesOnly()" id="btnValuesOnly"
            style="padding: 8px 16px; background-color: #8b5cf6; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">🖊️
            Mode Timpa (Isian Saja)</button>
        <p style="font-size: 12px; color: #64748b; margin-top: 8px;">Pilih ukuran kertas sebelum mencetak. Jendela cetak
            akan otomatis terbuka.</p>
    </div>
    <div class="sheet sheet-1">
        <table>
            <colgroup>
                <col style="width:3.4177%;" />
                <col style="width:7.0110%;" />
                <col style="width:4.2493%;" />
                <col style="width:1.2930%;" />
                <col style="width:6.1888%;" />
                <col style="width:9.3303%;" />
                <col style="width:7.0110%;" />
                <col style="width:3.9732%;" />
                <col style="width:2.0305%;" />
                <col style="width:4.2493%;" />
                <col style="width:5.0810%;" />
                <col style="width:7.0110%;" />
                <col style="width:4.3403%;" />
                <col style="width:7.0110%;" />
                <col style="width:1.7543%;" />
                <col style="width:3.6938%;" />
                <col style="width:1.7543%;" />
                <col style="width:5.0810%;" />
                <col style="width:3.6938%;" />
                <col style="width:4.2493%;" />
                <col style="width:7.5760%;" />
            </colgroup>
            <tbody>
                <tr style="height:8.2pt;">
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        Kementerian Kehutanan</td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Lembar Ke</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        Direktorat Jenderal Pengelolaan Hutan Lestari</td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Kode No.</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        Balai Pengelolaan Hutan Lestari Wilayah IV Jambi</td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:8.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Nomor </span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <span class="print-value">{{ $spd->nomor_spd }}</span></td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.2pt;">
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:16.5pt;">
                    <td colspan="20"
                        style="font-size:12.0pt;font-family:'Tahoma',Arial,sans-serif;font-weight:bold;text-decoration:underline;vertical-align:bottom;text-align:center;white-space:nowrap;overflow:visible;">
                        SURAT PERJALANAN DINAS</td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-top:0.75pt solid #000;border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        1. </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        <span class="print-value">{{ $spd->exists ? ($spd->ppk ?? 'Pejabat Pembuat Komitmen') : '' }}</span></td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:center;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:center;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:center;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="border-top:0.75pt solid #000;border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        2.</td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        Nama pegawai/NIP yang melaksanakan</td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="8" rowspan="2"
                        style="border-top:0.75pt solid #000;border-bottom:0.75pt solid #000;border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:middle;text-align:left;white-space:nowrap;overflow:visible;">
                        <span class="print-value">{{ $spd->pegawai_ditugaskan }}</span> / @if($spd->nip_pegawai)<span class="print-value">NIP. {{ $spd->nip_pegawai }}</span>@endif</td>
                    <td rowspan="2"
                        style="border-top:0.75pt solid #000;border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:middle;text-align:center;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="4" rowspan="2"
                        style="border-top:0.75pt solid #000;border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:middle;text-align:center;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="border-bottom:0.75pt solid #000;border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:middle;white-space:nowrap;overflow:visible;">
                        perjalanan dinas</td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        3. </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        a. Pangkat dan golongan </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        a. <span class="print-value">{{ $spd->exists ? ($spd->pangkat_pegawai ?? '-') : '' }}</span></td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        b. Jabatan / Instansi</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        b. <span class="print-value">{{ $spd->exists ? ($spd->jabatan_pegawai ?? '-') : '' }}</span></td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        c. Tingkat biaya perjalanan dinas</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        c. -</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-bottom:0.75pt solid #000;border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.7pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="13" rowspan="5"
                        style="border-top:0.75pt solid #000;border-bottom:0.75pt solid #000;border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:middle;text-align:left;white-space:normal;overflow:visible;">
                        <span class="print-value">{{ $spd->tujuan_kegiatan }}</span></td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        4. </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        Maksud perjalanan dinas</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-top:0.75pt solid #000;border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        5.</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        Alat angkut yang dipergunakan</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        <span class="print-value">{{ is_array($spd->alat_angkut) ? implode(', ', $spd->alat_angkut) : $spd->alat_angkut }}</span></td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-bottom:0.75pt solid #000;border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        6.</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        a. Tempat berangkat</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        a. <span class="print-value">{{ $spd->berangkat_dari }}</span></td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        b. Tempat tujuan</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        b.
                        <span class="print-value">{{ is_array($spd->tempat_tujuan) ? implode(', ', $spd->tempat_tujuan) : $spd->tempat_tujuan }}</span>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-bottom:0.75pt solid #000;border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        7.</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        a. Lama perjalanan dinas</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        a. <span class="print-value">{{ $spd->lama_kegiatan }}</span> Hari</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:right;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        b. Tanggal berangkat</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        b.
                        <span class="print-value">{{ $spd->tgl_berangkat ? \Carbon\Carbon::parse($spd->tgl_berangkat)->locale('id')->translatedFormat('d F Y') : '-' }}</span>
                    </td>
                    <td colspan="4"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        c. Tanggal harus kembali</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        c.
                        <span class="print-value">{{ $spd->tgl_kembali ? \Carbon\Carbon::parse($spd->tgl_kembali)->locale('id')->translatedFormat('d F Y') : '' }}</span>
                    </td>
                    <td colspan="4"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-bottom:0.75pt solid #000;border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="border-top:0.75pt solid #000;border-bottom:0.75pt solid #000;border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:middle;white-space:nowrap;overflow:visible;">
                        8.</td>
                    <td
                        style="border-top:0.75pt solid #000;border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:middle;white-space:nowrap;overflow:visible;">
                        Pengikut</td>
                    <td
                        style="border-top:0.75pt solid #000;border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:middle;white-space:nowrap;overflow:visible;">
                        Nama</td>
                    <td
                        style="border-top:0.75pt solid #000;border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;border-bottom:0.75pt solid #000;border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:middle;white-space:nowrap;overflow:visible;">
                        Tanggal Lahir</td>
                    <td
                        style="border-top:0.75pt solid #000;border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;border-bottom:0.75pt solid #000;border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;border-bottom:0.75pt solid #000;border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="4"
                        style="border-top:0.75pt solid #000;border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:middle;text-align:center;white-space:nowrap;overflow:visible;">
                        Keterangan</td>
                    <td
                        style="border-top:0.75pt solid #000;border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        1.</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        2.</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        3.</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        4.</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        5.</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-bottom:0.75pt solid #000;border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        9.</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        Pembebanan anggaran </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        <span style=""> a. Instansi </span></td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                                                <span style=""> a. BPHL Wilayah IV Jambi</span></td></td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:10pt;">
                    <td
                        style="border-bottom:0.75pt solid #000;border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:middle;white-space:nowrap;overflow:visible;">
                        <span style="">b. Akun</span></td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:middle;white-space:nowrap;overflow:visible;">
                        <span style="">b. <span class="print-value">{{ $spd->kode_mak }}</span></span></td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:middle;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        10.</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        Keterangan lain - lain</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="border-bottom:0.75pt solid #000;border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:7.7pt;">
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:center;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Dikeluarkan di </span><span class="value-col">: <span class="print-value">{{ $spd->berangkat_dari }}</span></span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:center;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:center;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Tanggal </span><span class="value-col">:
                                <span class="print-value">{{ $spd->tgl_spd ? \Carbon\Carbon::parse($spd->tgl_spd)->locale('id')->translatedFormat('d F Y') : '-' }}</span></span></div>
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:center;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="5"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:center;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:center;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:center;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:center;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        <span class="print-value" style="">{{ $spd->exists ? ($spd->ppk ?? 'Pejabat Pembuat Komitmen') : '' }}</span></td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:56.25pt;">
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:56.25pt;">
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        <span class="print-value" style=" ">{{ $spd->nama_ppk }}</span></td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        <span style="">@if($spd->nip_ppk)<span class="print-value">NIP. {{ $spd->nip_ppk }}</span>@endif</span></td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
    <div class="sheet sheet-2">
        <table>
            <colgroup>
                <col style="width:3.4177%;" />
                <col style="width:7.0110%;" />
                <col style="width:4.2493%;" />
                <col style="width:1.2930%;" />
                <col style="width:6.1888%;" />
                <col style="width:9.3303%;" />
                <col style="width:7.0110%;" />
                <col style="width:3.9732%;" />
                <col style="width:2.0305%;" />
                <col style="width:4.2493%;" />
                <col style="width:5.0810%;" />
                <col style="width:7.0110%;" />
                <col style="width:4.3403%;" />
                <col style="width:7.0110%;" />
                <col style="width:1.7543%;" />
                <col style="width:3.6938%;" />
                <col style="width:1.7543%;" />
                <col style="width:5.0810%;" />
                <col style="width:3.6938%;" />
                <col style="width:4.2493%;" />
                <col style="width:7.5760%;" />
            </colgroup>
            <tbody>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-right:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>

                    {{-- HALAMAN belakang--}}
                    <td colspan="3"
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Berangkat dari</span><span class="value-col">: <span class="print-value">{{ $spd->berangkat_dari }}</span></span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-right:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        <span style="">(Tempat Kedudukan)</span></td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-right:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow">
                            <span class="label-col" style="">Pada tanggal</span><span class="value-col" style="">:
                                <span class="print-value">{{ $spd->tgl_berangkat ? \Carbon\Carbon::parse($spd->tgl_berangkat)->locale('id')->translatedFormat('d F Y') : '-' }}</span></span>
                        </div>
                    </td>
                    <td colspan="4"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-right:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col" style="">Ke</span><span class="value-col" style="">:
                                <span class="print-value">{{ is_array($spd->tempat_tujuan) ? implode(', ', $spd->tempat_tujuan) : $spd->tempat_tujuan }}</span></span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-right:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
<td colspan="3"
    style="border-left:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
    <div class="labelrow"><span class="label-col" style="">Kepala</span><span class="value-col" style="">: <span class="print-value">{{ $spd->kepala_seksi_jabatan }}</span></span></div>
</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-right:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-right:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-right:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-right:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-right:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <span style="padding-left: 3.5em; text-decoration: underline; "><span class="print-value">{{ $spd->kepala_seksi_nama }}</span></span>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;border-right:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <span style="padding-left: 3.5em; ">@if($spd->kepala_seksi_nip)<span class="print-value">NIP. {{ $spd->kepala_seksi_nip }}</span>@endif</span>
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        II.</td>
                    <td colspan="3"
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Tiba di</span><span class="value-col">:
                                                            <span class="print-value">{{ is_array($spd->tempat_tujuan) ? implode(', ', $spd->tempat_tujuan) : $spd->tempat_tujuan }}</span></span>
</span></div>
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    {{--kolom kanan untuk kepulangan--}}
                    <td colspan="3"
                        style="border-top:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Berangkat dari</span><span class="value-col">:
                                                            <span class="print-value">{{ is_array($spd->tempat_tujuan) ? implode(', ', $spd->tempat_tujuan) : $spd->tempat_tujuan }}</span></span>
</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                                        {{--kolom kiri untuk keberangkatan--}}

                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Pada Tgl.</span><span class="value-col">: <span class="print-value">{{ $spd->tgl_berangkat ? \Carbon\Carbon::parse($spd->tgl_berangkat)->locale('id')->translatedFormat('d F Y') : '-' }}</span></span></div>
                    </td>
                    <td colspan="2"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                                        {{--kolom kanan untuk kepulangan--}}

                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Ke</span><span class="value-col">:<span class="print-value">{{ is_array($spd->berangkat_dari) ? implode(', ', $spd->berangkat_dari) : $spd->berangkat_dari }}</span></span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.25pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        {{--Berisi inputan siapa kepala yang ditemui di tempat tujuan / Pejabat Instansi/ Perusahaan--}}
                        <div class="labelrow"><span class="label-col">Kepala</span><span class="value-col">:<span class="print-value">{{ $spd->pejabat_instansi_perusahaan }}</span></span></div>
                    </td>
                    <td colspan="4" rowspan="2"
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:normal;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                                            {{--kolom kanan untuk kepulangan--}}
                        <div class="labelrow"><span class="label-col">Pada Tanggal</span><span class="value-col">:<span class="print-value">{{ $spd->tgl_kembali ? \Carbon\Carbon::parse($spd->tgl_kembali)->locale('id')->translatedFormat('d F Y') : '' }}</span></span></div>
                    </td>
                    <td colspan="5"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.25pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                                            {{--kolom kanan untuk kepulangan--}}

                        <div class="labelrow"><span class="label-col">Kepala</span><span class="value-col">: <span class="print-value">{{ $spd->pejabat_instansi_perusahaan }}</span></span></div>
                    </td>
                    <td colspan="1" rowspan="2"
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:normal;overflow:visible;">
                    </td>
                    <td colspan="7" rowspan="2"
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:normal;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <span style="padding-left: 3.5em; text-decoration: underline; "><span class="print-value">{{ $spd->pejabat_instansi_perusahaan_nama }}</span></span>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <span style="padding-left: 3.5em; text-decoration: underline; "><span class="print-value">{{ $spd->pejabat_instansi_perusahaan_nama }}</span></span>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        @if($spd->pejabat_instansi_perusahaan_nip)<span style="padding-left: 3.5em; "><span class="print-value">NIP. {{ $spd->pejabat_instansi_perusahaan_nip }}</span></span>@endif
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td colspan="3"
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        @if($spd->pejabat_instansi_perusahaan_nip)<span style="padding-left: 3.5em; "><span class="print-value">NIP. {{ $spd->pejabat_instansi_perusahaan_nip }}</span></span>@endif
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        III.</td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Tiba di</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Berangkat dari</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Pada Tgl.</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Ke</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Kepala</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Pada Tanggal</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Kepala</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        IV.</td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Tiba di</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Berangkat dari</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Pada Tgl.</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Ke</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Kepala</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Pada Tanggal</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Kepala</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        V.</td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Tiba di</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Berangkat dari</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Pada Tgl.</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Ke</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Kepala</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Pada Tanggal</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Kepala</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:6.5pt;">
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        VI.</td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Tiba di</span><span class="value-col">: <span class="print-value">{{ $spd->berangkat_dari }}</span></span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td colspan="12" rowspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:top;text-align:left;white-space:normal;overflow:visible;">
                        Telah diperiksa keterangan bahwa perjalanan tersebut atas perintahnya dan semata-mata untuk
                        kepentingan jabatan dan waktu yang sesingkat-singkatnya.</td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        (Tempat Kedudukan)</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Pada Tgl.</span><span class="value-col">:
                                <span class="print-value">{{ $spd->tgl_kembali ? \Carbon\Carbon::parse($spd->tgl_kembali)->locale('id')->translatedFormat('d F Y') :'' }}</span></span></div>
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:center;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="5"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                        <span class="print-value">{{ $spd->exists ? ($spd->ppk ?? 'Pejabat Pembuat Komitmen') : '' }}</span></td>
                    <td colspan="2"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="10"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        <span class="print-value">{{ $spd->exists ? ($spd->ppk ?? 'Pejabat Pembuat Komitmen') : '' }}</span></td>
                </tr>
                <tr style="height:56.25pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="5"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td colspan="2"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="10"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:56.25pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="5"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td colspan="2"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="10"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="5"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                        <span style=""><span class="print-value">{{ $spd->nama_ppk }}</span></span></td>
                    <td colspan="2"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="10"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        <span style=""><span class="print-value">{{ $spd->nama_ppk }}</span></span></td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="5"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                        @if($spd->nip_ppk) <span style=""><span class="print-value">NIP. {{ $spd->nip_ppk }}</span></span>@endif</td>
                    <td colspan="2"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="10"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        @if($spd->nip_ppk) <span style=""><span class="print-value">NIP. {{ $spd->nip_ppk }}</span></span>@endif</td>
                </tr>
                <tr style="height:9.3pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="3"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="5"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td colspan="2"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="10"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;border-right:0.75pt solid #000;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:10.0pt;font-family:'Arial',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        VII.</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        Catatan lain-lain</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:8.9pt;">
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        VIII.</td>
                    <td colspan="2"
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        <div class="labelrow"><span class="label-col">Perhatian</span><span class="value-col">:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        PPK yang menerbitkan SPD pegawai yang melakukan perjalanan dinas, para pejabat yang mengesahkan
                        tanggal berangkat/tiba,</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        serta Bendahara Pengeluaran bertanggung jawab berdasarkan peraturan keuangan Negara apabila
                        Negara menderita rugi akibat</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
                <tr style="height:14.4pt;">
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:10.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        kesalahan, kelalaian dan kealpaannya.</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Calibri',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        function printA4() {
            document.body.classList.remove('paper-f4');
            document.body.classList.add('paper-a4');
            const styleEl = document.getElementById('page-style');
            if (styleEl) {
                styleEl.innerHTML = `@page { size: A4 portrait; margin: 8mm 10mm; }`;
            }
            window.print();
        }

        function printF4() {
            document.body.classList.remove('paper-a4');
            document.body.classList.add('paper-f4');
            // Try to set F4 page size — browser may or may not honour it.
            // Sheet height is fixed to 255mm so content always fits in 1 page
            // regardless of whether the physical paper is A4 or F4.
            const styleEl = document.getElementById('page-style');
            if (styleEl) {
                styleEl.innerHTML = `@page { size: 215mm 330mm portrait; margin: 8mm 10mm; }`;
            }
            window.print();
        }

        function toggleBorders() {
            const isHidden = document.body.classList.toggle('no-borders');
            const btn = document.getElementById('btnToggleBorders');
            if (isHidden) {
                btn.innerHTML = '📝 Tampilkan Garis Tabel';
                btn.style.backgroundColor = '#6366f1';
            } else {
                btn.innerHTML = '📝 Sembunyikan Garis Tabel';
                btn.style.backgroundColor = '#f59e0b';
            }
        }

        function toggleValuesOnly() {
            const isActive = document.body.classList.toggle('values-only');
            const btn = document.getElementById('btnValuesOnly');
            if (isActive) {
                btn.innerHTML = '🖊️ Tampilkan Semua (Normal)';
                btn.style.backgroundColor = '#059669';
                // Aktifkan juga no-borders agar garis juga hilang
                document.body.classList.add('no-borders');
            } else {
                btn.innerHTML = '🖊️ Mode Timpa (Isian Saja)';
                btn.style.backgroundColor = '#8b5cf6';
                document.body.classList.remove('no-borders');
                // Reset tombol garis juga
                const btnBorders = document.getElementById('btnToggleBorders');
                btnBorders.innerHTML = '📝 Sembunyikan Garis Tabel';
                btnBorders.style.backgroundColor = '#f59e0b';
            }
        }
    </script>
</body>

</html>
