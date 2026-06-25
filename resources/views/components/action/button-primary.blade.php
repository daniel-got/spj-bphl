@props(['type' => 'button'])

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'bg-primary hover:bg-primary-hover text-white font-medium py-2 px-5 rounded-md transition-colors duration-150']) }}
>
    {{ $slot }}
</button>
