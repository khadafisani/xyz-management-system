<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Enums\InstallationStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
        'date',
    ];

    protected $searchable = [
        'address',
        'note',
        'service-name',
        'service-service_category-name'
    ];

    protected $appends = [
        'status_name',
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

    protected function statusName(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
               return InstallationStatus::getString($this->status);
            }
        );
    }
}
