<?php

namespace App\Http\Controllers;

use App\Models\TrainingCalendarMonthly;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class TrainingCalendarMonthlyController extends Controller
{
    public function index()
    {
        $trainingCalendar = TrainingCalendarMonthly::where('is_display', 1)->first();

        return view('training-calendar.monthly.index', compact('trainingCalendar'));
    }

    public function list(Request $request, Builder $builder)
    {
        if (request()->ajax()) {
            return DataTables::of(TrainingCalendarMonthly::query())
                ->addIndexColumn()
                ->editColumn('is_display', function ($trainingCalendar) {
                    if($trainingCalendar->is_display == 1) {
                        return '<span class="badge bg-success">Display</span>';
                    }
                })
                ->addColumn('action', function ($trainingCalendar) {
                    return view('training-calendar.monthly.partial.action', compact('trainingCalendar'))->render();
                })
                ->rawColumns(['is_display', 'action'])
                ->toJson();
        }

        $html = $builder->columns([
            ['data' => 'id', 'visible' => false],
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '5%'],
            ['data' => 'name', 'title' => 'Name'],
            ['data' => 'is_display', 'title' => 'Status'],
            ['data' => 'action', 'title' => 'Action', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '10%'],
        ]);

        return view('training-calendar.monthly.list', compact('html'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('document_path')) {
            $path = $request->file('document_path')->store('training_calendar_monthly_documents', 'public');
            $data['document_path'] = $path;
        }

        TrainingCalendarMonthly::create([
            'name'          => $data['name'] ?? null,
            'description'   => $data['description'] ?? null,
            'document_path' => $data['document_path'] ?? null,
            'is_display'    => $data['is_display'] ?? null,
            'created_by'    => $request->user()->id,
            'updated_by'    => $request->user()->id,
        ]);

        return response()->json(['message' => 'Monthly Training Calendar created successfully']);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();
        $trainingCalendar = TrainingCalendarMonthly::findOrFail($id);
        
        if ($request->hasFile('document_path')) {
            if ($trainingCalendar->document_path) {
                Storage::disk('public')->delete($trainingCalendar->document_path);
            }
            $path = $request->file('document_path')->store('training_calendar_monthly_documents', 'public');
            $data['document_path'] = $path;
        } else {
            $data['document_path'] = $trainingCalendar->document_path;
        }

        if(($data['is_display'] ?? 2) == 1) {
            TrainingCalendarMonthly::query()->update(['is_display' => 2]);
        }

        $trainingCalendar->update([
            'name'          => $data['name'] ?? null,
            'description'   => $data['description'] ?? null,
            'document_path' => $data['document_path'] ?? null,
            'is_display'    => $data['is_display'] ?? 2,
            'updated_by'    => $request->user()->id,
        ]);

        return response()->json(['message' => 'Monthly Training Calendar updated successfully']);
    }

    public function delete($id)
    {
        TrainingCalendarMonthly::findOrFail($id)->delete();
        return response()->json(['message' => 'Monthly Training Calendar deleted successfully']);
    }
}
