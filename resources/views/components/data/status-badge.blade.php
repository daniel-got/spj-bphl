@props(['status'])

@php
$map = [
    // SPT/SPD statuses
    'draft'     => ['label' => 'Draft',     'color' => 'gray'],
    'pending'   => ['label' => 'Menunggu',  'color' => 'yellow'],
    'approved'  => ['label' => 'Disetujui', 'color' => 'green'],
    'rejected'  => ['label' => 'Ditolak',   'color' => 'red'],
    'active'    => ['label' => 'Aktif',     'color' => 'blue'],
    'inactive'  => ['label' => 'Nonaktif',  'color' => 'gray'],
    'completed' => ['label' => 'Selesai',   'color' => 'green'],
    'cancelled' => ['label' => 'Dibatalkan','color' => 'red'],
    'ongoing'   => ['label' => 'Berlangsung','color' => 'blue'],
];

$config = $map[$status] ?? ['label' => ucfirst($status), 'color' => 'gray'];
@endphp

<x-data.badge :label="$config['label']" :color="$config['color']" {{ $attributes }} />
