@props([
    'name'        => 'q',
    'placeholder' => 'Cari...',
    'value'       => null,
    'action'      => null,
    'method'      => 'GET',
])

<form
    action="{{ $action ?? request()->url() }}"
    method="{{ strtoupper($method) === 'GET' ? 'GET' : 'POST' }}"
    role="search"
    {{ $attributes->only('class') }}
>
    @if(strtoupper($method) !== 'GET')
        @csrf
    @endif

    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            type="search"
            value="{{ old($name, $value ?? request($name)) }}"
            placeholder="{{ $placeholder }}"
            autocomplete="off"
            class="w-full pl-10 pr-4 py-2 text-sm border border-border-custom rounded-md shadow-sm bg-surface text-text-main
                focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary
                placeholder-muted"
        >
    </div>
</form>
