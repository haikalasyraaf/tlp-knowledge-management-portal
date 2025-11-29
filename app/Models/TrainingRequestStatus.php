<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingRequestStatus extends Model
{
    protected $fillable = [
        'training_request_id',
        'user_id',
        'status_type',
        'transport_to_venue',
        'approved_training_cost',
        'is_accomodation_required',
        'is_hdrc_claimable',
        'is_budget_under_atp',
        'approval_decision',
        'remarks',
    ];

    public function trainingRequest()
    {
        return $this->belongsTo(TrainingRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
