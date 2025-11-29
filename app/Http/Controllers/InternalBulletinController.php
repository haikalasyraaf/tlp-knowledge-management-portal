<?php

namespace App\Http\Controllers;

use App\Models\InternalBulletin;
use App\Models\InternalBulletinDocument;
use App\Models\User;
use App\Notifications\UserAlertNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
                ->editColumn('image_display', function ($bulletin) {
                    $image = $bulletin->image_path ? Storage::url($bulletin->image_path) : asset('images/default-news.png');
                    return '<img src="' . $image . '" style="width: 120px; height: 100%; object-fit: cover; object-position: center; border-radius: 8px;">';
                })
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
                ->rawColumns(['image_display', 'title', 'is_display', 'action'])
                ->toJson();
        }

        $html = $builder->columns([
            ['data' => 'id', 'visible' => false],
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '5%'],
            ['data' => 'image_display', 'title' => 'Image', 'orderable' => false, 'searchable' => false],
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

        $users = User::whereNot('id', $bulletin->created_by)->get();
        $sender = User::find($bulletin->created_by);

        foreach($users as $user) {
            try {
                $user->notify(new UserAlertNotification(
                    'Internal Bulletin',
                    'New Bulletin Added',
                    $sender->name . ' has added a new bulletin: "' . $bulletin->title . '".',
                    $sender->name
                ));
            } catch (\Exception $e) {
                Log::warning("Alert notification failed for ({$user->employee_id}) {$user->name}: {$e->getMessage()}");
            }
        }

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
