<!doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{ $title ?? 'Cetak Dokumen' }}</title>
        <style>
            body {
                font-family: "Calibri", "Arial", sans-serif;
                font-size: 14px;
                color: #000;
                background-color: #fff;
                padding: 20px;
                line-height: 1.3;
            }
            .container {
                max-width: 800px;
                margin: 0 auto;
            }
            .header-title {
                text-align: center;
                font-weight: bold;
                font-size: 16px;
                text-decoration: underline;
                margin-bottom: 20px;
            }
            .meta-info {
                margin-bottom: 20px;
            }
            .meta-info table {
                border: none;
                width: auto;
            }
            .meta-info td {
                padding: 2px 5px 2px 0;
                vertical-align: top;
            }
            .main-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 10px;
            }
            .main-table th,
            .main-table td {
                border: 1px solid #000;
                padding: 6px 10px;
                vertical-align: top;
            }
            .main-table th {
                text-align: center;
                font-weight: bold;
            }
            .text-center {
                text-align: center;
            }
            .text-right {
                text-align: right;
            }
            .terbilang {
                font-style: italic;
                margin-bottom: 30px;
            }
            .signature-section {
                width: 100%;
                border: none;
                margin-top: 10px;
            }
            .signature-section td {
                width: 50%;
                border: none;
                padding: 0 5px;
                vertical-align: top;
            }
            .signature-space {
                height: 70px;
            }
            .bold-name {
                font-weight: bold;
                text-decoration: underline;
            }
            .divider {
                border-bottom: 2px solid #000;
                margin: 30px 0 20px 0;
            }
            .rampung-section {
                margin-top: 20px;
            }
            .rampung-table td {
                padding: 4px 0;
                vertical-align: top;
                border: none;
            }
            
            @media print {
                body {
                    padding: 0;
                }
                .container {
                    width: 100%;
                    max-width: none;
                }
                @page {
                    size: auto;
                    margin: 1.5cm;
                }
            }
        </style>
    </head>
    <body>
        {{ $slot }}

        <script>
            // Cetak dikendalikan oleh tombol di dalam halaman (A4/F4)
        </script>
    </body>
</html>
