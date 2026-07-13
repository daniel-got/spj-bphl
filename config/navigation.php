<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Navbar (Publik — Landing Page)
    |--------------------------------------------------------------------------
    | Link navigasi yang tampil di navbar halaman publik.
    */
    'navbar' => [
        ['label' => 'Beranda', 'url' => '/'],
        ['label' => 'Tentang',  'url' => '/tentang'],
        ['label' => 'Kontak',   'url' => '/kontak'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sidebar (Dashboard — Setelah Login)
    |--------------------------------------------------------------------------
    | Item menu sidebar dashboard. Setiap item mendukung:
    | - label   : teks yang ditampilkan
    | - url     : route URL
    | - icon    : nama icon dari x-utility.icon (Heroicons)
    | - active  : ditentukan secara dinamis di komponen (bukan di sini)
    */
    'sidebar' => [
        // --- GRUP: UTAMA ---
        [
            'header' => 'Utama',
            'roles' => ['admin', 'pembuat_spt', 'user', 'ppk_1', 'ppk_2', 'ppk_3', 'bendahara_pengeluaran', 'verifikator', 'kepala_balai', 'kepala_tu', 'kepala_seksi_pephphl', 'kepala_seksi_ppphphl'],
        ],
        [
            'label' => 'Dashboard',
            'url' => '/admin/dashboard',
            'icon' => 'home',
            'roles' => ['admin'],
        ],
        [
            'label' => 'Dashboard',
            'url' => '/user/pembuat-spt',
            'icon' => 'home',
            'roles' => ['pembuat_spt'],
        ],
        [
            'label' => 'Dashboard',
            'url' => '/user/dashboard',
            'icon' => 'home',
            'roles' => ['user', 'ppk_1', 'ppk_2', 'ppk_3', 'bendahara_pengeluaran', 'verifikator', 'kepala_balai', 'kepala_tu', 'kepala_seksi_pephphl', 'kepala_seksi_ppphphl'],
        ],

        // --- GRUP: TUGAS SAYA (Semua Aktor) ---
        [
            'header' => 'Tugas Saya',
            'roles' => ['admin', 'pembuat_spt', 'user', 'ppk_1', 'ppk_2', 'ppk_3', 'bendahara_pengeluaran', 'verifikator', 'kepala_balai', 'kepala_tu', 'kepala_seksi_pephphl', 'kepala_seksi_ppphphl'],
        ],
        [
            'label' => 'SPT Saya',
            'url' => '/user/spt',
            'icon' => 'document-text',
            'roles' => ['admin', 'user', 'ppk_1', 'ppk_2', 'ppk_3', 'bendahara_pengeluaran', 'verifikator', 'pembuat_spt', 'kepala_balai', 'kepala_tu', 'kepala_seksi_pephphl', 'kepala_seksi_ppphphl'],
        ],
        [
            'label' => 'SPD Saya',
            'url' => '/user/spd',
            'icon' => 'clipboard',
            'roles' => ['admin', 'user', 'ppk_1', 'ppk_2', 'ppk_3', 'bendahara_pengeluaran', 'verifikator', 'pembuat_spt', 'kepala_balai', 'kepala_tu', 'kepala_seksi_pephphl', 'kepala_seksi_ppphphl'],
        ],
        [
            'label' => 'Rincian Saya',
            'url' => '/user/rincian',
            'icon' => 'calculator',
            'roles' => ['admin', 'user', 'ppk_1', 'ppk_2', 'ppk_3', 'bendahara_pengeluaran', 'verifikator', 'pembuat_spt', 'kepala_balai', 'kepala_tu', 'kepala_seksi_pephphl', 'kepala_seksi_ppphphl'],
        ],

        // --- GRUP: OPERASIONAL (Input & Verifikasi) ---
        [
            'header' => 'Operasional',
            'roles' => ['admin', 'pembuat_spt', 'verifikator', 'kepala_balai', 'kepala_tu', 'kepala_seksi_pephphl', 'kepala_seksi_ppphphl'],
        ],
        [
            'label' => 'Kelola SPT Pegawai',
            'url' => '/user/spt/kelola',
            'icon' => 'pencil-square',
            'roles' => ['admin', 'pembuat_spt'],
        ],
        [
            'label' => 'Verifikasi SPT',
            'url' => '/verifikasi/spt',
            'icon' => 'check-badge',
            'roles' => ['kepala_balai', 'kepala_tu', 'kepala_seksi_pephphl', 'kepala_seksi_ppphphl'],
        ],
        [
            'label' => 'Verifikasi SPJ',
            'url' => '/verifikasi/spj',
            'icon' => 'shield-check',
            'roles' => ['verifikator', 'kepala_balai', 'kepala_tu', 'kepala_seksi_pephphl', 'kepala_seksi_ppphphl'],
        ],

        // --- GRUP: ADMINISTRATOR ---
        [
            'header' => 'Administrasi',
            'roles' => ['admin'],
        ],
        [
            'label' => 'Kelola Pegawai',
            'url' => '/admin/kelolaPegawai',
            'icon' => 'users',
            'roles' => ['admin'],
        ],
        [
            'label' => 'Data Uang Harian',
            'url' => '/admin/uang-harian',
            'icon' => 'currency-dollar',
            'roles' => ['admin'],
        ],
        [
            'label' => 'Data Uang Penginapan',
            'url' => '/admin/uang-penginapan',
            'icon' => 'building-office', // use building-office for hotel/penginapan
            'roles' => ['admin'],
        ],
        [
            'label' => 'Kelola PPK',
            'url' => '/admin/ppk',
            'icon' => 'identification',
            'roles' => ['admin'],
        ],
        [
            'label' => 'Master Surat Dasar',
            'url' => '/admin/surat-dasar',
            'icon' => 'document-duplicate',
            'roles' => ['admin'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Footer (Kolom Menu Publik)
    |--------------------------------------------------------------------------
    | Kolom-kolom menu yang tampil di bagian footer. Format:
    | 'Judul Kolom' => [
    |     ['label' => '...', 'url' => '...'],
    | ]
    */
    'footer' => [
        'Layanan' => [
            ['label' => 'Surat Perintah Tugas (SPT)', 'url' => '/spt'],
            ['label' => 'Surat Perjalanan Dinas (SPD)', 'url' => '/user/spd'],
            ['label' => 'Laporan Pertanggungjawaban',  'url' => '/lpj'],
        ],
        'Navigasi' => [
            ['label' => 'Beranda', 'url' => '/'],
            ['label' => 'Tentang', 'url' => '/tentang'],
            ['label' => 'Kontak',  'url' => '/kontak'],
        ],
        'Legal' => [
            ['label' => 'Kebijakan Privasi', 'url' => '/privasi'],
            ['label' => 'Syarat & Ketentuan', 'url' => '/syarat'],
        ],
    ],

];
