@props([
    'name',
    'label'       => null,
    'placeholder' => null,
    'value'       => null,
    'rows'        => 3,
    'required'    => false,
    'disabled'    => false,
    'error'       => null,
    'hint'        => null,
])

<div {{ $attributes->only('class')->merge(['class' => 'flex flex-col gap-1']) }}>
    @if($label)
        <label for="{{ $name }}" class="text-sm font-medium text-text-main">
            {{ $label }}
            @if($required) <span class="text-danger">*</span> @endif
        </label>
    @endif

    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $required  ? 'required'  : '' }}
        {{ $disabled  ? 'disabled'  : '' }}
        {{ $attributes->except(['class', 'name', 'rows', 'value', 'placeholder', 'required', 'disabled']) }}
        class="w-full px-3 py-2 text-sm border rounded-md shadow-sm placeholder-muted bg-surface text-text-main
            focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary
            disabled:bg-background disabled:text-muted disabled:cursor-not-allowed
            {{ $error ? 'border-danger focus:ring-danger' : 'border-border-custom' }}"
    >{{ old($name, $value) }}</textarea>

    @if($error)
        <p class="text-xs text-danger">{{ $error }}</p>
    @elseif($hint)
        <p class="text-xs text-muted">{{ $hint }}</p>
    @endif
</div>
