<?php

namespace App\Http\Controllers;

use App\Models\LoginImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class LoginImageController extends Controller
{
    public function index(Request $request, Builder $builder)
    {
        if (request()->ajax()) {
            return DataTables::of(LoginImage::query())
                ->addIndexColumn()
                ->editColumn('image_display', function ($image) {
                    return '<img src="' . Storage::url($image->image_path) . '" alt="' . ($image->image_label ?? 'Login Image') . '" style="width: 120px; height: 100%; object-fit: cover; object-position: center; border-radius: 8px;">';
                })
                ->editColumn('image_label', function ($image) {
                    if($image->image_label || $image->image_placeholder) {
                        return '<b>' . ($image->image_label ?? '') . '</b> <br><small class="text-muted">' . ($image->image_placeholder ?? '') . '</small>';
                    } else {
                        return '-';
                    }
                })
                ->addColumn('action', function ($image) {
                    return view('login-image.partial.action', compact('image'))->render();
                })
                ->rawColumns(['image_display', 'image_label', 'action'])
                ->toJson();
        }

        $html = $builder->columns([
            ['data' => 'id', 'visible' => false],
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '5%'],
            ['data' => 'image_display', 'title' => 'Image'],
            ['data' => 'image_label', 'title' => 'Content'],
            ['data' => 'action', 'title' => 'Action', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '10%'],
        ]);

        return view('login-image.index', compact('html'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image_label'       => 'required_with:image_placeholder|string|nullable',
            'image_placeholder' => 'nullable|string',
            'image_path' => ['required',
                function ($attribute, $value, $fail) {
                    $imageInfo = getimagesize($value->getPathname());
                    if ($imageInfo[0] <= $imageInfo[1]) {
                        $fail('The image must be in landscape orientation.');
                    }
                },
            ],
        ]);

        $data = $request->all();
        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('login_images', 'public');
            $data['image_path'] = $path;
        }

        LoginImage::create([
            'image_label'       => $data['image_label'] ?? null,
            'image_placeholder' => $data['image_placeholder'] ?? null,
            'image_path'        => $data['image_path'],
            'added_by'          => $request->user()->id,
        ]);

        return response()->json(['message' => 'Image added successfully']);
    }

    public function delete($id)
    {
        LoginImage::findOrFail($id)->delete();
        return response()->json(['message' => 'Image deleted successfully']);
    }
}
