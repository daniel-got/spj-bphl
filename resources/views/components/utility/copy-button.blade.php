@props([
    'value',              // teks yang akan disalin
    'label' => 'Salin',  // teks tombol
])

<button
    type="button"
    onclick="
        navigator.clipboard.writeText({{ json_encode($value) }}).then(() => {
            const btn = this;
            const original = btn.innerHTML;
            btn.innerHTML = '<svg class=\'w-4 h-4\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M5 13l4 4L19 7\'/></svg><span>Tersalin!</span>';
            btn.disabled = true;
            setTimeout(() => { btn.innerHTML = original; btn.disabled = false; }, 2000);
        });
    "
    {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-medium text-text-main border border-border-custom rounded-md hover:bg-background transition-colors disabled:opacity-50']) }}
>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
    </svg>
    <span>{{ $label }}</span>
</button>
