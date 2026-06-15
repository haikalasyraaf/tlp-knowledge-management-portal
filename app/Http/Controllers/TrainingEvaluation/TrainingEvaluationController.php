<?php

namespace App\Http\Controllers\TrainingEvaluation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TrainingEvaluation\TrainingEvaluation;
use App\Models\TrainingEvaluation\TrainingEvaluationQuestion;
use App\Models\TrainingEvaluation\TrainingEvaluationDefaultQuestion;
use App\Models\TrainingEvaluation\TrainingEvaluationGroup;
use App\Notifications\UserAlertNotification;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class TrainingEvaluationController extends Controller
{
    public function index(Request $request, Builder $builder, TrainingEvaluationGroup $trainingEvaluationGroup)
    {
        $user = $request->user();
        $query = TrainingEvaluation::where('form_group_id', $trainingEvaluationGroup->id);

        if (request()->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('user_id', function ($trainingEvaluation) {
                    $user = User::where('id', $trainingEvaluation->user_id)->first();
                    return $user->name;
                })
                ->editColumn('status', function ($trainingEvaluation) {
                    $status = $trainingEvaluation->status;

                    $trainingStatuses = [
                        1 => ['label' => 'Pending', 'class' => 'bg-secondary'],
                        2 => ['label' => 'Submitted', 'class' => 'bg-success'],
                    ];

                    return '<span class="badge '.$trainingStatuses[$status]['class'].'">'.$trainingStatuses[$status]['label'].'</span>';
                })
                ->addColumn('action', function ($trainingEvaluation) {
                    return view('training-evaluation.partial.action-list', compact('trainingEvaluation'))->render();
                })
                ->rawColumns(['user_id', 'status', 'action'])
                ->toJson();
        }

        $html = $builder->columns([
            ['data' => 'id', 'visible' => false],
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '5%'],
            ['data' => 'user_id', 'title' => 'Title', 'width' => '40%'],
            ['data' => 'status', 'title' => 'Status'],
            ['data' => 'action', 'title' => 'Action', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '20%'],
        ]);

        return view('training-evaluation.list', compact('html', 'trainingEvaluationGroup'));
    }

    public function show(TrainingEvaluationGroup $trainingEvaluationGroup, User $user)
    {
        $trainingEvaluation = TrainingEvaluation::where('form_group_id', $trainingEvaluationGroup->id)->where('user_id', $user->id)->first();
        return view('training-evaluation.show', compact('trainingEvaluation'));
    }

    public function submit(Request $request, TrainingEvaluation $trainingEvaluation)
    {

        $request->validate([
            'answers' => 'required|array|min:1',
            'answers.*.question_id' => 'required|exists:training_evaluation_questions,id',
            'answers.*.answer_value' => 'required_if:answers.*.question_type,scale|integer|min:1|max:5',
            'answers.*.answer_text' => 'required_if:answers.*.question_type,text|string|max:1000',
        ]);

        foreach ($request->answers as $answer) {
            $question = TrainingEvaluationQuestion::find($answer['question_id']);
            $question->answer_value = $answer['answer_value'] ?? null;
            $question->answer_text  = $answer['answer_text'] ?? null;
            $question->update();
        }

        $trainingEvaluation->status = 2;
        $trainingEvaluation->submitted_on = now();
        $trainingEvaluation->update();

        return response()->json(['message' => $trainingEvaluation->form_title . ' submit successfully']);
    }

    public function export(TrainingEvaluation $trainingEvaluation)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(9);

        // Column widths
        $sheet->getColumnDimension('A')->setWidth(0.68);
        $sheet->getColumnDimension('B')->setWidth(5);    // No
        $sheet->getColumnDimension('C')->setWidth(50);   // Evaluation
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
        $sheet->setCellValue('B2', 'TITLE : TRAINING EFFECTIVENESS EVALUATION FORM');
        $sheet->mergeCells('E2:H2');
        $sheet->getStyle('E2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FF6600'); // Orange
        $sheet->getStyle('E2:H2')->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('E2')->getFont()->setBold(true)->setSize(8);
        $sheet->getStyle('E2')->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->setCellValue('E2', "THIS RECORD SHALL BE KEPT\nFOR AT LEAST 7 YEARS");

        // Example participant info
        $sheet->setCellValue('C4', 'Name / Nama');
        $sheet->setCellValue('D4', $trainingEvaluation->user->name ?? '---');

        $sheet->setCellValue('C5', 'Department / Jabatan');
        $sheet->setCellValue('D5', $trainingEvaluation->user->department ?? '---');

        $sheet->setCellValue('C6', 'Course Title / Tajuk Kursus');
        $sheet->setCellValue('D6', $trainingEvaluation->form_title ?? '---');

        $sheet->setCellValue('C7', 'Date / Tarikh');
        $sheet->setCellValue('D7', $trainingEvaluation->form_date?->format('d-M-Y') ?? '---');

        // Evaluation questions header
        $sheet->setCellValue('B9', 'No');
        $sheet->setCellValue('C9', 'Evaluation');
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
        foreach ($trainingEvaluation->questions as $index => $question) {
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
        }, 'training-evaluation.xlsx');
    }

    public function delete(TrainingEvaluationGroup $trainingEvaluationGroup) 
    {
        TrainingEvaluationGroup::findOrFail($trainingEvaluationGroup->id)->delete();
        return response()->json(['message' => 'Training Evaluation deleted successfully']);
    }
}