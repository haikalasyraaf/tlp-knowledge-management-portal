<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TrainingRecord;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class TrainingRecordController extends Controller
{
    public function index(Request $request, Builder $builder)
    {
        $user = $request->user();
        $staffs = User::all();

        $query = TrainingRecord::query()
            ->join('users', 'users.id', '=', 'training_records.user_id')
            ->select(
                'training_records.*',
                'users.name as staff_name'
            );

        if ($user->role == 'Staff') {
            $query->where('training_records.user_id', $user->id);
            $staffs = User::where('id', $request->user()->id)->get();
        }

        if ($request->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->filterColumn('staff_name', function ($query, $keyword) {
                    $query->where('users.name', 'like', "%{$keyword}%");
                })
                ->addColumn('action', function ($trainingRecord) {
                    return view('training-record.partial.action', compact('trainingRecord'))->render();
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        $html = $builder->columns([
            ['data' => 'id', 'visible' => false],
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '5%'],
            ['data' => 'form_title', 'name' => 'form_title', 'title' => 'Title', 'width' => '40%'],
            ['data' => 'staff_name', 'name' => 'staff_name', 'title' => 'Name'],
            ['data' => 'action', 'title' => 'Action', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '20%'],
        ]);

        return view('training-record.index', compact('html', 'staffs'));
    }

    public function create(Request $request)
    {

        $request->validate([
            'form_title' => 'required|string|max:255',
            'form_date' => 'required|date',
            'form_hours' => 'required|numeric',
            'staff_ids' => 'required|array|min:1',
        ]);

        foreach($request->staff_ids as $staffId) {
            $user = User::where('id', $staffId)->first();

            $trainingRecord = TrainingRecord::create([
                'user_id'       => $user->id,
                'form_title'    => $request->form_title,
                'form_date'     => $request->form_date,
                'form_provider' => $request->form_provider,
                'form_hours'    => $request->form_venue,
                'created_by'    => $request->user()->id,
                'updated_by'    => $request->user()->id,
            ]);
        }

        return redirect()->back()->with('success', 'Form assigned to user successfully.');
    }

    public function delete(TrainingRecord $trainingRecord) 
    {
        TrainingRecord::findOrFail($trainingRecord->id)->delete();
        return response()->json(['message' => 'Training Record deleted successfully']);
    }
}