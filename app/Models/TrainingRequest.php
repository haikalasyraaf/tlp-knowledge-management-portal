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

    public function statuses()
    {
        return $this->hasMany(TrainingRequestStatus::class);
    }

    public function documents()
    {
        return $this->hasMany(TrainingRequestDocument::class);
    }
}
