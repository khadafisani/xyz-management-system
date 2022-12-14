<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Enums\InstallationPaymentStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstallationPayment extends Model
{
    use HasFactory, QueryBuilder;

    protected $fillable = [
        'installation_id',
        'amount',
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
        'status' => InstallationPaymentStatus::class,
    ];

    public function installation(): BelongsTo
    {
        return $this->belongsTo(Installation::class);
    }
}
