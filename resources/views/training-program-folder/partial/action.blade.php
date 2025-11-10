<div class="d-flex justify-content-center gap-1">
    @if (auth()->user()->role == 'Admin')
        <a href="#" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal{{$folder->id}}">Edit</a>
        <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$folder->id}}">Delete</a>
    @else
        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{$folder->id}}">View</a>
    @endif
</div>

<div class="modal fade" id="editModal{{$folder->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-start">
            <div class="modal-header pb-0">
                @if (auth()->user()->role == 'Admin')
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Folder</h1>
                @else
                    <h1 class="modal-title fs-5" id="editModalLabel">View Folder</h1>
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
                    <form id="editForm{{$folder->id}}">
                        <div class="card card-detail" style="box-shadow: none !important">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <label for="name{{$folder->id}}" class="form-label">Folder Name</label>
                                        <input id="name{{$folder->id}}" type="text" name="name" class="form-control"
                                            value="{{$folder->name}}" placeholder="Folder name"
                                            {{ auth()->user()->role == 'Admin' ? '' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label for="description{{$folder->id}}" class="form-label">Description</label>
                                        <textarea id="description{{$folder->id}}" name="description" class="form-control" rows="10"
                                            placeholder="Enter folder description..."
                                            {{ auth()->user()->role == 'Admin' ? '' : 'disabled' }}>{!! $folder->description !!}</textarea>
                                    </div>

                                    @if (auth()->user()->role == 'Admin')
                                        <div class="col-12 text-end">
                                            <button type="button" class="btn btn-primary edit-btn" data-id="{{ $folder->id }}">Save</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>

                    <form id="documentForm{{$folder->id}}" enctype="multipart/form-data">
                        <div class="card card-attachment mt-3 d-none" style="box-shadow: none !important">
                            <div class="card-body">
                                <div class="row">
                                    @if (auth()->user()->role == 'Admin')
                                        <div class="col-lg-12 mb-3">
                                            <label for="document_path{{$folder->id}}" class="form-label">Document</label>
                                            <input id="document_path{{$folder->id}}" type="file" name="document_path" class="form-control">
                                        </div>
                                        <div class="col-12 mb-3 text-end">
                                            <button type="button" class="btn btn-primary upload-document-btn" data-id="{{ $folder->id }}">Upload</button>
                                        </div>
                                    @endif

                                    <div class="col-12 mb-2">
                                        List of Attachment(s)
                                    </div>

                                    <div class="attachments-container" id="document-container-{{ $folder->id }}">
                                        @forelse ($folder->documents as $document)
                                            <div class="col-12 mb-2" id="document-{{ $document->id }}">
                                                <div class="card">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>{{ $document->document_name }}</div>
                                                            <div>
                                                                <a href="#" class="btn btn-sm btn-info text-white view-doc-btn" data-bs-toggle="modal" data-bs-target="#viewModal{{ $document->id }}" data-file="{{ asset('storage/' . $document->document_path) }}">View</a>
                                                                <a href="{{ asset('storage/'.$document->document_path) }}" class="btn btn-sm btn-primary" class="text-primary" download="{{ Str::slug(pathinfo($document->document_name, PATHINFO_FILENAME)) }}">Download</a>
                                                                @if (auth()->user()->role == 'Admin')
                                                                    <a href="#" class="btn btn-sm btn-danger delete-document-btn" data-folder-id="{{ $folder->id }}" data-id="{{ $document->id }}">Delete</a>
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

<div class="modal fade" id="deleteModal{{$folder->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-start">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        Are you sure want to delete this folder? This action cannot be undone
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger delete-btn" data-id="{{ $folder->id }}">Delete</button>
            </div>
        </div>
    </div>
</div>