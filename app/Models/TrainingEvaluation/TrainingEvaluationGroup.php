<?php

namespace App\Models\TrainingEvaluation;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TrainingEvaluationGroup extends Model
{
    protected $fillable = [
        'group_name',
        'created_by',
        'updated_by',
    ];

    public function forms()
    {
        return $this->hasMany(TrainingEvaluation::class, 'form_group_id');
    }
}