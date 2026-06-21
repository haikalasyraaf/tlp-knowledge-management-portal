<?php

namespace App\Http\Controllers\TrainingAssessment;

use App\Http\Controllers\Controller;
use App\Models\TrainingAssessment\TrainingAssessment;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TrainingAssessment\TrainingAssessmentGroup;
use App\Models\TrainingAssessment\TrainingAssessmentPostQuestion;
use App\Models\TrainingAssessment\TrainingAssessmentPreQuestion;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class TrainingAssessmentController extends Controller
{
    public function index(Request $request, Builder $builder, TrainingAssessmentGroup $trainingAssessmentGroup)
    {
        $user = $request->user();
        $query = TrainingAssessment::where('form_group_id', $trainingAssessmentGroup->id);

        if (request()->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('user_id', function ($trainingAssessment) {
                    $user = User::where('id', $trainingAssessment->user_id)->first();
                    return $user->name;
                })
                ->editColumn('status', function ($trainingAssessment) {
                    $status = $trainingAssessment->status;

                    $trainingStatuses = [
                        1 => ['label' => 'Pending Pre', 'class' => 'bg-secondary'],
                        2 => ['label' => 'Pending Post', 'class' => 'bg-warning'],
                        3 => ['label' => 'Submitted', 'class' => 'bg-success'],
                    ];

                    return '<span class="badge '.$trainingStatuses[$status]['class'].'">'.$trainingStatuses[$status]['label'].'</span>';
                })
                ->addColumn('action', function ($trainingAssessment) {
                    return view('training-assessment.partial.action-list', compact('trainingAssessment'))->render();
                })
                ->rawColumns(['user_id', 'status', 'action'])
                ->toJson();
        }

        $html = $builder->columns([
            ['data' => 'id', 'visible' => false],
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '5%'],
            ['data' => 'user_id', 'title' => 'Title', 'width' => '35%'],
            ['data' => 'status', 'title' => 'Status'],
            ['data' => 'action', 'title' => 'Action', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '25%'],
        ]);

        return view('training-assessment.list', compact('html', 'trainingAssessmentGroup'));
    }

    public function showPreQuestion(TrainingAssessmentGroup $trainingAssessmentGroup, User $user)
    {
        $trainingAssessment = TrainingAssessment::where('form_group_id', $trainingAssessmentGroup->id)->where('user_id', $user->id)->first();
        return view('training-assessment.pre-show', compact('trainingAssessment'));
    }

    public function showPostQuestion(TrainingAssessmentGroup $trainingAssessmentGroup, User $user)
    {
        $trainingAssessment = TrainingAssessment::where('form_group_id', $trainingAssessmentGroup->id)->where('user_id', $user->id)->first();
        return view('training-assessment.post-show', compact('trainingAssessment'));
    }

    public function submitPreQuestion(Request $request, TrainingAssessment $trainingAssessment)
    {

        $request->validate([
            'answers' => 'required|array|min:1',
            'answers.*.question_id' => 'required|exists:training_assessment_pre_questions,id',
            'answers.*.answer_value' => 'required_if:answers.*.question_type,scale|integer|min:1|max:5',
            'answers.*.answer_text' => 'required_if:answers.*.question_type,text|string|max:1000',
        ]);

        foreach ($request->answers as $answer) {
            $question = TrainingAssessmentPreQuestion::find($answer['question_id']);
            $question->answer_value = $answer['answer_value'] ?? null;
            $question->answer_text  = $answer['answer_text'] ?? null;
            $question->update();
        }

        $trainingAssessment->status = 2;
        $trainingAssessment->pre_submitted_on = now();
        $trainingAssessment->update();

        return response()->json(['message' => $trainingAssessment->form_title . ' submit successfully']);
    }

    public function submitPostQuestion(Request $request, TrainingAssessment $trainingAssessment)
    {

        $request->validate([
            'answers' => 'required|array|min:1',
            'answers.*.question_id' => 'required|exists:training_assessment_post_questions,id',
            'answers.*.answer_value' => 'required_if:answers.*.question_type,scale|integer|min:1|max:5',
            'answers.*.answer_text' => 'required_if:answers.*.question_type,text|string|max:1000',
        ]);

        foreach ($request->answers as $answer) {
            $question = TrainingAssessmentPostQuestion::find($answer['question_id']);
            $question->answer_value = $answer['answer_value'] ?? null;
            $question->answer_text  = $answer['answer_text'] ?? null;
            $question->update();
        }

        $trainingAssessment->status = 3;
        $trainingAssessment->post_submitted_on = now();
        $trainingAssessment->update();

        return response()->json(['message' => $trainingAssessment->form_title . ' submit successfully']);
    }

    public function export(TrainingAssessment $trainingAssessment)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(9);

        // Column widths
        $sheet->getColumnDimension('A')->setWidth(0.68);
        $sheet->getColumnDimension('B')->setWidth(5);    // No
        $sheet->getColumnDimension('C')->setWidth(50);   // Assessment
        $sheet->getColumnDimension('D')->setWidth(5);    // 1
        $sheet->getColumnDimension('E')->setWidth(5);    // 2
        $sheet->getColumnDimension('F')->setWidth(5);    // 3
        $sheet->getColumnDimension('G')->setWidth(5);    // 4
        $sheet->getColumnDimension('H')->setWidth(5);    // 5

        // Example header rows
        $sheet->getRowDimension('2')->setRowHeight(30);
        $sheet->getStyle('2:2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B2')->getFont()->setBold(true)->setSize(10);
        $sheet->mergeCells('B2:D2');
        $sheet->setCellValue('B2', 'TITLE : TRAINING EFFECTIVENESS ASSESSMENT FORM');
        $sheet->mergeCells('E2:H2');
        $sheet->getStyle('E2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FF6600'); // Orange
        $sheet->getStyle('E2:H2')->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('E2')->getFont()->setBold(true)->setSize(8);
        $sheet->getStyle('E2')->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->setCellValue('E2', "THIS RECORD SHALL BE KEPT\nFOR AT LEAST 7 YEARS");

        // Example participant info
        $sheet->setCellValue('C4', 'Name / Nama');
        $sheet->setCellValue('D4', $trainingAssessment->user->name ?? '---');

        $sheet->setCellValue('C5', 'Department / Jabatan');
        $sheet->setCellValue('D5', $trainingAssessment->user->department ?? '---');

        $sheet->setCellValue('C6', 'Course Title / Tajuk Kursus');
        $sheet->setCellValue('D6', $trainingAssessment->form_title ?? '---');

        $sheet->setCellValue('C7', 'Date / Tarikh');
        $sheet->setCellValue('D7', $trainingAssessment->form_date?->format('d-M-Y') ?? '---');

        // Assessment questions header
        $sheet->setCellValue('B9', 'No');
        $sheet->setCellValue('C9', 'Assessment');
        $sheet->setCellValue('D9', '1');
        $sheet->setCellValue('E9', '2');
        $sheet->setCellValue('F9', '3');
        $sheet->setCellValue('G9', '4');
        $sheet->setCellValue('H9', '5');

        // Bold header row
        $sheet->getStyle('B9:H9')->getFont()->setBold(true);
        $sheet->getStyle('B9:H9')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
                                                ->setVertical(Alignment::VERTICAL_CENTER);

        // Fill header row background
        $sheet->getStyle('B9:H9')->getFill()->setFillType(Fill::FILL_SOLID)
                                            ->getStartColor()->setARGB('FF1F4E78'); // Dark Blue
                                            #ff6600

        // Font color white for header
        $sheet->getStyle('B9:H9')->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->getColumnDimension('C')->setAutoSize(true);

        // Add questions
        $row = 10;
        foreach ($trainingAssessment->questions as $index => $question) {
            $sheet->setCellValue('B'.$row, $index + 1);
            $sheet->setCellValue('C'.$row, $question->question_text);
            // leave C-G blank for answer
            $row++;
        }

        // Borders
        $sheet->getStyle("B9:H$row")->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Export
        $writer = new Xlsx($spreadsheet);
        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, 'training-assessment.xlsx');
    }

    public function delete(TrainingAssessmentGroup $trainingAssessmentGroup) 
    {
        TrainingAssessmentGroup::findOrFail($trainingAssessmentGroup->id)->delete();
        return response()->json(['message' => 'Training Assessment deleted successfully']);
    }
}