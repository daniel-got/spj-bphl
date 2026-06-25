@props(['type' => 'button'])

<x-action.button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'bg-black hover:bg-gray-800 text-white font-medium py-2 px-5']) }}
>
    {{ $slot }}
</x-action.button>
