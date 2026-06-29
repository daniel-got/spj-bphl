<?php

namespace App\Enums;

enum Pangkat: string
{
    case I_A = 'I/a';
    case I_B = 'I/b';
    case I_C = 'I/c';
    case I_D = 'I/d';
    
    case II_A = 'II/a';
    case II_B = 'II/b';
    case II_C = 'II/c';
    case II_D = 'II/d';
    
    case III_A = 'III/a';
    case III_B = 'III/b';
    case III_C = 'III/c';
    case III_D = 'III/d';
    
    case IV_A = 'IV/a';
    case IV_B = 'IV/b';
    case IV_C = 'IV/c';
    case IV_D = 'IV/d';
    case IV_E = 'IV/e';

    public function label(): string
    {
        return match($this) {
            self::I_A => 'Juru Muda (I/a)',
            self::I_B => 'Juru Muda Tingkat I (I/b)',
            self::I_C => 'Juru (I/c)',
            self::I_D => 'Juru Tingkat I (I/d)',
            
            self::II_A => 'Pengatur Muda (II/a)',
            self::II_B => 'Pengatur Muda Tingkat I (II/b)',
            self::II_C => 'Pengatur (II/c)',
            self::II_D => 'Pengatur Tingkat I (II/d)',
            
            self::III_A => 'Penata Muda (III/a)',
            self::III_B => 'Penata Muda Tingkat I (III/b)',
            self::III_C => 'Penata (III/c)',
            self::III_D => 'Penata Tingkat I (III/d)',
            
            self::IV_A => 'Pembina (IV/a)',
            self::IV_B => 'Pembina Tingkat I (IV/b)',
            self::IV_C => 'Pembina Utama Muda (IV/c)',
            self::IV_D => 'Pembina Utama Madya (IV/d)',
            self::IV_E => 'Pembina Utama (IV/e)',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
