<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingProgramFolder extends Model
{
    protected $fillable = [
        'training_program_id',
        'name',
        'description',
        'image_path',
        'status',
        'created_by',
        'updated_by',
    ];

    public function trainingProgram()
    {
        return $this->belongsTo(TrainingProgram::class, 'training_program_id');
    }

    public function documents()
    {
        return $this->hasMany(TrainingProgramFolderDocument::class, 'training_program_folder_id');
    }
}
