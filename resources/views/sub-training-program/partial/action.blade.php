<div class="d-flex justify-content-center gap-1">
    <a href="{{ asset('storage/' . $training->document_path) }}" class="btn btn-sm btn-primary" download>Download</a>
    @if (auth()->user()->role == 'Admin')
        <a href="#" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal{{$training->id}}">Edit</a>
        <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$training->id}}">Delete</a>
    @endif
</div>

<div class="modal fade" id="editModal{{$training->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
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
                                    <input id="program_document" type="file" name="document_path" class="form-control" accept="application/pdf">
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

<div class="modal fade" id="deleteModal{{$training->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
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