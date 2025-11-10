<x-app-layout>

    <div class="d-flex align-items-center mb-3">
        <p class="mb-0 me-3 p-0" style="font-weight: 500">Training Program</p>

        <div class="flex-grow-1 border-top"></div>

        @if (auth()->user()->role == 'Admin')
            <button class="btn btn-sm btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-plus-lg icon-13 me-1"></i> New Program
            </button>            
        @endif
    </div>

    <div class="d-flex flex-wrap justify-content-center align-items-stretch">
        @forelse ($trainingPrograms as $trainingProgram)
            <div class="mx-3 mb-6" style="width: 350px;">
                <div class="card h-100 mb-3" style="border-radius: 6px; overflow: hidden;">
                    @if (auth()->user()->role == 'Admin')
                        <button type="button" class="btn btn-danger position-absolute top-0 end-0 m-2" style="z-index: 10;" data-bs-toggle="modal" data-bs-target="#deleteModal{{$trainingProgram->id}}">
                            <i class="bi bi-trash icon-13"></i>
                        </button>
                    @endif
                    <img src="{{ $trainingProgram->image_path ? asset('storage/' . $trainingProgram->image_path) : asset('images/no-image.jpg') }}" class="card-img-top" style="height: 200px" alt="Image">
                    <div class="card-body">
                        <h5 class="card-title">{{ $trainingProgram->name }}</h5>
                        <p class="card-text" style="text-align: justify;">
                            {!! $trainingProgram->description !!}
                        </p>
                    </div>
                    <div class="px-3 pb-3 text-center">
                        <div class="d-flex">
                            <div class="flex-fill">
                                <a href="{{ route('training-program.folder.index', $trainingProgram->id) }}" class="w-100 btn btn-primary">
                                    <i class="bi bi-card-list icon-13 me-1"></i> View
                                </a>
                            </div>
                            @if (auth()->user()->role == 'Admin')
                                <div class="ms-2">
                                    <a href="#" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal{{$trainingProgram->id}}">
                                        <i class="bi bi-pencil-square icon-13 me-1"></i> Edit
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editModal{{$trainingProgram->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content text-start">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editModalLabel">Edit Training Program</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editTrainingProgram{{$trainingProgram->id}}" enctype="multipart/form-data">
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
                                            <label for="program_name" class="form-label">Program Name</label>
                                            <input id="program_name" type="text" name="name" class="form-control" value="{{$trainingProgram->name}}" placeholder="Name">
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <label for="program_description" class="form-label">Program Description</label>
                                            <textarea id="program_description" name="description" class="form-control" rows="5"
                                                placeholder="Enter description...">{!!$trainingProgram->description!!} </textarea>
                                        </div>
                                        <div class="col-12 text-end">
                                            <button type="button" class="btn btn-primary edit-btn" data-id="{{ $trainingProgram->id }}">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteModal{{$trainingProgram->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content text-start">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this training program? All its related content will be deleted as well.
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger delete-btn" data-id="{{ $trainingProgram->id }}">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

        @empty
            <div>
                No training programs available at the moment.
            </div>
        @endforelse
    </div>

    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content text-start">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createModalLabel">Add Training Program</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createTrainingProgram" enctype="multipart/form-data">
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
                                    <label for="program_name" class="form-label">Program Name</label>
                                    <input id="program_name" type="text" name="name" class="form-control" placeholder="Name">
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="program_description" class="form-label">Program Description</label>
                                    <textarea id="program_description" name="description" class="form-control" rows="5"
                                        placeholder="Enter description..."></textarea>
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
        <script>
            $(document).on('click', '.add-btn', function () {
                let form = $('#createTrainingProgram')[0];
                let formData = new FormData(form);

                $('.add-btn').attr('disabled', true);
                $.ajax({
                    url: "/training-program/create",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        toastr.success('Training Program added successfully!', null, 1500);
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

            $(document).on('click', '.edit-btn', function () {
                let programId = $(this).data('id');
                let form = $('#editTrainingProgram' + programId)[0];
                let formData = new FormData(form);

                $('.edit-btn').attr('disabled', true);
                $.ajax({
                    url: "/training-program/" + programId + "/edit",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        toastr.success('Training Program updated successfully!', null, 1500);
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    },
                    error: function (xhr) {
                        $('.edit-btn').removeAttr('disabled');

                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.delete-btn', function () {
                let programId = $(this).data('id');

                $('.delete-btn').attr('disabled', true);
                $.ajax({
                    url: "/training-program/" + programId + "/delete",
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        toastr.success('Training Program removed successfully!', null, 1500);
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
