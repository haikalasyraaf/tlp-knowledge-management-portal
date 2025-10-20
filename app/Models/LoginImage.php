<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginImage extends Model
{
    protected $fillable = [
        'image_path',
        'image_label',
        'image_placeholder',
        'added_by',
    ];
}
