@props([
    'label',
    'color' => 'primary', // primary | secondary | success | warning | danger | info | gray
])

@php
$colorMap = [
    'primary'   => 'bg-primary-light text-primary',
    'secondary' => 'bg-secondary-light text-secondary',
    'success'   => 'bg-green-100 text-success',
    'warning'   => 'bg-yellow-100 text-warning',
    'danger'    => 'bg-red-100 text-danger',
    'info'      => 'bg-blue-100 text-info',
    'gray'      => 'bg-background text-muted',
];
$classes = $colorMap[$color] ?? $colorMap['gray'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium $classes"]) }}>
    {{ $label }}
</span>