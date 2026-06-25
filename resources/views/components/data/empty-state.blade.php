@props([
    'title'       => 'Belum ada data',
    'description' => null,
    'icon'        => 'inbox',
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center py-12 text-center']) }}>
    <div class="w-14 h-14 rounded-full bg-primary-light flex items-center justify-center mb-4">
        <x-utility.icon :name="$icon" class="w-7 h-7 text-primary" />
    </div>
    <h3 class="text-sm font-semibold text-text-main">{{ $title }}</h3>
    @if($description)
        <p class="mt-1 text-sm text-muted max-w-xs">{{ $description }}</p>
    @endif
    @isset($actions)
        <div class="mt-4">{{ $actions }}</div>
    @endisset
</div>
