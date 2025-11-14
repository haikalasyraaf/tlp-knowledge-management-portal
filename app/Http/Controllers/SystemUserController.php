<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class SystemUserController extends Controller
{
    public function index(Request $request, Builder $builder)
    {
        if (request()->ajax()) {
            return DataTables::of(User::query())
                ->addIndexColumn()
                ->addColumn('role', function ($user) {
                    return view('system-user.partial.role', compact('user'))->render();
                })
                ->addColumn('status', function ($user) {
                    return view('system-user.partial.status', compact('user'))->render();
                })
                ->addColumn('action', function ($user) {
                    return view('system-user.partial.action', compact('user'))->render();
                })
                ->rawColumns(['role', 'status', 'action'])
                ->toJson();
        }

        $html = $builder->columns([
            ['data' => 'id', 'visible' => false],
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => '', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '5%'],
            ['data' => 'employee_id', 'title' => 'Employee ID'],
            ['data' => 'name', 'title' => 'Name'],
            ['data' => 'role', 'title' => 'Role'],
            ['data' => 'status', 'title' => 'Status'],
            ['data' => 'action', 'title' => 'Action', 'className' => 'text-center', 'orderable' => false, 'searchable' => false, 'width' => '10%'],
        ]);

        return view('system-user.index', compact('html'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'   => 'required|string|max:255',
            'name'          => 'required|string|max:255',
            'role'          => 'required|string',
            'department'    => 'required|string',
            'designation'   => 'required|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('profile_photos', $filename, 'public');
            $data['profile_photo_path'] = $filePath;
        }

        $data['password'] = bcrypt($request->employee_id);

        $user = User::create($data);

        return response()->json(['message' => 'User updated successfully']);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'employee_id'   => 'required|string|max:255',
            'name'          => 'required|string|max:255',
            'role'          => 'required|string',
            'department'    => 'required|string',
            'designation'   => 'required|string',
        ]);

        $user = User::findOrFail($id);
        $data = $request->except(['password', 'profile_photo']);

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('profile_photos', $filename, 'public');
            $data['profile_photo_path'] = $filePath;
        } else {
            $data['profile_photo_path'] = $user->profile_photo_path;
        }

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return response()->json(['message' => 'User updated successfully']);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        // Delete profile photo if it exists
        if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // Then delete the user
        $user->delete();
        return response()->json(['success' => true]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:csv,xlsx,xls|',
        ]);

        $path = $request->file('import_file')->getRealPath();

        (new FastExcel)->import($path, function ($line) {
            return User::updateOrCreate([
                'employee_id'   => $line['Employee No.'] ?? null,
            ], [
                'name'          => $line['Name (As IC)'] ?? null,
                'email'         => null,
                'password'      => isset($line['Employee No.']) ? Hash::make($line['Employee No.']) : Hash::make('12341234'),
                'role'          => 'Staff',
                'department'    => $line['Department'] ?? null,
                'designation'   => $line['Designation'] ?? null,
            ]);
        });

        return response()->json(['message' => 'Users imported successfully']);
    }
}
