<x-layout.app title="Data Kwitansi">
    <div class="flex flex-1 w-full">
        <x-layout.sidebar />

        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <main class="grow flex flex-col px-6 py-10">
                <div class="max-w-7xl mx-auto w-full space-y-6">

                    @if(session('success'))
                        <div class="mb-4">
                            <x-feedback.alert type="success" :message="session('success')" />
                        </div>
                    @endif

                    <x-layout.page-header title="Daftar Kwitansi" subtitle="Daftar Kwitansi Saya" />

                    <div class="flex flex-col gap-4">
                        <x-layout.card class="p-4 sm:p-6" noPadding>
                            <div class="mb-6 flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
                                <h3 class="text-lg font-bold text-text-main">
                                    Daftar Kwitansi Saya
                                </h3>
                                
                                <form method="GET" action="{{ route('user.kwitansi.index') }}" class="w-full sm:w-auto">
                                    <div class="flex flex-col sm:flex-row gap-3">
                                        <div class="relative min-w-[250px]">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <x-utility.icon name="magnifying-glass" class="h-4 w-4 text-muted" />
                                            </div>
                                            <input type="text" name="search" value="{{ request('search') }}"
                                                class="block w-full pl-10 pr-3 py-2 border border-border-custom rounded-md leading-5 bg-surface text-text-main placeholder-muted focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary sm:text-sm transition-colors"
                                                placeholder="Cari Kwitansi / SPD...">
                                        </div>
                                        <div class="flex gap-2">
                                            <x-action.button-primary type="submit" class="w-full justify-center text-center ">
                                                Cari
                                            </x-action.button-primary>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            @php
                                $headers = [
                                    'No',
                                    'Nomor Kwitansi',
                                    'Nomor SPD',
                                    'Nama Pegawai',
                                    'Dibuat Tanggal',
                                    'Aksi',
                                ];

                                $rows = collect(isset($kwitansis) ? $kwitansis->items() : [])->map(function ($kwitansi, $index) use ($kwitansis) {
                                    $nomorSpdLink = '<a href="' . route('user.rincian.show', $kwitansi->rincian_id) . '" class="text-primary hover:underline font-semibold" title="Lihat Rincian">' . e($kwitansi->rincian->spd->nomor_spd ?? '') . '</a>';

                                    $actions = [
                                        'print' => route('user.kwitansi.print', $kwitansi->id),
                                        'edit' => route('user.kwitansi.edit', $kwitansi->id),
                                    ];

                                    return [
                                        'cells' => [
                                            ($kwitansis->firstItem() ?? 1) + $index,
                                            e($kwitansi->nomor_kwitansi ?? ''),
                                            $nomorSpdLink,
                                            e($kwitansi->rincian->spd->pegawai_ditugaskan ?? ''),
                                            $kwitansi->created_at ? $kwitansi->created_at->format('d/m/Y H:i') : '-',
                                        ],
                                        'actions' => $actions
                                    ];
                                });
                            @endphp

                            <x-data.table :headers="$headers" :rows="$rows" :striped="true" />

                            @if (isset($kwitansis) && $kwitansis->hasPages())
                                <div class="mt-4">
                                    {{ $kwitansis->withQueryString()->links('components.navigation.pagination') }}
                                </div>
                            @elseif (isset($kwitansis))
                                <div class="mt-4 text-xs text-muted">
                                    <span>Menampilkan {{ $kwitansis->count() }} entri.</span>
                                </div>
                            @endif
                        </x-layout.card>
                    </div>

                </div>
            </main>
        </div>
    </div>
</x-layout.app>
