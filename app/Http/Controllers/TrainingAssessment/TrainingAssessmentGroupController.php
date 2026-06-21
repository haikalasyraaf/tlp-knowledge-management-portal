<?php

namespace App\Http\Controllers\TrainingAssessment;

use App\Http\Controllers\Controller;
use App\Models\TrainingAssessment\TrainingAssessment;
use App\Models\TrainingAssessment\TrainingAssessmentDefaultQuestion;
use App\Models\TrainingAssessment\TrainingAssessmentGroup;
use App\Models\TrainingAssessment\TrainingAssessmentPostQuestion;
use App\Models\TrainingAssessment\TrainingAssessmentPreQuestion;
use App\Models\User;
use App\Notifications\UserAlertNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class TrainingAssessmentGroupController extends Controller
{
    public function index(Request $request, Builder $builder)
    {
        $user = $request->user();
        $staffs = User::all();
        $default_questions = TrainingAssessmentDefaultQuestion::all();

        if ($user->role == 'Admin') {
            $query = TrainingAssessmentGroup::query();
        }

        if ($user->role == 'Staff') {
            $query = TrainingAssessmentGroup::whereHas('forms', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        if (request()->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('created_by', function ($trainingAssessmentGroup) {
                    $user = User::where('id', $trainingAssessmentGroup->created_by)->first();
                    return $user->name;
                })
                ->addColumn('action', function ($trainingAssessmentGroup) {
                    return view('training-assessment.partial.action', compact('trainingAssessmentGroup'))->render();
                })
                ->rawColumns(['created_by', 'status', 'action'])
                ->toJson();
        }

        $html = $builder->columns([
            ['data' => 'id', 'visible' => false],
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '5%'],
            ['data' => 'group_name', 'title' => 'Title', 'width' => '35%'],
            ['data' => 'created_by', 'title' => 'Created By'],
            ['data' => 'action', 'title' => 'Action', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '25%'],
        ]);

        return view('training-assessment.index', compact('html', 'staffs', 'default_questions'));
    }

    public function create(Request $request)
    {

        $request->validate([
            'form_title' => 'required|string|max:255',
            'form_date' => 'required|date',

            'staff_ids' => 'required|array',
            'staff_ids.*' => 'exists:users,id',

            'question' => 'required|array',
            'question.*.question_category' => 'required|string',
            'question.*.question_text' => 'required|string',
            'question.*.question_type' => 'required|in:scale,text',
        ]);

        $assessmentGroup = TrainingAssessmentGroup::create([
            'group_name' => $request->form_title,
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
        ]);

        foreach($request->staff_ids as $staffId) {
            $user = User::where('id', $staffId)->first();
            $sender = User::find($assessmentGroup->created_by);

            $trainingAssessment = TrainingAssessment::create([
                'user_id' => $user->id,
                'form_group_id' => $assessmentGroup->id,
                'form_title' => $request->form_title,
                'form_date' => $request->form_date,
                'form_venue' => $request->form_venue,
                'form_provider' => $request->form_provider,
            ]);

            foreach($request->question as $question) {
                TrainingAssessmentPreQuestion::create([
                    'training_id'       => $trainingAssessment->id,
                    'question_category' => $question['question_category'],
                    'question_text'     => $question['question_text'],
                    'question_type'     => $question['question_type'],
                ]);

                TrainingAssessmentPostQuestion::create([
                    'training_id'       => $trainingAssessment->id,
                    'question_category' => $question['question_category'],
                    'question_text'     => $question['question_text'],
                    'question_type'     => $question['question_type'],
                ]);
            }

            try {
                $user->notify(new UserAlertNotification(
                    'Training Assessment',
                    'New Training Assessment Received',
                    $sender->name . ' sent you an assessment: "' . $trainingAssessment->form_title . '".',
                    $sender->name,
                    route('training-assessment.index')
                ));
            } catch (\Exception $e) {
                Log::warning("Alert notification failed for ({$user->employee_id}) {$user->name}: {$e->getMessage()}");
            }
        }

        return redirect()->back()->with('success', 'Form assigned to user successfully.');
    }

    public function delete(TrainingAssessmentGroup $trainingAssessmentGroup) 
    {
        TrainingAssessmentGroup::findOrFail($trainingAssessmentGroup->id)->delete();
        return response()->json(['message' => 'Training Assessment deleted successfully']);
    }
}