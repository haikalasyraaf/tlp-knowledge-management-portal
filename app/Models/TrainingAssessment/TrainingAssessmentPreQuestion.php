<?php

namespace App\Models\TrainingAssessment;

use Illuminate\Database\Eloquent\Model;

class TrainingAssessmentPreQuestion extends Model
{
    protected $fillable = [
        'training_id',
        'question_category',
        'question_text',
        'question_type',
        'order_no',
        'answer_value',
        'answer_text',
    ];

    public function form()
    {
        return $this->belongsTo(TrainingAssessment::class, 'training_id');
    }
}