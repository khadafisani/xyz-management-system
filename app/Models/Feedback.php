<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory, QueryBuilder;

    protected $table = 'feedbacks';

    protected $fillable = [
        'is_responded',
        'description',
        'note',
        'file_path'
    ];

    protected $searchable = [
        'note',
        'is_responded',
        'description',
    ];
}
