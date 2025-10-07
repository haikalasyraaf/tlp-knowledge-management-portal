<?php

namespace App\Http\Controllers;

use App\Models\SubTrainingProgram;
use App\Models\TrainingProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TrainingProgramController extends Controller
{
    public function index()
    {
        $trainingPrograms = TrainingProgram::latest()->get();

        return view('training-program.index', compact('trainingPrograms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable',
        ]);

        $data = $request->only(['name', 'description']);

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('training_images', 'public');
            $data['image_path'] = $path;
        }

        TrainingProgram::create($data);

        return response()->json(['message' => 'Training program created successfully']);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable',
        ]);

        $data = $request->only(['name', 'description']);

        $program = TrainingProgram::findOrFail($id);

        if ($request->hasFile('image_path')) {
            if ($program->image_path && Storage::disk('public')->exists($program->image_path)) {
                Storage::disk('public')->delete($program->image_path);
            }

            $path = $request->file('image_path')->store('training_images', 'public');
            $data['image_path'] = $path;
        }

        $program->update($data);

        return response()->json(['message' => 'Training program updated successfully']);
    }

    public function delete($id)
    {
        DB::transaction(function () use ($id) {
            $subPrograms = SubTrainingProgram::where('training_program_id', $id)->get();
            foreach ($subPrograms as $subProgram) {
                if ($subProgram->document_path && Storage::disk('public')->exists($subProgram->document_path)) {
                    Storage::disk('public')->delete($subProgram->document_path);
                }
            }

            SubTrainingProgram::where('training_program_id', $id)->delete();

            $program = TrainingProgram::findOrFail($id);
            if ($program->image_path && Storage::disk('public')->exists($program->image_path)) {
                Storage::disk('public')->delete($program->image_path);
            }

            $program->delete();
        });

        return response()->json(['success' => true]);
    }
}
