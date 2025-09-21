<div class="d-flex justify-content-center gap-1">
    @if (!$course->isUserEnrolled(auth()->id()))
        <a href="#" class="btn btn-sm btn-success btn-apply" data-course-id="{{ $course->id }}" data-course-name="{{ $course->course_name }}">Join</a>
    @else
        <a href="#" class="btn btn-sm btn-warning btn-withdraw" data-course-id="{{ $course->id }}" data-course-name="{{ $course->course_name }}">Leave</a>
    @endif
    @if (auth()->user()->role == 'Admin')
        <a href="#" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal{{$course->id}}">Edit</a>
        <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$course->id}}">Delete</a>
    @endif
</div>

<div class="modal fade" id="editModal{{$course->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content text-start">
            <div class="modal-header pb-0">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Course</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm{{$course->id}}">
                    <div class="card" style="box-shadow: none !important">
                        <div class="card-body py-0">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <label for="course_name" class="form-label">Name</label>
                                    <input id="course_name" type="text" name="course_name" class="form-control" value="{{ $course->course_name }}" placeholder="Course Name">                        
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="course_objective" class="form-label">Objective</label>
                                    <textarea id="course_objective" name="course_objective" class="form-control" rows="4"
                                        placeholder="Enter objective...">{!! $course->course_objective !!}</textarea>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="course_duration" class="form-label">Duration</label>
                                    <div class="input-group">
                                        <input id="course_duration" type="text" name="course_duration" class="form-control" value="{{ $course->course_duration }}" placeholder="0">
                                        <span class="input-group-text" id="basic-addon1" style="font-size: 13px !important">Hour(s)</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="course_cost" class="form-label">Cost</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1" style="font-size: 13px !important">RM</span>
                                        <input id="course_cost" type="text" name="course_cost" class="form-control" value="{{ $course->course_cost }}" placeholder="0.00">
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="course_category" class="form-label">Remark</label>
                                    <input id="course_category" type="text" name="course_category" class="form-control" value="{{ $course->course_category }}" placeholder="Course Category">                        
                                </div>
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-primary edit-btn" data-id="{{ $course->id }}">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal{{$course->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-start">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        Are you sure want to delete this course? This action cannot be undone
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger delete-btn" data-id="{{ $course->id }}">Delete</button>
            </div>
        </div>
    </div>
</div>