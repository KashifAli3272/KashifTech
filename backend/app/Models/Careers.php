<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Careers extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'department',
        'location',
        'experience',
        'type',
        'description',
        'skills',

    ];
     protected $casts = [
    'skills' => 'array',
];
}
