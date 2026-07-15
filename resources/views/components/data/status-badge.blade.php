@props(['status'])

@php
$map = [
    // Database statuses (Indonesian)
    'diajukan'  => ['label' => 'Diajukan',    'color' => 'info'],
    'disetujui' => ['label' => 'Disetujui',   'color' => 'success'],
    'direvisi'  => ['label' => 'Direvisi',    'color' => 'warning'],
    'ditolak'   => ['label' => 'Ditolak',     'color' => 'danger'],
    'selesai'   => ['label' => 'Selesai',     'color' => 'success'],

    // Dynamic progress statuses
    'dalam_pembuatan_spd'     => ['label' => 'Dalam Pembuatan SPD',     'color' => 'primary'],
    'dalam_pembuatan_rincian' => ['label' => 'Dalam Pembuatan Rincian', 'color' => 'info'],
    'pengajuan_spj'           => ['label' => 'Pengajuan SPJ',           'color' => 'warning'],
    
    // SPT/SPD statuses
    'draft'     => ['label' => 'Draft',       'color' => 'gray'],
    'pending'   => ['label' => 'Menunggu',    'color' => 'warning'],
    'approved'  => ['label' => 'Disetujui',   'color' => 'success'],
    'rejected'  => ['label' => 'Ditolak',     'color' => 'danger'],
    'active'    => ['label' => 'Aktif',       'color' => 'primary'],
    'inactive'  => ['label' => 'Nonaktif',    'color' => 'gray'],
    'completed' => ['label' => 'Selesai',     'color' => 'success'],
    'cancelled' => ['label' => 'Dibatalkan',  'color' => 'danger'],
    'ongoing'   => ['label' => 'Berlangsung', 'color' => 'info'],
];

$config = $map[$status] ?? ['label' => ucfirst($status), 'color' => 'gray'];
@endphp

<x-data.badge :label="$config['label']" :color="$config['color']" {{ $attributes }} />
