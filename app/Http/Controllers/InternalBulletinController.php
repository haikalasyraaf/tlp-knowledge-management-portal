<?php

namespace App\Http\Controllers;

use App\Models\InternalBulletin;
use App\Models\InternalBulletinDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class InternalBulletinController extends Controller
{
    public function index(Request $request, Builder $builder)
    {
        if (request()->ajax()) {
            return DataTables::of(InternalBulletin::query())
                ->addIndexColumn()
                ->editColumn('title', function ($bulletin) {
                    if($bulletin->is_top_learner) {
                        $monthYear = date('M Y', strtotime($bulletin->top_learner_month));
                        return '<strong>' . $bulletin->title . '<br><span class="badge rounded-pill text-bg-success">' . $monthYear . ' Top Learner</span></strong>';
                    } else {
                        return $bulletin->title;
                    }
                })
                ->editColumn('created_by', function ($bulletin) {
                    $user = User::where('id', $bulletin->created_by)->first();
                    return $user->name;
                })
                ->editColumn('created_at', function ($bulletin) {
                    return $bulletin->created_at->format('d/m/Y H:i');
                })
                ->addColumn('action', function ($bulletin) {
                    return view('internal-bulletin.partial.action', compact('bulletin'))->render();
                })
                ->rawColumns(['title', 'is_display', 'action'])
                ->toJson();
        }

        $html = $builder->columns([
            ['data' => 'id', 'visible' => false],
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '5%'],
            ['data' => 'title', 'title' => 'Title', 'width' => '40%'],
            ['data' => 'created_by', 'title' => 'Created By'],
            ['data' => 'created_at', 'title' => 'Posted On'],
            ['data' => 'action', 'title' => 'Action', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '20%'],
        ]);

        return view('internal-bulletin.index', compact('html'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('internal_bulletin_images', 'public');
            $data['image_path'] = $path;
        }

        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        $bulletin = InternalBulletin::create($data);

        return response()->json(['message'   => 'Internal Bulletin created successfully.', 'bulletin' => $bulletin]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $data = $request->all();
        $bulletin = InternalBulletin::findOrFail($id);

        if ($request->hasFile('image_path')) {
            if ($bulletin->image_path && Storage::disk('public')->exists($bulletin->image_path)) {
                Storage::disk('public')->delete($bulletin->image_path);
            }

            $path = $request->file('image_path')->store('internal_bulletin_images', 'public');
            $data['image_path'] = $path;
        }

        $data['updated_by'] = $request->user()->id;
        $bulletin->update($data);

        return response()->json(['message' => 'Internal Bulletin updated successfully']);
    }

    public function delete($id)
    {
        InternalBulletin::findOrFail($id)->delete();
        return response()->json(['message' => 'Internal Bulletin deleted successfully']);
    }

    public function uploadDocument($bulletinId, Request $request)
    {
        $request->validate([
            'document_path' => 'required|max:51200',
        ]);

        $file = $request->file('document_path');
        $path = $file->store('internal_bulletin_document', 'public');

        $document = InternalBulletinDocument::create([
            'internal_bulletin_id'  => $bulletinId,
            'document_name'         => $file->getClientOriginalName(),
            'document_path'         => $path,
            'created_by'            => $request->user()->id,
            'updated_by'            => $request->user()->id,
        ]);

        return response()->json(['message' => 'Internal Bulletin Document uploaded successfully',
            'document' => [
                'id' => $document->id,
                'name' => $document->document_name,
                'path' => asset('storage/' . $document->document_path),
            ],
        ]);
    }

    public function deleteDocument($bulletinId, $id)
    {
        $document = InternalBulletinDocument::findOrFail($id);
        Storage::disk('public')->delete($document->document_path);
        $document->delete();

        return response()->json(['message' => 'Internal Bulletin Document deleted successfully']);
    }
}
