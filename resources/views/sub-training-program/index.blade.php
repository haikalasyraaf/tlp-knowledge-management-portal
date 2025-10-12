<x-app-layout>
    <div class="d-flex align-items-center mb-3">
        <div class="flex-fill"></div>
        <div>
            <a href="{{route('training-program.index')}}" class="btn btn-secondary">
                <i class="bi bi-arrow-left icon-13 me-2"></i>Back
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-0">
            <div class="p-3" style="border-bottom: 1px solid #dee2e6">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h5 class="mb-0">{{ $trainingProgram->name }}</h5>
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

    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content text-start">
                <div class="modal-header pb-0">
                    <h1 class="modal-title fs-5" id="createModalLabel">New Record</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createForm">
                        <div class="card" style="box-shadow: none !important">
                            <div class="card-body py-0">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label for="program_name" class="form-label">Document Name <span class="text-danger">*</span></label>
                                        <input id="program_name" type="text" name="program_name" class="form-control" placeholder="Name">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="program_document" class="form-label">Attachment</label>
                                        <input id="program_document" type="file" name="document_path" class="form-control">
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label for="program_description" class="form-label">Description</label>
                                        <textarea name="program_description" id="program_description" rows="4" class="form-control" placeholder="Enter description..."></textarea>                     
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
                    url: "/training-program/{{ $trainingProgram->id }}/program/create",
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
                        toastr.success('New program added successfully!', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.edit-btn', function () {
                let trainingId = $(this).data('id');
                let form = $('#editForm' + trainingId);

                $.ajax({
                    url: "/training-program/{{ $trainingProgram->id }}/program/" + trainingId + "/edit",
                    type: "POST",
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#editModal' + trainingId).modal('hide');

                        console.log(response);
                        toastr.success('Program detail updated successfully!', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.delete-btn', function () {
                let trainingId = $(this).data('id');

                $.ajax({
                    url: "/training-program/{{ $trainingProgram->id }}/program/" + trainingId + "/delete",
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#deleteModal' + trainingId).modal('hide');

                        console.log(response);
                        toastr.success('Program has been removed successfully!', '', { timeOut: 8000 });
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
