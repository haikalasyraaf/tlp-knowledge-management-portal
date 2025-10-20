<?php

namespace App\Http\Controllers\TrainingNeedsIdentification;

use App\Http\Controllers\Controller;
use App\Models\TrainingNeedsIdentification\TniCompetency;
use App\Models\TrainingNeedsIdentification\TniCourse;
use App\Models\TrainingNeedsIdentification\TniProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TniCompetencyController extends Controller
{
    public function index($program_id)
    {
        $program = TniProgram::findOrFail($program_id);
        $tniCompetencies = TniCompetency::where('tni_program_id', $program->id)->latest()->get();

        return view('training-needs-identification.competency.index', compact('program' ,'tniCompetencies'));
    }

    public function store($program_id, Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('tni_competency_images', 'public');
            $data['image_path'] = $path;
        }

        $data['tni_program_id'] = $program_id;
        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;

        TniCompetency::create($data);

        return response()->json(['message' => 'Competency added successfully']);
    }

    public function update($program_id, $competency_id, Request $request)
    {
        $data = $request->all();

        $competency = TniCompetency::findOrFail($competency_id);

        if ($request->hasFile('image_path')) {
            if ($competency->image_path && Storage::disk('public')->exists($competency->image_path)) {
                Storage::disk('public')->delete($competency->image_path);
            }

            $path = $request->file('image_path')->store('tni_competency_images', 'public');
            $data['image_path'] = $path;
        }

        $data['tni_program_id'] = $program_id;
        $data['updated_by'] = Auth::user()->id;

        $competency->update($data);

        return response()->json(['message' => 'Competency updated successfully']);
    }

    public function delete($id)
    {
        DB::transaction(function () use ($id) {
            TniCourse::where('tni_competency_id', $id)->delete();

            $competency = TniCompetency::findOrFail($id);
            if ($competency->image_path && Storage::disk('public')->exists($competency->image_path)) {
                Storage::disk('public')->delete($competency->image_path);
            }

            $competency->delete();
        });

        return response()->json(['success' => true]);
    }
}
