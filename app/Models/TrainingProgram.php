<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingProgram extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image_path',
        'status',
        'created_by',
        'updated_by',
    ];
}
