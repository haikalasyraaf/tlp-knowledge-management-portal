<?php

namespace App\Http\Controllers;

use App\Models\TrainingRequest;
use App\Models\TrainingRequestDocument;
use App\Models\TrainingRequestStatus;
use App\Models\TrainingRequestUser;
use App\Models\User;
use App\Notifications\UserAlertNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class TrainingRequestController extends Controller
{
    public function index(Request $request, Builder $builder)
    {
        $user = $request->user();
        $query = TrainingRequest::with(['reviewStatus', 'approveStatus']);
        if ($user->role == 'Staff') {
            $query->where('created_by', $user->id);
        }

        if (request()->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('created_by', function ($trainingRequest) {
                    $user = User::where('id', $trainingRequest->created_by)->first();
                    return $user->name;
                })
                ->editColumn('status', function ($trainingRequest) use ($user) {
                    $status = $trainingRequest->status;

                    $trainingStatuses = [
                        1 => ['label' => 'Under Review', 'class' => 'bg-secondary'],
                        2 => ['label' => 'Pending Recommendation', 'class' => 'bg-warning'],
                        3 => ['label' => 'Recommended', 'class' => 'bg-success'],
                        4 => ['label' => 'Not Recommended', 'class' => 'bg-danger'],
                        5 => ['label' => 'Pending Approval', 'class' => 'bg-warning'],
                        6 => ['label' => 'Approved', 'class' => 'bg-success'],
                        7 => ['label' => 'Rejected', 'class' => 'bg-danger'],
                        8 => ['label' => 'KIV', 'class' => 'bg-danger'],
                        9 => ['label' => 'Training Completed', 'class' => 'bg-primary'],
                    ];

                    if ($user->role != 'Admin' && in_array($status, [2,3,4,5])) {
                        $status = 1;
                    }

                    return '<span class="badge '.$trainingStatuses[$status]['class'].'">'.$trainingStatuses[$status]['label'].'</span>';
                })
                ->addColumn('action', function ($trainingRequest) {
                    return view('training-request.partial.action', compact('trainingRequest'))->render();
                })
                ->rawColumns(['created_by', 'status', 'action'])
                ->toJson();
        }

        $html = $builder->columns([
            ['data' => 'id', 'visible' => false],
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '5%'],
            ['data' => 'training_title', 'title' => 'Title', 'width' => '40%'],
            ['data' => 'created_by', 'title' => 'Requested By'],
            ['data' => 'status', 'title' => 'Status', 'className' => 'text-center'],
            ['data' => 'action', 'title' => 'Action', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '20%'],
        ]);

        return view('training-request.index', compact('html'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'requestor_name'                => 'required|string|max:255',
            'deparment_name'                => 'required|string|max:255',
            'training_title'                => 'required|string|max:255',
            'training_organiser'            => 'required|string|max:255',
            'training_venue'                => 'required|string|max:255',
            'training_cost'                 => 'required|numeric',
            'training_start_date'           => 'required|date',
            'training_end_date'             => 'required|date|after_or_equal:training_start_date',
            'employees_recommended'         => 'nullable|string',
            'training_objective'            => 'required|string',
            'remarks'                       => 'nullable|string',
            'participants'                  => 'required|array|min:1',
            'participants.*.name'           => 'required|string|max:255',
            'participants.*.department'     => 'nullable|string|max:255',
        ], [
            'participants.required'         => 'At least one participant is required to proceed.',
            'participants.*.name.required'  => 'Ensure each participant name is filled. Remove any empty rows to proceed.',
        ]);

        $data['date_requested'] = now();
        $data['created_by']     = $request->user()->id;
        $data['updated_by']     = $request->user()->id;

        $trainingRequest = TrainingRequest::create($data);

        if ($request->has('participants')) {
            foreach ($request->participants as $participant) {
                TrainingRequestUser::create([
                    'training_request_id' => $trainingRequest->id,
                    'name'                => $participant['name'],
                    'department'          => $participant['department'] ?? null,
                    'status'              => 1,
                    'created_by'          => $request->user()->id,
                    'updated_by'          => $request->user()->id,
                ]);
            }
        }

        $users = User::whereNot('id', $trainingRequest->created_by)->where('is_reviewer', 1)->get();
        $sender = User::find($trainingRequest->created_by);

        foreach($users as $user) {
            try {
                $user->notify(new UserAlertNotification(
                    'Training Request',
                    'New Training Request Pending Your Review',
                    "{$sender->name} has submitted a new training request titled \"{$trainingRequest->training_title}\". Seeking your help to review it.",
                    $sender->name
                ));
            } catch (\Exception $e) {
                Log::warning("Alert notification failed for ({$user->employee_id}) {$user->name}: {$e->getMessage()}");
            }
        }

        return response()->json(['message'   => 'Training Request created successfully.', 'trainingRequest' => $trainingRequest]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'requestor_name'                => 'required|string|max:255',
            'deparment_name'                => 'required|string|max:255',
            'training_title'                => 'required|string|max:255',
            'training_organiser'            => 'required|string|max:255',
            'training_venue'                => 'required|string|max:255',
            'training_cost'                 => 'required|numeric',
            'training_start_date'           => 'required|date',
            'training_end_date'             => 'required|date|after_or_equal:training_start_date',
            'employees_recommended'         => 'nullable|string',
            'training_objective'            => 'required|string',
            'remarks'                       => 'nullable|string',
            'participants'                  => 'required|array|min:1',
            'participants.*.name'           => 'required|string|max:255',
            'participants.*.department'     => 'nullable|string|max:255',
        ], [
            'participants.required'         => 'At least one participant is required to proceed.',
            'participants.*.name.required'  => 'Ensure each participant name is filled. Remove any empty rows to proceed.',
        ]);

        $data['updated_by'] = $request->user()->id;

        $trainingRequest = TrainingRequest::findOrFail($id);
        $trainingRequest->update($data);

        TrainingRequestUser::where('training_request_id', $trainingRequest->id)->delete();

        if ($request->has('participants')) {
            foreach ($request->participants as $participant) {
                TrainingRequestUser::create([
                    'training_request_id' => $trainingRequest->id,
                    'name'                => $participant['name'],
                    'department'          => $participant['department'] ?? null,
                    'created_by'          => $request->user()->id,
                    'updated_by'          => $request->user()->id,
                ]);
            }
        }

        return response()->json(['message' => 'Training Request updated successfully']);
    }

    public function destroy($id)
    {
        TrainingRequestUser::where('training_request_id', $id)->delete();
        TrainingRequest::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully.',
        ]);
    }

    public function uploadDocument($trainingRequestId, Request $request)
    {
        $request->validate([
            'document_path' => 'required|max:51200',
        ]);

        $file = $request->file('document_path');
        $path = $file->store('training_request_document', 'public');

        $document = TrainingRequestDocument::create([
            'training_request_id'      => $trainingRequestId,
            'document_name'            => $file->getClientOriginalName(),
            'document_path'            => $path,
            'created_by'               => $request->user()->id,
            'updated_by'               => $request->user()->id,
        ]);

        return response()->json(['message' => 'Training Request Document uploaded successfully',
            'document' => [
                'id' => $document->id,
                'name' => $document->document_name,
                'path' => asset('storage/' . $document->document_path),
            ],
        ]);
    }

    public function deleteDocument($trainingRequestId, $id)
    {
        $document = TrainingRequestDocument::findOrFail($id);
        Storage::disk('public')->delete($document->document_path);
        $document->delete();

        return response()->json(['message' => 'Training Request Document deleted successfully']);
    }

    public function generateFormPDF($id)
    {
        $trainingRequest = TrainingRequest::findOrFail($id);

        $pdf = Pdf::loadView('pdf.training-request-form', ['training' => $trainingRequest]);

        return $pdf->download($trainingRequest->training_title . '_training_form.pdf');
    }

    public function review(Request $request, $id)
    {
        $data = $request->validate([
            'transport_to_venue'        => 'required|string|max:255',
            'transportation_remark'     => 'nullable|required_if:transport_to_venue,4',
            'approved_training_cost'    => 'required|numeric',
            'training_duration'         => 'required|numeric',
            'is_accomodation_required'  => '',
            'is_hdrc_claimable'         => '',
            'is_budget_under_atp'       => '',
            'accommodation_name'        => 'nullable|required_if:is_accomodation_required,1',
            'internal_or_external'      => 'required|string',
            'remarks'                   => 'nullable|string',
        ]);

        $data['training_request_id']    = $id;
        $data['user_id']                = $request->user()->id;
        $data['status_type']            = 1;

        $trainingStatus = TrainingRequestStatus::create($data);

        $trainingRequest = TrainingRequest::findOrFail($id);
        $trainingRequest->update([
            'status' => 2
        ]);

        $users = User::whereNot('id', $trainingRequest->created_by)->where('is_approver', 1)->get();
        $sender = User::find($trainingStatus->user_id);

        foreach($users as $user) {
            try {
                $user->notify(new UserAlertNotification(
                    'Training Request',
                    'New Training Request Pending Your Approval',
                    "{$sender->name} has reviewed training request titled \"{$trainingRequest->training_title}\". Currently seeking your approval.",
                    $sender->name
                ));
            } catch (\Exception $e) {
                Log::warning("Alert notification failed for ({$user->employee_id}) {$user->name}: {$e->getMessage()}");
            }
        }

        return response()->json(['message' => 'Training Request Review Added']);
    }

    public function approve(Request $request, $id)
    {
        $data = $request->validate([
            'approval_decision' => 'required|string|max:255',
            'remarks'           => 'nullable|required_if:approval_decision,2',
        ]);

        $data['training_request_id']    = $id;
        $data['user_id']                = $request->user()->id;
        $data['status_type']            = 2;

        $trainingStatus = TrainingRequestStatus::create($data);

        $statusToBeUpdate = 4; // NOT RECOMMENDED
        if($trainingStatus->approval_decision == 1) {
            $statusToBeUpdate = 3; // RECOMMENDED
        } else if($trainingStatus->approval_decision == 3) {
            $statusToBeUpdate = 8; // KIV
        }

        $trainingRequest = TrainingRequest::findOrFail($id);
        $trainingRequest->update([
            'status' => $statusToBeUpdate
        ]);

        return response()->json(['message' => 'Training Request Status Added']);
    }

    public function hocApprove(Request $request, $id)
    {
        $data = $request->validate([
            'approval_decision' => 'required|string|max:255',
            'remarks'           => 'nullable|required_if:approval_decision,2',
        ]);

        $data['training_request_id']    = $id;
        $data['user_id']                = $request->user()->id;
        $data['status_type']            = 3;

        $trainingStatus = TrainingRequestStatus::create($data);

        $statusToBeUpdate = 7; // REJECTED
        if($trainingStatus->approval_decision == 1) {
            $statusToBeUpdate = 6; // APPROVED
        } else if($trainingStatus->approval_decision == 3) {
            $statusToBeUpdate = 8; // KIV
        }

        $trainingRequest = TrainingRequest::findOrFail($id);
        $trainingRequest->update([
            'status' => $statusToBeUpdate
        ]);

        $user = User::where('id', $trainingRequest->created_by)->first();
        $sender = User::find($trainingStatus->user_id);

        if ($trainingStatus->approval_decision == 1) {
            try {
                $user->notify(new UserAlertNotification(
                    'Training Request',
                    'Training Request Approved',
                    "{$sender->name} has reviewed training request titled \"{$trainingRequest->training_title}\". We are happy to inform it has been approved.",
                    $sender->name
                ));
            } catch (\Exception $e) {
                Log::warning("Alert notification failed for ({$user->employee_id}) {$user->name}: {$e->getMessage()}");
            }
        } else {
            try {
                $user->notify(new UserAlertNotification(
                    'Training Request',
                    'Training Request Rejected',
                    "{$sender->name} has reviewed training request titled \"{$trainingRequest->training_title}\". We are sorry to inform it has been rejected.",
                    $sender->name
                ));
            } catch (\Exception $e) {
                Log::warning("Alert notification failed for ({$user->employee_id}) {$user->name}: {$e->getMessage()}");
            }
        }

        return response()->json(['message' => 'Training Request HOC Status Added']);
    }

    public function markAsCompleted(Request $request, $id)
    {
        $trainingRequest = TrainingRequest::findOrFail($id);
        $trainingRequest->update(['status' => 9]);

        return response()->json(['message' => 'Training Request Mark As Completed']);
    }

    public function report(Request $request)
    {
        $reportType = $request->input('report_type');
        $year = $request->input('year');   // Example: 2025
        $month = $request->input('month'); // Example: 2025-10

        if ($reportType == 2 && $year) {
            // Yearly report
            $query = TrainingRequest::whereYear('created_at', $year);
        } elseif ($reportType == 3 && $month) {
            // Monthly report — extract year & month properly
            $parsedMonth = \Carbon\Carbon::parse($month);
            $query = TrainingRequest::whereYear('created_at', $parsedMonth->year)
                ->whereMonth('created_at', $parsedMonth->month);
        } else {
            $query = TrainingRequest::query();
        }

        $trainingRequests = $query->get();

        $counter = 0;
        $data = $trainingRequests->flatMap(function ($training) use (&$counter) {
            $counter++;
            $participants = $training->participants;
            return $participants->map(function ($participant, $index) use ($training, $participants, $counter) {
                return [
                    'No'                  => $index === 0 ? $counter : '',
                    'Date'                => $index === 0 ? (($s = Carbon::parse($training->training_start_date)) && ($e = Carbon::parse($training->training_end_date)) && $s->isSameDay($e) ? $s->format('d/m/Y') : $s->format('d/m/Y') . ' - ' . $e->format('d/m/Y')) : '',
                    'Course'              => $index === 0 ? $training->training_title : '',
                    'Name of Participant' => $participant->name,
                    'Department'          => $participant->department ?? '',
                    'No of Pax'           => $index === 0 ? $participants->count() : '',
                    'Internal'            => ($index === 0 && $training->reviewStatus) ? ($training->reviewStatus->internal_or_external == 1 ? '/' : '') : '',
                    'External'            => ($index === 0 && $training->reviewStatus) ? ($training->reviewStatus->internal_or_external != 1 ? '/' : '') : '',
                    'Total Cost (RM)'     => ($index === 0 && $training->reviewStatus) ? $training->reviewStatus->approved_training_cost : '',
                    'Total Mandays'       => '',
                    'Training Hour'       => ($index === 0 && $training->reviewStatus) ? $training->reviewStatus->training_duration : '',
                    'Training Manhours'   => '',
                    'Training Provider'   => $index === 0 ? $training->training_organiser : '',
                    'HRDF Claim'          => ($index === 0 && $training->reviewStatus) ? ($training->reviewStatus->is_hdrc_claimable == 1 ? 'YES' : 'NO') : '',
                    'Effectiveness Date'  => '',
                ];
            });
        });

        if ($data->isEmpty()) {
            throw new \Exception('No data available to export.');
        }

        return (new FastExcel($data))->download('training_request.xlsx');
    }
}
