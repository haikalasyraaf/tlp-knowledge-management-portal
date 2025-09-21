<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubTrainingProgram extends Model
{
    protected $fillable = [
        'training_program_id',
        'program_name',
        'program_description',
        'document_path',
        'status',
        'created_by',
        'updated_by',
    ];
}
