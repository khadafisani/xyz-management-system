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
        'date',
    ];

    protected $searchable = [
        'status',
        'note',
        'installation-name',
        'date',
    ];

    protected $casts = [
        'status' => InstallationPaymentStatus::class,
    ];

    public function installation(): BelongsTo
    {
        return $this->belongsTo(Installation::class);
    }
}
