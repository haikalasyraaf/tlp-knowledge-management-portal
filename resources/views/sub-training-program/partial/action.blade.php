<div class="d-flex justify-content-center gap-1">
    <a href="#" class="btn btn-sm btn-info text-white view-doc-btn" data-bs-toggle="modal" data-bs-target="#viewModal{{ $training->id }}" data-file="{{ asset('storage/' . $training->document_path) }}">View</a>
    <a href="{{ asset('storage/' . $training->document_path) }}" class="btn btn-sm btn-primary" download="{{ Str::slug($training->program_name) . '.' . pathinfo($training->document_path, PATHINFO_EXTENSION) }}">Download</a>
    @if (auth()->user()->role == 'Admin')
        <a href="#" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal{{$training->id}}">Edit</a>
        <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$training->id}}">Delete</a>
    @endif
</div>

<div class="modal fade" id="editModal{{$training->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-start">
            <div class="modal-header pb-0">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Record</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm{{$training->id}}">
                    <div class="card" style="box-shadow: none !important">
                        <div class="card-body py-0">
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="program_name" class="form-label">Program Name <span class="text-danger">*</span></label>
                                    <input id="program_name" type="text" name="program_name" class="form-control" value="{{$training->program_name}}" placeholder="Name">
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="program_document" class="form-label">Program Document / Infographic</label>
                                    <input id="program_document" type="file" name="document_path" class="form-control">
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="program_description" class="form-label">Description</label>
                                    <textarea name="program_description" id="program_description" rows="4" class="form-control" placeholder="Enter description...">{!!$training->program_description!!}</textarea>                     
                                </div>
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-primary edit-btn" data-id="{{ $training->id }}">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewModal{{ $training->id }}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-3">
                    <h5 class="mb-1">{{ $training->program_name }}</h5>
                    <p>{!! $training->program_description !!}</p>
                </div>

                {{-- Default iframe preview --}}
                <iframe id="previewFrame{{ $training->id }}" src="" width="100%" height="600" style="border:none;display:none;"></iframe>

                {{-- Fallback message --}}
                <div id="downloadContainer{{ $training->id }}" style="display:none;">
                    <div class="d-flex justify-content-center align-items-center" style="height: 600px">
                        <div>
                            <p>File type not support for preview. You can download the file below:</p>
                            <a id="downloadBtn{{ $training->id }}" href="#" class="btn btn-primary" download>Download File</a>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal{{$training->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-start">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        Are you sure want to delete this system training?
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger delete-btn" data-id="{{ $training->id }}">Delete</button>
            </div>
        </div>
    </div>
</div>