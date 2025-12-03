<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingRequest extends Model
{
    protected $fillable = [
        'user_id',
        'requestor_name',
        'deparment_name',
        'date_requested',
        'training_title',
        'training_organiser',
        'training_venue',
        'training_start_date',
        'training_end_date',
        'training_cost',
        'approved_training_cost',
        'employees_recommended',
        'training_objective',
        'remarks',
        'status',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewStatus()
    {
        return $this->hasOne(TrainingRequestStatus::class)->where('status_type', 1);
    }

    public function approveStatus()
    {
        return $this->hasOne(TrainingRequestStatus::class)->where('status_type', 2);
    }

    public function documents()
    {
        return $this->hasMany(TrainingRequestDocument::class);
    }

    public function participants()
    {
        return $this->hasMany(TrainingRequestUser::class);
    }
}
