<x-layout.app title="Data Uang Penginapan">
    <div id="uang-penginapan-root" class="flex">

        <x-layout.sidebar />

        <main class="flex-1 p-6 bg-background min-h-screen">
            <x-layout.breadcrumb :items="[['label' => 'Admin'], ['label' => 'Data Uang Penginapan']]" />

            <x-layout.page-header title="Data Uang Penginapan" description="Manajemen tarif uang penginapan perjalanan dinas per provinsi">
                <x-slot:actions>
                    <x-action.button onclick="openModal('modal-import')"
                        class="border border-border-custom text-text-main hover:bg-background px-4 py-2 text-sm rounded-md transition-colors flex items-center gap-2">
                        <x-utility.icon name="arrow-up-tray" class="w-4 h-4" />
                        Import CSV
                    </x-action.button>
                    <x-action.button-primary onclick="openModal('modal-tambah')"
                        class="flex items-center gap-2">
                        <x-utility.icon name="plus" class="w-4 h-4" />
                        Tambah Tarif
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
                @if (session('warning'))
                    <x-feedback.alert type="warning" title="Peringatan" :dismissible="true">
                        {{ session('warning') }}
                    </x-feedback.alert>
                @endif
                @if (session('error'))
                    <x-feedback.alert type="error" title="Gagal" :dismissible="true">
                        {{ session('error') }}
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

            <x-layout.card class="mt-6">
                <x-slot:header>
                    <div class="flex justify-between items-center px-6 py-4 border-b border-border-custom bg-surface">
                        <h3 class="text-lg font-semibold text-text-main">Daftar Tarif Uang Penginapan</h3>
                    </div>
                </x-slot:header>

                <div class="p-0">
                    @php
                        $headers = ['Provinsi', 'Golongan IV', 'Golongan III/II/I', 'Aksi'];
                        
                        $rows = $uangPenginapans->map(function($item) {
                            $data = [
                                'id' => $item->id,
                                'provinsi' => $item->provinsi,
                                'gol_iv' => $item->gol_iv,
                                'gol_iii_ii_i' => $item->gol_iii_ii_i,
                            ];
                            
                            $editUrl = route('admin.uang-penginapan.update', $item->id);
                            $deleteUrl = route('admin.uang-penginapan.destroy', $item->id);
                            
                            return [
                                'cells' => [
                                    $item->provinsi,
                                    'Rp ' . number_format($item->gol_iv, 0, ',', '.'),
                                    'Rp ' . number_format($item->gol_iii_ii_i, 0, ',', '.'),
                                ],
                                'actions' => [
                                    'edit' => [
                                        'onclick' => "openEditModalHandler({$item->id}, '{$editUrl}', " . json_encode($data) . ")"
                                    ],
                                    'delete' => [
                                        'onclick' => "openDeleteModalHandler('{$deleteUrl}')"
                                    ]
                                ]
                            ];
                        })->toArray();
                    @endphp

                    <x-data.table :headers="$headers" :rows="$rows" :striped="true" class="border-0 rounded-none overflow-x-auto" />
                </div>

                @if ($uangPenginapans->hasPages())
                    <x-slot:footer>
                        {{ $uangPenginapans->links('components.navigation.pagination') }}
                    </x-slot:footer>
                @endif
            </x-layout.card>
        </main>

        {{-- ========================================================== --}}
        {{-- MODAL TAMBAH DATA --}}
        {{-- ========================================================== --}}
        <x-feedback.modal id="modal-tambah" title="Tambah Tarif Uang Penginapan" size="md">
            <form id="form-tambah" method="POST" action="{{ route('admin.uang-penginapan.store') }}" class="space-y-4">
                @csrf
                <x-form.input name="provinsi" label="Provinsi" placeholder="Contoh: Jambi" :required="true" />
                
                <div class="grid grid-cols-1 gap-4">
                    <x-form.input type="number" name="gol_iv" label="Golongan IV" :required="true" value="0" />
                    <x-form.input type="number" name="gol_iii_ii_i" label="Golongan III/II/I" :required="true" value="0" />
                </div>
            </form>

            <x-slot:footer>
                <x-action.button onclick="closeModal('modal-tambah')" class="border border-border-custom text-text-main hover:bg-background px-4 py-2 text-sm rounded-md transition-colors">
                    Batal
                </x-action.button>
                <x-action.button-primary type="submit" form="form-tambah">
                    Simpan
                </x-action.button-primary>
            </x-slot:footer>
        </x-feedback.modal>

        {{-- ========================================================== --}}
        {{-- MODAL EDIT DATA --}}
        {{-- ========================================================== --}}
        <x-feedback.modal id="modal-edit" title="Edit Tarif Uang Penginapan" size="md">
            <form id="form-edit" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <x-form.input name="provinsi" id="edit-provinsi" label="Provinsi" :required="true" />
                
                <div class="grid grid-cols-1 gap-4">
                    <x-form.input type="number" name="gol_iv" id="edit-gol-iv" label="Golongan IV" :required="true" />
                    <x-form.input type="number" name="gol_iii_ii_i" id="edit-gol-iii-ii-i" label="Golongan III/II/I" :required="true" />
                </div>
            </form>

            <x-slot:footer>
                <x-action.button onclick="closeModal('modal-edit')" class="border border-border-custom text-text-main hover:bg-background px-4 py-2 text-sm rounded-md transition-colors">
                    Batal
                </x-action.button>
                <x-action.button-primary type="submit" form="form-edit">
                    Simpan Perubahan
                </x-action.button-primary>
            </x-slot:footer>
        </x-feedback.modal>

        {{-- ========================================================== --}}
        {{-- MODAL HAPUS DATA --}}
        {{-- ========================================================== --}}
        <x-feedback.modal id="modal-hapus" title="Konfirmasi Hapus" size="md">
            <form id="form-hapus" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex flex-col items-center justify-center p-4 text-center">
                    <div class="w-12 h-12 rounded-full bg-red-100 text-danger flex items-center justify-center mb-4">
                        <x-utility.icon name="exclamation-triangle" class="w-6 h-6" />
                    </div>
                    <h3 class="mb-2 text-lg font-normal text-text-main">Apakah Anda yakin ingin menghapus data ini?</h3>
                    <p class="text-sm text-muted">Data yang dihapus tidak dapat dikembalikan.</p>
                </div>
            </form>
            <x-slot:footer>
                <x-action.button onclick="closeModal('modal-hapus')" class="border border-border-custom text-text-main hover:bg-background px-4 py-2 text-sm rounded-md transition-colors">
                    Batal
                </x-action.button>
                <x-action.button type="submit" form="form-hapus" class="bg-danger hover:bg-red-700 text-white px-4 py-2 text-sm rounded-md transition-colors">
                    Ya, Hapus
                </x-action.button>
            </x-slot:footer>
        </x-feedback.modal>

        {{-- ========================================================== --}}
        {{-- MODAL IMPORT CSV --}}
        {{-- ========================================================== --}}
        <x-feedback.modal id="modal-import" title="Import Data Uang Penginapan (CSV)" size="xl">
            {{-- STEP 1: Upload --}}
            <div id="import-step-upload">
                <div class="p-4 bg-blue-50 text-blue-700 text-sm rounded-md flex items-start gap-3 mb-4">
                    <x-utility.icon name="information-circle" class="w-5 h-5 shrink-0 mt-0.5" />
                    <div>
                        <p class="font-medium mb-1">Panduan Import Data</p>
                        <ul class="list-disc pl-4 space-y-1 text-blue-600">
                            <li>Format header kolom wajib: <code class="text-xs bg-blue-100 px-1 rounded">provinsi, gol_iv, gol_iii_ii_i</code></li>
                            <li>Kolom angka (uang) pastikan tidak menggunakan titik pemisah ribuan.</li>
                            <li>Klik <strong>Cek Data CSV</strong> untuk memvalidasi sebelum diimpor.</li>
                        </ul>
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-sm font-medium text-text-main">Upload File CSV <span class="text-danger">*</span></label>
                    <input id="csv-file-input" type="file" accept=".csv"
                        onchange="document.getElementById('csv-file-name').innerText = this.files[0] ? '📄 ' + this.files[0].name : 'Maksimal 5MB'"
                        class="w-full px-3 py-2 text-sm border border-border-custom rounded-md shadow-sm bg-surface text-text-main file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-sm file:bg-primary file:text-white hover:file:bg-primary-hover cursor-pointer">
                    <p id="csv-file-name" class="text-xs text-muted mt-1">Maksimal 5MB</p>
                </div>
            </div>

            {{-- STEP: Loading --}}
            <div id="import-step-loading" style="display: none;" class="flex flex-col items-center justify-center py-8 gap-3">
                <div class="w-10 h-10 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
                <p class="text-sm text-muted">Sedang menganalisis data CSV...</p>
            </div>

            {{-- STEP: Result --}}
            <div id="import-step-result" style="display: none;">
                <div id="import-result-success" style="display: none;" class="space-y-4">
                    <div class="flex items-center gap-3 p-4 bg-green-50 text-green-700 rounded-lg">
                        <x-utility.icon name="check-circle" class="w-8 h-8 shrink-0 text-green-600" />
                        <div>
                            <p class="font-semibold">Data CSV valid!</p>
                            <p id="import-success-msg" class="text-sm"></p>
                        </div>
                    </div>
                    <div id="import-preview-container" style="display: none;">
                        <p class="text-sm font-medium text-text-main mb-2">Preview data (maks. 5 baris):</p>
                        <table class="w-full text-xs text-left border border-border-custom rounded-md overflow-hidden">
                            <thead class="bg-background/60">
                                <tr>
                                    <th class="px-3 py-2 text-muted">Provinsi</th>
                                    <th class="px-3 py-2 text-muted">Golongan IV</th>
                                    <th class="px-3 py-2 text-muted">Golongan III/II/I</th>
                                </tr>
                            </thead>
                            <tbody id="import-preview-body" class="divide-y divide-border-custom"></tbody>
                        </table>
                    </div>
                </div>

                <div id="import-result-error" style="display: none;" class="space-y-4">
                    <div class="flex items-center gap-3 p-4 bg-red-50 text-danger rounded-lg">
                        <x-utility.icon name="x-circle" class="w-8 h-8 shrink-0 text-red-600" />
                        <div>
                            <p class="font-semibold">Ditemukan kesalahan pada data!</p>
                            <p id="import-error-msg" class="text-sm"></p>
                        </div>
                    </div>
                    <div id="import-error-list" class="max-h-40 overflow-y-auto space-y-1"></div>
                </div>
            </div>

            <x-slot:footer>
                <div id="import-footer-upload" class="flex gap-2">
                    <x-action.button onclick="tutupImportModal()" class="border border-border-custom text-text-main hover:bg-background px-4 py-2 text-sm rounded-md transition-colors">Batal</x-action.button>
                    <x-action.button-primary onclick="cekDataCSV()" class="flex items-center gap-2">
                        <x-utility.icon name="check-circle" class="w-4 h-4" />
                        Cek Data CSV
                    </x-action.button-primary>
                </div>

                <div id="import-footer-success" style="display: none;" class="flex gap-2">
                    <x-action.button onclick="tutupImportModal()" class="border border-border-custom text-text-main hover:bg-background px-4 py-2 text-sm rounded-md transition-colors">Tutup</x-action.button>
                    <x-action.button onclick="importSekarang()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 text-sm rounded-md transition-colors flex items-center gap-2">
                        <x-utility.icon name="upload" class="w-4 h-4" />
                        Import Data Sekarang
                    </x-action.button>
                </div>

                <div id="import-footer-error" style="display: none;" class="flex gap-2">
                    <x-action.button onclick="tutupImportModal()" class="border border-border-custom text-text-main hover:bg-background px-4 py-2 text-sm rounded-md transition-colors">Tutup</x-action.button>
                    <x-action.button onclick="resetImportModal()" class="bg-warning hover:bg-yellow-600 text-white px-4 py-2 text-sm rounded-md transition-colors flex items-center gap-2">
                        <x-utility.icon name="download" class="w-4 h-4" />
                        Import Ulang
                    </x-action.button>
                </div>
            </x-slot:footer>
        </x-feedback.modal>

        <form id="form-import-token" method="POST" action="{{ route('admin.uang-penginapan.import') }}" class="hidden">
            @csrf
            <input id="import-token-input" type="hidden" name="import_token">
        </form>
    </div>

    <script>
        function openEditModalHandler(id, url, data) {
            document.getElementById('edit-provinsi').value = data.provinsi || '';
            document.getElementById('edit-gol-iv').value = data.gol_iv || 0;
            document.getElementById('edit-gol-iii-ii-i').value = data.gol_iii_ii_i || 0;
            document.getElementById('form-edit').action = url;
            openModal('modal-edit');
        }

        function openDeleteModalHandler(url) {
            document.getElementById('form-hapus').action = url;
            openModal('modal-hapus');
        }

        let currentImportToken = null;

        function tutupImportModal() {
            resetImportModal();
            closeModal('modal-import');
        }

        function resetImportModal() {
            document.getElementById('import-step-upload').style.display = 'block';
            document.getElementById('import-step-loading').style.display = 'none';
            document.getElementById('import-step-result').style.display = 'none';

            document.getElementById('import-footer-upload').style.display = 'flex';
            document.getElementById('import-footer-success').style.display = 'none';
            document.getElementById('import-footer-error').style.display = 'none';

            const fileInput = document.getElementById('csv-file-input');
            if (fileInput) fileInput.value = '';
            document.getElementById('csv-file-name').innerText = 'Maksimal 5MB';

            currentImportToken = null;
        }

        async function cekDataCSV() {
            const fileInput = document.getElementById('csv-file-input');
            if (!fileInput || !fileInput.files.length) {
                alert('Pilih file CSV terlebih dahulu.');
                return;
            }

            document.getElementById('import-step-upload').style.display = 'none';
            document.getElementById('import-footer-upload').style.display = 'none';
            document.getElementById('import-step-loading').style.display = 'flex';

            const formData = new FormData();
            formData.append('file', fileInput.files[0]);
            formData.append('_token', '{{ csrf_token() }}');

            try {
                const response = await fetch('{{ route('admin.uang-penginapan.validateImport') }}', {
                    method: 'POST',
                    body: formData,
                });

                const data = await response.json();
                tampilkanHasilImport(data);
            } catch (e) {
                tampilkanHasilImport({
                    valid: false,
                    berhasil: 0,
                    gagal: 0,
                    errors: ['Gagal menghubungi server.'],
                    token: null,
                    preview: []
                });
            }
        }

        function tampilkanHasilImport(result) {
            document.getElementById('import-step-loading').style.display = 'none';
            document.getElementById('import-step-result').style.display = 'block';

            if (result.valid) {
                document.getElementById('import-result-success').style.display = 'block';
                document.getElementById('import-result-error').style.display = 'none';
                document.getElementById('import-footer-success').style.display = 'flex';
                document.getElementById('import-success-msg').innerText = `${result.berhasil} data siap diimpor ke sistem.`;
                currentImportToken = result.token;

                if (result.preview && result.preview.length > 0) {
                    document.getElementById('import-preview-container').style.display = 'block';
                    const tbody = document.getElementById('import-preview-body');
                    tbody.innerHTML = '';
                    result.preview.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `<td class="px-3 py-2 text-text-main">${row.provinsi}</td><td class="px-3 py-2 text-muted">${row.gol_iv}</td><td class="px-3 py-2 text-muted">${row.gol_iii_ii_i}</td>`;
                        tbody.appendChild(tr);
                    });
                }
            } else {
                document.getElementById('import-result-success').style.display = 'none';
                document.getElementById('import-result-error').style.display = 'block';
                document.getElementById('import-footer-error').style.display = 'flex';

                document.getElementById('import-error-msg').innerText = `${result.gagal} baris bermasalah.`;
                const errList = document.getElementById('import-error-list');
                errList.innerHTML = '';
                if (result.errors) {
                    result.errors.forEach(err => {
                        const div = document.createElement('div');
                        div.className = 'flex items-start gap-2 text-xs text-danger';
                        div.innerHTML = `<span class="shrink-0">•</span><span>${err}</span>`;
                        errList.appendChild(div);
                    });
                }
            }
        }

        function importSekarang() {
            if (!currentImportToken) return;
            document.getElementById('import-token-input').value = currentImportToken;
            document.getElementById('form-import-token').submit();
        }
    </script>
</x-layout.app>
