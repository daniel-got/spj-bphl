<x-layout.app title="Beranda - SPJ BPHL 4">

    <div class="portal-bg min-h-screen flex flex-col relative">
        <div class="absolute inset-0 portal-overlay pointer-events-none z-0"></div>

        <div class="relative z-10 flex flex-col min-h-screen">
            
            <div class="sticky top-0 z-50 bg-white/90 border-b border-gray-200/60 shadow-sm backdrop-blur-md">
                <x-layout.navbar />
            </div>

            <section id="hero-section" class="flex-grow flex items-center justify-center pt-16 pb-12 md:pt-24 md:pb-16">
                <div class="max-w-6xl mx-auto px-6 w-full text-center flex flex-col items-center justify-center">

                    <h1 class="font-doc-title text-4xl md:text-5xl font-extrabold tracking-tight text-black mb-6 drop-shadow-sm">
                        SPJ Perjalanan Dinas
                    </h1>

                    <p class="text-sm md:text-base text-gray-600 font-medium leading-relaxed max-w-3xl mb-12">
                        Portal resmi Balai Pengelolaan Hutan Lestari (BPHL) Wilayah IV Jambi untuk pengelolaan
                        administrasi Surat Perintah Tugas (SPT), Surat Perjalanan Dinas (SPD), dan Rincian Biaya secara terintegrasi.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 w-full">
                        <x-dashboard.stat-card
                            title="Total Pegawai"
                            :value="$totalPegawai"
                            description="Personil BPHL IV"
                            icon="users"
                            color="blue"
                        />

                        <x-dashboard.stat-card
                            title="Golongan IV"
                            :value="$totalPegawaiIV"
                            description="Total Pegawai Golongan IV"
                            icon="users"
                            color="green"
                        />

                        <x-dashboard.stat-card
                            title="Golongan III"
                            :value="$totalPegawaiIII"
                            description="Total Pegawai Golongan III"
                            icon="users"
                            color="yellow"
                        />

                        <x-dashboard.stat-card
                            title="Golongan II"
                            :value="$totalPegawaiII"
                            description="Total Pegawai Golongan II"
                            icon="users"
                            color="red"
                        />
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