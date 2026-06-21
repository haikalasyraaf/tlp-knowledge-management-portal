<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingRecord extends Model
{
    protected $fillable = [
        'user_id',
        'form_title',
        'form_provider',
        'form_date',
        'form_hours',
        'created_by',
        'updated_by',
    ];
}
