<!-- /resources/views/components/button/primary.blade.php -->
@props([
    'type' => 'button',
])
<x-button
    {{ $attributes->merge(['class' => 'bg-black hover:bg-gray-800 text-white font-medium py-2 px-5 rounded-md transition duration-150 ease-in-out']) }}>
    {{ $slot }}
</x-button>
