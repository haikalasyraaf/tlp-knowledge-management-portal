<?php

namespace App\Models\TrainingNeedsIdentification;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TniCourse extends Model
{
    protected $table = 'tni_courses';

    protected $fillable = [
        'tni_competency_id',
        'course_name',
        'course_objective',
        'course_duration',
        'course_cost',
        'course_category',
        'created_by',
        'updated_by',
    ];

    public function competency()
    {
        return $this->belongsTo(TniCompetency::class, 'tni_competency_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'tni_course_user')->withPivot('status')->withTimestamps();
    }

    public function isUserEnrolled($userId)
    {
        return $this->users->contains(function ($user) use ($userId) {
            return $user->id === $userId && $user->pivot->status === 'enrolled';
        });
    }
}
