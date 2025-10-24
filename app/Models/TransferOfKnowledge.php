<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferOfKnowledge extends Model
{
    protected $fillable = [
        'title',
        'content',
        'created_by',
        'updated_by',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'top_learner_month',
    ];

    protected $casts = [
        'is_top_learner' => 'boolean',
        'top_learner_month' => 'date',
    ];

    public function documents()
    {
        return $this->hasMany(TransferOfKnowledgeDocument::class, 'transfer_of_knowledge_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
