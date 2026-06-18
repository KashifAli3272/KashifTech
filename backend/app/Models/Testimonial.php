<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

 protected $fillable = [
    'initials', 'name', 'title', 'review', 'rating', 'is_active',
];

// Model $casts — add is_active
protected $casts = [
    'rating'    => 'integer',
    'is_active' => 'boolean',
];
}
