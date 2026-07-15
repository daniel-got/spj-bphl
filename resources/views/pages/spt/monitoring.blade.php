<x-layout.app title="Pantau Progress SPT - SPJ BPHL 4">
    <div class="flex flex-1 w-full">
        <x-layout.sidebar />

        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <main class="grow flex flex-col px-6 py-10">
                <div class="max-w-7xl mx-auto w-full">

                    {{-- Page Header --}}
                    <x-layout.page-header title="Pantau Progress SPT" subtitle="Lihat tahapan penyelesaian dokumen dari Surat Perintah Tugas (SPT) hingga penerbitan SPD dan SPJ.">
                    </x-layout.page-header>

                    {{-- Ringkasan Statistik Monitoring --}}
                    @php
                        // Menghitung statistik sederhana dari koleksi data di halaman ini
                        $totalSpt = $spts->total();
                        
                        // Query database langsung untuk counter ringkasan yang akurat
                        $countApprovedSpt = \App\Models\Spt::where('status', 'disetujui')->count();
                        
                        // Menghitung SPT yang semua SPD-nya sudah terbit
                        $countSpdCompleted = 0;
                        $countSpjCompleted = 0;
                        
                        foreach (\App\Models\Spt::with(['spds.rincian'])->where('status', 'disetujui')->get() as $sptItem) {
                            $totalTravelers = count($sptItem->pegawai_ditugaskan ?? []);
                            $createdSpds = $sptItem->spds->count();
                            $approvedSpjs = $sptItem->spds->filter(fn($spd) => $spd->rincian?->status === 'disetujui')->count();
                            
                            if ($totalTravelers > 0) {
                                if ($createdSpds >= $totalTravelers) {
                                    $countSpdCompleted++;
                                }
                                if ($approvedSpjs >= $totalTravelers) {
                                    $countSpjCompleted++;
                                }
                            }
                        }
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        {{-- Card 1: Total SPT --}}
                        <div class="bg-surface rounded-xl border border-border-custom p-6 shadow-xs flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-muted font-sans">Total SPT</p>
                                <p class="text-3xl font-extrabold text-text-main mt-1">{{ $totalSpt }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center">
                                <x-utility.icon name="document-text" class="w-6 h-6" />
                            </div>
                        </div>

                        {{-- Card 2: SPT Disetujui --}}
                        <div class="bg-surface rounded-xl border border-border-custom p-6 shadow-xs flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-muted font-sans">SPT Disetujui (TU)</p>
                                <p class="text-3xl font-bold text-emerald-600 mt-1">{{ $countApprovedSpt }}</p>
                            </div>
                            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center">
                                <x-utility.icon name="check-circle" class="w-6 h-6" />
                            </div>
                        </div>

                        {{-- Card 3: SPD Selesai --}}
                        <div class="bg-surface rounded-xl border border-border-custom p-6 shadow-xs flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-muted font-sans">SPD Terbit Lengkap</p>
                                <p class="text-3xl font-bold text-indigo-600 mt-1">{{ $countSpdCompleted }}</p>
                            </div>
                            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center">
                                <x-utility.icon name="clipboard" class="w-6 h-6" />
                            </div>
                        </div>

                        {{-- Card 4: SPJ Selesai --}}
                        <div class="bg-surface rounded-xl border border-border-custom p-6 shadow-xs flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-muted font-sans">Pengajuan SPJ</p>
                                <p class="text-3xl font-bold text-purple-600 mt-1">{{ $countSpjCompleted }}</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center">
                                <x-utility.icon name="clipboard-check" class="w-6 h-6" />
                            </div>
                        </div>
                    </div>

                    {{-- Card Table --}}
                    <x-layout.card>
                        <x-slot:header>
                            <div class="flex items-center gap-2">
                                <h3 class="text-lg font-semibold text-text-main">
                                    Alur Penyelesaian SPT
                                </h3>
                            </div>
                        </x-slot:header>

                        {{-- Filter & Pencarian --}}
                        <div class="mb-6 mt-2 border-b border-border-custom pb-6">
                            <form method="GET" action="{{ route('user.spt.monitoring') }}">
                                <div class="grid grid-cols-12 gap-4 items-end">
                                    <div class="col-span-12 md:col-span-5 flex flex-col gap-1">
                                        <label for="search" class="text-sm font-medium text-text-main font-sans">Pencarian</label>
                                        <x-form.search name="search" placeholder="Cari nomor SPT, tujuan, penanggung jawab..." :value="request('search')" />
                                    </div>
                                    <div class="col-span-12 md:col-span-3 flex flex-col gap-1">
                                        <x-form.select name="status" label="Status SPT" :options="[
                                            '' => 'Semua Status SPT',
                                            'draft' => 'Draft',
                                            'diajukan' => 'Diajukan',
                                            'disetujui' => 'Disetujui',
                                            'direvisi' => 'Direvisi',
                                            'ditolak' => 'Ditolak',
                                            'dalam_pembuatan_spd' => 'Dalam Pembuatan SPD',
                                            'dalam_pembuatan_rincian' => 'Dalam Pembuatan Rincian',
                                            'pengajuan_spj' => 'Pengajuan SPJ',
                                            'selesai' => 'Selesai'
                                        ]" :selected="request('status')" onchange="this.form.submit()" />
                                    </div>
                                    <div class="col-span-12 md:col-span-4 flex gap-2 items-center justify-end">
                                        <x-action.button-primary type="submit" class="w-full justify-center md:w-auto px-6">
                                            Cari & Filter
                                        </x-action.button-primary>
                                        @if(request('search') || request('status'))
                                            <a href="{{ route('user.spt.monitoring') }}" class="text-sm text-muted hover:text-text-main underline px-2">
                                                Reset
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- Custom Step Table --}}
                        <div class="overflow-x-auto rounded-lg border border-border-custom bg-surface">
                            <table class="min-w-full divide-y divide-border-custom text-sm">
                                <thead class="bg-background">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wider whitespace-nowrap">No-spt</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wider whitespace-nowrap">Tujuan</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wider whitespace-nowrap">Penanggung Jawab</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wider whitespace-nowrap">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-surface divide-y divide-border-custom">
                                    @forelse($spts as $index => $spt)
                                        @php
                                            $totalTravelers = count($spt->pegawai_ditugaskan ?? []);
                                        @endphp
                                        <tr class="{{ $index % 2 !== 0 ? 'bg-background' : '' }} hover:bg-background transition-colors">
                                            {{-- 1. No-spt --}}
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <a href="{{ route('user.spt.show', $spt->id) }}" class="text-primary hover:underline font-semibold font-sans text-sm" title="Lihat Rincian SPT">
                                                    {{ $spt->nomor_spt }}
                                                </a>
                                            </td>
                                            
                                            {{-- 2. Tujuan --}}
                                            <td class="px-4 py-4">
                                                <div class="max-w-[280px]">
                                                    <p class="font-medium text-text-main text-xs line-clamp-2 leading-relaxed" title="{{ $spt->tujuan_kegiatan }}">
                                                        {{ $spt->tujuan_kegiatan }}
                                                    </p>
                                                </div>
                                            </td>

                                            {{-- 3. Penanggung Jawab --}}
                                            <td class="px-4 py-4 whitespace-nowrap text-text-main font-sans text-sm">
                                                {{ $spt->penanggung_jawab ?? '-' }}
                                            </td>

                                            {{-- 4. Status --}}
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="flex flex-col gap-1 items-start">
                                                    <x-data.status-badge status="{{ $spt->status_progress }}" />
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-12">
                                                <x-data.empty-state title="Tidak ada data SPT yang terpantau" />
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-4 flex justify-between items-center text-xs text-muted">
                            <span>Menampilkan {{ $spts->count() }} dari {{ $spts->total() }} entri SPT.</span>
                            {{ $spts->withQueryString()->links() }}
                        </div>
                    </x-layout.card>

                </div>
            </main>

            <x-layout.footer />
        </div>
    </div>
</x-layout.app>
