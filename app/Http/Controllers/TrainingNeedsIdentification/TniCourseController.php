<?php

namespace App\Http\Controllers\TrainingNeedsIdentification;

use App\Http\Controllers\Controller;
use App\Models\TrainingNeedsIdentification\TniCompetency;
use App\Models\TrainingNeedsIdentification\TniCourse;
use App\Models\TrainingNeedsIdentification\TniProgram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class TniCourseController extends Controller
{
    public function index($program_id, $competency_id, Request $request, Builder $builder)
    {
        $program    = TniProgram::findOrFail($program_id);
        $competency = TniCompetency::findOrFail($competency_id);
        $query      = TniCourse::where('tni_competency_id', $competency_id)->get();

        if (request()->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('created_by', function ($course) {
                    $user = User::where('id', $course->created_by)->first();
                    return $user->name;
                })
                ->editColumn('created_at', function ($course) {
                    return $course->created_at->format('d/m/Y H:i');
                })
                ->editColumn('participant_count', function ($course) {
                    if($course->participant_count > 0) {
                        return '<span class="badge bg-success">' . $course->participant_count . ' Participant(s)</span>';
                    } else {
                        return '<span class="badge bg-warning">No Participant</span>';
                    }
                })
                ->addColumn('action', function ($course) {
                    return view('training-needs-identification.course.partial.action', compact('course'))->render();
                })
                ->rawColumns(['participant_count', 'action'])
                ->toJson();
        }

        $html = $builder->columns([
            ['data' => 'id', 'visible' => false],
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '5%'],
            ['data' => 'course_name', 'title' => 'Name', 'width' => '45%'],
            ['data' => 'participant_count', 'title' => 'Total Enrollment', 'className' => 'text-center', 'width' => '10%'],
            ['data' => 'action', 'title' => 'Action', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '10%'],
        ]);

        return view('training-needs-identification.course.index', compact('program', 'competency', 'html'));
    }

    public function store($program_id, $competency_id, Request $request)
    {
        $data = $request->all();

        $data['tni_competency_id'] = $competency_id;
        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;

        TniCourse::create($data);

        return response()->json(['message' => 'Course added successfully']);
    }

    public function update($program_id, $competency_id, $id, Request $request)
    {
        $data = $request->all();

        $data['tni_competency_id'] = $competency_id;
        $data['updated_by'] = Auth::user()->id;

        $course = TniCourse::findOrFail($id);
        $course->update($data);

        return response()->json(['message' => 'Course updated successfully']);
    }

    public function delete($program_id, $competency_id, $id)
    {
        TniCourse::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function apply($program_id, $competency_id, $id)
    {
        $user = Auth::user();

        $course = TniCourse::where('tni_competency_id', $competency_id)
            ->where('id', $id)
            ->firstOrFail();

        $userEnrollmentCount = $user->tniCourses()->wherePivot('status', 'enrolled')->count();

        if ($userEnrollmentCount >= 5) {
            return response()->json(['message' => 'Enrollment limit reached. Maximum only 5 is allowed per staff.'], 400);
        }

        $existing = $course->users()->where('user_id', $user->id)->first();

        if ($existing) {
            if ($existing->pivot->status === 'enrolled') {
                return response()->json(['message' => 'You are already enrolled in this program.'], 400);
            }
            // Reactivate enrollment if withdrawn
            $course->users()->updateExistingPivot($user->id, ['status' => 'enrolled']);
        } else {
            $course->users()->attach($user->id, ['status' => 'enrolled']);
        }

        $participantCount = $course->users()->wherePivot('status', 'enrolled')->count();
        $course->participant_count = $participantCount;
        $course->save();

        return response()->json(['message' => 'Successfully enrolled in the program.']);
    }

    public function withdraw($program_id, $competency_id, $id)
    {
        $user = Auth::user();

        $course = TniCourse::where('tni_competency_id', $competency_id)
            ->where('id', $id)
            ->firstOrFail();

        $existing = $course->users()->where('user_id', $user->id)->first();

        if (!$existing || $existing->pivot->status === 'withdrawn') {
            return response()->json(['message' => 'You are not enrolled in this program.'], 400);
        }

        $course->users()->updateExistingPivot($user->id, ['status' => 'withdrawn']);

        $participantCount = $course->users()->wherePivot('status', 'enrolled')->count();
        $course->participant_count = $participantCount;
        $course->save();

        return response()->json(['message' => 'Successfully withdrawn from the program.']);
    }
}
