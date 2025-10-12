<x-app-layout>
    <div class="card">
        <div class="card-body p-0">
            <div class="p-3" style="border-bottom: 1px solid #dee2e6">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h5 class="mb-0">Training Needs Identification (Course)</h5>
                    </div>
                    <div class="col-6 text-end">
                        @if (auth()->user()->role == 'Admin')
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                                <i class="bi bi-plus-lg icon-13 me-1"></i> New Course
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
                <div class="modal-header pb-0">
                    <h1 class="modal-title fs-5" id="createModalLabel">New Course</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createForm">
                        <div class="card" style="box-shadow: none !important">
                            <div class="card-body py-0">
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <label for="course_name" class="form-label">Name</label>
                                        <input id="course_name" type="text" name="course_name" class="form-control" placeholder="Course Name">                        
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label for="course_objective" class="form-label">Objective</label>
                                        <textarea id="course_objective" name="course_objective" class="form-control" rows="4"
                                            placeholder="Enter objective..."></textarea>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="course_duration" class="form-label">Duration</label>
                                        <div class="input-group">
                                            <input id="course_duration" type="text" name="course_duration" class="form-control" placeholder="0">
                                            <span class="input-group-text" id="basic-addon1" style="font-size: 13px !important">Hour(s)</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="course_cost" class="form-label">Cost</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1" style="font-size: 13px !important">RM</span>
                                            <input id="course_cost" type="text" name="course_cost" class="form-control" placeholder="0.00">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label for="course_category" class="form-label">Remark</label>
                                        <input id="course_category" type="text" name="course_category" class="form-control" placeholder="Course Name">                        
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
                    url: "/training-needs/program/{{ $program_id }}/competency/{{ $competency_id }}/course/create",
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
                        toastr.success('Course added successfully!', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.edit-btn', function () {
                let courseId = $(this).data('id');
                let form = $('#editForm' + courseId)[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "/training-needs/program/{{ $program_id }}/competency/{{ $competency_id }}/course/" + courseId + "/edit",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#editModal' + courseId).modal('hide');

                        console.log(response);
                        toastr.success('Course updated successfully!', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.delete-btn', function () {
                let courseId = $(this).data('id');

                $.ajax({
                    url: "/training-needs/program/{{ $program_id }}/competency/{{ $competency_id }}/course/" + courseId + "/delete",
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#deleteModal' + courseId).modal('hide');

                        console.log(response);
                        toastr.success('Course removed successfully!', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.btn-apply', function (e) {
                e.preventDefault();
                const courseId = $(this).data('course-id');
                const courseName = $(this).data('course-name');
                const url = `/training-needs/program/{{ $program_id }}/competency/{{ $competency_id }}/course/${courseId}/apply`;

                $.ajax({
                    url: url,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {

                        console.log(response);
                        toastr.success('You’re now enrolled in ' + courseName + '.', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.btn-withdraw', function (e) {
                e.preventDefault();
                const courseId = $(this).data('course-id');
                const courseName = $(this).data('course-name');
                const url = `/training-needs/program/{{ $program_id }}/competency/{{ $competency_id }}/course/${courseId}/withdraw`;

                $.ajax({
                    url: url,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        console.log(response);
                        toastr.warning('You’ve opted out from ' + courseName +'.', '', { timeOut: 8000 });
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
