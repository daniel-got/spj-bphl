@props([
    'name',
    'label'       => null,
    'type'        => 'text',
    'placeholder' => null,
    'value'       => null,
    'required'    => false,
    'disabled'    => false,
    'error'       => null,
    'hint'        => null,
])

<div {{ $attributes->only('class')->merge(['class' => 'flex flex-col gap-1']) }}>
    @if($label)
        <label for="{{ $name }}" class="text-sm font-medium text-gray-700">
            {{ $label }}
            @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $required  ? 'required'  : '' }}
        {{ $disabled  ? 'disabled'  : '' }}
        {{ $attributes->except(['class', 'name', 'type', 'value', 'placeholder', 'required', 'disabled']) }}
        class="w-full px-3 py-2 text-sm border rounded-md shadow-sm placeholder-gray-400
            focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900
            disabled:bg-gray-50 disabled:text-gray-500 disabled:cursor-not-allowed
            {{ $error ? 'border-red-400 focus:ring-red-400' : 'border-gray-300' }}"
    >

    @if($error)
        <p class="text-xs text-red-500">{{ $error }}</p>
    @elseif($hint)
        <p class="text-xs text-gray-400">{{ $hint }}</p>
    @endif
</div>
