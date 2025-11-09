<div class="d-flex justify-content-center gap-1">
    <a href="#" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal{{$bulletin->id}}">Edit</a>
    <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$bulletin->id}}">Delete</a>
</div>

<div class="modal fade" id="editModal{{$bulletin->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-start">
            <div class="modal-header pb-0">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Internal Bulletin</h1>
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
                    <form id="editForm{{$bulletin->id}}">
                        <div class="card card-detail" style="box-shadow: none !important">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="drop-area">
                                            <p class="drag-drop-text mb-0">Drag & drop image here or click to select</p>
                                            <input type="file" name="image_path" class="form-control program_image_path" style="display:none;" accept="image/*">
                                            <img class="image-preview" src="#" alt="Image preview" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <button type="button" class="w-100 btn btn-sm btn-outline-danger clear-image-btn" style="display: none;">Clear Image</button>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label for="title{{$bulletin->id}}" class="form-label">Title</label>
                                        <input id="title{{$bulletin->id}}" type="text" name="title" class="form-control"
                                            value="{{$bulletin->title}}" placeholder="Title">
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label for="description{{$bulletin->id}}" class="form-label">Description</label>
                                        <textarea id="description{{$bulletin->id}}" name="description" class="form-control" rows="10"
                                            placeholder="Enter description...">{!! $bulletin->description !!}</textarea>
                                    </div>

                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-primary edit-btn" data-id="{{ $bulletin->id }}">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form id="documentForm{{$bulletin->id}}" enctype="multipart/form-data">
                        <div class="card card-attachment d-none" style="box-shadow: none !important">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <label for="document_path{{$bulletin->id}}" class="form-label">Document</label>
                                        <input id="document_path{{$bulletin->id}}" type="file" name="document_path" class="form-control">
                                    </div>
                                    <div class="col-12 mb-3 text-end">
                                        <button type="button" class="btn btn-primary upload-document-btn" data-id="{{ $bulletin->id }}">Upload</button>
                                    </div>

                                    <div class="col-12 mb-2">
                                        List of Attachment(s)
                                    </div>

                                    <div class="attachments-container" id="document-container-{{ $bulletin->id }}">
                                        @forelse ($bulletin->documents as $document)
                                            <div class="col-12 mb-2" id="document-{{ $document->id }}">
                                                <div class="card">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>{{ $document->document_name }}</div>
                                                            <div>
                                                                <a href="#" class="btn btn-sm btn-info text-white view-doc-btn" data-bs-toggle="modal" data-bs-target="#viewModal{{ $document->id }}" data-file="{{ asset('storage/' . $document->document_path) }}">View</a>
                                                                <a href="{{ asset('storage/'.$document->document_path) }}" class="btn btn-sm btn-primary" class="text-primary" download="{{ Str::slug(pathinfo($document->document_name, PATHINFO_FILENAME)) }}">Download</a>
                                                                <a href="#" class="btn btn-sm btn-danger delete-document-btn" data-bulletin-id="{{ $bulletin->id }}" data-id="{{ $document->id }}">Delete</a>
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

<div class="modal fade" id="topLearnerModal{{$bulletin->id}}" tabindex="-1" aria-labelledby="topLearnerModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content text-start">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="learnerForm{{$bulletin->id}}">
                    <div class="card" style="box-shadow: none !important">
                        <div class="card-body py-0">
                            <div class="row">
                                <div class="col-12">
                                    <label for="top_learner_month{{$bulletin->id}}" class="form-label">Top Learner Month</label>
                                    <input id="top_learner_month{{$bulletin->id}}" type="month" name="top_learner_month" class="form-control">
                                </div>
                            </div>                            
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary set-top-learner-btn" data-id="{{ $bulletin->id }}">Set as Top Learner</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal{{$bulletin->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-start">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        Are you sure want to delete this Internal Bulletin? This action cannot be undone
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger delete-btn" data-id="{{ $bulletin->id }}">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    (() => {
        // Replace {{$bulletin->id}} with the actual bulletin ID
        const modal = document.getElementById('editModal{{$bulletin->id}}');
        if (!modal) return;

        const dropArea = modal.querySelector('.drop-area');
        const fileInput = dropArea.querySelector('.program_image_path');
        const preview = dropArea.querySelector('.image-preview');
        const clearBtn = modal.querySelector('.clear-image-btn');
        const dragDropText = dropArea.querySelector('.drag-drop-text');

        if (!dropArea || !fileInput || !preview || !clearBtn) return;

        // Click to open file dialog
        dropArea.addEventListener('click', () => fileInput.click());

        // Drag over
        dropArea.addEventListener('dragover', e => {
            e.preventDefault();
            dropArea.style.borderColor = '#007bff';
            dropArea.style.backgroundColor = '#e9f5ff';
        });

        dropArea.addEventListener('dragleave', e => {
            e.preventDefault();
            dropArea.style.borderColor = '#ccc';
            dropArea.style.backgroundColor = '';
        });

        // Drop
        dropArea.addEventListener('drop', e => {
            e.preventDefault();
            dropArea.style.borderColor = '#ccc';
            dropArea.style.backgroundColor = '';
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                showPreview(fileInput.files[0]);
            }
        });

        // File input change
        fileInput.addEventListener('change', () => {
            if (fileInput.files && fileInput.files[0]) showPreview(fileInput.files[0]);
        });

        // Clear button
        clearBtn.addEventListener('click', () => {
            fileInput.value = '';
            preview.src = '#';
            preview.style.display = 'none';
            clearBtn.style.display = 'none';
            dragDropText.style.display = 'inline-block';
            dropArea.style.borderColor = '#ccc';
            dropArea.style.backgroundColor = '';
        });

        // Preview function
        function showPreview(file) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.style.display = 'block';
                clearBtn.style.display = 'inline-block';
                dragDropText.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    })();
</script>