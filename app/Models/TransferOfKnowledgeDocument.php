<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferOfKnowledgeDocument extends Model
{
    protected $fillable = [
        'transfer_of_knowledge_id',
        'document_name',
        'document_path',
        'created_by',
        'updated_by',
    ];

    public function transferOfKnowledge()
    {
        return $this->belongsTo(TransferOfKnowledge::class, 'transfer_of_knowledge_id');
    }
}
