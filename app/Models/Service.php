<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use HasFactory, QueryBuilder;

    protected $fillable = [
        'name',
        'download_speed',
        'upload_speed',
        'amount',
        'installation_fee',
        'total',
        'quote_every_month',
        'service_category_id',
    ];

    protected $searchable = [
        'name',
        'amount',
        'installation_fee',
        'total',
        'service_category-name',
    ];

    public function service_category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }
}
