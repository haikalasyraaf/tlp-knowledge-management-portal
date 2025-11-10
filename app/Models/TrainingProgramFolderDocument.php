<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingProgramFolderDocument extends Model
{
    protected $fillable = [
        'training_program_id',
        'training_program_folder_id',
        'document_name',
        'document_path',
        'status',
        'created_by',
        'updated_by',
    ];

    public function trainingProgram()
    {
        return $this->belongsTo(TrainingProgram::class, 'training_program_id');
    }

    public function trainingProgramFolder()
    {
        return $this->belongsTo(TrainingProgramFolder::class, 'training_program_folder_id');
    }
}
