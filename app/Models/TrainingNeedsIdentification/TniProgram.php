<?php

namespace App\Models\TrainingNeedsIdentification;

use Illuminate\Database\Eloquent\Model;

class TniProgram extends Model
{
    protected $table = 'tni_programs';

    protected $fillable = [
        'image_path',
        'program_name',
        'program_description',
        'created_by',
        'updated_by',
    ];
}
