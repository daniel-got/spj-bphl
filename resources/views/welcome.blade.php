<x-layout title="Beranda - SPJ BPHL 4">

    <x-navbar />

    <main class="grow flex flex-col justify-center items-center px-6 py-16 md:py-24 text-center">

        <div class="max-w-3xl mb-16">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-6 text-black">
                Sistem Informasi Perjalanan Dinas
            </h1>
            <p class="text-lg text-gray-600 leading-relaxed mb-8">
                Portal resmi Balai Pengelolaan Hutan Lestari (BPHL) Wilayah IV Jambi untuk pengelolaan administrasi
                Surat Perintah Tugas (SPT), Surat Perjalanan Dinas (SPD), dan Rincian Biaya secara terintegrasi.
            </p>
        </div>

        <x-card title="Total Pegawai Terdaftar" :value="$totalPegawai" description="Personil BPHL 4" />

    </main>

    <x-footer />

</x-layout>
