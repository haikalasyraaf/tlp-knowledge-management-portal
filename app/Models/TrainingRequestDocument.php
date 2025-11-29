<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingRequestDocument extends Model
{
    protected $fillable = [
        'training_request_id',
        'document_name',
        'document_path',
        'created_by',
        'updated_by',
    ];

    public function trainingRequest()
    {
        return $this->belongsTo(TrainingRequest::class);
    }
}
