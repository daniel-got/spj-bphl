<x-layout.app title="Edit Kwitansi">
    <div class="flex flex-1 w-full">
        <x-layout.sidebar />

        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <main class="grow flex flex-col px-6 py-10">
                <div class="max-w-4xl mx-auto w-full space-y-6">

                    @if(session('success'))
                        <div class="mb-4">
                            <x-feedback.alert type="success" :message="session('success')" />
                        </div>
                    @endif

                    <div class="flex items-center gap-4 mb-4">
                        <a href="{{ route('user.kwitansi.index') }}" class="text-muted hover:text-primary transition-colors">
                            <x-utility.icon name="arrow-left" class="w-5 h-5" />
                        </a>
                        <div>
                            <h2 class="text-xl font-bold text-text-main">
                                Edit Kwitansi: {{ $kwitansi->nomor_kwitansi }}
                            </h2>
                            <p class="text-sm text-muted">Untuk SPD: {{ $kwitansi->rincian->spd->nomor_spd ?? '-' }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('user.kwitansi.update', $kwitansi->id) }}">
                        @csrf
                        @method('PUT')
                        <x-layout.card class="p-4 sm:p-6 space-y-6">
                            
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-text-main border-b border-border-custom pb-2">
                                    Informasi Kwitansi
                                </h3>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-muted">Nomor Kwitansi</p>
                                        <p class="font-medium text-text-main">{{ $kwitansi->nomor_kwitansi }}</p>
                                    </div>
                                    <div>
                                        <p class="text-muted">Pegawai Ditugaskan</p>
                                        <p class="font-medium text-text-main">{{ $kwitansi->rincian->spd->pegawai_ditugaskan ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-text-main border-b border-border-custom pb-2">
                                    Ubah Isian
                                </h3>

                                <div class="space-y-1">
                                    <label class="block text-sm font-medium text-text-main">Untuk Pembayaran</label>
                                    <textarea name="untuk_pembayaran" rows="4" required
                                        class="mt-1 block w-full rounded-md border-border-custom shadow-sm focus:border-primary focus:ring-primary sm:text-sm bg-surface text-text-main transition-colors resize-none p-3"
                                        placeholder="Biaya Perjalanan Dinas ...">{{ old('untuk_pembayaran', $kwitansi->untuk_pembayaran) }}</textarea>
                                    @error('untuk_pembayaran')
                                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <p class="text-xs text-muted">Informasi lainnya akan ditarik secara otomatis dari Rincian Biaya (tidak dapat diubah).</p>
                            </div>

                        </x-layout.card>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('user.kwitansi.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-border-custom text-sm font-medium rounded-md text-text-main bg-surface hover:bg-surface-muted transition-colors">
                                Batal
                            </a>
                            <x-action.button-primary type="submit">
                                Simpan Perubahan
                            </x-action.button-primary>
                        </div>
                    </form>

                </div>
            </main>
        </div>
    </div>
</x-layout.app>
