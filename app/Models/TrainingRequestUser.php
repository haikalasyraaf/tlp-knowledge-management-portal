<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingRequestUser extends Model
{
    protected $fillable = [
        'training_request_id',
        'name',
        'department',
        'status',
        'created_by',
        'updated_by'
    ];

    public function trainingRequest()
    {
        return $this->belongsTo(TrainingRequest::class);
    }
}
