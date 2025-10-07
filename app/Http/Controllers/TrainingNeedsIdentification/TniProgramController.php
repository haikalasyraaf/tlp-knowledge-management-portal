<?php

namespace App\Http\Controllers\TrainingNeedsIdentification;

use App\Http\Controllers\Controller;
use App\Models\TrainingNeedsIdentification\TniCompetency;
use App\Models\TrainingNeedsIdentification\TniCourse;
use App\Models\TrainingNeedsIdentification\TniProgram;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TniProgramController extends Controller
{
    public function index()
    {
        $tniPrograms = TniProgram::latest()->get();

        return view('training-needs-identification.program.index', compact('tniPrograms'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('tni_program_images', 'public');
            $data['image_path'] = $path;
        }

        $data['created_at'] = Auth::user()->id;
        $data['updated_at'] = Auth::user()->id;

        TniProgram::create($data);

        return response()->json(['message' => 'Program added successfully']);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();

        $program = TniProgram::findOrFail($id);

        if ($request->hasFile('image_path')) {
            if ($program->image_path && Storage::disk('public')->exists($program->image_path)) {
                Storage::disk('public')->delete($program->image_path);
            }

            $path = $request->file('image_path')->store('tni_program_images', 'public');
            $data['image_path'] = $path;
        }

        $data['updated_at'] = Auth::user()->id;

        $program->update($data);

        return response()->json(['message' => 'Program updated successfully']);
    }

    public function delete($id)
    {
        DB::transaction(function () use ($id) {
            $competencies = TniCompetency::where('tni_program_id', $id)->get();

            foreach ($competencies as $competency) {
                TniCourse::where('tni_competency_id', $competency->id)->delete();

                if ($competency->image_path && Storage::disk('public')->exists($competency->image_path)) {
                    Storage::disk('public')->delete($competency->image_path);
                }
            }

            TniCompetency::where('tni_program_id', $id)->delete();

            $program = TniProgram::findOrFail($id);
            if ($program->image_path && Storage::disk('public')->exists($program->image_path)) {
                Storage::disk('public')->delete($program->image_path);
            }

            $program->delete();
        });

        return response()->json(['success' => true]);
    }

    public function report()
    {
        $courses = TniCourse::with(['users'])->get();

        $data = $courses->flatMap(function ($course) {
            return $course->users->map(function ($user) use ($course) {
                return [
                    'Staff ID'          => $user->employee_id ?? '-',
                    'Staff Name'        => $user->name,
                    'Department'        => $user->department ?? '-',
                    'Program Name'      => $course->competency->program->program_name,
                    'Course Name'       => $course->course_name,
                    'Duration (Hours)'  => $course->course_duration ?? '-',
                    'Cost'              => number_format((float) $course->course_cost, 2, '.', ',')  ?? '-',
                    'Remark'            => $course->course_category ?? '-',
                ];
            });
        });

        return (new FastExcel($data))->download('program_report.xlsx');
    }
}
