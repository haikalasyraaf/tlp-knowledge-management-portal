<x-app-layout>
    <div class="card">
        <div class="card-body p-0">
            <div class="p-3" style="border-bottom: 1px solid #dee2e6">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h5 class="mb-0">Internal Bulletin List</h5>
                    </div>
                    <div class="col-6 text-end">
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="bi bi-plus-lg icon-13 me-1"></i> New Record
                        </button>                    
                    </div>
                </div>                
            </div>

            <div class="p-3">
                {!! $html->table() !!}
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content text-start">
                <div class="modal-header pb-0">
                    <h1 class="modal-title fs-5" id="createModalLabel">Create Internal Bulletin</h1>
                    <button type="button" class="btn-close close-create-modal-btn" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        <form id="createForm">
                            <div class="card card-detail" style="box-shadow: none !important">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <label for="create_title" class="form-label">Title</label>
                                            <input id="create_title" type="text" name="title" class="form-control" placeholder="Title" required>
                                        </div>

                                        <div class="col-lg-12 mb-3">
                                            <label for="create_description" class="form-label">Description</label>
                                            <textarea id="create_description" name="description" class="form-control" rows="10" placeholder="Enter description..." required></textarea>
                                        </div>

                                        <div class="col-12 text-end">
                                            <button type="button" class="btn btn-primary add-btn">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form id="createDocumentForm" enctype="multipart/form-data">
                            <div class="card card-attachment mt-3 d-none" style="box-shadow: none !important">
                                <div class="card-body">
                                    <input type="hidden" name="bulletin_id" id="created_bulletin_id">

                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <label for="create_document_path" class="form-label">Document</label>
                                            <input id="create_document_path" type="file" name="document_path" class="form-control" disabled>
                                        </div>

                                        <div class="col-12 mb-3 text-end">
                                            <button type="button" class="btn btn-primary upload-create-document-btn" disabled>Upload</button>
                                        </div>

                                        <div class="col-12 mb-2">
                                            List of Attachment(s)
                                        </div>

                                        <div class="attachments-container" id="create-document-container">
                                            <div class="col-12 mb-2" id="empty-create-document-message">
                                                <div class="card">
                                                    <div class="card-body p-2 text-center">
                                                        No document uploaded
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-muted small mt-2" id="upload-note">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Please submit the Internal Bulletin before uploading documents.
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        {!! $html->scripts() !!}
        <script>
            $(document).on('click', '.add-btn', function (e) {
                let form = $('#createForm')[0];
                let formData = new FormData(form);
                $(e.currentTarget).prop('disabled', true);

                $.ajax({
                    url: "/internal-bulletin/create",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        toastr.success('Internal Bulletin created successfully! You can now upload documents.', '', { timeOut: 8000 });

                        $('#created_bulletin_id').val(response.bulletin.id);
                        $('#create_document_path').prop('disabled', false);
                        $('.upload-create-document-btn').prop('disabled', false);
                        $('#upload-note').fadeOut();
                        $('.attachment-btn').trigger('click');
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                        $(e.currentTarget).prop('disabled', false);
                    }
                });
            });

            $(document).on('click', '.edit-btn', function () {
                let bulletinId = $(this).data('id');
                let form = $('#editForm' + bulletinId)[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "/internal-bulletin/" + bulletinId + "/edit",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#editModal' + bulletinId).modal('hide');

                        console.log(response);
                        toastr.success('Internal Bulletin updated successfully!', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.delete-btn', function () {
                let bulletinId = $(this).data('id');

                $.ajax({
                    url: "/internal-bulletin/" + bulletinId + "/delete",
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#deleteModal' + bulletinId).modal('hide');

                        console.log(response);
                        toastr.success('Internal Bulletin removed successfully!', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.set-top-learner-btn', function () {
                let bulletinId = $(this).data('id');
                let form = $('#learnerForm' + bulletinId)[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "/internal-bulletin/" + bulletinId + "/set-as-top-learner",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#topLearnerModal' + bulletinId).modal('hide');

                        console.log(response);
                        toastr.success('Internal Bulletin set as Top Learner', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.remove-as-top-learner', function () {
                let bulletinId = $(this).data('id');

                $.ajax({
                    url: "/internal-bulletin/" + bulletinId + "/remove-as-top-learner",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        console.log(response);
                        toastr.success('Internal Bulletin remove as Top Learner', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            // UPLOAD document (after record is created)
            $(document).on('click', '.upload-create-document-btn', function (e) {
                e.preventDefault();

                let bulletinId = $('#created_bulletin_id').val();
                if (!bulletinId) {
                    toastr.warning('Please save the form first before uploading documents.');
                    return;
                }

                let form = $('#createDocumentForm')[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "/internal-bulletin/" + bulletinId + "/document/upload",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                    success: function (response) {
                        toastr.success('Document uploaded successfully!', '', { timeOut: 8000 });

                        let nameWithoutExt = response.document.name.replace(/\.[^/.]+$/, '');
                        let downloadName = nameWithoutExt.replace(/\s+/g, '-');
                        let newAttachmentRow =
                            '<div class="col-12 mb-2" id="document-' + response.document.id + '">' +
                                '<div class="card">' +
                                    '<div class="card-body p-2">' +
                                        '<div class="d-flex justify-content-between align-items-center">' +
                                            '<div>' + response.document.name + '</div>' +
                                            '<div>' +
                                                '<a href="#" class="btn btn-sm btn-info text-white view-doc-btn" data-bs-toggle="modal" data-bs-target="#viewModal' + response.document.id + '" data-file="' + response.document.path + '">View</a> ' +
                                                '<a href="' + response.document.path + '" class="btn btn-sm btn-primary text-white" download="' + downloadName + '">Download</a> ' +
                                                '<a href="#" class="btn btn-sm btn-danger delete-document-btn" data-bulletin-id="' + bulletinId + '" data-id="' + response.document.id + '">Delete</a>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                            '<div class="modal fade" id="viewModal' + response.document.id + '" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">' +
                                '<div class="modal-dialog modal-xl">' +
                                    '<div class="modal-content">' +
                                        '<div class="modal-header">' +
                                            '<button type="button" class="btn-close" onclick="$(\'#viewModal' + response.document.id + '\').modal(\'hide\');"></button>' +
                                        '</div>' +
                                        '<div class="modal-body text-center">' +
                                            '<iframe id="previewFrame' + response.document.id + '" src="" width="100%" height="600" style="border:none;display:none;"></iframe>' +
                                            '<div id="downloadContainer' + response.document.id + '" style="display:none;">' +
                                                '<div class="d-flex justify-content-center align-items-center" style="height: 600px">' +
                                                    '<div>' +
                                                        '<p>File type not supported for preview. You can download the file below:</p>' +
                                                        '<a id="downloadBtn' + response.document.id + '" href="' + response.document.path + '" class="btn btn-primary" download="' + downloadName + '">Download File</a>' +
                                                    '</div>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';

                        $('#create-document-container').append(newAttachmentRow);
                        $('#createDocumentForm').trigger('reset');
                        $('#empty-create-document-message').remove();
                    },
                    error: function (xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                        console.log(xhr.responseText);
                    }
                });
            });

            $(document).on('click', '.upload-document-btn', function (e) {
                e.preventDefault();

                let bulletinId = $(this).data('id');
                let form = $('#documentForm' + bulletinId)[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "/internal-bulletin/" + bulletinId + "/document/upload",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {

                        console.log(response);
                        toastr.success('Internal Bulletin Document uploaded successfully!', '', { timeOut: 8000 });

                        let nameWithoutExt = response.document.name.replace(/\.[^/.]+$/, '');
                        let downloadName = nameWithoutExt.replace(/\s+/g, '-');
                        let newAttachmentRow =
                            '<div class="col-12 mb-2" id="document-' + response.document.id + '">' +
                                '<div class="card">' +
                                    '<div class="card-body p-2">' +
                                        '<div class="d-flex justify-content-between align-items-center">' +
                                            '<div>' + response.document.name + '</div>' +
                                            '<div>' +
                                                '<a href="#" class="btn btn-sm btn-info text-white view-doc-btn" data-bs-toggle="modal" data-bs-target="#viewModal' + response.document.id + '" data-file="' + response.document.path + '">View</a> ' +
                                                '<a href="' + response.document.path + '" class="btn btn-sm btn-primary text-white" download="' + downloadName + '">Download</a> ' +
                                                '<a href="#" class="btn btn-sm btn-danger delete-document-btn" data-bulletin-id="' + bulletinId + '" data-id="' + response.document.id + '">Delete</a>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                            '<div class="modal fade" id="viewModal' + response.document.id + '" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">' +
                                '<div class="modal-dialog modal-xl">' +
                                    '<div class="modal-content">' +
                                        '<div class="modal-header">' +
                                            '<button type="button" class="btn-close" onclick="$(\'#viewModal' + response.document.id + '\').modal(\'hide\');"></button>' +
                                        '</div>' +
                                        '<div class="modal-body text-center">' +
                                            '<iframe id="previewFrame' + response.document.id + '" src="" width="100%" height="600" style="border:none;display:none;"></iframe>' +
                                            '<div id="downloadContainer' + response.document.id + '" style="display:none;">' +
                                                '<div class="d-flex justify-content-center align-items-center" style="height: 600px">' +
                                                    '<div>' +
                                                        '<p>File type not supported for preview. You can download the file below:</p>' +
                                                        '<a id="downloadBtn' + response.document.id + '" href="' + response.document.path + '" class="btn btn-primary" download="' + downloadName + '">Download File</a>' +
                                                    '</div>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';

                        $('#document-container-' + bulletinId).append(newAttachmentRow);

                        $('#documentForm' + bulletinId).trigger('reset');
                        $('#empty-document-message').remove();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.delete-document-btn', function (e) {
                e.preventDefault();

                let bulletinId = $(this).data('bulletin-id');
                let documentId = $(this).data('id');

                if (!confirm("Are you sure you want to delete this document?")) {
                    return;
                }

                $.ajax({
                    url: "/internal-bulletin/" + bulletinId + "/document/" + documentId + "/delete",
                    method: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        toastr.success(response.message, '', { timeOut: 8000 });
                        $("#document-" + documentId).remove(); // remove the card from DOM

                        setTimeout(() => {
                            let list = $("#document-container-" + bulletinId);
                            if (list.find(".card").length === 0) {
                                let newAttachmentRow =
                                    '<div class="col-12 mb-2" id="empty-document-message">' +
                                        '<div class="card">' +
                                            '<div class="card-body p-2">' +
                                                '<div class="d-flex justify-content-center align-items-center">' +
                                                    '<div class="text-center">No document uploaded</div>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>';

                                $('#document-container-' + bulletinId).append(newAttachmentRow);
                            }                            
                        }, 500);
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Failed to delete document!');
                    }
                });
            });

            // Handle click on the 'Detail' button
            $(document).on('click', '.detail-btn', function (e) {
                e.preventDefault();

                const $wrapper = $(this).closest('.edit-wrapper');
                const $detailCard = $wrapper.find('.card-detail');
                const $attachmentCard = $wrapper.find('.card-attachment');
                const $attachmentBtn = $wrapper.find('.attachment-btn');

                $detailCard.removeClass('d-none');
                $attachmentCard.addClass('d-none');

                $(this).addClass('active btn-primary').removeClass('btn-secondary');
                $attachmentBtn.removeClass('active btn-primary').addClass('btn-secondary');
            });

            // Handle click on the 'Attachment' button
            $(document).on('click', '.attachment-btn', function (e) {
                e.preventDefault();

                const $wrapper = $(this).closest('.edit-wrapper');
                const $detailCard = $wrapper.find('.card-detail');
                const $attachmentCard = $wrapper.find('.card-attachment');
                const $detailBtn = $wrapper.find('.detail-btn');

                $detailCard.addClass('d-none');
                $attachmentCard.removeClass('d-none');

                $(this).addClass('active btn-primary').removeClass('btn-secondary');
                $detailBtn.removeClass('active btn-primary').addClass('btn-secondary');
            });

            $(document).on('click', '.close-create-modal-btn', function (e) {

                let bulletinId = $('#created_bulletin_id').val();
                $('#createForm')[0].reset();
                $('#createDocumentForm')[0].reset();
                $('#created_bulletin_id').val('');

                // Disable attachment inputs/buttons
                $('#create_document_path').prop('disabled', true);
                $('.upload-create-document-btn').prop('disabled', true);

                // Reset attachment container
                let container = $('#create-document-container, [id^="create-document-container-"]');
                container.html(`
                    <div class="col-12 mb-2" id="empty-create-document-message">
                        <div class="card">
                            <div class="card-body p-2 text-center">
                                No document uploaded
                            </div>
                        </div>
                    </div>
                `);

                // Reset ID back to generic
                container.attr('id', 'create-document-container');

                // Show upload note again
                $('#upload-note').show();

                // Reset navbar buttons (Detail active, Attachment inactive)
                $('.detail-btn').trigger('click');

                // ----- CLOSE MODAL -----
                $('#createModal').modal('hide');
                $('.add-btn').prop('disabled', false);

                // ----- RELOAD DATATABLE IF NEW RECORD CREATED -----
                if (bulletinId) {
                    $('#dataTableBuilder').DataTable().ajax.reload();
                }
            });
        </script>
    @endpush
</x-app-layout>
