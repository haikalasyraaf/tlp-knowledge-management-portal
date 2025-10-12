<div class="d-flex justify-content-center gap-1">
    <a href="{{ asset('storage/' . $trainingCalendar->document_path) }}" class="btn btn-sm btn-primary" download>Download</a>
    @if (auth()->user()->role == 'Admin')
        <a href="#" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal{{$trainingCalendar->id}}">Edit</a>
        <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$trainingCalendar->id}}">Delete</a>
    @endif
</div>

<div class="modal fade" id="editModal{{$trainingCalendar->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-start">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Calendar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm{{$trainingCalendar->id}}">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input id="name" type="text" name="name" class="form-control"
                                        placeholder="Name" value="{{$trainingCalendar->name}}">
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="document_path" class="form-label">Document</label>
                                    <input id="document_path" type="file" name="document_path" class="form-control" accept="application/pdf">
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea id="description" name="description" class="form-control" rows="4"
                                        placeholder="Enter description...">{!!$trainingCalendar->description!!}</textarea>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="form-check">
                                        <input type="hidden" name="is_display" class="form-check-input" value="2">
                                        <input id="checkChecked" type="checkbox" name="is_display" class="form-check-input" value="1" {{$trainingCalendar->is_display == "1" ? 'checked' : ''}}>
                                        <label class="form-check-label" for="checkChecked">Set as Display</label>
                                    </div>
                                </div>

                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-primary edit-btn" data-id="{{ $trainingCalendar->id }}">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal{{$trainingCalendar->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-start">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        Are you sure want to delete this calendar? This action cannot be undone
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger delete-btn" data-id="{{ $trainingCalendar->id }}">Delete</button>
            </div>
        </div>
    </div>
</div>