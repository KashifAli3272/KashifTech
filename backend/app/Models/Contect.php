<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contect extends Model
{
    protected $fillable = [
        'name',
        'email',
        'message',
        'phone',
        'company',
        'service',
        'budget'
    ];
}
