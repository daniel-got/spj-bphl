<x-layout.app title="Kelola Pegawai">
    <div id="kelola-pegawai-root" class="flex">

        <x-layout.admin-sidebar />

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

                    <div class="p-0 overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-background/50">
                                <tr class="border-b border-border-custom">
                                    <th class="px-6 py-4 font-medium text-muted">NIP</th>
                                    <th class="px-6 py-4 font-medium text-muted">Nama Pegawai</th>
                                    <th class="px-6 py-4 font-medium text-muted">Jabatan</th>
                                    <th class="px-6 py-4 font-medium text-muted">Role Akses</th>
                                    <th class="px-6 py-4 font-medium text-muted text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-custom">
                                @forelse ($pegawais as $pegawai)
                                    <tr class="hover:bg-background/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pegawai->nip }}</td>
                                        <td class="px-6 py-4 font-medium text-text-main">
                                            {{ $pegawai->nama_pegawai }}<br>
                                            <span
                                                class="text-xs text-muted font-normal">{{ $pegawai->user?->email }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-muted">
                                            {{ $pegawai->jabatan ?? '-' }}<br>
                                            <span class="text-xs">{{ $pegawai->sub_seksi ?? '' }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $roleColor = match ($pegawai->user?->role) {
                                                    'admin' => 'purple',
                                                    'verifikator' => 'blue',
                                                    'kepala_balai',
                                                    'kepala_tu',
                                                    'kepala_seksi_pephphl',
                                                    'kepala_seksi_ppphphl'
                                                        => 'yellow',
                                                    default => 'gray',
                                                };
                                            @endphp
                                            <x-data.badge :label="$pegawai->user?->roleLabel() ?? 'Unknown'" :color="$roleColor" />
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            {{-- Dropdown Aksi --}}
                                            @php
                                                $pegawaiData = [
                                                    'id' => $pegawai->id,
                                                    'nip' => $pegawai->nip,
                                                    'nama_pegawai' => $pegawai->nama_pegawai,
                                                    'email' => $pegawai->user?->email,
                                                    'pangkat' => $pegawai->pangkat,
                                                    'golongan' => $pegawai->golongan,
                                                    'jabatan' => $pegawai->jabatan,
                                                    'sub_seksi' => $pegawai->sub_seksi,
                                                    'role' => $pegawai->user?->role,
                                                ];
                                            @endphp

                                            <div class="flex items-center justify-end gap-2">
                                                <button
                                                    onclick="openEditModalHandler({{ $pegawaiData['id'] }}, '{{ route('admin.kelolaPegawai.update', $pegawai->id) }}', {{ json_encode($pegawaiData) }})"
                                                    class="p-2 text-muted hover:text-primary hover:bg-primary-light rounded-md transition-colors"
                                                    title="Edit">
                                                    <x-utility.icon name="pencil" class="w-4 h-4" />
                                                </button>
                                                <button
                                                    onclick="openDeleteModalHandler('{{ route('admin.kelolaPegawai.destroy', $pegawai->id) }}')"
                                                    class="p-2 text-muted hover:text-danger hover:bg-red-50 rounded-md transition-colors"
                                                    title="Hapus">
                                                    <x-utility.icon name="trash" class="w-4 h-4" />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12">
                                            <x-data.empty-state title="Belum Ada Pegawai"
                                                description="Data pegawai belum ditambahkan ke dalam sistem." />
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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

                <x-form.select name="role" label="Role Akses Sistem" :options="array_combine(
                    \App\Enums\UserRole::values(),
                    array_map(fn($role) => \App\Enums\UserRole::from($role)->label(), \App\Enums\UserRole::values()),
                )" :selected="old('role')"
                    :required="true" />

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

                <div class="flex flex-col gap-1">
                    <label class="text-sm font-medium text-text-main">Role Akses Sistem <span
                            class="text-danger">*</span></label>
                    <select id="edit-role" name="role" required
                        class="w-full bg-surface border border-border-custom text-text-main text-sm rounded-md focus:ring-primary focus:border-primary block px-3 py-2">
                        @foreach (\App\Enums\UserRole::cases() as $role)
                            <option value="{{ $role->value }}">{{ $role->label() }}</option>
                        @endforeach
                    </select>
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
                    <button type="button" onclick="tutupImportModal()"
                        class="p-1 rounded-md text-muted hover:text-text-main hover:bg-background transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Body --}}
                <div class="px-6 py-4">

                    {{-- STEP 1: Upload --}}
                    <div id="import-step-upload">
                        <div class="p-4 bg-blue-50 text-blue-700 text-sm rounded-md flex items-start gap-3 mb-4">
                            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                <p class="font-medium mb-1">Panduan Import Data</p>
                                <ul class="list-disc pl-4 space-y-1 text-blue-600">
                                    <li>Format kolom: <code class="text-xs bg-blue-100 px-1 rounded">nama_pegawai, nip,
                                            pangkat, golongan, jabatan, sub_seksi, email, password, role</code></li>
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
                                <svg class="w-8 h-8 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
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
                                <svg class="w-8 h-8 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
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
                        <button type="button" onclick="tutupImportModal()"
                            class="border border-border-custom text-text-main hover:bg-background px-4 py-2 text-sm rounded-md transition-colors">Batal</button>
                        <button type="button" onclick="cekDataCSV()"
                            class="bg-primary hover:bg-primary-hover text-white px-4 py-2 text-sm rounded-md transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Cek Data CSV
                        </button>
                    </div>

                    {{-- Step Result: VALID --}}
                    <div id="import-footer-success" style="display: none;" class="flex gap-2">
                        <button type="button" onclick="tutupImportModal()"
                            class="border border-border-custom text-text-main hover:bg-background px-4 py-2 text-sm rounded-md transition-colors">Tutup</button>
                        <button type="button" onclick="importSekarang()"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 text-sm rounded-md transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Import Data Sekarang
                        </button>
                    </div>

                    {{-- Step Result: ADA ERROR --}}
                    <div id="import-footer-error" style="display: none;" class="flex gap-2">
                        <button type="button" onclick="tutupImportModal()"
                            class="border border-border-custom text-text-main hover:bg-background px-4 py-2 text-sm rounded-md transition-colors">Tutup</button>
                        <button type="button" onclick="resetImportModal()"
                            class="bg-warning hover:bg-yellow-600 text-white px-4 py-2 text-sm rounded-md transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Import Ulang
                        </button>
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
        function openEditModalHandler(id, url, pegawai) {
            // Langsung isi value DOM element — paling andal, tidak bergantung pada Alpine.js
            document.getElementById('edit-nama').value = pegawai.nama_pegawai || '';
            document.getElementById('edit-nip').value = pegawai.nip || '';
            document.getElementById('edit-email').value = pegawai.email || '';
            document.getElementById('edit-pangkat').value = pegawai.pangkat || '';
            document.getElementById('edit-golongan').value = pegawai.golongan || '';
            document.getElementById('edit-jabatan').value = pegawai.jabatan || '';
            document.getElementById('edit-sub-seksi').value = pegawai.sub_seksi || '';

            // Set selected option pada dropdown Role
            const roleSelect = document.getElementById('edit-role');
            if (roleSelect && pegawai.role) {
                roleSelect.value = pegawai.role;
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
                            `<td class="px-3 py-2 text-text-main">${row.nama}</td><td class="px-3 py-2 text-muted">${row.nip}</td><td class="px-3 py-2 text-muted">${row.role}</td>`;
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
