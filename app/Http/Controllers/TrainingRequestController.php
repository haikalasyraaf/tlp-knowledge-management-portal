<?php

namespace App\Http\Controllers;

use App\Models\TrainingRequest;
use App\Models\TrainingRequestDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class TrainingRequestController extends Controller
{
    public function index(Request $request, Builder $builder)
    {
        if($request->user()->role == 'Admin') {
            $query = TrainingRequest::orderBy('id', 'desc');
        } else if ($request->user()->role == 'Staff') {
            $query = TrainingRequest::where('created_by', $request->user()->id)->orderBy('id', 'desc');
        }

        if (request()->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('created_by', function ($trainingRequest) {
                    $user = User::where('id', $trainingRequest->created_by)->first();
                    return $user->name;
                })
                ->editColumn('status', function ($trainingRequest) {
                    if($trainingRequest->status == 1) {
                        return '<span class="badge bg-secondary">Under Review</span>';
                    } else if ($trainingRequest->status == 2) {
                        return '<span class="badge bg-warning">Pending Approval</span>';
                    } else if ($trainingRequest->status == 3) {
                        return '<span class="badge bg-success">Approved</span>';
                    } else if ($trainingRequest->status == 4) {
                        return '<span class="badge bg-danger">Rejected</span>';
                    } else if ($trainingRequest->status == 5) {
                        return '<span class="badge bg-primary">Completed</span>';
                    }
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
            'requestor_name'            => 'required|string|max:255',
            'deparment_name'            => 'required|string|max:255',
            'training_title'            => 'required|string|max:255',
            'training_organiser'        => 'required|string|max:255',
            'training_venue'            => 'required|string|max:255',
            'training_cost'             => 'required|numeric',
            'training_start_date'       => 'required|date',
            'training_end_date'         => 'required|date|after:training_start_date',
            'employees_recommended'     => 'nullable|string',
            'training_objective'        => 'required|string',
            'remarks'                   => 'nullable|string',
        ]);

        $data['date_requested'] = now();
        $data['created_by']     = $request->user()->id;
        $data['updated_by']     = $request->user()->id;

        $trainingRequest = TrainingRequest::create($data);

        return response()->json(['message'   => 'Training Request created successfully.', 'trainingRequest' => $trainingRequest]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'requestor_name'            => 'required|string|max:255',
            'deparment_name'            => 'required|string|max:255',
            'training_title'            => 'required|string|max:255',
            'training_organiser'        => 'required|string|max:255',
            'training_venue'            => 'required|string|max:255',
            'training_cost'             => 'required|numeric',
            'training_start_date'       => 'required|date',
            'training_end_date'         => 'required|date|after:training_start_date',
            'employees_recommended'     => 'nullable|string',
            'training_objective'        => 'required|string',
            'remarks'                   => 'nullable|string',
        ]);

        $data['updated_by'] = $request->user()->id;

        $trainingRequest = TrainingRequest::findOrFail($id);
        $trainingRequest->update($data);

        return response()->json(['message' => 'Training Request updated successfully']);
    }

    public function destroy($id)
    {
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
}
