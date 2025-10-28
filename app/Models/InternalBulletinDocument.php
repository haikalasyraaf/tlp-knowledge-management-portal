<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalBulletinDocument extends Model
{
    protected $fillable = [
        'internal_bulletin_id',
        'document_name',
        'document_path',
        'created_by',
        'updated_by',
    ];

    public function internalBulletin()
    {
        return $this->belongsTo(InternalBulletin::class, 'internal_bulletin_id');
    }
}
