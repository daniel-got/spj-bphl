<x-layout.app title="Pengaturan Sistem">
    <div id="pengaturan-root" class="flex">

        <x-layout.sidebar />

        <main class="flex-1 p-6 bg-background min-h-screen">
            <x-layout.breadcrumb :items="[['label' => 'Admin'], ['label' => 'Pengaturan Sistem']]" />

            <x-layout.page-header
                title="Pengaturan Sistem"
                description="Kelola konfigurasi penyimpanan Cloudflare R2 secara dinamis tanpa perlu mengubah file konfigurasi server."
            />

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

            {{-- Form Konfigurasi R2 --}}
            <x-layout.card class="mt-6 max-w-3xl">
                <x-slot:header>
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-border-custom bg-surface">
                        <div class="p-2 rounded-lg bg-primary-light">
                            <x-utility.icon name="cloud-arrow-up" class="w-5 h-5 text-primary" />
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-text-main">Cloudflare R2 Storage</h3>
                            <p class="text-xs text-muted mt-0.5">Konfigurasi akan aktif langsung tanpa perlu restart server.</p>
                        </div>
                    </div>
                </x-slot:header>

                <form id="form-r2" action="{{ route('admin.pengaturan.r2.update') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <x-form.input
                                name="r2_endpoint"
                                label="Endpoint URL"
                                type="url"
                                placeholder="https://xxxxxxxx.r2.cloudflarestorage.com"
                                :value="old('r2_endpoint', $r2Config['r2_endpoint'])"
                                :required="true"
                                hint="URL endpoint R2 dari dashboard Cloudflare"
                                :error="$errors->first('r2_endpoint')"
                            />
                        </div>

                        <x-form.input
                            name="r2_bucket"
                            label="Nama Bucket"
                            placeholder="nama-bucket-anda"
                            :value="old('r2_bucket', $r2Config['r2_bucket'])"
                            :required="true"
                            :error="$errors->first('r2_bucket')"
                        />

                        <x-form.input
                            name="r2_access_key"
                            label="Access Key ID"
                            placeholder="Masukkan Access Key ID"
                            :value="old('r2_access_key', $r2Config['r2_access_key'])"
                            :required="true"
                            :error="$errors->first('r2_access_key')"
                        />

                        <div class="md:col-span-2">
                            <x-form.input
                                name="r2_secret_key"
                                label="Secret Access Key"
                                type="password"
                                placeholder="{{ $r2Config['r2_has_secret'] ? '••••••••••••••••••••••• (sudah tersimpan, kosongkan untuk tidak mengubah)' : 'Masukkan Secret Access Key baru' }}"
                                :hint="$r2Config['r2_has_secret'] ? 'Secret Key sudah tersimpan. Isi hanya jika ingin menggantinya.' : 'Secret Access Key dari halaman API Cloudflare R2.'"
                                :error="$errors->first('r2_secret_key')"
                            />
                        </div>
                    </div>

                    {{-- Status Konfigurasi --}}
                    <div class="flex items-center gap-2 p-3 rounded-lg {{ $r2Config['r2_endpoint'] ? 'bg-primary-light border border-primary/20' : 'bg-warning/10 border border-warning/20' }}">
                        <x-utility.icon
                            name="{{ $r2Config['r2_endpoint'] ? 'check-circle' : 'exclamation-triangle' }}"
                            class="w-4 h-4 {{ $r2Config['r2_endpoint'] ? 'text-primary' : 'text-warning' }}"
                        />
                        <p class="text-xs {{ $r2Config['r2_endpoint'] ? 'text-primary' : 'text-warning' }} font-medium">
                            @if ($r2Config['r2_endpoint'])
                                Konfigurasi R2 aktif dari database. Bucket: <strong>{{ $r2Config['r2_bucket'] }}</strong>
                            @else
                                Konfigurasi R2 belum diatur. Sistem menggunakan nilai dari file <code>.env</code>.
                            @endif
                        </p>
                    </div>
                </form>

                <x-slot:footer>
                    <div class="flex justify-end px-6 py-4 border-t border-border-custom">
                        <x-action.button-primary type="submit" form="form-r2" class="flex items-center gap-2">
                            <x-utility.icon name="check" class="w-4 h-4" />
                            Simpan Konfigurasi
                        </x-action.button-primary>
                    </div>
                </x-slot:footer>
            </x-layout.card>

        </main>
    </div>
</x-layout.app>
