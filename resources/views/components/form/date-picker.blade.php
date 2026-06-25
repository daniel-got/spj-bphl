@props([
    'name',
    'label'    => null,
    'value'    => null,
    'required' => false,
    'disabled' => false,
    'error'    => null,
    'hint'     => null,
])

<div {{ $attributes->only('class')->merge(['class' => 'flex flex-col gap-1']) }}>
    @if($label)
        <label for="{{ $name }}" class="text-sm font-medium text-text-main">
            {{ $label }}
            @if($required) <span class="text-danger">*</span> @endif
        </label>
    @endif

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="date"
        value="{{ old($name, $value) }}"
        {{ $required  ? 'required'  : '' }}
        {{ $disabled  ? 'disabled'  : '' }}
        {{ $attributes->except(['class', 'name', 'type', 'value', 'required', 'disabled']) }}
        class="w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-surface text-text-main
            focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary
            disabled:bg-background disabled:text-muted disabled:cursor-not-allowed
            {{ $error ? 'border-danger focus:ring-danger' : 'border-border-custom' }}"
    >

    @if($error)
        <p class="text-xs text-danger">{{ $error }}</p>
    @elseif($hint)
        <p class="text-xs text-muted">{{ $hint }}</p>
    @endif
</div>
