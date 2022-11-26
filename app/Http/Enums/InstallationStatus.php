<?php

namespace App\Models\Enums;

use Illuminate\Support\Facades\Lang;

enum InstallationStatus: int
{
    use Enum;

    case REJECTED = 0;
    case SUBMITTED = 1;
    case PROCEED = 2;
    case FINISH = 3;

    public static function getString($val): string
    {
        return match ($val) {
            self::REJECTED => 'Ditolak',
            self::SUBMITTED => 'Diajukan',
            self::PROCEED => 'Sedang diproses',
            self::FINISH => 'Selesai',
        };
    }
}
