<?php

namespace App\Models\TrainingEvaluation;

use Illuminate\Database\Eloquent\Model;

class TrainingEvaluationDefaultQuestion extends Model
{
    protected $fillable = [
        'question_category',
        'question_text',
        'question_type',
    ];
}