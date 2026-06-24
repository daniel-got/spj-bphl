@props(['title', 'value', 'description' => ''])

<div class="bg-white border border-gray-200 rounded-lg p-8 shadow-sm min-w-[250px]">
    <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">
        {{ $title }}
    </h2>
    <div class="text-5xl font-black text-black">
        {{ $value }}
    </div>
    @if($description)
        <p class="text-sm text-gray-500 mt-2">{{ $description }}</p>
    @endif
</div>
