<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Lampiran Rincian Biaya - {{ $rincian->nomor_spd }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @page {
            size: A4;
            margin: 1cm;
        }
        body {
            background: #fff;
            color: #000;
        }
        .page-break {
            page-break-after: always;
        }
        .page-break:last-child {
            page-break-after: auto;
        }
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-900">
    <div class="no-print p-4 bg-white shadow-sm flex justify-between items-center fixed top-0 left-0 right-0 z-50">
        <div>
            <h1 class="font-bold text-lg">Lampiran: {{ $rincian->nomor_spd }}</h1>
            <p class="text-sm text-gray-600">Total: {{ count($lampirans) }} Lampiran</p>
        </div>
        <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700">
            Cetak Dokumen
        </button>
    </div>

    <div class="mt-20 print:mt-0">
        @if(count($lampirans) == 0)
            <div class="max-w-4xl mx-auto p-8 bg-white shadow text-center">
                <p class="text-gray-500">Tidak ada lampiran untuk rincian ini.</p>
            </div>
        @else
            @foreach($lampirans as $lampiran)
                <div class="page-break w-[210mm] min-h-[297mm] mx-auto bg-white print:w-auto print:min-h-0 print:shadow-none shadow-md mb-8 p-8 relative flex flex-col items-center justify-center">
                    <div class="absolute top-4 left-4 text-xs text-gray-500 print:text-black font-semibold">
                        SPJ: {{ $rincian->nomor_spd }} | Kategori: {{ $lampiran['tipe'] }}
                    </div>
                    
                    @php
                        $ext = strtolower(pathinfo($lampiran['path'], PATHINFO_EXTENSION));
                    @endphp
                    
                    @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                        <img src="{{ $lampiran['url'] }}" class="max-w-full max-h-[270mm] object-contain" alt="Lampiran">
                    @else
                        <div class="text-center p-8 border border-dashed border-gray-400">
                            <p class="font-bold mb-2">Lampiran Format {{ strtoupper($ext) }}</p>
                            <p class="text-sm text-gray-600 mb-4">Format file ini mungkin tidak dapat dirender langsung di halaman cetak.</p>
                            <a href="{{ $lampiran['url'] }}" target="_blank" class="text-blue-600 underline text-sm no-print">Buka / Unduh File</a>
                            <p class="text-xs text-gray-400 mt-2 print:block hidden">URL Lampiran: {{ $lampiran['url'] }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</body>
</html>
