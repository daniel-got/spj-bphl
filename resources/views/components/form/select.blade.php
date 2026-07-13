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
        <label for="{{ $name }}" class="text-sm font-medium text-text-main">
            {{ $label }}
            @if($required) <span class="text-danger">*</span> @endif
        </label>
    @endif

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->except('class') }}
        class="w-full h-10 px-3 py-2 text-sm border rounded-md shadow-sm bg-surface text-text-main
            focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary
            disabled:bg-background disabled:text-muted disabled:cursor-not-allowed
            {{ $error ? 'border-danger focus:ring-danger' : 'border-border-custom' }}"
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
        <p class="text-xs text-danger">{{ $error }}</p>
    @elseif($hint)
        <p class="text-xs text-muted">{{ $hint }}</p>
    @endif
</div>
