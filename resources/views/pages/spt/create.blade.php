<x-layout.app title="Tambah SPT - SPJ BPHL 4">

    <x-layout.navbar />

    <main class="grow flex flex-col px-6 py-10">

        <div class="max-w-5xl mx-auto w-full">

            @if ($errors->any())
                <div class="mb-6">
                    <x-feedback.alert type="error" title="Terjadi Kesalahan" :dismissible="true">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-feedback.alert>
                </div>
            @endif

            {{-- Header --}}
            <div class="flex items-center gap-3 mb-8">
                <a href="{{ route('user.spt.index') }}" class="text-muted hover:text-text-main transition font-medium">
                    ← Kembali
                </a>
                <h1 class="text-2xl font-extrabold tracking-tight text-text-main">
                    Tambah SPT Baru
                </h1>
            </div>

            {{-- Form --}}
            <form action="{{ route('user.spt.store') }}" method="POST" id="spt-form">
                @csrf

                <div class="bg-surface border border-border-custom rounded-xl shadow-sm p-6 space-y-6">

                    {{-- Nomor & Tanggal --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="nomor_spt" label="Nomor SPT" placeholder="Contoh: 094/01/SPT/2026"
                            :value="old('nomor_spt')" :required="true" :error="$errors->first('nomor_spt')" />
                        <x-form.date-picker name="tgl_spt" label="Tanggal SPT" :value="old('tgl_spt')" :required="true"
                            :error="$errors->first('tgl_spt')" />
                    </div>

                    {{-- Pegawai yang Ditugaskan (Dinamis) --}}
                    <div class="border-t border-border-custom pt-6">
                        <label class="text-sm font-medium text-text-main mb-2 block">
                            Pegawai yang Ditugaskan <span class="text-danger">*</span>
                        </label>

                        <div id="pegawai-list" class="space-y-4">
                            <div class="pegawai-item border border-border-custom rounded-lg p-4 bg-background/50">
                                <div class="flex items-start gap-2">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 grow">
                                        <div class="flex flex-col">
                                            <label class="text-xs font-medium text-text-main mb-1">Nama Pegawai</label>
                                            <select required
                                                class="pegawai-select w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-surface text-text-main focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary border-border-custom">
                                                <option value="">Pilih Pegawai</option>
                                                @foreach ($pegawaiList as $pegawai)
                                                    <option value="{{ $pegawai->id }}"
                                                        data-nama="{{ $pegawai->nama_pegawai }}"
                                                        data-nip="{{ $pegawai->nip }}"
                                                        data-pangkat="{{ $pegawai->pangkat }}{{ $pegawai->golongan ? ' / '.$pegawai->golongan : '' }}"
                                                        data-jabatan="{{ $pegawai->jabatan }}">
                                                        {{ $pegawai->nama_pegawai }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="text-xs font-medium text-text-main mb-1">NIP</label>
                                            <input type="text" readonly tabindex="-1"
                                                class="pegawai-nip w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-background text-muted border-border-custom cursor-not-allowed" />
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="text-xs font-medium text-text-main mb-1">Pangkat/Golongan</label>
                                            <input type="text" readonly tabindex="-1"
                                                class="pegawai-pangkat w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-background text-muted border-border-custom cursor-not-allowed" />
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="text-xs font-medium text-text-main mb-1">Jabatan</label>
                                            <input type="text" readonly tabindex="-1"
                                                class="pegawai-jabatan w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-background text-muted border-border-custom cursor-not-allowed" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="button" id="add-pegawai-btn"
                                class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary hover:text-primary-hover transition duration-150">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Pegawai
                            </button>
                        </div>

                        {{-- Hidden input berisi snapshot JSON lengkap, diisi oleh JS sebelum submit --}}
                        <input type="hidden" name="pegawai_ditugaskan" id="pegawai_ditugaskan_json"
                            value="{{ old('pegawai_ditugaskan') }}">

                        @if ($errors->has('pegawai_ditugaskan'))
                            <p class="text-xs text-danger mt-1">{{ $errors->first('pegawai_ditugaskan') }}</p>
                        @endif
                    </div>

                    {{-- Tujuan & Tempat --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-border-custom pt-6">
                        <x-form.textarea name="tujuan_kegiatan" label="Tujuan Kegiatan"
                            placeholder="Tuliskan tujuan kegiatan perjalanan dinas..." :rows="3"
                            :value="old('tujuan_kegiatan')" :required="true" :error="$errors->first('tujuan_kegiatan')" />

                        <x-form.input name="tempat_tujuan" label="Tempat Tujuan" placeholder="Contoh: Jakarta"
                            :value="old('tempat_tujuan')" :required="true" :error="$errors->first('tempat_tujuan')" />
                    </div>

                    {{-- Tanggal Berangkat, Kembali, Durasi Penugasan --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-border-custom pt-6">
                        <x-form.date-picker name="tgl_berangkat" label="Tanggal Berangkat" :value="old('tgl_berangkat')"
                            :required="true" :error="$errors->first('tgl_berangkat')" />
                        <x-form.date-picker name="tgl_kembali" label="Tanggal Kembali" :value="old('tgl_kembali')"
                            :required="true" :error="$errors->first('tgl_kembali')" />
                        <x-form.input name="lama_kegiatan" label="Durasi Penugasan (hari)" type="number"
                            placeholder="Otomatis dihitung" :value="old('lama_kegiatan')" :required="true"
                            :error="$errors->first('lama_kegiatan')" :readonly="true" />
                    </div>

                    {{-- Kode MAK --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-border-custom pt-6">
                        <x-form.input name="kode_mak" label="Kode MAK" placeholder="Kode MAK" :value="old('kode_mak')"
                            :required="true" :error="$errors->first('kode_mak')" />
                    </div>

                </div>

                {{-- Tombol --}}
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('user.spt.index') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-md border border-border-custom text-sm font-medium text-text-main hover:bg-background transition duration-150 ease-in-out">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center bg-primary hover:bg-primary-hover text-white text-sm font-semibold py-2.5 px-5 rounded-md transition duration-150 ease-in-out border border-transparent">
                        Simpan
                    </button>
                </div>

            </form>

        </div>

    </main>

    <x-layout.footer />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('pegawai-list');
            const addBtn = document.getElementById('add-pegawai-btn');
            const form = document.getElementById('spt-form');
            const hiddenInput = document.getElementById('pegawai_ditugaskan_json');
            const tglBerangkat = document.getElementById('tgl_berangkat');
            const tglKembali = document.getElementById('tgl_kembali');
            const lamaKegiatan = document.getElementById('lama_kegiatan');

            const firstSelect = container.querySelector('.pegawai-select');
            const optionsHTML = firstSelect ? firstSelect.innerHTML : '<option value="">Pilih Pegawai</option>';

            function attachAutoFill(item) {
                const select = item.querySelector('.pegawai-select');
                const nipInput = item.querySelector('.pegawai-nip');
                const pangkatInput = item.querySelector('.pegawai-pangkat');
                const jabatanInput = item.querySelector('.pegawai-jabatan');

                select.addEventListener('change', function() {
                    const opt = select.options[select.selectedIndex];
                    nipInput.value = opt.getAttribute('data-nip') || '';
                    pangkatInput.value = opt.getAttribute('data-pangkat') || '';
                    jabatanInput.value = opt.getAttribute('data-jabatan') || '';
                });
            }

            function updateRemoveButtons() {
                const items = container.querySelectorAll('.pegawai-item');
                items.forEach((item) => {
                    let removeBtn = item.querySelector('.remove-pegawai-btn');
                    if (items.length > 1) {
                        if (!removeBtn) {
                            removeBtn = document.createElement('button');
                            removeBtn.type = 'button';
                            removeBtn.className =
                                'remove-pegawai-btn text-danger hover:text-red-700 transition duration-150 p-2 mt-5';
                            removeBtn.innerHTML =
                                `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>`;
                            removeBtn.addEventListener('click', function() {
                                item.remove();
                                updateRemoveButtons();
                            });
                            item.querySelector('.flex.items-start').appendChild(removeBtn);
                        }
                    } else {
                        if (removeBtn) removeBtn.remove();
                    }
                });
            }

            addBtn.addEventListener('click', function() {
                const newItem = document.createElement('div');
                newItem.className = 'pegawai-item border border-border-custom rounded-lg p-4 bg-background/50';
                newItem.innerHTML = `
                    <div class="flex items-start gap-2">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 grow">
                            <div class="flex flex-col">
                                <label class="text-xs font-medium text-text-main mb-1">Nama Pegawai</label>
                                <select required
                                    class="pegawai-select w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-surface text-text-main focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary border-border-custom">
                                    ${optionsHTML}
                                </select>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-medium text-text-main mb-1">NIP</label>
                                <input type="text" readonly tabindex="-1"
                                    class="pegawai-nip w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-background text-muted border-border-custom cursor-not-allowed" />
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-medium text-text-main mb-1">Pangkat/Golongan</label>
                                <input type="text" readonly tabindex="-1"
                                    class="pegawai-pangkat w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-background text-muted border-border-custom cursor-not-allowed" />
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-medium text-text-main mb-1">Jabatan</label>
                                <input type="text" readonly tabindex="-1"
                                    class="pegawai-jabatan w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-background text-muted border-border-custom cursor-not-allowed" />
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(newItem);
                attachAutoFill(newItem);
                updateRemoveButtons();
            });

            container.querySelectorAll('.pegawai-item').forEach(attachAutoFill);
            updateRemoveButtons();

            // Sebelum submit, kumpulkan semua baris pegawai jadi array JSON snapshot lengkap
            form.addEventListener('submit', function(e) {
                const items = container.querySelectorAll('.pegawai-item');
                const pegawaiData = [];

                items.forEach((item) => {
                    const select = item.querySelector('.pegawai-select');
                    const opt = select.options[select.selectedIndex];
                    if (select.value) {
                        pegawaiData.push({
                            pegawai_id: select.value,
                            nama_pegawai: opt.getAttribute('data-nama') || '',
                            nip: opt.getAttribute('data-nip') || '',
                            pangkat: opt.getAttribute('data-pangkat') || '',
                            jabatan: opt.getAttribute('data-jabatan') || '',
                        });
                    }
                });

                if (pegawaiData.length === 0) {
                    e.preventDefault();
                    alert('Pilih minimal satu pegawai yang ditugaskan.');
                    return;
                }

                hiddenInput.value = JSON.stringify(pegawaiData);
            });

            // Hitung durasi penugasan otomatis
            function hitungHari() {
                const tgl1 = tglBerangkat ? new Date(tglBerangkat.value) : null;
                const tgl2 = tglKembali ? new Date(tglKembali.value) : null;

                if (tgl1 && tgl2 && tglBerangkat.value && tglKembali.value) {
                    const selisih = tgl2.getTime() - tgl1.getTime();
                    lamaKegiatan.value = selisih >= 0
                        ? Math.ceil(selisih / (1000 * 3600 * 24)) + 1
                        : '';
                }
            }

            if (tglBerangkat) tglBerangkat.addEventListener('change', hitungHari);
            if (tglKembali) tglKembali.addEventListener('change', hitungHari);
        });
    </script>

</x-layout.app>