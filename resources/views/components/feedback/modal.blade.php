@props([
    'id',
    'title'      => null,
    'size'       => 'md',  // sm | md | lg | xl
    'closeable'  => true,
])

@php
$sizeMap = [
    'sm' => 'max-w-sm',
    'md' => 'max-w-lg',
    'lg' => 'max-w-2xl',
    'xl' => 'max-w-4xl',
];
$maxW = $sizeMap[$size] ?? $sizeMap['md'];
@endphp

{{-- Overlay --}}
<div
    id="{{ $id }}"
    class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
    onclick="{{ $closeable ? 'if(event.target===this) document.getElementById(\''. $id .'\').classList.replace(\'flex\',\'hidden\').valueOf()&&document.getElementById(\''. $id .'\').classList.add(\'hidden\')' : '' }}"
    aria-modal="true"
    role="dialog"
>
    <div class="relative w-full {{ $maxW }} bg-white rounded-xl shadow-2xl" onclick="event.stopPropagation()">

        {{-- Header --}}
        @if($title || $closeable)
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                @if($title)
                    <h2 class="text-base font-semibold text-gray-900">{{ $title }}</h2>
                @else
                    <div></div>
                @endif
                @if($closeable)
                    <button
                        type="button"
                        onclick="document.getElementById('{{ $id }}').classList.add('hidden'); document.getElementById('{{ $id }}').classList.remove('flex')"
                        class="p-1 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                @endif
            </div>
        @endif

        {{-- Body --}}
        <div class="px-6 py-4">
            {{ $slot }}
        </div>

        {{-- Footer --}}
        @isset($footer)
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-2">
                {{ $footer }}
            </div>
        @endisset
    </div>
</div>

{{-- Helper script: buka modal dengan openModal('id') --}}
<script>
function openModal(id) {
    const el = document.getElementById(id);
    if(el) { el.classList.remove('hidden'); el.classList.add('flex'); }
}
function closeModal(id) {
    const el = document.getElementById(id);
    if(el) { el.classList.add('hidden'); el.classList.remove('flex'); }
}
</script>
