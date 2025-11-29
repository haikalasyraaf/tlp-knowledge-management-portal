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

    public function reviewBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getTransportToVenueTextAttribute()
    {
        $options = [
            1 => 'Self Drive',
            2 => 'Company Car',
            3 => 'Flight',
            4 => 'Others',
        ];

        return $options[$this->transport_to_venue] ?? '-';
    }
}
