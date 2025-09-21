<?php

namespace App\Http\Controllers;

use App\Models\TrainingProgram;
use Illuminate\Http\Request;
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
        TrainingProgram::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
