<x-app-layout>
    <div class="card">
        <div class="card-body p-0">
            <div class="p-3" style="border-bottom: 1px solid #dee2e6">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h5 class="mb-0">
                            Training Record List
                        </h5>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content text-start">
                <div class="modal-header pb-0">
                    <h1 class="modal-title fs-5" id="createModalLabel">Create Training Record</h1>
                    <button type="button" class="btn-close close-create-modal-btn" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="edit-wrapper">
                        <form id="createForm">
                            <div class="card card-detail" style="box-shadow: none !important">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            <input name="form_title" type="text" class="form-control" placeholder="Course Title*">
                                        </div>
                                        <div class="col-12 mb-2">
                                            <input name="form_date" type="date" class="form-control" value="{{now()->format('Y-m-d')}}">
                                        </div>
                                        <div class="col-12 mb-2">
                                            <input name="form_provider" type="text" class="form-control" placeholder="Provider">
                                        </div>
                                        <div class="col-12 mb-2">
                                            <input name="form_hours" type="text" class="form-control" placeholder="Hours">
                                        </div>
                                    </div>
                                    <div id="staffRepeater" class="mt-3">
                                        <label class="form-label">System Users</label>
                                        <div>
                                            <div class="row">
                                                <div class="col-11 pe-0">
                                                    <input type="text" id="staffSearch" class="form-control my-2" placeholder="Search...">
                                                </div>
                                            </div>
                                            <div style="height: 210px; overflow-y: auto; overflow-x: hidden;">
                                                @foreach ($staffs as $index => $staff)
                                                    <div class="row align-items-center staff-row mb-2">
                                                        <div class="col-7 pe-0">
                                                            <input type="text" name="staff[0][name]" class="form-control staff-name" value="{{$staff->name}}" disabled>
                                                        </div>
                                                        <div class="col-4 pe-0">
                                                            <input type="text" name="staff[0][department]" class="form-control staff-department" value="{{$staff->department}}" disabled>
                                                        </div>
                                                        <div class="col-1 pe-0">
                                                            <div class="form-check form-check-inline py-0 m-0">
                                                                <input class="form-check-input" type="checkbox" name="staff_ids[]" value="{{$staff->id}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-end">
                                            <button type="button" class="btn btn-sm btn-success add-btn">Create record</button>
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
                    url: "training-record/create",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        toastr.success('Training Record created successfully!', '', { timeOut: 8000 });

                        setTimeout(() => {
                            window.location.reload();
                        }, 500);
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                        $(e.currentTarget).prop('disabled', false);
                    }
                });
            });

            $(document).on('click', '.delete-btn', function () {

                let trainingRecordId = $(this).data('id');

                $.ajax({
                    url: "/training-record/" + trainingRecordId + "/delete",
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        toastr.success('Training Record removed successfully!', '', { timeOut: 8000 });

                        setTimeout(() => {
                            window.location.reload();
                        }, 500);
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.close-create-modal-btn', function (e) {
                window.location.reload();
            });

            $('#staffSearch').on('input', function() {
                let value = $(this).val().toLowerCase();

                $('.staff-row').filter(function() {
                    let name = $(this).find('.staff-name').val().toLowerCase();
                    let department = $(this).find('.staff-department').val().toLowerCase();

                    $(this).toggle(
                        name.includes(value) || department.includes(value)
                    );
                });
            });

        </script>
    @endpush
</x-app-layout>
