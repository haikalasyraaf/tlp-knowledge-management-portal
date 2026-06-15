<?php

namespace App\Models\TrainingEvaluation;

use Illuminate\Database\Eloquent\Model;

class TrainingEvaluationQuestion extends Model
{
    protected $fillable = [
        'training_evaluation_id',
        'question_category',
        'question_text',
        'question_type',
        'order_no',
        'answer_value',
        'answer_text',
    ];

    public function form()
    {
        return $this->belongsTo(TrainingEvaluation::class, 'training_evaluation_id');
    }
}