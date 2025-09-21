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

    public function documents()
    {
        return $this->hasMany(TransferOfKnowledgeDocument::class, 'transfer_of_knowledge_id');
    }
}
