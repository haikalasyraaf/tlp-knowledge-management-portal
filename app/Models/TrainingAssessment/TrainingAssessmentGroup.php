<?php

namespace App\Models\TrainingAssessment;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TrainingAssessmentGroup extends Model
{
    protected $fillable = [
        'group_name',
        'created_by',
        'updated_by',
    ];

    public function forms()
    {
        return $this->hasMany(TrainingAssessment::class, 'form_group_id');
    }
}