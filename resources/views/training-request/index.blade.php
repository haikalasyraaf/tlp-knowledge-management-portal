<x-app-layout>
    <div class="card">
        <div class="card-body p-0">
            <div class="p-3" style="border-bottom: 1px solid #dee2e6">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h5 class="mb-0">
                            Training Request List
                        </h5>
                    </div>
                    <div class="col-6 text-end">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#reportFormModal" class="btn btn-sm btn-success ms-2">
                            <i class="bi bi-file-earmark-arrow-down-fill icon-13 me-1"></i> Export
                        </a>
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
                    <h1 class="modal-title fs-5" id="createModalLabel">Create Training Request</h1>
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
                                        <div class="col-lg-6 mb-3">
                                            <label for="create_requestor_name" class="form-label">Requestor Name<span style="color: red"> *</span></label>
                                            <input id="create_requestor_name" type="text" name="requestor_name" class="form-control" placeholder="Requestor Name">
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label for="create_deparment_name" class="form-label">Department<span style="color: red"> *</span></label>
                                            <select id="create_deparment_name" name="deparment_name" class="form-select">
                                                <option value="" selected disabled>Please select</option>
                                                <option value="Auxiliary Police">Auxiliary Police</option>
                                                <option value="Breakbulk & Customer Service">Breakbulk & Customer Service</option>
                                                <option value="Business Development & Commercial">Business Development & Commercial</option>
                                                <option value="Corporate Planning & Strategic Transformation">Corporate Planning & Strategic Transformation</option>
                                                <option value="Corporate Strategic Planning">Corporate Strategic Planning</option>
                                                <option value="Corporate_Services">Corporate_Services</option>
                                                <option value="Environment, Safety & Health">Environment, Safety & Health</option>
                                                <option value="Finance">Finance</option>
                                                <option value="Governance , Risk & Compliance">Governance , Risk & Compliance</option>
                                                <option value="Human Resource & Administration">Human Resource & Administration</option>
                                                <option value="IT">IT</option>
                                                <option value="Marine & Liquid Operations">Marine & Liquid Operations</option>
                                                <option value="Office of Executive Director & Chief Executive">Office of Executive Director & Chief Executive</option>
                                                <option value="Technical Engineering & Facility Management">Technical Engineering & Facility Management</option>
                                                <option value="Terminal & Free Zone Operation">Terminal & Free Zone Operation</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label for="create_training_title" class="form-label">Training Title<span style="color: red"> *</span></label>
                                            <input id="create_training_title" type="text" name="training_title" class="form-control" placeholder="Training Title">
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label for="create_training_organiser" class="form-label">Training Organiser<span style="color: red"> *</span></label>
                                            <input id="create_training_organiser" type="text" name="training_organiser" class="form-control" placeholder="Training Organiser">
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label for="create_training_venue" class="form-label">Training Venue<span style="color: red"> *</span></label>
                                            <input id="create_training_venue" type="text" name="training_venue" class="form-control" placeholder="Training Venue">
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label for="create_training_cost" class="form-label">Training Cost<span style="color: red"> *</span></label>
                                            <input id="create_training_cost" type="text" name="training_cost" class="form-control" placeholder="Training Cost">
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label for="create_training_start_date" class="form-label">Training Start Date<span style="color: red"> *</span></label>
                                            <input id="create_training_start_date" type="date" name="training_start_date" class="form-control" placeholder="Training Start Date">
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label for="create_title" class="form-label">Training End Date<span style="color: red"> *</span></label>
                                            <input id="create_title" type="date" name="training_end_date" class="form-control" placeholder="Training End Date">
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label for="create_training_objective" class="form-label">Training Objective<span style="color: red"> *</span></label>
                                            <textarea id="create_training_objective" name="training_objective" class="form-control" rows="4" placeholder="Enter training objective..."></textarea>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label for="create_remarks" class="form-label">Remark</label>
                                            <textarea id="create_remarks" name="remarks" class="form-control" rows="4" placeholder="Enter remarks..."></textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Participants<span style="color: red"> *</span></label>
                                            <div id="participantsRepeater">
                                                <div class="row g-3 participant-row mb-2">
                                                    <div class="col-lg-5">
                                                        <input type="text" name="participants[0][name]" class="form-control" placeholder="Participant Name">
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <select name="participants[0][department]" class="form-select">
                                                            <option value="" selected disabled>Please select</option>
                                                            <option value="Auxiliary Police">Auxiliary Police</option>
                                                            <option value="Breakbulk & Customer Service">Breakbulk & Customer Service</option>
                                                            <option value="Business Development & Commercial">Business Development & Commercial</option>
                                                            <option value="Corporate Planning & Strategic Transformation">Corporate Planning & Strategic Transformation</option>
                                                            <option value="Corporate Strategic Planning">Corporate Strategic Planning</option>
                                                            <option value="Corporate_Services">Corporate_Services</option>
                                                            <option value="Environment, Safety & Health">Environment, Safety & Health</option>
                                                            <option value="Finance">Finance</option>
                                                            <option value="Governance , Risk & Compliance">Governance , Risk & Compliance</option>
                                                            <option value="Human Resource & Administration">Human Resource & Administration</option>
                                                            <option value="IT">IT</option>
                                                            <option value="Marine & Liquid Operations">Marine & Liquid Operations</option>
                                                            <option value="Office of Executive Director & Chief Executive">Office of Executive Director & Chief Executive</option>
                                                            <option value="Technical Engineering & Facility Management">Technical Engineering & Facility Management</option>
                                                            <option value="Terminal & Free Zone Operation">Terminal & Free Zone Operation</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <button type="button" class="btn btn-danger remove-participant w-100">Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-secondary add-participant" data-id="">Add Participant</button>
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
                                    <input type="hidden" name="training_request_id" id="created_training_request_id">

                                    <div class="small mt-1" id="upload-note" style="color: red !important">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Please submit the Training Request before uploading documents.
                                    </div>

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

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reportFormModal" tabindex="-1" aria-labelledby="reportFormModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content text-start">
                <div class="modal-header pb-0">
                    <h1 class="modal-title fs-5" id="reportFormModalLabel">Export Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reportForm" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="report_type" class="form-label">Report Type</label>
                                    <select name="report_type" id="report_type" class="form-select">
                                        <option value="" hidden selected>Please select</option>
                                        <option value="1">All</option>
                                        <option value="2">Yearly</option>
                                        <option value="3">Monthly</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-3 year-group d-none">
                                    <label for="year" class="form-label">Year</label>
                                    <input type="number" class="form-control" id="year" name="year" min="2000" max="2100" value="{{ date('Y') }}"
                                        oninput="if (this.value.length > 4) this.value = this.value.slice(0,4);">
                                </div>

                                <div class="col-lg-6 mb-3 month-group d-none">
                                    <label for="month" class="form-label">Month</label>
                                    <input type="month" class="form-control" id="month" name="month">
                                </div>
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-primary report-btn">Export</button>
                                </div>
                            </div>
                        </div>
                    </form>
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
                    url: "/training-request/create",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        toastr.success('Training Request created successfully! You can now upload documents.', '', { timeOut: 8000 });

                        $('#created_training_request_id').val(response.trainingRequest.id);
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
                let trainingRequestId = $(this).data('id');
                let form = $('#editForm' + trainingRequestId)[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "/training-request/" + trainingRequestId + "/edit",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#editModal' + trainingRequestId).modal('hide');

                        console.log(response);
                        toastr.success('Training Request updated successfully!', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.delete-btn', function () {
                let trainingRequestId = $(this).data('id');

                $.ajax({
                    url: "/training-request/" + trainingRequestId + "/delete",
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#deleteModal' + trainingRequestId).modal('hide');

                        console.log(response);
                        toastr.success('Training Request removed successfully!', '', { timeOut: 8000 });
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

                let trainingRequestId = $('#created_training_request_id').val();
                if (!trainingRequestId) {
                    toastr.warning('Please save the form first before uploading documents.');
                    return;
                }

                let form = $('#createDocumentForm')[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "/training-request/" + trainingRequestId + "/document/upload",
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
                                                '<a href="#" class="btn btn-sm btn-danger delete-document-btn" data-training-request-id="' + trainingRequestId + '" data-id="' + response.document.id + '">Delete</a>' +
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

                let trainingRequestId = $(this).data('id');
                let form = $('#documentForm' + trainingRequestId)[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "/training-request/" + trainingRequestId + "/document/upload",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {

                        console.log(response);
                        toastr.success('Training Request Document uploaded successfully!', '', { timeOut: 8000 });

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
                                                '<a href="#" class="btn btn-sm btn-danger delete-document-btn" data-training-request-id="' + trainingRequestId + '" data-id="' + response.document.id + '">Delete</a>' +
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

                        $('#document-container-' + trainingRequestId).append(newAttachmentRow);

                        $('#documentForm' + trainingRequestId).trigger('reset');
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

                let trainingRequestId = $(this).data('training-request-id');
                let documentId = $(this).data('id');

                if (!confirm("Are you sure you want to delete this document?")) {
                    return;
                }

                $.ajax({
                    url: "/training-request/" + trainingRequestId + "/document/" + documentId + "/delete",
                    method: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        toastr.success(response.message, '', { timeOut: 8000 });
                        $("#document-" + documentId).remove(); // remove the card from DOM

                        setTimeout(() => {
                            let list = $("#document-container-" + trainingRequestId);
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

                                $('#document-container-' + trainingRequestId).append(newAttachmentRow);
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

                let trainingRequestId = $('#created_training_request_id').val();
                $('#createForm')[0].reset();
                $('#createDocumentForm')[0].reset();
                $('#created_training_request_id').val('');

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
                if (trainingRequestId) {
                    $('#dataTableBuilder').DataTable().ajax.reload();
                }
            });

            $(document).on('click', '.reviewer-submit-btn', function () {
                let trainingRequestId = $(this).data('id');
                let form = $('#reviewerForm' + trainingRequestId)[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "/training-request/" + trainingRequestId + "/review",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#statusModal' + trainingRequestId).modal('hide');

                        console.log(response);
                        toastr.success('Training Request updated successfully!', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.approver-submit-btn', function () {
                let trainingRequestId = $(this).data('id');
                let form = $('#approverForm' + trainingRequestId)[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "/training-request/" + trainingRequestId + "/approve",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#statusModal' + trainingRequestId).modal('hide');

                        console.log(response);
                        toastr.success('Training Request updated successfully!', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.hoc-approver-submit-btn', function () {
                let trainingRequestId = $(this).data('id');
                let form = $('#hocApproverForm' + trainingRequestId)[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "/training-request/" + trainingRequestId + "/hoc-approve",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#statusModal' + trainingRequestId).modal('hide');

                        console.log(response);
                        toastr.success('Training Request updated successfully!', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.mark-as-completed-btn', function () {
                let trainingRequestId = $(this).data('id');

                $.ajax({
                    url: "/training-request/" + trainingRequestId + "/mark-as-completed",
                    type: "POST",
                    data: {},
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#statusModal' + trainingRequestId).modal('hide');

                        console.log(response);
                        toastr.success('Training Request updated successfully!', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.add-participant', function () {

                let id = $(this).data('id') ?? '';  
                let container = $('#participantsRepeater' + id);

                let index = container.children('.participant-row').length;

                container.append(`
                    <div class="row g-3 participant-row mb-2">
                        <div class="col-lg-5">
                            <input type="text" name="participants[${index}][name]" class="form-control" placeholder="Participant Name">
                        </div>

                        <div class="col-lg-5">
                            <select name="participants[${index}][department]" class="form-select">
                                <option value="" selected disabled>Please select</option>
                                <option value="Auxiliary Police">Auxiliary Police</option>
                                <option value="Breakbulk & Customer Service">Breakbulk & Customer Service</option>
                                <option value="Business Development & Commercial">Business Development & Commercial</option>
                                <option value="Corporate Planning & Strategic Transformation">Corporate Planning & Strategic Transformation</option>
                                <option value="Corporate Strategic Planning">Corporate Strategic Planning</option>
                                <option value="Corporate_Services">Corporate_Services</option>
                                <option value="Environment, Safety & Health">Environment, Safety & Health</option>
                                <option value="Finance">Finance</option>
                                <option value="Governance , Risk & Compliance">Governance , Risk & Compliance</option>
                                <option value="Human Resource & Administration">Human Resource & Administration</option>
                                <option value="IT">IT</option>
                                <option value="Marine & Liquid Operations">Marine & Liquid Operations</option>
                                <option value="Office of Executive Director & Chief Executive">Office of Executive Director & Chief Executive</option>
                                <option value="Technical Engineering & Facility Management">Technical Engineering & Facility Management</option>
                                <option value="Terminal & Free Zone Operation">Terminal & Free Zone Operation</option>
                            </select>
                        </div>

                        <div class="col-lg-2">
                            <button type="button" class="btn btn-danger remove-participant w-100">Remove</button>
                        </div>
                    </div>
                `);
            });

            $(document).on('click', '.remove-participant', function () {
                $(this).closest('.participant-row').remove();
            });

            $(document).on('click', '.generate-form-btn', function () {
                let trainingRequestId = $(this).data('id');

                $.ajax({
                    url: "/training-request/" + trainingRequestId + "/generate-form-pdf",
                    type: "POST",
                    data: {},
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#statusModal' + trainingRequestId).modal('hide');

                        console.log(response);
                        toastr.success('Training Request updated successfully!', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('change', '#report_type', function () {
                const selected = $(this).val();
                const currentYear = new Date().getFullYear();

                // Hide both first
                $('.year-group, .month-group').addClass('d-none');

                if (selected === '2') {
                    // Yearly → show year input and set to current year
                    $('.year-group').removeClass('d-none');
                    $('#year').val(currentYear);
                    $('#month').val('');
                } 
                else if (selected === '3') {
                    // Monthly → show month input only
                    $('.month-group').removeClass('d-none');
                    $('#year').val('');
                } 
                else {
                    // All → clear both
                    $('#year, #month').val('');
                }
            });

            $(document).on('click', '.report-btn', function () {
                let form = $('#reportForm')[0];
                let formData = new FormData(form);

                // Disable button while generating
                let btn = $(this);
                btn.prop('disabled', true).text('Generating...');

                $.ajax({
                    url: "/training-request/report",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    xhrFields: {
                        responseType: 'blob' // 👈 important for file download
                    },
                    success: function (blob, status, xhr) {
                        // ✅ Get filename from header if available
                        let filename = "";
                        const disposition = xhr.getResponseHeader('Content-Disposition');
                        if (disposition && disposition.indexOf('attachment') !== -1) {
                            const matches = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/.exec(disposition);
                            if (matches && matches[1]) filename = matches[1].replace(/['"]/g, '');
                        }
                        if (!filename) filename = "program_report.xlsx";

                        // ✅ Create a link and trigger download
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = filename;
                        document.body.appendChild(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(url);

                        toastr.success('Report exported successfully!');
                        
                        // Close modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('reportFormModal'));
                        modal.hide();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Failed to export report!');
                    },
                    complete: function () {
                        // Always reset button state
                        btn.prop('disabled', false).text('Export');
                    }
                });
            });

        </script>
    @endpush
</x-app-layout>
