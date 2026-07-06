<x-layout.app title="Beranda - SPJ BPHL 4">

    <style>
        /* Memastikan background kabut hutan mengunci penuh ke seluruh layar secara statis */
        .main-portal-bg {
            background-image: url('https://images.unsplash.com/photo-1542273917363-3b1817f69a2d?q=80&w=1920&auto=format&fit=crop') !important;
            background-attachment: fixed !important;
            background-position: center !important;
            background-size: cover !important;
        }

        /* Lapisan putih tipis transparan global agar teks tetap terbaca tajam */
        .light-overlay {
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.72), rgba(255, 255, 255, 0.82)) !important;
        }

        /* Memastikan transisi perpindahan scroll berjalan mulus */
        html {
            scroll-behavior: smooth;
        }

        /* Menghapus background solid bawaan layout jika ada */
        section, footer {
            background-color: transparent !important;
        }
    </style>

    <div class="main-portal-bg min-h-screen flex flex-col relative">
        <div class="absolute inset-0 light-overlay pointer-events-none z-0"></div>

        <div class="relative z-10 flex flex-col min-h-screen">
            
            <div class="sticky top-0 z-50 bg-white/90 border-b border-gray-200/60 shadow-sm backdrop-blur-md">
                <x-layout.navbar />
            </div>

            <section id="hero-section" class="flex-grow flex items-center justify-center pt-16 pb-12 md:pt-24 md:pb-16">
                <div class="max-w-6xl mx-auto px-6 w-full text-center flex flex-col items-center justify-center">
                    
                    <h1 class="font-doc-title text-4xl md:text-5xl font-extrabold tracking-tight text-emerald-950 mb-6 drop-shadow-sm">
                        SPJ Perjalanan Dinas
                    </h1>

                    <p class="text-sm md:text-base text-emerald-900/80 font-medium leading-relaxed max-w-3xl mb-10">
                        Portal resmi Balai Pengelolaan Hutan Lestari (BPHL) Wilayah IV Jambi untuk pengelolaan 
                        administrasi Surat Perintah Tugas (SPT), Surat Perjalanan Dinas (SPD), dan Rincian Biaya secara terintegrasi.
                    </p>

                    <div class="mb-12">
                        <a href="#ringkasan"
                            class="inline-flex items-center justify-center border-2 border-emerald-800 text-emerald-800 hover:bg-emerald-800 hover:text-white text-xs font-bold uppercase tracking-wider px-6 py-3 rounded-xl transition-all duration-200 shadow-sm">
                            Lihat Ringkasan Personil
                        </a>
                    </div>

                    <div id="ringkasan" class="w-full pt-4 scroll-mt-24">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 w-full">
                            
                            @php
                                $ringkasan = [
                                    ['label' => 'TOTAL PEGAWAI', 'desc' => 'Personil BPHL IV', 'value' => $totalPegawai, 'borderColor' => 'border-blue-200/80', 'badgeColor' => 'bg-blue-50/80 text-blue-600'],
                                    ['label' => 'GOLONGAN IV', 'desc' => 'Total Pegawai Golongan IV', 'value' => $totalPegawaiIV, 'borderColor' => 'border-emerald-200/80', 'badgeColor' => 'bg-emerald-50/80 text-emerald-600'],
                                    ['label' => 'GOLONGAN III', 'desc' => 'Total Pegawai Golongan III', 'value' => $totalPegawaiIII, 'borderColor' => 'border-amber-200/80', 'badgeColor' => 'bg-amber-50/80 text-amber-600'],
                                    ['label' => 'GOLONGAN II', 'desc' => 'Total Pegawai Golongan II', 'value' => $totalPegawaiII, 'borderColor' => 'border-rose-200/80', 'badgeColor' => 'bg-rose-50/80 text-rose-600'],
                                ];
                            @endphp

                            @foreach ($ringkasan as $item)
                                <div class="bg-white/90 backdrop-blur-sm border {{ $item['borderColor'] }} rounded-2xl p-5 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between text-left h-40">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-[11px] font-extrabold uppercase tracking-wider text-emerald-950/70">{{ $item['label'] }}</h3>
                                            <p class="text-[10px] text-gray-400 font-medium mt-0.5">{{ $item['desc'] }}</p>
                                        </div>
                                        <div class="p-1.5 rounded-lg {{ $item['badgeColor'] }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <span class="text-3xl font-black text-emerald-950 tracking-tight">
                                            {{ $item['value'] }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                </div>
            </section>

            <section class="border-t border-emerald-900/10 py-16 backdrop-blur-xs">
                <div class="max-w-6xl mx-auto px-6">
                    <h2 class="font-doc-title text-xl md:text-2xl font-bold text-emerald-950 mb-8 text-left">
                        Layanan Administrasi
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white/75 backdrop-blur-sm border border-emerald-900/5 rounded-2xl p-6 shadow-xs hover:shadow-sm transition-all duration-200">
                            <span class="font-doc-mono text-xs text-emerald-700 font-bold tracking-wider">01 &middot; SPT</span>
                            <h3 class="text-base font-bold text-emerald-950 mt-1 mb-2">Surat Perintah Tugas</h3>
                            <p class="text-sm text-emerald-900/80 leading-relaxed">
                                Terbitkan dan kelola penugasan pegawai untuk setiap perjalanan dinas, lengkap dengan penanggung jawab dan anggota tim.
                            </p>
                        </div>
                        <div class="bg-white/75 backdrop-blur-sm border border-emerald-900/5 rounded-2xl p-6 shadow-xs hover:shadow-sm transition-all duration-200">
                            <span class="font-doc-mono text-xs text-emerald-700 font-bold tracking-wider">02 &middot; SPD</span>
                            <h3 class="text-base font-bold text-emerald-950 mt-1 mb-2">Surat Perjalanan Dinas</h3>
                            <p class="text-sm text-emerald-900/80 leading-relaxed">
                                Susun surat perjalanan dinas yang tertaut langsung dengan data SPT yang sudah diterbitkan.
                            </p>
                        </div>
                        <div class="bg-white/75 backdrop-blur-sm border border-emerald-900/5 rounded-2xl p-6 shadow-xs hover:shadow-sm transition-all duration-200">
                            <span class="font-doc-mono text-xs text-emerald-700 font-bold tracking-wider">03 &middot; RINCIAN</span>
                            <h3 class="text-base font-bold text-emerald-950 mt-1 mb-2">Rincian Biaya</h3>
                            <p class="text-sm text-emerald-900/80 leading-relaxed">
                                Catat rincian biaya perjalanan dinas secara terperinci untuk keperluan pertanggungjawaban.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <div class="mt-auto border-t border-emerald-900/10 backdrop-blur-md bg-white/40">
                <x-layout.footer />
            </div>

        </div>
    </div>

</x-layout.app>