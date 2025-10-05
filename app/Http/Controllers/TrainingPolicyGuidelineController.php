<?php

namespace App\Http\Controllers;

use App\Models\TrainingPolicyGuideline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class TrainingPolicyGuidelineController extends Controller
{
    public function index(Request $request, Builder $builder)
    {
        if (request()->ajax()) {
            return DataTables::of(TrainingPolicyGuideline::query())
                ->addIndexColumn()
                ->addColumn('action', function ($trainingPolicy) {
                    return view('training-policy.partial.action', compact('trainingPolicy'))->render();
                })
                ->rawColumns(['is_display', 'action'])
                ->toJson();
        }

        $html = $builder->columns([
            ['data' => 'id', 'visible' => false],
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '5%'],
            ['data' => 'name', 'title' => 'Name'],
            ['data' => 'action', 'title' => 'Action', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '20%'],
        ]);

        return view('training-policy.index', compact('html'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();
        if ($request->hasFile('document_path')) {
            $path = $request->file('document_path')->store('training_policy', 'public');
            $data['document_path'] = $path;
        }

        TrainingPolicyGuideline::create([
            'name'          => $data['name'] ?? null,
            'description'   => $data['description'] ?? null,
            'document_path' => $data['document_path'] ?? null,
            'created_by'    => $request->user()->id,
            'updated_by'    => $request->user()->id,
        ]);

        return response()->json(['message' => 'Training Policy created successfully']);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();
        $trainingPolicy = TrainingPolicyGuideline::findOrFail($id);
        
        if ($request->hasFile('document_path')) {
            if ($trainingPolicy->document_path) {
                Storage::disk('public')->delete($trainingPolicy->document_path);
            }
            $path = $request->file('document_path')->store('training_policy', 'public');
            $data['document_path'] = $path;
        } else {
            $data['document_path'] = $trainingPolicy->document_path;
        }

        $trainingPolicy->update([
            'name'          => $data['name'] ?? null,
            'description'   => $data['description'] ?? null,
            'document_path' => $data['document_path'] ?? null,
            'updated_by'    => $request->user()->id,
        ]);

        return response()->json(['message' => 'Training Policy updated successfully']);
    }

    public function delete($id)
    {
        TrainingPolicyGuideline::findOrFail($id)->delete();
        return response()->json(['message' => 'Training Policy deleted successfully']);
    }
}
