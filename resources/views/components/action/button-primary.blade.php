@props(['type' => 'button'])

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'bg-primary hover:bg-primary-hover text-white font-medium h-10 px-5 rounded-md transition-colors duration-150 flex items-center justify-center']) }}
>
    {{ $slot }}
</button>
