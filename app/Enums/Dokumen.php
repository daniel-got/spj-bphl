<?php

namespace App\Enums;

enum Dokumen: string
{
    case DRAFT = 'draft';
    case DIAJUKAN = 'diajukan';
    case DIREVISI = 'direvisi';
    case DISETUJUI = 'disetujui';
    case DITOLAK = 'ditolak';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::DIAJUKAN => 'Diajukan',
            self::DIREVISI => 'Direvisi',
            self::DISETUJUI => 'Disetujui',
            self::DITOLAK => 'Ditolak',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => 'gray',
            self::DIAJUKAN => 'blue',
            self::DIREVISI => 'yellow',
            self::DISETUJUI => 'green',
            self::DITOLAK => 'red',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
