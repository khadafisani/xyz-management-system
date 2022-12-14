<?php

namespace App\Http\Enums;

use Illuminate\Support\Facades\Lang;

enum InstallationPaymentStatus: int
{
    use Enum;

    case REJECTED = 0;
    case SUBMITTED = 1;
    case PAID = 2;

    public static function getString($val): string
    {
        return match ($val) {
            self::REJECTED => 'Ditolak',
            self::SUBMITTED => 'Diajukan',
            self::PAID => 'Telah dibayar',
        };
    }
}
