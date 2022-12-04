<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceCategory extends Model
{
    use HasFactory, QueryBuilder;

    protected $fillable = [
        'name'
    ];

    protected $searchable = [
        'name',
        'service-name',
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
