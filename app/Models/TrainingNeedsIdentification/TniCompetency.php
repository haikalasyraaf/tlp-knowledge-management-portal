<?php

namespace App\Models\TrainingNeedsIdentification;

use Illuminate\Database\Eloquent\Model;

class TniCompetency extends Model
{
    protected $table = 'tni_competencies';

    protected $fillable = [
        'tni_program_id',
        'image_path',
        'competency_name',
        'competency_description',
        'created_by',
        'updated_by',
    ];

    public function program()
    {
        return $this->belongsTo(TniProgram::class, 'tni_program_id');
    }
}
