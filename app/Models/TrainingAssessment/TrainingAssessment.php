<?php

namespace App\Models\TrainingAssessment;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class TrainingAssessment extends Model
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
        'pre_status',
        'pre_submitted_on',
        'post_status',
        'post_submitted_on',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'form_date' => 'date',
        'pre_submitted_on' => 'datetime',
        'post_submitted_on' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(TrainingAssessmentGroup::class, 'form_group_id');
    }

    public function pre_questions()
    {
        return $this->hasMany(TrainingAssessmentPreQuestion::class, 'training_id');
    }

    public function post_questions()
    {
        return $this->hasMany(TrainingAssessmentPostQuestion::class, 'training_id');
    }
}