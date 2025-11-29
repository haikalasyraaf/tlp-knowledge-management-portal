<div class="d-flex justify-content-center gap-1">
    @if (auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by))
        <a href="#" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal{{$trainingRequest->id}}">Edit</a>
        <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$trainingRequest->id}}">Delete</a>
    @else
        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{$trainingRequest->id}}">View</a>
    @endif
</div>

<div class="modal fade" id="editModal{{$trainingRequest->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-start">
            <div class="modal-header pb-0">
                @if (auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by))
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Training Request</h1>
                @else
                    <h1 class="modal-title fs-5" id="editModalLabel">View Training Request</h1>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="edit-wrapper">
                    <div class="card" style="box-shadow: none !important">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <a class="w-100 btn btn-primary detail-btn active" href="#">Detail</a>
                                </div>
                                <div class="col-6">
                                    <a class="w-100 btn btn-secondary attachment-btn" href="#">Attachment</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form id="editForm{{$trainingRequest->id}}">
                        <div class="card card-detail" style="box-shadow: none !important">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label for="create_requestor_name{{$trainingRequest->id}}" class="form-label">Requestor Name<span style="color: red"> *</span></label>
                                        <input id="create_requestor_name{{$trainingRequest->id}}" type="text" name="requestor_name" class="form-control" value="{{$trainingRequest->requestor_name}}" placeholder="Requestor Name" 
                                            {{ auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by) ? '' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="create_deparment_name{{$trainingRequest->id}}" class="form-label">Department<span style="color: red"> *</span></label>
                                        <input id="create_deparment_name{{$trainingRequest->id}}" type="text" name="deparment_name" class="form-control" value="{{$trainingRequest->deparment_name}}" placeholder="Department"
                                            {{ auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by) ? '' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="create_training_title{{$trainingRequest->id}}" class="form-label">Training Title<span style="color: red"> *</span></label>
                                        <input id="create_training_title{{$trainingRequest->id}}" type="text" name="training_title" class="form-control" value="{{$trainingRequest->training_title}}" placeholder="Training Title"
                                            {{ auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by) ? '' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="create_training_organiser{{$trainingRequest->id}}" class="form-label">Training Organiser<span style="color: red"> *</span></label>
                                        <input id="create_training_organiser{{$trainingRequest->id}}" type="text" name="training_organiser" class="form-control" value="{{$trainingRequest->training_organiser}}" placeholder="Training Organiser"
                                            {{ auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by) ? '' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="create_training_venue{{$trainingRequest->id}}" class="form-label">Training Venue<span style="color: red"> *</span></label>
                                        <input id="create_training_venue{{$trainingRequest->id}}" type="text" name="training_venue" class="form-control" value="{{$trainingRequest->training_venue}}" placeholder="Training Venue"
                                            {{ auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by) ? '' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="create_training_cost{{$trainingRequest->id}}" class="form-label">Training Cost<span style="color: red"> *</span></label>
                                        <input id="create_training_cost{{$trainingRequest->id}}" type="text" name="training_cost" class="form-control" value="{{$trainingRequest->training_cost}}" placeholder="Training Cost"
                                            {{ auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by) ? '' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="create_training_start_date{{$trainingRequest->id}}" class="form-label">Training Start Date<span style="color: red"> *</span></label>
                                        <input id="create_training_start_date{{$trainingRequest->id}}" type="date" name="training_start_date" class="form-control" value="{{$trainingRequest->training_start_date}}" placeholder="Training Start Date"
                                            {{ auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by) ? '' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="create_title{{$trainingRequest->id}}" class="form-label">Training End Date<span style="color: red"> *</span></label>
                                        <input id="create_title{{$trainingRequest->id}}" type="date" name="training_end_date" class="form-control" value="{{$trainingRequest->training_end_date}}" placeholder="Training End Date"
                                            {{ auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by) ? '' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="create_employees_recommended{{$trainingRequest->id}}" class="form-label">Employee Recommended<span style="color: red"> *</span></label>
                                        <input id="create_employees_recommended{{$trainingRequest->id}}" type="text" name="employees_recommended" class="form-control" value="{{$trainingRequest->employees_recommended}}" placeholder="Employee Recommended"
                                            {{ auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by) ? '' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="create_remarks{{$trainingRequest->id}}" class="form-label">Remark</label>
                                        <input id="create_remarks{{$trainingRequest->id}}" type="text" name="remarks" class="form-control" value="{{$trainingRequest->remarks}}" placeholder="Remark"
                                            {{ auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by) ? '' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label for="create_training_objective{{$trainingRequest->id}}" class="form-label">Training Objective<span style="color: red"> *</span></label>
                                        <textarea id="create_training_objective{{$trainingRequest->id}}" name="training_objective" class="form-control" rows="4"
                                            placeholder="Enter training objective..."
                                            {{ auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by) ? '' : 'disabled' }}>{!! $trainingRequest->training_objective !!}</textarea>
                                    </div>

                                    @if (auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by))
                                        <div class="col-12 text-end">
                                            <button type="button" class="btn btn-primary edit-btn" data-id="{{ $trainingRequest->id }}">Save</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>

                    <form id="documentForm{{$trainingRequest->id}}" enctype="multipart/form-data">
                        <div class="card card-attachment mt-3 d-none" style="box-shadow: none !important">
                            <div class="card-body">
                                <div class="row">
                                    @if (auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by))
                                        <div class="col-lg-12 mb-3">
                                            <label for="document_path{{$trainingRequest->id}}" class="form-label">Document</label>
                                            <input id="document_path{{$trainingRequest->id}}" type="file" name="document_path" class="form-control">
                                        </div>
                                        <div class="col-12 mb-3 text-end">
                                            <button type="button" class="btn btn-primary upload-document-btn" data-id="{{ $trainingRequest->id }}">Upload</button>
                                        </div>
                                    @endif

                                    <div class="col-12 mb-2">
                                        List of Attachment(s)
                                    </div>

                                    <div class="attachments-container" id="document-container-{{ $trainingRequest->id }}">
                                        @forelse ($trainingRequest->documents as $document)
                                            <div class="col-12 mb-2" id="document-{{ $document->id }}">
                                                <div class="card">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>{{ $document->document_name }}</div>
                                                            <div>
                                                                <a href="#" class="btn btn-sm btn-info text-white view-doc-btn" data-bs-toggle="modal" data-bs-target="#viewModal{{ $document->id }}" data-file="{{ asset('storage/' . $document->document_path) }}">View</a>
                                                                <a href="{{ asset('storage/'.$document->document_path) }}" class="btn btn-sm btn-primary" class="text-primary" download="{{ Str::slug(pathinfo($document->document_name, PATHINFO_FILENAME)) }}">Download</a>
                                                                @if (auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by))
                                                                    <a href="#" class="btn btn-sm btn-danger delete-document-btn" data-training-request-id="{{ $trainingRequest->id }}" data-id="{{ $document->id }}">Delete</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="viewModal{{ $document->id }}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="btn-close" onclick="$('#viewModal{{ $document->id }}').modal('hide');"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            {{-- Default iframe preview --}}
                                                            <iframe id="previewFrame{{ $document->id }}" src="" width="100%" height="600" style="border:none;display:none;"></iframe>

                                                            {{-- Fallback message --}}
                                                            <div id="downloadContainer{{ $document->id }}" style="display:none;">
                                                                <div class="d-flex justify-content-center align-items-center" style="height: 600px">
                                                                    <div>
                                                                        <p>File type not support for preview. You can download the file below:</p>
                                                                        <a id="downloadBtn{{ $document->id }}" href="#" class="btn btn-primary" download>Download File</a>                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12 mb-2" id="empty-document-message">
                                                <div class="card">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            <div class="text-center">No document uploaded</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal{{$trainingRequest->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-start">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        Are you sure want to delete this training request? This action cannot be undone
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger delete-btn" data-id="{{ $trainingRequest->id }}">Delete</button>
            </div>
        </div>
    </div>
</div>