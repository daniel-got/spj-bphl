@props([
    'name',
    'label'    => null,
    'options'  => [], // ['value' => 'label'] atau [['value'=>'', 'label'=>'']]
    'selected' => null,
    'required' => false,
    'disabled' => false,
    'error'    => null,
    'hint'     => null,
    'placeholder' => 'Pilih salah satu',
])

<div {{ $attributes->only('class')->merge(['class' => 'flex flex-col gap-1']) }}>
    @if($label)
        <label for="{{ $name }}" class="text-sm font-medium text-gray-700">
            {{ $label }}
            @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        class="w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-white
            focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900
            disabled:bg-gray-50 disabled:text-gray-500 disabled:cursor-not-allowed
            {{ $error ? 'border-red-400 focus:ring-red-400' : 'border-gray-300' }}"
    >
        <option value="" disabled {{ !old($name, $selected) ? 'selected' : '' }}>{{ $placeholder }}</option>

        @foreach($options as $optValue => $optLabel)
            @if(is_array($optLabel))
                <option value="{{ $optLabel['value'] }}"
                    {{ old($name, $selected) == $optLabel['value'] ? 'selected' : '' }}>
                    {{ $optLabel['label'] }}
                </option>
            @else
                <option value="{{ $optValue }}"
                    {{ old($name, $selected) == $optValue ? 'selected' : '' }}>
                    {{ $optLabel }}
                </option>
            @endif
        @endforeach
    </select>

    @if($error)
        <p class="text-xs text-red-500">{{ $error }}</p>
    @elseif($hint)
        <p class="text-xs text-gray-400">{{ $hint }}</p>
    @endif
</div>
