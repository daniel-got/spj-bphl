@props([
    'name',
    'label'    => null,
    'accept'   => null,   // misal: '.pdf,.docx'
    'multiple' => false,
    'required' => false,
    'disabled' => false,
    'error'    => null,
    'hint'     => null,
    'maxSize'  => '10MB',
])

<div {{ $attributes->only('class')->merge(['class' => 'flex flex-col gap-1']) }}>
    @if($label)
        <label for="{{ $name }}" class="text-sm font-medium text-text-main">
            {{ $label }}
            @if($required) <span class="text-danger">*</span> @endif
        </label>
    @endif

    <label
        for="{{ $name }}"
        class="flex flex-col items-center justify-center w-full px-4 py-8 border-2 border-dashed rounded-lg cursor-pointer
            transition-colors duration-150
            {{ $error ? 'border-danger bg-red-50 hover:bg-red-100' : 'border-border-custom bg-surface hover:bg-background' }}
            {{ $disabled ? 'cursor-not-allowed opacity-50' : '' }}"
    >
        <svg class="w-8 h-8 text-muted mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
        </svg>
        <p class="text-sm text-muted">
            <span class="font-medium text-text-main">Klik untuk upload</span> atau seret file ke sini
        </p>
        @if($accept)
            <p class="text-xs text-muted mt-1">Format: {{ $accept }} &bull; Maks. {{ $maxSize }}</p>
        @endif
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            type="file"
            accept="{{ $accept }}"
            {{ $multiple  ? 'multiple'  : '' }}
            {{ $required  ? 'required'  : '' }}
            {{ $disabled  ? 'disabled'  : '' }}
            class="sr-only"
        >
    </label>

    @if($error)
        <p class="text-xs text-danger">{{ $error }}</p>
    @elseif($hint)
        <p class="text-xs text-muted">{{ $hint }}</p>
    @endif
</div>
