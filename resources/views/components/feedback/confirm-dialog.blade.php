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
    <p class="text-sm text-gray-600">{{ $message }}</p>

    <x-slot:footer>
        <button
            type="button"
            onclick="closeModal('{{ $id }}')"
            class="px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors"
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
                    {{ $danger ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-gray-900 hover:bg-gray-800 text-white' }}"
            >
                {{ $confirmText }}
            </button>
        </form>
    </x-slot:footer>
</x-feedback.modal>
