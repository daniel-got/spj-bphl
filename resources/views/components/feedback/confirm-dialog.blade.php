@props([
    'id',
    'title'       => 'Konfirmasi',
    'message'     => 'Apakah kamu yakin ingin melanjutkan tindakan ini?',
    'confirmText' => 'Ya, Lanjutkan',
    'cancelText'  => 'Batal',
    'action'      => '#',
    'method'      => 'POST',
    'danger'      => true,
])

<x-feedback.modal :id="$id" :title="$title" size="sm">
    <p class="text-sm text-muted">{{ $message }}</p>

    <x-slot:footer>
        <button
            type="button"
            onclick="closeModal('{{ $id }}')"
            class="px-4 py-2 text-sm font-medium text-text-main border border-border-custom rounded-md hover:bg-background transition-colors"
        >
            {{ $cancelText }}
        </button>

        <form action="{{ $action }}" method="POST" class="inline">
            @csrf
            @if(strtoupper($method) !== 'POST')
                @method($method)
            @endif
            <button
                type="submit"
                class="px-4 py-2 text-sm font-medium rounded-md transition-colors
                    {{ $danger ? 'bg-danger hover:opacity-90 text-white' : 'bg-primary hover:bg-primary-hover text-white' }}"
            >
                {{ $confirmText }}
            </button>
        </form>
    </x-slot:footer>
</x-feedback.modal>
