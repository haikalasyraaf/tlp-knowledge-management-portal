<x-app-layout>
    <div class="card">
        <div class="card-body p-0">
            <div class="p-3" style="border-bottom: 1px solid #dee2e6">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h5 class="mb-0">Yearly Calendar List</h5>
                    </div>
                    <div class="col-6 text-end">
                        @if (auth()->user()->role == 'Admin')
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                                <i class="bi bi-plus-lg icon-13 me-1"></i> New Record
                            </button>                            
                        @endif
                    </div>
                </div>                
            </div>

            <div class="p-3">
                {!! $html->table() !!}
            </div>
        </div>
    </div>

    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content text-start">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createModalLabel">New Calendar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createForm">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input id="name" type="text" name="name" class="form-control" placeholder="Name">                        
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="document_path" class="form-label">Document</label>
                                        <input id="document_path" type="file" name="document_path" class="form-control" accept="application/pdf">
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea id="description" name="description" class="form-control" rows="4"
                                            placeholder="Enter description..."></textarea>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" name="is_display" class="form-check-input" value="2">
                                            <input id="checkChecked" type="checkbox" name="is_display" class="form-check-input" value="1" checked>
                                            <label class="form-check-label" for="checkChecked">Set as Display</label>
                                        </div>
                                    </div>

                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-primary add-btn">Save</button>
                                    </div>
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
            $(document).on('click', '.add-btn', function () {
                let form = $('#createForm')[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "/training-calendar/yearly/create",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        form.reset();
                        $('#createModal').modal('hide');

                        console.log(response);
                        toastr.success('Yearly Calendar added successfully!', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.edit-btn', function () {
                let calendarId = $(this).data('id');
                let form = $('#editForm' + calendarId)[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "/training-calendar/yearly/" + calendarId + "/edit",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#editModal' + calendarId).modal('hide');

                        console.log(response);
                        toastr.success('yearly Calendar updated successfully!', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.delete-btn', function () {
                let calendarId = $(this).data('id');

                $.ajax({
                    url: "/training-calendar/yearly/" + calendarId + "/delete",
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#deleteModal' + calendarId).modal('hide');

                        console.log(response);
                        toastr.success('Yearly Calendar removed successfully!', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
