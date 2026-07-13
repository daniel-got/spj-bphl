<x-layout.app title="Kelola Pegawai">
    <div id="kelola-pegawai-root" class="flex">

        <x-layout.sidebar />

        <main class="flex-1 p-6 bg-background min-h-screen">
            <x-layout.breadcrumb :items="[['label' => 'Admin'], ['label' => 'Kelola Pegawai']]" />

            <x-layout.page-header title="Data Pegawai" description="Manajemen akun dan data profil pegawai BPHL">
                <x-slot:actions>
                    <x-action.button onclick="openModal('modal-import-pegawai')"
                        class="border border-border-custom text-text-main hover:bg-background px-4 py-2 text-sm rounded-md transition-colors flex items-center gap-2">
                        <x-utility.icon name="arrow-up-tray" class="w-4 h-4" />
                        Import CSV
                    </x-action.button>
                    <x-action.button-primary onclick="openModal('modal-tambah-pegawai')"
                        class="flex items-center gap-2">
                        <x-utility.icon name="plus" class="w-4 h-4" />
                        Tambah Pegawai
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

            <div class="mt-6">
                <div class="bg-surface border border-border-custom rounded-xl overflow-hidden shadow-sm">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-border-custom bg-surface">
                        <h3 class="text-lg font-semibold text-text-main">Daftar Pegawai</h3>
                    </div>

                    <div class="p-0 overflow-x-auto border-t border-border-custom">
                        @php
                            $headers = [
                                'NIP',
                                'Nama Pegawai',
                                'Jabatan',
                                'Role Akses',
                                'Aksi'
                            ];
                            
                            $rows = $pegawais->map(function($pegawai) {
                                $userRoles = $pegawai->user?->roles ?? ['user'];
                                $badges = array_map(function($role) {
                                    $roleColor = match ($role) {
                                        'admin' => 'primary',
                                        'verifikator' => 'info',
                                        'pembuat_spt' => 'success',
                                        'kepala_balai', 'kepala_tu', 'kepala_seksi_pephphl', 'kepala_seksi_ppphphl' => 'warning',
                                        default => 'gray',
                                    };
                                    $label = \App\Enums\UserRole::tryFrom($role)?->label() ?? ucfirst($role);
                                    return \Illuminate\Support\Facades\Blade::render('<x-data.badge label="' . $label . '" color="' . $roleColor . '" />');
                                }, $userRoles);
                                
                                $badge = '<div class="flex flex-wrap gap-1">' . implode('', $badges) . '</div>';

                                
                                $pegawaiData = [
                                    'id' => $pegawai->id,
                                    'nip' => $pegawai->nip,
                                    'nama_pegawai' => $pegawai->nama_pegawai,
                                    'email' => $pegawai->user?->email,
                                    'pangkat' => $pegawai->pangkat,
                                    'golongan' => $pegawai->golongan,
                                    'jabatan' => $pegawai->jabatan,
                                    'sub_seksi' => $pegawai->sub_seksi,
                                    'roles' => $pegawai->user?->roles ?? ['user'],
                                ];
                                
                                $editUrl = route('admin.kelolaPegawai.update', $pegawai->id);
                                $deleteUrl = route('admin.kelolaPegawai.destroy', $pegawai->id);

                                return [
                                    'cells' => [
                                        $pegawai->nip,
                                        '<div class="font-medium text-text-main">' . e($pegawai->nama_pegawai) . '</div><div class="text-xs text-muted font-normal">' . e($pegawai->user?->email) . '</div>',
                                        '<div class="text-muted">' . e($pegawai->jabatan ?? '-') . '</div><div class="text-xs">' . e($pegawai->sub_seksi ?? '') . '</div>',
                                        $badge
                                    ],
                                    'actions' => [
                                        'edit' => [
                                            'onclick' => "openEditModalHandler({$pegawai->id}, '{$editUrl}', " . json_encode($pegawaiData) . ")"
                                        ],
                                        'delete' => [
                                            'onclick' => "openDeleteModalHandler('{$deleteUrl}')"
                                        ]
                                    ]
                                ];
                            })->toArray();
                        @endphp
                        
                        <x-data.table :headers="$headers" :rows="$rows" :striped="false" class="border-0 rounded-none" />
                    </div>

                    @if ($pegawais->hasPages())
                        <div class="px-6 py-4 border-t border-border-custom bg-surface">
                            {{ $pegawais->links('components.navigation.pagination') }}
                        </div>
                    @endif
                </div>
            </div>
        </main>

        {{-- ========================================================== --}}
        {{-- MODAL TAMBAH PEGAWAI --}}
        {{-- ========================================================== --}}
        <x-feedback.modal id="modal-tambah-pegawai" title="Tambah Pegawai Baru" size="lg">
            <form id="form-tambah-pegawai" method="POST" action="{{ route('admin.kelolaPegawai.store') }}"
                class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form.input name="nama_pegawai" label="Nama Lengkap" placeholder="Contoh: Budi Santoso"
                        :value="old('nama_pegawai')" :required="true" />
                    <x-form.input name="nip" label="NIP" placeholder="18 Digit NIP" :value="old('nip')"
                        :required="true" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form.input name="email" label="Email" type="email" placeholder="email@bphl.go.id"
                        :value="old('email')" :required="true" />
                    <x-form.input name="password" label="Password Baru" type="password" placeholder="Minimal 8 karakter"
                        :required="true" />
                </div>

                <div class="flex flex-col gap-1 relative mt-2 tags-input-container" data-target="tambah">
                    <label class="text-sm font-medium text-text-main">Role Akses Sistem <span class="text-danger">*</span></label>
                    <div class="tags-wrapper flex flex-wrap items-center gap-2 p-1.5 min-h-[42px] bg-surface border border-border-custom rounded-md shadow-sm transition-all duration-200 focus-within:ring-2 focus-within:ring-primary focus-within:border-primary cursor-text">
                        <input type="text" class="role-input flex-1 min-w-[120px] bg-transparent border-none outline-none text-sm text-text-main placeholder-muted py-1 px-1 focus:ring-0" placeholder="Ketik role..." autocomplete="off">
                    </div>
                    <div class="hidden-inputs-container"></div>
                    
                    <div class="suggestions-container absolute left-0 right-0 top-[100%] mt-1 bg-surface border border-border-custom rounded-md shadow-lg overflow-hidden z-50 hidden opacity-0 transition-opacity duration-200">
                        <div class="suggestions-list max-h-52 overflow-y-auto py-1"></div>
                    </div>
                </div>

                <hr class="border-border-custom my-4">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form.select name="pangkat" label="Pangkat (Opsional)" :options="array_combine(
                        \App\Enums\Pangkat::values(),
                        array_map(fn($p) => \App\Enums\Pangkat::from($p)->label(), \App\Enums\Pangkat::values()),
                    )" :selected="old('pangkat')" />

                    <x-form.select name="golongan" label="Golongan (Opsional)" :options="array_combine(
                        \App\Enums\Golongan::values(),
                        array_map(fn($g) => \App\Enums\Golongan::from($g)->label(), \App\Enums\Golongan::values()),
                    )" :selected="old('golongan')" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <x-form.input name="jabatan" label="Jabatan (Opsional)" placeholder="Contoh: Staf Pelaksana"
                        :value="old('jabatan')" />
                    <x-form.input name="sub_seksi" label="Sub Seksi (Opsional)" placeholder="Contoh: TU"
                        :value="old('sub_seksi')" />
                </div>
            </form>

            <x-slot:footer>
                <x-action.button onclick="closeModal('modal-tambah-pegawai')"
                    class="border border-border-custom text-text-main hover:bg-background px-4 py-2 text-sm rounded-md transition-colors">
                    Batal
                </x-action.button>
                <x-action.button type="submit" form="form-tambah-pegawai"
                    class="bg-primary hover:bg-primary-hover text-white px-4 py-2 text-sm rounded-md transition-colors">
                    Simpan Pegawai
                </x-action.button>
            </x-slot:footer>
        </x-feedback.modal>

        {{-- ========================================================== --}}
        {{-- MODAL EDIT PEGAWAI --}}
        {{-- ========================================================== --}}
        <x-feedback.modal id="modal-edit-pegawai" title="Edit Data Pegawai" size="lg">
            <form id="form-edit-pegawai" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-text-main">Nama Lengkap <span
                                class="text-danger">*</span></label>
                        <input id="edit-nama" type="text" name="nama_pegawai" required
                            class="w-full px-3 py-2 text-sm border border-border-custom rounded-md shadow-sm bg-surface text-text-main focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-text-main">NIP <span
                                class="text-danger">*</span></label>
                        <input id="edit-nip" type="text" name="nip" required
                            class="w-full px-3 py-2 text-sm border border-border-custom rounded-md shadow-sm bg-surface text-text-main focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-text-main">Email <span
                                class="text-danger">*</span></label>
                        <input id="edit-email" type="email" name="email" required
                            class="w-full px-3 py-2 text-sm border border-border-custom rounded-md shadow-sm bg-surface text-text-main focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-text-main">Password Baru (Opsional)</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah"
                            class="w-full px-3 py-2 text-sm border border-border-custom rounded-md shadow-sm bg-surface text-text-main focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <div class="flex flex-col gap-1 relative mt-2 tags-input-container" data-target="edit">
                    <label class="text-sm font-medium text-text-main">Role Akses Sistem <span class="text-danger">*</span></label>
                    <div class="tags-wrapper flex flex-wrap items-center gap-2 p-1.5 min-h-[42px] bg-surface border border-border-custom rounded-md shadow-sm transition-all duration-200 focus-within:ring-2 focus-within:ring-primary focus-within:border-primary cursor-text">
                        <input type="text" class="role-input flex-1 min-w-[120px] bg-transparent border-none outline-none text-sm text-text-main placeholder-muted py-1 px-1 focus:ring-0" placeholder="Ketik role..." autocomplete="off">
                    </div>
                    <div class="hidden-inputs-container"></div>
                    
                    <div class="suggestions-container absolute left-0 right-0 top-[100%] mt-1 bg-surface border border-border-custom rounded-md shadow-lg overflow-hidden z-50 hidden opacity-0 transition-opacity duration-200">
                        <div class="suggestions-list max-h-52 overflow-y-auto py-1"></div>
                    </div>
                </div>

                <hr class="border-border-custom my-4">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-text-main">Pangkat</label>
                        <select id="edit-pangkat" name="pangkat"
                            class="w-full px-3 py-2 text-sm border border-border-custom rounded-md shadow-sm bg-surface text-text-main focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                            <option value="">Pilih Pangkat</option>
                            @foreach (\App\Enums\Pangkat::cases() as $pangkat)
                                <option value="{{ $pangkat->value }}">{{ $pangkat->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-text-main">Golongan</label>
                        <select id="edit-golongan" name="golongan"
                            class="w-full px-3 py-2 text-sm border border-border-custom rounded-md shadow-sm bg-surface text-text-main focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                            <option value="">Pilih Golongan</option>
                            @foreach (\App\Enums\Golongan::cases() as $golongan)
                                <option value="{{ $golongan->value }}">{{ $golongan->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-text-main">Jabatan</label>
                        <input id="edit-jabatan" type="text" name="jabatan"
                            class="w-full px-3 py-2 text-sm border border-border-custom rounded-md shadow-sm bg-surface text-text-main focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-text-main">Sub Seksi</label>
                        <input id="edit-sub-seksi" type="text" name="sub_seksi"
                            class="w-full px-3 py-2 text-sm border border-border-custom rounded-md shadow-sm bg-surface text-text-main focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                </div>
            </form>

            <x-slot:footer>
                <x-action.button onclick="closeModal('modal-edit-pegawai')"
                    class="border border-border-custom text-text-main hover:bg-background px-4 py-2 text-sm rounded-md transition-colors">
                    Batal
                </x-action.button>
                <x-action.button type="submit" form="form-edit-pegawai"
                    class="bg-primary hover:bg-primary-hover text-white px-4 py-2 text-sm rounded-md transition-colors">
                    Simpan Perubahan
                </x-action.button>
            </x-slot:footer>
        </x-feedback.modal>

        {{-- ========================================================== --}}
        {{-- MODAL HAPUS PEGAWAI --}}
        {{-- ========================================================== --}}
        <x-feedback.modal id="modal-hapus-pegawai" title="Konfirmasi Hapus" size="md">
            <form id="form-hapus-pegawai" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex flex-col items-center justify-center p-4 text-center">
                    <div class="w-12 h-12 rounded-full bg-red-100 text-danger flex items-center justify-center mb-4">
                        <x-utility.icon name="exclamation-triangle" class="w-6 h-6" />
                    </div>
                    <h3 class="mb-2 text-lg font-normal text-text-main">Apakah Anda yakin ingin menghapus data pegawai
                        ini?</h3>
                    <p class="text-sm text-muted">Data yang dihapus tidak dapat dikembalikan. Akun pengguna juga akan
                        ikut terhapus.</p>
                </div>
            </form>
            <x-slot:footer>
                <x-action.button onclick="closeModal('modal-hapus-pegawai')"
                    class="border border-border-custom text-text-main hover:bg-background px-4 py-2 text-sm rounded-md transition-colors">
                    Batal
                </x-action.button>
                <x-action.button type="submit" form="form-hapus-pegawai"
                    class="bg-danger hover:bg-red-700 text-white px-4 py-2 text-sm rounded-md transition-colors">
                    Ya, Hapus
                </x-action.button>
            </x-slot:footer>
        </x-feedback.modal>

        {{-- ========================================================== --}}
        {{-- MODAL IMPORT CSV — Multi-step dengan Cek Data terlebih dahulu --}}
        {{-- ========================================================== --}}
        {{-- MODAL IMPORT CSV (Vanilla JS) --}}
        {{-- ========================================================== --}}
        <div id="modal-import-pegawai"
            class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
            onclick="if(event.target===this) tutupImportModal()" aria-modal="true" role="dialog">

            <div class="relative w-full max-w-2xl bg-surface rounded-xl shadow-2xl" onclick="event.stopPropagation()">
                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-border-custom">
                    <h2 class="text-base font-semibold text-text-main">
                        Import Data Pegawai (CSV)
                    </h2>
                    <x-action.icon-button onclick="tutupImportModal()">
                        <x-utility.icon name="x-mark" class="w-5 h-5" />
                    </x-action.icon-button>
                </div>

                {{-- Body --}}
                <div class="px-6 py-4">

                    {{-- STEP 1: Upload --}}
                    <div id="import-step-upload">
                        <div class="p-4 bg-blue-50 text-blue-700 text-sm rounded-md flex items-start gap-3 mb-4">
                            <x-utility.icon name="information-circle" class="w-5 h-5 shrink-0 mt-0.5 text-blue-500" />
                            <div>
                                <p class="font-medium mb-1">Panduan Import Data</p>
                                <ul class="list-disc pl-4 space-y-1 text-blue-600">
                                    <li>Format kolom: <code class="text-xs bg-blue-100 px-1 rounded">nama_pegawai, nip,
                                            pangkat, golongan, jabatan, sub_seksi, email, password, roles</code></li>
                                    <li>Klik <strong>Cek Data CSV</strong> untuk memvalidasi sebelum import ke database.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-sm font-medium text-text-main">Upload File CSV <span
                                    class="text-danger">*</span></label>
                            <input id="csv-file-input" type="file" accept=".csv"
                                onchange="document.getElementById('csv-file-name').innerText = this.files[0] ? '📄 ' + this.files[0].name : 'Maksimal 5MB'"
                                class="w-full px-3 py-2 text-sm border border-border-custom rounded-md shadow-sm bg-surface text-text-main file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-sm file:bg-primary file:text-white hover:file:bg-primary-hover cursor-pointer">
                            <p id="csv-file-name" class="text-xs text-muted mt-1">Maksimal 5MB</p>
                        </div>
                    </div>

                    {{-- STEP: Loading --}}
                    <div id="import-step-loading" style="display: none;"
                        class="flex flex-col items-center justify-center py-8 gap-3">
                        <div class="w-10 h-10 border-4 border-primary border-t-transparent rounded-full animate-spin">
                        </div>
                        <p class="text-sm text-muted">Sedang menganalisis data CSV...</p>
                    </div>

                    {{-- STEP: Result --}}
                    <div id="import-step-result" style="display: none;">
                        {{-- SUKSES --}}
                        <div id="import-result-success" style="display: none;" class="space-y-4">
                            <div class="flex items-center gap-3 p-4 bg-green-50 text-green-700 rounded-lg">
                                <x-utility.icon name="check-circle" class="w-8 h-8 shrink-0 text-green-500" />
                                <div>
                                    <p class="font-semibold">Data CSV valid!</p>
                                    <p id="import-success-msg" class="text-sm"></p>
                                </div>
                            </div>
                            <div id="import-preview-container" style="display: none;">
                                <p class="text-sm font-medium text-text-main mb-2">Preview data (maks. 5 baris):</p>
                                <table
                                    class="w-full text-xs text-left border border-border-custom rounded-md overflow-hidden">
                                    <thead class="bg-background/60">
                                        <tr>
                                            <th class="px-3 py-2 text-muted">Nama</th>
                                            <th class="px-3 py-2 text-muted">NIP</th>
                                            <th class="px-3 py-2 text-muted">Role</th>
                                        </tr>
                                    </thead>
                                    <tbody id="import-preview-body" class="divide-y divide-border-custom">
                                        {{-- Rows diisi via JS --}}
                                    </tbody>
                                </table>
                                <p id="import-preview-more" class="text-xs text-muted mt-1" style="display: none;">
                                </p>
                            </div>
                        </div>

                        {{-- GAGAL / ADA ERROR --}}
                        <div id="import-result-error" style="display: none;" class="space-y-4">
                            <div class="flex items-center gap-3 p-4 bg-red-50 text-danger rounded-lg">
                                <x-utility.icon name="x-circle" class="w-8 h-8 shrink-0 text-red-500" />
                                <div>
                                    <p class="font-semibold">Ditemukan kesalahan pada data!</p>
                                    <p id="import-error-msg" class="text-sm"></p>
                                </div>
                            </div>
                            <div id="import-error-list" class="max-h-40 overflow-y-auto space-y-1">
                                {{-- Errors diisi via JS --}}
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="px-6 py-4 border-t border-border-custom flex justify-end gap-2">
                    {{-- Step Upload --}}
                    <div id="import-footer-upload" class="flex gap-2">
                        <x-action.button onclick="tutupImportModal()">Batal</x-action.button>
                        <x-action.button-primary onclick="cekDataCSV()" class="gap-2">
                            <x-utility.icon name="check-circle" class="w-4 h-4" />
                            Cek Data CSV
                        </x-action.button-primary>
                    </div>

                    {{-- Step Result: VALID --}}
                    <div id="import-footer-success" style="display: none;" class="flex gap-2">
                        <x-action.button onclick="tutupImportModal()">Tutup</x-action.button>
                        <x-action.button onclick="importSekarang()" class="bg-green-600 hover:bg-green-700 text-white border-transparent gap-2">
                            <x-utility.icon name="upload" class="w-4 h-4" />
                            Import Data Sekarang
                        </x-action.button>
                    </div>

                    {{-- Step Result: ADA ERROR --}}
                    <div id="import-footer-error" style="display: none;" class="flex gap-2">
                        <x-action.button onclick="tutupImportModal()">Tutup</x-action.button>
                        <x-action.button onclick="resetImportModal()" class="bg-warning hover:bg-yellow-600 text-white border-transparent gap-2">
                            <x-utility.icon name="download" class="w-4 h-4" />
                            Import Ulang
                        </x-action.button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form tersembunyi untuk submit token import ke server --}}
        <form id="form-import-token" method="POST" action="{{ route('admin.kelolaPegawai.import') }}"
            class="hidden">
            @csrf
            <input id="import-token-input" type="hidden" name="import_token">
        </form>
    </div>

    {{-- ================================================================
         Script: Handler global untuk modal Edit & Hapus.
         Menggunakan Alpine.store-free approach: akses component via $root
    ================================================================ --}}
    <script>
        // Master roles data from Enum
        const masterRoles = @json(
            array_values(array_map(function($case) { 
                return ['value' => $case->value, 'label' => $case->label()]; 
            }, \App\Enums\UserRole::cases()))
        );

        // State untuk menyimpan role yang sudah dipilih per modal
        let selectedRoles = {
            'tambah': ['user'],
            'edit': []
        };
        
        function initTagsInput() {
            document.querySelectorAll('.tags-input-container').forEach(container => {
                const target = container.getAttribute('data-target');
                const tagsWrapper = container.querySelector('.tags-wrapper');
                const roleInput = container.querySelector('.role-input');
                const suggestionsContainer = container.querySelector('.suggestions-container');
                const suggestionsList = container.querySelector('.suggestions-list');
                const hiddenInputsContainer = container.querySelector('.hidden-inputs-container');

                function renderTags() {
                    container.querySelectorAll('.role-tag').forEach(el => el.remove());
                    hiddenInputsContainer.innerHTML = '';
                    
                    selectedRoles[target].forEach(roleVal => {
                        const roleData = masterRoles.find(r => r.value === roleVal) || {value: roleVal, label: roleVal};
                        
                        const tagEl = document.createElement('span');
                        tagEl.className = 'role-tag inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-medium bg-primary text-white shadow-sm transition-transform hover:scale-[1.02]';
                        
                        tagEl.innerHTML = `
                            ${roleData.label}
                            <button type="button" class="tag-close focus:outline-none text-white/80 hover:text-white transition-colors" data-role="${roleData.value}">
                                <x-utility.icon name="x-mark" class="w-3 h-3 pointer-events-none" />
                            </button>
                        `;
                        tagsWrapper.insertBefore(tagEl, roleInput);
                        
                        // Add hidden input
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'roles[]';
                        hiddenInput.value = roleData.value;
                        hiddenInputsContainer.appendChild(hiddenInput);
                    });
                }

                function renderSuggestions(query = "") {
                    suggestionsList.innerHTML = '';
                    
                    const filteredRoles = masterRoles.filter(role => 
                        role.label.toLowerCase().includes(query.toLowerCase()) && 
                        !selectedRoles[target].includes(role.value)
                    );

                    if (filteredRoles.length === 0) {
                        suggestionsList.innerHTML = '<div class="px-4 py-3 text-sm text-muted text-center italic">Tidak ada role tersisa.</div>';
                    } else {
                        filteredRoles.forEach((role, index) => {
                            const item = document.createElement('div');
                            item.className = 'suggestion-item px-4 py-2 text-sm text-text-main cursor-pointer hover:bg-background transition-colors';
                            item.textContent = role.label;
                            
                            if(index === 0 && query !== "") {
                                item.classList.add('bg-background');
                            }
                            
                            item.addEventListener('mousedown', (e) => {
                                e.preventDefault(); // Prevent input from losing focus
                                addRole(role.value);
                            });
                            
                            suggestionsList.appendChild(item);
                        });
                    }
                    
                    suggestionsContainer.classList.remove('hidden');
                    setTimeout(() => {
                        suggestionsContainer.classList.remove('opacity-0');
                        suggestionsContainer.classList.add('opacity-100');
                    }, 10);
                }

                function hideSuggestions() {
                    suggestionsContainer.classList.remove('opacity-100');
                    suggestionsContainer.classList.add('opacity-0');
                    setTimeout(() => {
                        suggestionsContainer.classList.add('hidden');
                    }, 200);
                }

                function addRole(roleValue) {
                    if (!selectedRoles[target].includes(roleValue)) {
                        selectedRoles[target].push(roleValue);
                        renderTags();
                        roleInput.value = '';
                        roleInput.focus();
                        renderSuggestions(); 
                    }
                }

                function removeRole(roleValue) {
                    selectedRoles[target] = selectedRoles[target].filter(r => r !== roleValue);
                    renderTags();
                    if(document.activeElement === roleInput) {
                        renderSuggestions(roleInput.value);
                    }
                }

                roleInput.addEventListener('input', (e) => {
                    renderSuggestions(e.target.value);
                });

                roleInput.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const activeSuggestion = suggestionsList.querySelector('.suggestion-item.bg-background') || suggestionsList.querySelector('.suggestion-item');
                        if (activeSuggestion) {
                            const foundRole = masterRoles.find(r => r.label === activeSuggestion.textContent);
                            if(foundRole) addRole(foundRole.value);
                        }
                    }
                    
                    if (e.key === 'Backspace' && roleInput.value === '' && selectedRoles[target].length > 0) {
                        removeRole(selectedRoles[target][selectedRoles[target].length - 1]);
                    }
                });

                roleInput.addEventListener('focus', () => {
                    renderSuggestions(roleInput.value);
                });
                
                roleInput.addEventListener('blur', () => {
                    hideSuggestions();
                });

                tagsWrapper.addEventListener('mousedown', (e) => {
                    if (e.target.closest('.tag-close')) {
                        e.preventDefault(); // prevent blur
                        const btn = e.target.closest('.tag-close');
                        const roleToRemove = btn.getAttribute('data-role');
                        removeRole(roleToRemove);
                    } else {
                        roleInput.focus();
                    }
                });

                // Attach methods to container so they can be triggered from outside
                container.renderTags = renderTags;
                
                // Initial render
                renderTags();
            });
        }
        
        document.addEventListener('DOMContentLoaded', initTagsInput);

        function openEditModalHandler(id, url, pegawai) {
            // Langsung isi value DOM element — paling andal, tidak bergantung pada Alpine.js
            document.getElementById('edit-nama').value = pegawai.nama_pegawai || '';
            document.getElementById('edit-nip').value = pegawai.nip || '';
            document.getElementById('edit-email').value = pegawai.email || '';
            document.getElementById('edit-pangkat').value = pegawai.pangkat || '';
            document.getElementById('edit-golongan').value = pegawai.golongan || '';
            document.getElementById('edit-jabatan').value = pegawai.jabatan || '';
            document.getElementById('edit-sub-seksi').value = pegawai.sub_seksi || '';

            // Update role tags state for edit modal
            selectedRoles['edit'] = pegawai.roles || [];
            const editContainer = document.querySelector('.tags-input-container[data-target="edit"]');
            if(editContainer && editContainer.renderTags) {
                editContainer.renderTags();
            }

            // Set action form ke URL yang benar
            document.getElementById('form-edit-pegawai').action = url;
            openModal('modal-edit-pegawai');
        }

        function openDeleteModalHandler(url) {
            document.getElementById('form-hapus-pegawai').action = url;
            openModal('modal-hapus-pegawai');
        }

        // ================================================================
        // Script: Handler Vanilla JS untuk modal Import CSV
        // Dijamin 100% jalan karena tidak ada dependensi ke Alpine.js
        // ================================================================

        let currentImportToken = null;

        function tutupImportModal() {
            resetImportModal();
            closeModal('modal-import-pegawai');
        }

        function resetImportModal() {
            // Tampilkan step Upload, sembunyikan yang lain
            document.getElementById('import-step-upload').style.display = 'block';
            document.getElementById('import-step-loading').style.display = 'none';
            document.getElementById('import-step-result').style.display = 'none';

            document.getElementById('import-footer-upload').style.display = 'flex';
            document.getElementById('import-footer-success').style.display = 'none';
            document.getElementById('import-footer-error').style.display = 'none';

            // Reset input file
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

            // Ganti tampilan ke Loading
            document.getElementById('import-step-upload').style.display = 'none';
            document.getElementById('import-footer-upload').style.display = 'none';
            document.getElementById('import-step-loading').style.display = 'flex';

            const formData = new FormData();
            formData.append('file', fileInput.files[0]);
            formData.append('_token', '{{ csrf_token() }}');

            try {
                const response = await fetch('{{ route('admin.kelolaPegawai.validateImport') }}', {
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
                    errors: ['Gagal menghubungi server. Server merespon dengan error.'],
                    token: null,
                    preview: []
                });
            }
        }

        function tampilkanHasilImport(result) {
            // Sembunyikan loading
            document.getElementById('import-step-loading').style.display = 'none';
            document.getElementById('import-step-result').style.display = 'block';

            if (result.valid) {
                // Tampilkan form sukses
                document.getElementById('import-result-success').style.display = 'block';
                document.getElementById('import-result-error').style.display = 'none';
                document.getElementById('import-footer-success').style.display = 'flex';

                document.getElementById('import-success-msg').innerText = `${result.berhasil} data siap diimpor ke sistem.`;
                currentImportToken = result.token;

                // Tampilkan preview jika ada
                if (result.preview && result.preview.length > 0) {
                    document.getElementById('import-preview-container').style.display = 'block';
                    const tbody = document.getElementById('import-preview-body');
                    tbody.innerHTML = '';

                    result.preview.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML =
                            `<td class="px-3 py-2 text-text-main">${row.nama}</td><td class="px-3 py-2 text-muted">${row.nip}</td><td class="px-3 py-2 text-muted">${row.roles}</td>`;
                        tbody.appendChild(tr);
                    });

                    if (result.berhasil > 5) {
                        const more = document.getElementById('import-preview-more');
                        more.style.display = 'block';
                        more.innerText = `...dan ${result.berhasil - 5} data lainnya.`;
                    }
                }
            } else {
                // Tampilkan form error
                document.getElementById('import-result-success').style.display = 'none';
                document.getElementById('import-result-error').style.display = 'block';
                document.getElementById('import-footer-error').style.display = 'flex';

                const errDetail = result.berhasil > 0 ? `, ${result.berhasil} baris valid.` : '.';
                document.getElementById('import-error-msg').innerText = `${result.gagal} baris bermasalah${errDetail}`;

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
