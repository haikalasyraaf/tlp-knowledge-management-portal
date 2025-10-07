<?php

namespace App\Http\Controllers;

use App\Models\TransferOfKnowledge;
use App\Models\TransferOfKnowledgeDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class TransferOfKnowledgeController extends Controller
{
    public function index(Request $request, Builder $builder)
    {
        if (request()->ajax()) {
            return DataTables::of(TransferOfKnowledge::query())
                ->addIndexColumn()
                ->editColumn('created_by', function ($knowledge) {
                    $user = User::where('id', $knowledge->created_by)->first();
                    return $user->name;
                })
                ->editColumn('created_at', function ($knowledge) {
                    return $knowledge->created_at->format('d/m/Y H:i');
                })
                ->addColumn('action', function ($knowledge) {
                    return view('transfer-of-knowledge.partial.action', compact('knowledge'))->render();
                })
                ->rawColumns(['is_display', 'action'])
                ->toJson();
        }

        $html = $builder->columns([
            ['data' => 'id', 'visible' => false],
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '5%'],
            ['data' => 'title', 'title' => 'Title', 'width' => '45%'],
            ['data' => 'created_by', 'title' => 'Author By'],
            ['data' => 'created_at', 'title' => 'Posted On'],
            ['data' => 'action', 'title' => 'Action', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '10%'],
        ]);

        return view('transfer-of-knowledge.index', compact('html'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $data = $request->all();

        TransferOfKnowledge::create([
            'title'         => $data['title'] ?? null,
            'content'       => $data['content'] ?? null,
            'created_by'    => $request->user()->id,
            'updated_by'    => $request->user()->id,
        ]);

        return response()->json(['message' => 'Transfer of Knowledge created successfully']);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $data = $request->all();
        $knowledge = TransferOfKnowledge::findOrFail($id);

        $knowledge->update([
            'title'         => $data['title'] ?? null,
            'content'       => $data['content'] ?? null,
            'updated_by'    => $request->user()->id,
        ]);

        return response()->json(['message' => 'Transfer of Knowledge updated successfully']);
    }

    public function delete($id)
    {
        TransferOfKnowledge::findOrFail($id)->delete();
        return response()->json(['message' => 'Transfer of Knowledge deleted successfully']);
    }

    public function uploadDocument($knowledgeId, Request $request)
    {
        $request->validate([
            'document_path' => 'required|max:51200',
        ]);

        $file = $request->file('document_path');
        $path = $file->store('transfer_of_knowledge_document', 'public');

        $document = TransferOfKnowledgeDocument::create([
            'transfer_of_knowledge_id' => $knowledgeId,
            'document_name'            => $file->getClientOriginalName(),
            'document_path'            => $path,
            'created_by'               => $request->user()->id,
            'updated_by'               => $request->user()->id,
        ]);

        return response()->json(['message' => 'Transfer of Knowledge Document uploaded successfully',
            'document' => [
                'id' => $document->id,
                'name' => $document->document_name,
                'path' => asset('storage/' . $document->document_path),
            ],
        ]);
    }

    public function deleteDocument($knowledgeId, $id)
    {
        $document = TransferOfKnowledgeDocument::findOrFail($id);
        Storage::disk('public')->delete($document->document_path);
        $document->delete();

        return response()->json(['message' => 'Transfer of Knowledge Document deleted successfully']);
    }
}
