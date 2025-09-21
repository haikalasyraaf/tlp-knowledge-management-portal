<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingPolicyGuideline extends Model
{
    protected $fillable = [
        'name',
        'description',
        'document_path',
        'created_by',
        'updated_by',
    ];
}
