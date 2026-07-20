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

        /* Enable dynamic row scaling */
        tr {
            height: auto !important;
        }

        /* Override the extremely tall signature spacer rows from Excel template */
        tr[style*="56.25pt"] {
            height: 5pt !important;
        }

        td,
        span,
        div,
        tr,
        p {
            font-size: 9.5pt !important;
            line-height: 1.2 !important;
        }

        td {
            padding: 2.5px 4px !important;
            vertical-align: bottom;
            overflow: hidden;
            word-wrap: break-word;
        }

        .labelrow {
            display: flex;
            justify-content: flex-start;
            width: 100%;
        }

        .labelrow span:first-child {
            display: inline-block;
            width: 75pt;
        }

        .sheet {
            page-break-after: always !important;
            page-break-inside: avoid !important;
            width: 100%;
            overflow: hidden;
            box-sizing: border-box;
        }

        .sheet:last-child {
            page-break-after: auto !important;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            /* Use vh to adapt exactly to the printable area of the physical page without overflowing */
            body.paper-a4 .sheet {
                height: 99vh;
                max-height: 99vh;
            }

            body.paper-a4 * {
                font-size: 8pt !important;
                line-height: 1.1 !important;
            }

            body.paper-a4 td {
                padding: 1.5px 3px !important;
            }

            body.paper-a4 tr[style*="56.25pt"] {
                height: 5pt !important;
            }

            body.paper-f4 .sheet {
                height: 99vh;
                max-height: 99vh;
            }

            body.paper-f4 * {
                font-size: 8pt !important;
                line-height: 1.1 !important;
            }

            body.paper-f4 td {
                padding: 1.5px 3px !important;
            }

            body.paper-f4 tr[style*="56.25pt"] {
                height: 5pt !important;
            }
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
            style="padding: 8px 16px; background-color: #10b981; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">🖨️
            Cetak (F4)</button>
        <p style="font-size: 12px; color: #64748b; margin-top: 8px;">Pilih ukuran kertas sebelum mencetak. Jendela cetak
            akan otomatis terbuka.</p>
    </div>
    <div class="sheet">
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
                        <div class="labelrow"><span>Lembar Ke</span><span>:</span></div>
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
                        <div class="labelrow"><span>Kode No.</span><span>:</span></div>
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
                        <div class="labelrow"><span>Nomor </span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:nowrap;overflow:visible;">
                        {{ $spd->nomor_spd }}</td>
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
                        {{ $spd->ppk ?? 'Pejabat Pembuat Komitmen' }}</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        {{ $spd->pegawai_ditugaskan }} / NIP. {{ $spd->nip_pegawai }}</td>
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
                        a. {{ $spd->pangkat_pegawai ?? '-' }}</td>
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
                        b. {{ $spd->jabatan_pegawai ?? '-' }}</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        {{ $spd->tujuan_kegiatan }}</td>
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
                        {{ is_array($spd->alat_angkut) ? implode(', ', $spd->alat_angkut) : $spd->alat_angkut }}</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        a. {{ $spd->berangkat_dari }}</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        {{ is_array($spd->tempat_tujuan) ? implode(', ', $spd->tempat_tujuan) : $spd->tempat_tujuan }}
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        a. {{ $spd->lama_kegiatan }} Hari</td>
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
                        {{ $spd->tgl_berangkat ? \Carbon\Carbon::parse($spd->tgl_berangkat)->locale('id')->translatedFormat('d F Y') : '-' }}
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
                        {{ $spd->tgl_kembali ? \Carbon\Carbon::parse($spd->tgl_kembali)->locale('id')->translatedFormat('d F Y') : '-' }}
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
                        a. Instansi </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        a. BPHL Wilayah IV Jambi</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        style="border-bottom:0.75pt solid #000;border-right:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="border-bottom:0.75pt solid #000;font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:middle;white-space:nowrap;overflow:visible;">
                        b. Akun</td>
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
                        b. {{ $spd->kode_mak }}</td>
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
                        <div class="labelrow"><span>Dikeluarkan di </span><span>: {{ $spd->berangkat_dari }}</span>
                        </div>
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
                        <div class="labelrow"><span>Tanggal </span><span>:
                                {{ $spd->tgl_spd ? \Carbon\Carbon::parse($spd->tgl_spd)->locale('id')->translatedFormat('d F Y') : '-' }}</span>
                        </div>
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
                        {{ $spd->ppk ?? 'Pejabat Pembuat Komitmen' }}</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        {{ $spd->nama_ppk }}</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        NIP. {{ $spd->nip_ppk }}</td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
    <div class="sheet">
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
                        <div class="labelrow"><span>Berangkat dari</span><span>: {{ $spd->berangkat_dari }}</span>
                        </div>
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
                        (Tempat Kedudukan)</td>
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
                        <div class="labelrow"><span>Pada tanggal</span><span>:
                                {{ $spd->tgl_berangkat ? \Carbon\Carbon::parse($spd->tgl_berangkat)->locale('id')->translatedFormat('d F Y') : '-' }}</span>
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
                        <div class="labelrow"><span>Ke</span><span>:
                                {{ is_array($spd->tempat_tujuan) ? implode(', ', $spd->tempat_tujuan) : $spd->tempat_tujuan }}</span>
                        </div>
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
    <div class="labelrow"><span>Kepala</span><span>: {{ $spd->kepala_seksi_jabatan }}</span></div>
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
                        <span style="padding-left: 3.5em; text-decoration: underline;">{{ $spd->kepala_seksi_nama }}</span>
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
                        <span style="padding-left: 3.5em;">NIP. {{ $spd->kepala_seksi_nip }}</span>
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
                        <div class="labelrow"><span>Tiba di</span><span>:
                                                            {{ is_array($spd->tempat_tujuan) ? implode(', ', $spd->tempat_tujuan) : $spd->tempat_tujuan }}</span>
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
                        <div class="labelrow"><span>Berangkat dari</span><span>:
                                                            {{ is_array($spd->tempat_tujuan) ? implode(', ', $spd->tempat_tujuan) : $spd->tempat_tujuan }}</span>
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
                        <div class="labelrow"><span>Pada Tgl.</span><span>: {{ $spd->tgl_berangkat ? \Carbon\Carbon::parse($spd->tgl_berangkat)->locale('id')->translatedFormat('d F Y') : '-' }}</span></div>
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
                        <div class="labelrow"><span>Ke</span><span>:{{ is_array($spd->berangkat_dari) ? implode(', ', $spd->berangkat_dari) : $spd->berangkat_dari }}</span></div>
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
                        <div class="labelrow"><span>Kepala</span><span>:{{$spd->pejabat_instansi_perusahaan}}</span></div>
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
                        <div class="labelrow"><span>Pada Tanggal</span><span>:{{ $spd->tgl_kembali ? \Carbon\Carbon::parse($spd->tgl_kembali)->locale('id')->translatedFormat('d F Y') : '-' }}</span></div>
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

                        <div class="labelrow"><span>Kepala</span><span>: {{ $spd->pejabat_instansi_perusahaan }}</span></div>
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
                        <span style="padding-left: 3.5em; text-decoration: underline;">{{ $spd->pejabat_instansi_perusahaan_nama }}</span>
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
                        <span style="padding-left: 3.5em; text-decoration: underline;">{{ $spd->pejabat_instansi_perusahaan_nama }}</span>
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
                        @if($spd->pejabat_instansi_perusahaan_nip)<span style="padding-left: 3.5em;">NIP. {{ $spd->pejabat_instansi_perusahaan_nip }}</span>@endif
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
                        @if($spd->pejabat_instansi_perusahaan_nip)<span style="padding-left: 3.5em;">NIP. {{ $spd->pejabat_instansi_perusahaan_nip }}</span>@endif
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
                        <div class="labelrow"><span>Tiba di</span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        <div class="labelrow"><span>Berangkat dari</span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        <div class="labelrow"><span>Pada Tgl.</span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        <div class="labelrow"><span>Ke</span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        <div class="labelrow"><span>Kepala</span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        <div class="labelrow"><span>Pada Tanggal</span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        <div class="labelrow"><span>Kepala</span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        <div class="labelrow"><span>Tiba di</span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        <div class="labelrow"><span>Berangkat dari</span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        <div class="labelrow"><span>Pada Tgl.</span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        <div class="labelrow"><span>Ke</span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        <div class="labelrow"><span>Kepala</span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        <div class="labelrow"><span>Pada Tanggal</span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        <div class="labelrow"><span>Kepala</span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        <div class="labelrow"><span>Tiba di</span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        <div class="labelrow"><span>Berangkat dari</span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        <div class="labelrow"><span>Pada Tgl.</span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        <div class="labelrow"><span>Ke</span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        <div class="labelrow"><span>Kepala</span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        <div class="labelrow"><span>Pada Tanggal</span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        <div class="labelrow"><span>Kepala</span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        <div class="labelrow"><span>Tiba di</span><span>: {{ $spd->berangkat_dari }}</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;text-align:left;white-space:normal;overflow:visible;">
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
                        <div class="labelrow"><span>Pada Tgl.</span><span>:
                                {{ $spd->tgl_kembali ? \Carbon\Carbon::parse($spd->tgl_kembali)->locale('id')->translatedFormat('d F Y') : '-' }}</span>
                        </div>
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
                        {{ $spd->ppk ?? 'Pejabat Pembuat Komitmen' }}</td>
                    <td colspan="2"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="10"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        {{ $spd->ppk ?? 'Pejabat Pembuat Komitmen' }}</td>
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
                        {{ $spd->nama_ppk }}</td>
                    <td colspan="2"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="10"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        {{ $spd->nama_ppk }}</td>
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
                        NIP. {{ $spd->nip_ppk }}</td>
                    <td colspan="2"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td colspan="10"
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                        NIP. {{ $spd->nip_ppk }}</td>
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
                        <div class="labelrow"><span>Perhatian</span><span>:</span></div>
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
                        style="font-size:11.0pt;font-family:'Tahoma',Arial,sans-serif;vertical-align:bottom;white-space:nowrap;overflow:visible;">
                    </td>
                    <td
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
    </script>
</body>

</html>
