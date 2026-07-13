<x-layout.app title="Master Surat Dasar">
    <div class="flex">
        <x-layout.sidebar />

        <main class="flex-1 p-6 bg-background min-h-screen">
            <x-layout.breadcrumb :items="[['label' => 'Admin'], ['label' => 'Master Surat Dasar']]" />

            <x-layout.page-header
                title="Master Surat Dasar"
                description="Kelola daftar surat dasar / acuan yang tersedia sebagai pilihan di form SPT."
            >
                <x-slot:actions>
                    {{-- Sinkron dari SPT Lama --}}
                    <form method="POST" action="{{ route('admin.surat-dasar.sinkron') }}" class="inline">
                        @csrf
                        <x-action.button type="submit"
                            class="border border-border-custom text-text-main hover:bg-background px-4 py-2 text-sm rounded-md transition-colors flex items-center gap-2">
                            <x-utility.icon name="arrow-path" class="w-4 h-4" />
                            Sinkron dari SPT
                        </x-action.button>
                    </form>
                    <x-action.button-primary onclick="openModal('modal-tambah')" class="flex items-center gap-2">
                        <x-utility.icon name="plus" class="w-4 h-4" />
                        Tambah Surat Dasar
                    </x-action.button-primary>
                </x-slot:actions>
            </x-layout.page-header>

            {{-- Flash Messages --}}
            <div class="mt-4">
                @if (session('success'))
                    <x-feedback.alert type="success" title="Berhasil" :dismissible="true">
                        {{ session('success') }}
                    </x-feedback.alert>
                @endif
                @if ($errors->any())
                    <x-feedback.alert type="error" title="Validasi Gagal" :dismissible="true">
                        <ul class="list-disc pl-4 space-y-1 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-feedback.alert>
                @endif
            </div>

            {{-- Filter & Tabel --}}
            <x-layout.card class="mt-6">
                <x-slot:header>
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 px-6 py-4 border-b border-border-custom bg-surface">
                        <h3 class="text-lg font-semibold text-text-main">Daftar Surat Dasar</h3>
                        <form method="GET" action="{{ route('admin.surat-dasar.index') }}" class="flex gap-2 w-full sm:w-auto">
                            <x-form.search name="search" placeholder="Cari teks surat dasar..." :value="request('search')" />
                        </form>
                    </div>
                </x-slot:header>

                <div class="p-0">
                    @if ($suratDasars->isEmpty())
                        <x-data.empty-state
                            title="Belum ada surat dasar"
                            description="Tambahkan surat dasar baru atau sinkronkan dari data SPT yang sudah ada."
                        >
                            <x-slot:action>
                                <x-action.button-primary onclick="openModal('modal-tambah')">
                                    + Tambah Surat Dasar
                                </x-action.button-primary>
                            </x-slot:action>
                        </x-data.empty-state>
                    @else
                        <table class="w-full text-sm text-left">
                            <thead class="border-b border-border-custom bg-background/50">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider w-8">#</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Teks Surat Dasar</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider text-center w-28">Status</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider text-center w-40">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-custom">
                                @foreach ($suratDasars as $index => $item)
                                    <tr class="hover:bg-background/40 transition-colors group">
                                        <td class="px-6 py-4 text-muted text-xs">
                                            {{ $suratDasars->firstItem() + $index }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-text-main text-sm leading-relaxed line-clamp-2 max-w-2xl">
                                                {{ $item->teks }}
                                            </p>
                                            <p class="text-xs text-muted mt-1">
                                                Ditambahkan {{ $item->created_at->diffForHumans() }}
                                            </p>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($item->aktif)
                                                <x-data.badge label="Aktif" color="green" />
                                            @else
                                                <x-data.badge label="Nonaktif" color="gray" />
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-1">
                                                {{-- Edit --}}
                                                <button
                                                    type="button"
                                                    title="Edit"
                                                    onclick="openEditModal({{ $item->id }}, {{ json_encode($item->teks) }}, {{ $item->aktif ? 'true' : 'false' }})"
                                                    class="p-1.5 rounded text-muted hover:text-primary hover:bg-primary-light transition-colors">
                                                    <x-utility.icon name="pencil" class="w-4 h-4" />
                                                </button>

                                                {{-- Toggle Aktif --}}
                                                <form method="POST" action="{{ route('admin.surat-dasar.toggle', $item) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        title="{{ $item->aktif ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                        class="p-1.5 rounded transition-colors {{ $item->aktif ? 'text-warning hover:bg-warning/10' : 'text-success hover:bg-success/10' }}">
                                                        <x-utility.icon name="{{ $item->aktif ? 'eye-slash' : 'eye' }}" class="w-4 h-4" />
                                                    </button>
                                                </form>

                                                {{-- Hapus --}}
                                                <button
                                                    type="button"
                                                    title="Hapus"
                                                    onclick="openModal('confirm-hapus-{{ $item->id }}')"
                                                    class="p-1.5 rounded text-muted hover:text-danger hover:bg-danger/10 transition-colors">
                                                    <x-utility.icon name="trash" class="w-4 h-4" />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Confirm Hapus Dialog per baris --}}
                                    <x-feedback.confirm-dialog
                                        id="confirm-hapus-{{ $item->id }}"
                                        title="Hapus Surat Dasar?"
                                        message="Tindakan ini permanen. Surat dasar ini tidak akan bisa dipilih lagi di form SPT."
                                        confirm-label="Ya, Hapus"
                                        cancel-label="Batal"
                                        action="{{ route('admin.surat-dasar.destroy', $item) }}"
                                        method="DELETE"
                                    />
                                @endforeach
                            </tbody>
                        </table>

                        <div class="px-6 py-4 border-t border-border-custom">
                            <x-navigation.pagination :paginator="$suratDasars" />
                        </div>
                    @endif
                </div>
            </x-layout.card>
        </main>
    </div>

    {{-- Modal Tambah --}}
    <x-feedback.modal id="modal-tambah" title="Tambah Surat Dasar" size="lg">
        <form id="form-tambah-surat-dasar" method="POST" action="{{ route('admin.surat-dasar.store') }}">
            @csrf
            <div class="space-y-4 p-1">
                <div>
                    <label for="teks_baru" class="text-sm font-medium text-text-main mb-2 block">
                        Teks Surat Dasar <span class="text-danger">*</span>
                    </label>
                    <textarea
                        name="teks"
                        id="teks_baru"
                        rows="4"
                        required
                        placeholder="Contoh: Nota Dinas Kepala Pusat Diklat SDM Lingkungan Hidup dan Kehutanan Nomor: ND.385/XI-3/2026 tanggal 10 Juli 2026"
                        class="w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-background border-border-custom focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary resize-none"
                    ></textarea>
                </div>
                <div class="flex items-center gap-2">
                    <input type="hidden" name="aktif" value="0">
                    <input type="checkbox" name="aktif" id="aktif_baru" value="1" checked
                        class="w-4 h-4 text-primary border-border-custom rounded focus:ring-primary">
                    <label for="aktif_baru" class="text-sm text-text-main">Langsung aktif (tampil di dropdown form SPT)</label>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex justify-end gap-2">
                    <x-action.button onclick="closeModal('modal-tambah')"
                        class="border border-border-custom text-text-main hover:bg-background px-4 py-2 text-sm rounded-md">
                        Batal
                    </x-action.button>
                    <x-action.button type="submit" form="form-tambah-surat-dasar"
                        class="bg-primary hover:bg-primary-hover text-white px-4 py-2 text-sm rounded-md">
                        Simpan
                    </x-action.button>
                </div>
            </x-slot:footer>
        </form>
    </x-feedback.modal>

    {{-- Modal Edit --}}
    <x-feedback.modal id="modal-edit" title="Edit Surat Dasar" size="lg">
        <form id="form-edit-surat-dasar" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="space-y-4 p-1">
                <div>
                    <label for="teks_edit" class="text-sm font-medium text-text-main mb-2 block">
                        Teks Surat Dasar <span class="text-danger">*</span>
                    </label>
                    <textarea
                        name="teks"
                        id="teks_edit"
                        rows="4"
                        required
                        class="w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-background border-border-custom focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary resize-none"
                    ></textarea>
                </div>
                <div class="flex items-center gap-2">
                    <input type="hidden" name="aktif" value="0">
                    <input type="checkbox" name="aktif" id="aktif_edit" value="1"
                        class="w-4 h-4 text-primary border-border-custom rounded focus:ring-primary">
                    <label for="aktif_edit" class="text-sm text-text-main">Aktif (tampil di dropdown form SPT)</label>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex justify-end gap-2">
                    <x-action.button onclick="closeModal('modal-edit')"
                        class="border border-border-custom text-text-main hover:bg-background px-4 py-2 text-sm rounded-md">
                        Batal
                    </x-action.button>
                    <x-action.button type="submit" form="form-edit-surat-dasar"
                        class="bg-primary hover:bg-primary-hover text-white px-4 py-2 text-sm rounded-md">
                        Perbarui
                    </x-action.button>
                </div>
            </x-slot:footer>
        </form>
    </x-feedback.modal>

    @push('scripts')
    <script>
        /**
         * Buka modal edit dan isi data dari baris yang dipilih.
         */
        function openEditModal(id, teks, aktif) {
            const form = document.getElementById('form-edit-surat-dasar');
            form.action = `/admin/surat-dasar/${id}`;

            document.getElementById('teks_edit').value = teks;

            const aktifCheckbox = document.getElementById('aktif_edit');
            aktifCheckbox.checked = aktif;

            openModal('modal-edit');
        }
    </script>
    @endpush
</x-layout.app>
