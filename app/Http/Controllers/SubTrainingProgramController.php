<?php

namespace App\Http\Controllers;

use App\Models\SubTrainingProgram;
use App\Models\TrainingProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class SubTrainingProgramController extends Controller
{

    public function index($programId, Request $request, Builder $builder)
    {
        $trainingProgram = TrainingProgram::where('id', $programId)->first();

        $query = SubTrainingProgram::where('training_program_id', $trainingProgram->id)->latest();

        if (request()->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($training) {
                    return view('sub-training-program.partial.action', compact('training'))->render();
                })
                ->rawColumns(['status', 'action'])
                ->toJson();
        }

        $html = $builder->columns([
            ['data' => 'id', 'visible' => false],
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'No', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '5%'],
            ['data' => 'program_name', 'title' => 'Name', 'width' => '45%'],
            ['data' => 'action', 'title' => 'Action', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '10%'],
        ]);

        return view('sub-training-program.index', compact('trainingProgram', 'html'));
    }

    public function store($programId, Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'program_name' => 'required|string|max:255',
            'program_description' => 'nullable|string',
            'document_path' => 'nullable|mimes:pdf',
        ]);

        if ($request->hasFile('document_path')) {
            $path = $request->file('document_path')->store('program_documents', 'public');
            $validated['document_path'] = $path;
        }

        SubTrainingProgram::create([
            'training_program_id'       => $programId,
            'program_name'              => $validated['program_name'],
            'program_description'       => $validated['program_description'] ?? null,
            'document_path'             => $validated['document_path'] ?? null,
            'status'                    => 1,
            'created_by'                => $request->user()->id,
            'updated_by'                => $request->user()->id,
        ]);

        return response()->json(['message' => 'Sub-training program created successfully']);
    }

    public function update($programId, $subProgramId, Request $request)
    {
        // Find the existing record
        $subProgram = SubTrainingProgram::where('training_program_id', $programId)
            ->where('id', $subProgramId)
            ->firstOrFail();

        // Validate input
        $validated = $request->validate([
            'program_name' => 'required|string|max:255',
            'program_description' => 'nullable|string',
            'document_path' => 'nullable|mimes:pdf',
        ]);

        if ($request->hasFile('document_path')) {
            if ($subProgram->document_path) {
                Storage::disk('public')->delete($subProgram->document_path);
            }
            $path = $request->file('document_path')->store('program_documents', 'public');
            $validated['document_path'] = $path;
        } else {
            $validated['document_path'] = $subProgram->document_path;
        }

        $subProgram->update([
            'program_name'              => $validated['program_name'],
            'document_path'             => $validated['document_path'],
            'program_description'       => $validated['program_description'] ?? null,
            'updated_by'                => $request->user()->id,
            'status'                    => $subProgram->status ?? 1,
        ]);

        return response()->json(['message' => 'Sub-training program updated successfully']);
    }


    public function delete($programId, $subProgramId)
    {
        $subProgram = SubTrainingProgram::where('training_program_id', $programId)->where('id', $subProgramId)->firstOrFail();

        if ($subProgram->document_path) {
            Storage::disk('public')->delete($subProgram->document_path);
        }

        $subProgram->delete();

        return response()->json(['message' => 'Sub-training program deleted successfully']);
    }
}
