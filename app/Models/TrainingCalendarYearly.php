<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingCalendarYearly extends Model
{
    protected $table = 'training_calendar_yearly';

    protected $fillable = [
        'name',
        'description',
        'document_path',
        'is_display',
        'created_by',
        'updated_by',
    ];
}
