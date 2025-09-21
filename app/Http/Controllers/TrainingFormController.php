<?php

namespace App\Http\Controllers;

use App\Models\TrainingForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class TrainingFormController extends Controller
{
    public function index(Request $request, Builder $builder)
    {
        if (request()->ajax()) {
            return DataTables::of(TrainingForm::query())
                ->addIndexColumn()
                ->addColumn('action', function ($trainingForm) {
                    return view('training-form.partial.action', compact('trainingForm'))->render();
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

        return view('training-form.index', compact('html'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('document_path')) {
            $path = $request->file('document_path')->store('training_form', 'public');
            $data['document_path'] = $path;
        }

        TrainingForm::create([
            'name'          => $data['name'] ?? null,
            'description'   => $data['description'] ?? null,
            'document_path' => $data['document_path'] ?? null,
            'created_by'    => $request->user()->id,
            'updated_by'    => $request->user()->id,
        ]);

        return response()->json(['message' => 'Training Form created successfully']);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();
        $trainingForm = TrainingForm::findOrFail($id);
        
        if ($request->hasFile('document_path')) {
            if ($trainingForm->document_path) {
                Storage::disk('public')->delete($trainingForm->document_path);
            }
            $path = $request->file('document_path')->store('training_form', 'public');
            $data['document_path'] = $path;
        } else {
            $data['document_path'] = $trainingForm->document_path;
        }

        $trainingForm->update([
            'name'          => $data['name'] ?? null,
            'description'   => $data['description'] ?? null,
            'document_path' => $data['document_path'] ?? null,
            'updated_by'    => $request->user()->id,
        ]);

        return response()->json(['message' => 'Training Form updated successfully']);
    }

    public function delete($id)
    {
        TrainingForm::findOrFail($id)->delete();
        return response()->json(['message' => 'Training Form deleted successfully']);
    }
}
