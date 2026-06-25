@props(['status'])

@php
$map = [
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
