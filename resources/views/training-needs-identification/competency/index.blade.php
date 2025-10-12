<x-app-layout>

    <div class="d-flex align-items-center mb-3">
        <p class="mb-0 me-3 p-0" style="font-weight: 500">Training Needs Identification (Competency)</p>

        <div class="flex-grow-1 border-top"></div>

        @if (auth()->user()->role == 'Admin')
        <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="bi bi-plus-lg icon-13 me-2"></i> New Competency
        </button>    
        @endif
    </div>

    <div class="d-flex flex-wrap justify-content-center align-items-stretch">
        @forelse ($tniCompetencies as $tniCompetency)
            <div class="mx-3 mb-6" style="width: 350px;">
                <div class="card h-100 mb-3" style="border-radius: 6px; overflow: hidden;">
                    @if (auth()->user()->role == 'Admin')
                        <button type="button" class="btn btn-danger position-absolute top-0 end-0 m-2" style="z-index: 10;" data-bs-toggle="modal" data-bs-target="#deleteModal{{$tniCompetency->id}}">
                            <i class="bi bi-trash icon-13"></i>
                        </button>
                    @endif
                    <img src="{{ $tniCompetency->image_path ? asset('storage/' . $tniCompetency->image_path) : asset('images/no-image.jpg') }}" class="card-img-top" style="height: 200px" alt="Image">
                    <div class="card-body">
                        <h5 class="card-title">{{ $tniCompetency->competency_name }}</h5>
                        <p class="card-text" style="text-align: justify;">
                            {!! $tniCompetency->competency_description !!}
                        </p>
                    </div>
                    <div class="px-3 pb-3 text-center">
                        <div class="d-flex">
                            <div class="flex-fill">
                                <a href="{{ route('training-needs.course.index', [$program_id, $tniCompetency->id]) }}" class="w-100 btn btn-primary">
                                    <i class="bi bi-card-list icon-13 me-1"></i> View
                                </a>
                            </div>
                            <div class="ms-2 {{auth()->user()->role == 'Staff' ? 'd-none' : ''}}" >
                                <a href="#" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal{{$tniCompetency->id}}">
                                    <i class="bi bi-pencil-square icon-13 me-1"></i> Edit
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editModal{{$tniCompetency->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content text-start">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editModalLabel">Edit Competency</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editData{{$tniCompetency->id}}" enctype="multipart/form-data">
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
                                            <label for="competency_name" class="form-label">Competency Name</label>
                                            <input id="competency_name" type="text" name="competency_name" class="form-control" value="{{$tniCompetency->competency_name}}" placeholder="Name">
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <label for="competency_description" class="form-label">Competency Description</label>
                                            <textarea id="competency_description" name="competency_description" class="form-control" rows="5"
                                                placeholder="Enter description...">{!!$tniCompetency->competency_description!!} </textarea>
                                        </div>
                                        <div class="col-12 text-end">
                                            <button type="button" class="btn btn-primary edit-btn" data-id="{{ $tniCompetency->id }}">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteModal{{$tniCompetency->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content text-start">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this competency? All its related content will be deleted as well.
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger delete-btn" data-id="{{ $tniCompetency->id }}">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div>
                No competency available at the moment.
            </div>
        @endforelse
    </div>

    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content text-start">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createModalLabel">Add Competency</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createData" enctype="multipart/form-data">
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
                                    <label for="competency_name" class="form-label">Competency Name</label>
                                    <input id="competency_name" type="text" name="competency_name" class="form-control" placeholder="Name">
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="competency_description" class="form-label">Competency Description</label>
                                    <textarea id="competency_description" name="competency_description" class="form-control" rows="5"
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
                let form = $('#createData')[0];
                let formData = new FormData(form);

                $('.add-btn').attr('disabled', true);
                $.ajax({
                    url: "/training-needs/program/{{ $program_id }}/competency/create",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        toastr.success('Competency added successfully!', null, 1500);
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
                let competencyId = $(this).data('id');
                let form = $('#editData' + competencyId)[0];
                let formData = new FormData(form);

                $('.edit-btn').attr('disabled', true);
                $.ajax({
                    url: "/training-needs/program/{{ $program_id }}/competency/" + competencyId + "/edit",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        toastr.success('Competency updated successfully!', null, 1500);
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
                let competencyId = $(this).data('id');

                $('.delete-btn').attr('disabled', true);
                $.ajax({
                    url: "/training-needs/program/{{ $program_id }}/competency/" + competencyId + "/delete",
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        toastr.success('Competency removed successfully!', null, 1500);
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
