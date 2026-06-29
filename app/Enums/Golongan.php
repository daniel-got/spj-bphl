<?php

namespace App\Enums;

enum Golongan: string
{
    case I = 'I';
    case II = 'II';
    case III = 'III';
    case IV = 'IV';

    public function label(): string
    {
        return match($this) {
            self::I => 'Golongan I',
            self::II => 'Golongan II',
            self::III => 'Golongan III',
            self::IV => 'Golongan IV',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
