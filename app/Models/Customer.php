<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'subdistrict',
        'city',
        'province'
    ];

    protected $searchable = [
        'address',
        'subdistrict',
        'city',
        'province'
    ];
}
