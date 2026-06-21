<?php

namespace App\Models\TrainingAssessment;

use Illuminate\Database\Eloquent\Model;

class TrainingAssessmentDefaultQuestion extends Model
{
    protected $fillable = [
        'question_category',
        'question_text',
        'question_type',
    ];
}