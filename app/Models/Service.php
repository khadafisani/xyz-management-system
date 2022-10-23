<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory;

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
}
