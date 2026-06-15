<?php

namespace App\Models\TrainingEvaluation;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class TrainingEvaluation extends Model
{
    protected $fillable = [
        'user_id',
        'form_group_id',
        'form_title',
        'form_date',
        'form_venue',
        'form_provider',
        'is_benefit',
        'is_relevant',
        'status',
        'submitted_on',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'form_date' => 'date',
        'submitted_on' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(TrainingEvaluationGroup::class, 'form_group_id');
    }

    public function questions()
    {
        return $this->hasMany(TrainingEvaluationQuestion::class, 'training_evaluation_id');
    }
}