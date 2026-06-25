@props(['type' => 'button'])

<button
    type="{{ $type }}"
    {{ $attributes->class([
        'inline-flex items-center justify-center border font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition duration-150 ease-in-out',
    ]) }}
>
    {{ $slot }}
</button>
