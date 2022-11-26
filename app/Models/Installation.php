<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\InstallationStatus;

class Installation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'address',
        'installation_fee',
        'note',
        'file_path',
        'status',
    ];

    protected $casts = [
        'status' => InstallationStatus::class,
    ];
}
