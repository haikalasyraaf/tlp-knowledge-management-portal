<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalBulletin extends Model
{
    protected $fillable = [
        'title',
        'content',
        'created_by',
        'updated_by',
    ];

    public function documents()
    {
        return $this->hasMany(InternalBulletinDocument::class, 'internal_bulletin_id');
    }
}
