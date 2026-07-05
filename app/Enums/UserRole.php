<?php

namespace App\Enums;

/**
 * Enum untuk role pengguna dalam sistem SPJ BPHL.
 * Menggunakan Backed Enum (string) untuk menghindari "magic string"
 * yang tersebar di seluruh kodebase.
 *
 * Cara pakai:
 *   UserRole::ADMIN->value         => 'admin'
 *   UserRole::ADMIN->label()       => 'Administrator'
 *   UserRole::isMonitoring($role)  => true/false
 */
enum UserRole: string
{
    case ADMIN                  = 'admin';
    case VERIFIKATOR            = 'verifikator';
    case KEPALA_BALAI           = 'kepala_balai';
    case KEPALA_TU              = 'kepala_tu';
    case KEPALA_SEKSI_PEPHPHL   = 'kepala_seksi_pephphl';
    case KEPALA_SEKSI_PPPHPHL   = 'kepala_seksi_ppphphl';
    case USER                   = 'user';

    /**
     * Label yang ditampilkan di UI (readable).
     */
    public function label(): string
    {
        return match ($this) {
            self::ADMIN                 => 'Administrator',
            self::VERIFIKATOR           => 'Verifikator',
            self::KEPALA_BALAI          => 'Kepala Balai',
            self::KEPALA_TU             => 'Kepala Sub Bagian TU',
            self::KEPALA_SEKSI_PEPHPHL  => 'Kepala Seksi PEPHPHL',
            self::KEPALA_SEKSI_PPPHPHL  => 'Kepala Seksi PPPHPHL',
            self::USER                  => 'Pegawai',
        };
    }

    /**
     * Role yang bisa memonitor dokumen (read-only).
     */
    public static function monitoringRoles(): array
    {
        return [
            self::KEPALA_BALAI->value,
            self::KEPALA_TU->value,
            self::KEPALA_SEKSI_PEPHPHL->value,
            self::KEPALA_SEKSI_PPPHPHL->value,
        ];
    }

    /**
     * Semua nilai enum sebagai array (untuk validasi).
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
