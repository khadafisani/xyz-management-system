<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Enums\InstallationStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
