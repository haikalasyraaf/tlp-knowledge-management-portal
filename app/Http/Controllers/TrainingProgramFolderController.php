<?php

namespace App\Http\Controllers;

use App\Models\TrainingProgram;
use App\Models\TrainingProgramFolder;
use App\Models\TrainingProgramFolderDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainingProgramFolderController extends Controller
{

    public function index($programId)
    {
        $trainingProgram = TrainingProgram::where('id', $programId)->first();

        $folders = TrainingProgramFolder::where('training_program_id', $trainingProgram->id)->orderBy('id', 'desc')->get();

        return view('training-program-folder.index', compact('trainingProgram', 'folders'));
    }

    public function store($programId, Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $folder = TrainingProgramFolder::create([
            'training_program_id'   => $programId,
            'name'                  => $validated['name'],
            'description'           => $validated['description'] ?? null,
            'status'                => 1,
            'created_by'            => $request->user()->id,
            'updated_by'            => $request->user()->id,
        ]);

        return response()->json(['message' => 'Training Program Folder created successfully', 'folder' => $folder]);
    }

    public function update($programId, $folderId, Request $request)
    {
        // Find the existing record
        $trainingProgramFolder = TrainingProgramFolder::where('training_program_id', $programId)
            ->where('id', $folderId)
            ->firstOrFail();

        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $trainingProgramFolder->update([
            'name'          => $validated['name'],
            'description'   => $validated['description'] ?? null,
            'updated_by'    => $request->user()->id,
        ]);

        return response()->json(['message' => 'Training Program Folder updated successfully']);
    }


    public function delete($programId, $folderId)
    {
        $trainingProgramFolder = TrainingProgramFolder::where('training_program_id', $programId)->where('id', $folderId)->firstOrFail();

        if ($trainingProgramFolder->image_path) {
            Storage::disk('public')->delete($trainingProgramFolder->image_path);
        }

        $trainingProgramFolder->delete();

        return response()->json(['message' => 'Training Program Folder deleted successfully']);
    }

    public function uploadDocument($programId, $folderId, Request $request)
    {
        $request->validate([
            'document_path' => 'required|max:51200',
        ]);

        $file = $request->file('document_path');
        $path = $file->store('training_program_folder_document', 'public');

        $document = TrainingProgramFolderDocument::create([
            'training_program_id'           => $programId,
            'training_program_folder_id'    => $folderId,
            'document_name'                 => $file->getClientOriginalName(),
            'document_path'                 => $path,
            'created_by'                    => $request->user()->id,
            'updated_by'                    => $request->user()->id,
        ]);

        return response()->json(['message' => 'Training Program Folder Document uploaded successfully',
            'document' => [
                'id' => $document->id,
                'name' => $document->document_name,
                'path' => asset('storage/' . $document->document_path),
            ],
        ]);
    }

    public function deleteDocument($programId, $folderId, $id)
    {
        $document = TrainingProgramFolderDocument::findOrFail($id);
        Storage::disk('public')->delete($document->document_path);
        $document->delete();

        return response()->json(['message' => 'Training Program Folder Document deleted successfully']);
    }
}
