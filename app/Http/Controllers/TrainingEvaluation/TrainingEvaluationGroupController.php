<?php

namespace App\Http\Controllers\TrainingEvaluation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TrainingEvaluation\TrainingEvaluation;
use App\Models\TrainingEvaluation\TrainingEvaluationQuestion;
use App\Models\TrainingEvaluation\TrainingEvaluationDefaultQuestion;
use App\Models\TrainingEvaluation\TrainingEvaluationGroup;
use App\Notifications\UserAlertNotification;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class TrainingEvaluationGroupController extends Controller
{
    public function index(Request $request, Builder $builder)
    {
        $user = $request->user();
        $staffs = User::all();
        $default_questions = TrainingEvaluationDefaultQuestion::all();

        if ($user->role == 'Admin') {
            $query = TrainingEvaluationGroup::query();
        }

        if ($user->role == 'Staff') {
            $query = TrainingEvaluationGroup::whereHas('forms', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        if (request()->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('created_by', function ($trainingEvaluationGroup) {
                    $user = User::where('id', $trainingEvaluationGroup->created_by)->first();
                    return $user->name;
                })
                ->addColumn('action', function ($trainingEvaluationGroup) {
                    return view('training-evaluation.partial.action', compact('trainingEvaluationGroup'))->render();
                })
                ->rawColumns(['created_by', 'status', 'action'])
                ->toJson();
        }

        $html = $builder->columns([
            ['data' => 'id', 'visible' => false],
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '5%'],
            ['data' => 'group_name', 'title' => 'Title', 'width' => '40%'],
            ['data' => 'created_by', 'title' => 'Created By'],
            ['data' => 'action', 'title' => 'Action', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '20%'],
        ]);

        return view('training-evaluation.index', compact('html', 'staffs', 'default_questions'));
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

        $evaluationGroup = TrainingEvaluationGroup::create([
            'group_name' => $request->form_title,
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
        ]);

        foreach($request->staff_ids as $staffId) {
            $user = User::where('id', $staffId)->first();
            $sender = User::find($evaluationGroup->created_by);

            $trainingEvaluation = TrainingEvaluation::create([
                'user_id' => $user->id,
                'form_group_id' => $evaluationGroup->id,
                'form_title' => $request->form_title,
                'form_date' => $request->form_date,
                'form_venue' => $request->form_venue,
                'form_provider' => $request->form_provider,
            ]);

            foreach($request->question as $question) {
                TrainingEvaluationQuestion::create([
                    'training_evaluation_id' => $trainingEvaluation->id,
                    'question_category' => $question['question_category'],
                    'question_text'     => $question['question_text'],
                    'question_type'     => $question['question_type'],
                ]);
            }
            try {
                $user->notify(new UserAlertNotification(
                    'Training Evaluation',
                    'New Training Evaluation Received',
                    $sender->name . ' sent you an evaluation: "' . $trainingEvaluation->form_title . '".',
                    $sender->name,
                    route('training-evaluation.index')
                ));
            } catch (\Exception $e) {
                Log::warning("Alert notification failed for ({$user->employee_id}) {$user->name}: {$e->getMessage()}");
            }
        }

        return redirect()->back()->with('success', 'Form assigned to user successfully.');
    }

    public function delete(TrainingEvaluationGroup $trainingEvaluationGroup) 
    {
        TrainingEvaluationGroup::findOrFail($trainingEvaluationGroup->id)->delete();
        return response()->json(['message' => 'Training Evaluation deleted successfully']);
    }
}