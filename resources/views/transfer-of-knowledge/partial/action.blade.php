<div class="d-flex justify-content-center gap-1">
    @if (auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $knowledge->created_by))
        <a href="#" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal{{$knowledge->id}}">Edit</a>
        <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$knowledge->id}}">Delete</a>
    @else
        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{$knowledge->id}}">View</a>
    @endif
</div>

<div class="modal fade" id="editModal{{$knowledge->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-start">
            <div class="modal-header pb-0">
                @if (auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $knowledge->created_by))
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Transfer of Knowledge</h1>
                @else
                    <h1 class="modal-title fs-5" id="editModalLabel">View Transfer of Knowledge</h1>
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
                    <form id="editForm{{$knowledge->id}}">
                        <div class="card card-detail" style="box-shadow: none !important">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <label for="title{{$knowledge->id}}" class="form-label">Title</label>
                                        <input id="title{{$knowledge->id}}" type="text" name="title" class="form-control"
                                            value="{{$knowledge->title}}" placeholder="Title"
                                            {{ auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $knowledge->created_by) ? '' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label for="content{{$knowledge->id}}" class="form-label">Training Output</label>
                                        <textarea id="content{{$knowledge->id}}" name="content" class="form-control" rows="10"
                                            placeholder="Enter training output..."
                                            {{ auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $knowledge->created_by) ? '' : 'disabled' }}>{!! $knowledge->content !!}</textarea>
                                    </div>

                                    @if (auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $knowledge->created_by))
                                        <div class="col-12 text-end">
                                            <button type="button" class="btn btn-primary edit-btn" data-id="{{ $knowledge->id }}">Save</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>

                    <form id="documentForm{{$knowledge->id}}" enctype="multipart/form-data">
                        <div class="card card-attachment d-none" style="box-shadow: none !important">
                            <div class="card-body">
                                <div class="row">
                                    @if (auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $knowledge->created_by))
                                        <div class="col-lg-12 mb-3">
                                            <label for="document_path{{$knowledge->id}}" class="form-label">Document</label>
                                            <input id="document_path{{$knowledge->id}}" type="file" name="document_path" class="form-control">
                                        </div>
                                        <div class="col-12 mb-3 text-end">
                                            <button type="button" class="btn btn-primary upload-document-btn" data-id="{{ $knowledge->id }}">Upload</button>
                                        </div>
                                    @endif

                                    <div class="col-12 mb-2">
                                        List of Attachment(s)
                                    </div>

                                    <div class="attachments-container" id="document-container-{{ $knowledge->id }}">
                                        @forelse ($knowledge->documents as $document)
                                            <div class="col-12 mb-2" id="document-{{ $document->id }}">
                                                <div class="card">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>{{ $document->document_name }}</div>
                                                            <div>
                                                                <a href="{{ asset('storage/'.$document->document_path) }}" target="_blank" class="text-primary">
                                                                    <i class="bi bi-download icon-13 ps-1"></i>
                                                                </a>
                                                                @if (auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $knowledge->created_by))
                                                                    <a href="#" class="text-danger delete-document-btn" data-knowledge-id="{{ $knowledge->id }}" data-id="{{ $document->id }}">
                                                                        <i class="bi bi-trash-fill icon-13 ps-1"></i>
                                                                    </a>
                                                                @endif
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

<div class="modal fade" id="deleteModal{{$knowledge->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-start">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        Are you sure want to delete this transfer of knowledge? This action cannot be undone
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger delete-btn" data-id="{{ $knowledge->id }}">Delete</button>
            </div>
        </div>
    </div>
</div>