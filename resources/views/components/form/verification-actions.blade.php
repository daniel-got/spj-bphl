@props([
    'actionUrl' => '',
    'currentStatus' => 'diajukan',
    'catatan' => ''
])

<form action="{{ $actionUrl }}" method="POST" class="mt-8 border-t border-border-custom pt-6">
    @csrf
    @method('PUT')

    <div class="mb-6">
        <x-form.textarea
            name="catatan_verifikator"
            label="Catatan Verifikasi"
            hint="Wajib diisi jika revisi/tolak"
            :value="old('catatan_verifikator', $catatan)"
            placeholder="Tuliskan catatan perbaikan atau alasan penolakan di sini..."
            :rows="3"
            :error="$errors->first('catatan_verifikator')"
        />
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <input type="hidden" name="status" id="status_action" value="">

        <x-action.button type="submit" onclick="document.getElementById('status_action').value='disetujui'"
            class="bg-success hover:opacity-90 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors duration-150 shadow-sm flex items-center">
            <x-utility.icon name="check-circle" class="w-5 h-5 mr-2" />
            Setujui Dokumen
        </x-action.button>

        <x-action.button type="submit" onclick="document.getElementById('status_action').value='direvisi'"
            class="bg-warning hover:opacity-90 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors duration-150 shadow-sm flex items-center">
            <x-utility.icon name="pencil" class="w-5 h-5 mr-2" />
            Kembalikan (Revisi)
        </x-action.button>

        <x-action.button type="submit" onclick="document.getElementById('status_action').value='ditolak'"
            class="bg-danger hover:opacity-90 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors duration-150 shadow-sm flex items-center">
            <x-utility.icon name="x-circle" class="w-5 h-5 mr-2" />
            Tolak Dokumen
        </x-action.button>
    </div>
</form>
