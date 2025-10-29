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
use Illuminate\Support\Facades\Log;
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

    public function report(Request $request)
    {
        $reportType = $request->input('report_type');
        $year = $request->input('year');   // Example: 2025
        $month = $request->input('month'); // Example: 2025-10

        $query = TniCourse::with(['users' => function ($q) use ($reportType, $year, $month) {
            $q->wherePivot('status', '!=', 'withdrawn');

            if ($reportType == 2 && $year) {
                // Yearly report
                $q->whereYear('tni_course_user.updated_at', $year);
            } elseif ($reportType == 3 && $month) {
                // Monthly report — extract year & month properly
                $parsedMonth = \Carbon\Carbon::parse($month);
                $q->whereYear('tni_course_user.updated_at', $parsedMonth->year)
                ->whereMonth('tni_course_user.updated_at', $parsedMonth->month);
            }
        }, 'competency.program']);

        $courses = $query->get();

        $data = $courses->flatMap(function ($course) {
            return $course->users->map(function ($user) use ($course) {
                return [
                    'Staff ID'          => $user->employee_id ?? '-',
                    'Staff Name'        => $user->name,
                    'Department'        => $user->department ?? '-',
                    'Program Name'      => optional(optional($course->competency)->program)->program_name ?? '-',
                    'Course Name'       => $course->course_name ?? '-',
                    'Duration (Hours)'  => $course->course_duration ?? '-',
                    'Cost'              => $course->course_cost ? number_format((float) $course->course_cost, 2, '.', ',') : '-',
                    'Remark'            => $course->course_category ?? '-',
                    'Date Applied'      => $user->pivot->updated_at ? $user->pivot->updated_at->format('d M Y h:i A') : '-',
                ];
            });
        });

        if ($data->isEmpty()) {
            throw new \Exception('No data available to export.');
        }

        return (new FastExcel($data))->download('program_report.xlsx');
    }
}
