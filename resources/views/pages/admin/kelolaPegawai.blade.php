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
                    <x-action.button-primary onclick="openModal('modal-tambah-pegawai')" class="flex items-center gap-2">
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
                                            <span class="text-xs text-muted font-normal">{{ $pegawai->user?->email }}</span>
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
                                                    'kepala_balai', 'kepala_tu', 'kepala_seksi_pephphl', 'kepala_seksi_ppphphl' => 'yellow',
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
                                                    'pangkat_golongan' => $pegawai->pangkat_golongan,
                                                    'jabatan' => $pegawai->jabatan,
                                                    'sub_seksi' => $pegawai->sub_seksi,
                                                    'role' => $pegawai->user?->role,
                                                ];
                                            @endphp
                                            
                                            <div class="flex items-center justify-end gap-2">
                                                <button 
                                                    onclick="openEditModalHandler({{ $pegawaiData['id'] }}, '{{ route('admin.kelolaPegawai.update', $pegawai->id) }}', {{ json_encode($pegawaiData) }})"
                                                    class="p-2 text-muted hover:text-primary hover:bg-primary-light rounded-md transition-colors" title="Edit">
                                                    <x-utility.icon name="pencil" class="w-4 h-4" />
                                                </button>
                                                <button 
                                                    onclick="openDeleteModalHandler('{{ route('admin.kelolaPegawai.destroy', $pegawai->id) }}')"
                                                    class="p-2 text-muted hover:text-danger hover:bg-red-50 rounded-md transition-colors" title="Hapus">
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
            <form id="form-tambah-pegawai" method="POST" action="{{ route('admin.kelolaPegawai.store') }}" class="space-y-4">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form.input name="nama_pegawai" label="Nama Lengkap" placeholder="Contoh: Budi Santoso" :value="old('nama_pegawai')" :required="true" />
                    <x-form.input name="nip" label="NIP" placeholder="18 Digit NIP" :value="old('nip')" :required="true" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form.input name="email" label="Email" type="email" placeholder="email@bphl.go.id" :value="old('email')" :required="true" />
                    <x-form.input name="password" label="Password Baru" type="password" placeholder="Minimal 8 karakter" :required="true" />
                </div>

                <x-form.select name="role" label="Role Akses Sistem" :options="array_combine(\App\Enums\UserRole::values(), array_map(fn($role) => \App\Enums\UserRole::from($role)->label(), \App\Enums\UserRole::values()))" :selected="old('role')" :required="true" />

                <hr class="border-border-custom my-4">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <x-form.input name="pangkat_golongan" label="Pangkat/Golongan (Opsional)" placeholder="Contoh: Penata Tk.I (III/d)" :value="old('pangkat_golongan')" />
                    <x-form.input name="jabatan" label="Jabatan (Opsional)" placeholder="Contoh: Staf Pelaksana" :value="old('jabatan')" />
                    <x-form.input name="sub_seksi" label="Sub Seksi (Opsional)" placeholder="Contoh: TU" :value="old('sub_seksi')" />
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
                        <label class="text-sm font-medium text-text-main">Nama Lengkap <span class="text-danger">*</span></label>
                        <input id="edit-nama" type="text" name="nama_pegawai" required
                            class="w-full px-3 py-2 text-sm border border-border-custom rounded-md shadow-sm bg-surface text-text-main focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-text-main">NIP <span class="text-danger">*</span></label>
                        <input id="edit-nip" type="text" name="nip" required
                            class="w-full px-3 py-2 text-sm border border-border-custom rounded-md shadow-sm bg-surface text-text-main focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-text-main">Email <span class="text-danger">*</span></label>
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
                    <label class="text-sm font-medium text-text-main">Role Akses Sistem <span class="text-danger">*</span></label>
                    <select id="edit-role" name="role" required
                        class="w-full bg-surface border border-border-custom text-text-main text-sm rounded-md focus:ring-primary focus:border-primary block px-3 py-2">
                        @foreach(\App\Enums\UserRole::cases() as $role)
                            <option value="{{ $role->value }}">{{ $role->label() }}</option>
                        @endforeach
                    </select>
                </div>

                <hr class="border-border-custom my-4">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-text-main">Pangkat/Golongan</label>
                        <input id="edit-pangkat" type="text" name="pangkat_golongan"
                            class="w-full px-3 py-2 text-sm border border-border-custom rounded-md shadow-sm bg-surface text-text-main focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
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
                    <h3 class="mb-2 text-lg font-normal text-text-main">Apakah Anda yakin ingin menghapus data pegawai ini?</h3>
                    <p class="text-sm text-muted">Data yang dihapus tidak dapat dikembalikan. Akun pengguna juga akan ikut terhapus.</p>
                </div>
            </form>
            <x-slot:footer>
                <x-action.button onclick="closeModal('modal-hapus-pegawai')" class="border border-border-custom text-text-main hover:bg-background px-4 py-2 text-sm rounded-md transition-colors">
                    Batal
                </x-action.button>
                <x-action.button type="submit" form="form-hapus-pegawai" class="bg-danger hover:bg-red-700 text-white px-4 py-2 text-sm rounded-md transition-colors">
                    Ya, Hapus
                </x-action.button>
            </x-slot:footer>
        </x-feedback.modal>

        {{-- ========================================================== --}}
        {{-- MODAL IMPORT CSV --}}
        {{-- ========================================================== --}}
        <x-feedback.modal id="modal-import-pegawai" title="Import Data Pegawai (CSV)" size="md">
            <form id="form-import-pegawai" method="POST" action="{{ route('admin.kelolaPegawai.import') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <div class="p-4 bg-info/10 text-info text-sm rounded-md flex items-start gap-3">
                    <x-utility.icon name="information-circle" class="w-5 h-5 shrink-0" />
                    <div>
                        <p class="font-medium mb-1">Panduan Import Data</p>
                        <ul class="list-disc pl-4 space-y-1 text-info/80">
                            <li>Gunakan template CSV yang disediakan.</li>
                            <li>Pastikan tidak ada NIP atau Email yang terduplikasi.</li>
                            <li>Gunakan Role: <code>admin</code>, <code>verifikator</code>, <code>user</code>, dll sesuai sistem.</li>
                        </ul>
                    </div>
                </div>

                <x-form.file-upload name="file" label="Upload File CSV" accept=".csv" hint="Maksimal ukuran file 5MB" :required="true" />
                
            </form>

            <x-slot:footer>
                <x-action.button onclick="closeModal('modal-import-pegawai')"
                    class="border border-border-custom text-text-main hover:bg-background px-4 py-2 text-sm rounded-md transition-colors">
                    Batal
                </x-action.button>
                <x-action.button type="submit" form="form-import-pegawai"
                    class="bg-primary hover:bg-primary-hover text-white px-4 py-2 text-sm rounded-md transition-colors flex items-center gap-2">
                    <x-utility.icon name="arrow-up-tray" class="w-4 h-4" />
                    Proses Import
                </x-action.button>
            </x-slot:footer>
        </x-feedback.modal>
    </div>

    {{-- ================================================================
         Script: Handler global untuk modal Edit & Hapus.
         Menggunakan Alpine.store-free approach: akses component via $root
    ================================================================ --}}
    <script>
        function openEditModalHandler(id, url, pegawai) {
            // Langsung isi value DOM element — paling andal, tidak bergantung pada Alpine.js
            document.getElementById('edit-nama').value       = pegawai.nama_pegawai  || '';
            document.getElementById('edit-nip').value        = pegawai.nip           || '';
            document.getElementById('edit-email').value      = pegawai.email         || '';
            document.getElementById('edit-pangkat').value    = pegawai.pangkat_golongan || '';
            document.getElementById('edit-jabatan').value    = pegawai.jabatan       || '';
            document.getElementById('edit-sub-seksi').value  = pegawai.sub_seksi     || '';

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
    </script>
</x-layout.app>
