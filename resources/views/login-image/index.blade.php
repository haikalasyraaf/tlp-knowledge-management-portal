<x-app-layout>

    <div class="card">
        <div class="card-body p-0">
            <div class="p-3" style="border-bottom: 1px solid #dee2e6">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h5 class="mb-0">Login Image List</h5>
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
        <div class="modal-dialog modal-md">
            <div class="modal-content text-start">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createModalLabel">Add Login Image</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addLoginImage" enctype="multipart/form-data">
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
                    
                                <div class="col-lg-12 my-3">
                                    <label for="image_label" class="form-label">Label</label>
                                    <input id="image_label" type="text" name="image_label" class="form-control" placeholder="Enter label">
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="image_placeholder" class="form-label">Placeholder</label>
                                    <input id="image_placeholder" type="text" name="image_placeholder" class="form-control" placeholder="Enter placeholder">
                                </div>
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-primary add-btn">Save</button>
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
                let form = $('#addLoginImage')[0];
                let formData = new FormData(form);

                $('.add-btn').attr('disabled', true);
                $.ajax({
                    url: "/settings/login-image/create",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        toastr.success('Login Image added successfully!', null, 1500);
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    },
                    error: function (xhr) {
                        $('.add-btn').removeAttr('disabled');

                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.delete-btn', function () {
                let imageId = $(this).data('id');

                $('.delete-btn').attr('disabled', true);
                $.ajax({
                    url: "/settings/login-image/" + imageId + "/delete",
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        toastr.success('Login image removed successfully!', null, 1500);
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    },
                    error: function (xhr) {
                        $('.delete-btn').removeAttr('disabled');

                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
