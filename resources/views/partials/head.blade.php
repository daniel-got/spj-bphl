<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="{{ $description ?? 'Sistem Informasi Perjalanan Dinas - BPHL Wilayah IV Jambi' }}">
<title>{{ $title ?? 'SPJ BPHL 4 Jambi' }}</title>

{{-- Favicon --}}
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<link rel="icon" type="image/png"    href="{{ asset('favicon.png') }}" sizes="32x32">
<link rel="apple-touch-icon"         href="{{ asset('favicon.png') }}" sizes="180x180">

{{-- Vite Assets --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])
