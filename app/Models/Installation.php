<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Enums\InstallationStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Installation extends Model
{
    use HasFactory, QueryBuilder;

    protected $fillable = [
        'user_id',
        'service_id',
        'address',
        'installation_fee',
        'note',
        'file_path',
        'status',
    ];

    protected $searchable = [
        'address',
        'note',
        'service-name',
        'service-service_category-name'
    ];

    protected $casts = [
        'status' => InstallationStatus::class,
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
