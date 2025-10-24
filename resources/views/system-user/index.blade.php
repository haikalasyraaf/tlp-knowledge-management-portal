<x-app-layout>
    <div class="card">
        <div class="card-body p-0">
            <div class="p-3" style="border-bottom: 1px solid #dee2e6">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h5 class="mb-0">System Users</h5>
                    </div>
                    <div class="col-6 text-end">
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="bi bi-file-earmark-arrow-up-fill icon-13 me-1"></i> Import
                        </button>
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

    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content text-start">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createModalLabel">New System User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createUserForm" enctype="multipart/form-data">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <div class="mb-2 d-flex justify-content-center">
                                            <img src="{{ asset('images/default-profile-photo.png') }}" alt="Profile Photo" class="img-thumbnail"
                                                style="width: 120px; height: 120px; object-fit: cover;">
                                        </div>
                                        <label for="user_profile_photo" class="form-label">Profile Photo</label>
                                        <input id="user_profile_photo" type="file" name="profile_photo" class="form-control" accept="image/*">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="user_employee_id" class="form-label">Employee ID</label>
                                        <input id="user_employee_id" type="text" name="employee_id" class="form-control" placeholder="Employee ID">                        
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="user_name" class="form-label">Name</label>
                                        <input id="user_name" type="text" name="name" class="form-control" placeholder="Name">                        
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="user_email" class="form-label">Email</label>
                                        <input id="user_email" type="email" name="email" class="form-control" placeholder="Email">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="user_role" class="form-label">Role</label>
                                        <select id="user_role" name="role" class="form-select">
                                            <option value="" selected disabled>Please select</option>
                                            <option value="Admin">Admin</option>
                                            <option value="Staff">Staff</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="user_department" class="form-label">Department</label>
                                        <select id="user_department" name="department" class="form-select">
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
                                        <label for="user_designation" class="form-label">Designation</label>
                                        <select id="user_designation" name="designation" class="form-select">
                                            <option value="" selected disabled>Please select</option>
                                            <option value="Assistant Executive">Assistant Executive</option>
                                            <option value="Assistant Operation Officer">Assistant Operation Officer</option>
                                            <option value="Assistant Superintendent of Police (ASP)">Assistant Superintendent of Police (ASP)</option>
                                            <option value="Associate Executive">Associate Executive</option>
                                            <option value="Billing Executive">Billing Executive</option>
                                            <option value="Chief Financial Officer">Chief Financial Officer</option>
                                            <option value="Deputy General Manager">Deputy General Manager</option>
                                            <option value="Deputy Manager">Deputy Manager</option>
                                            <option value="Driver cum Dispatch">Driver cum Dispatch</option>
                                            <option value="Executive">Executive</option>
                                            <option value="Executive Director">Executive Director</option>
                                            <option value="General Manager">General Manager</option>
                                            <option value="Handyman">Handyman</option>
                                            <option value="Head of Breakbulk & Customer Service">Head of Breakbulk & Customer Service</option>
                                            <option value="Head of Commercial">Head of Commercial</option>
                                            <option value="Konstabel">Konstabel</option>
                                            <option value="Koperal">Koperal</option>
                                            <option value="Lans Koperal">Lans Koperal</option>
                                            <option value="Manager">Manager</option>
                                            <option value="Marine Assistant">Marine Assistant</option>
                                            <option value="Operation Assistant">Operation Assistant</option>
                                            <option value="Operation Officer">Operation Officer</option>
                                            <option value="Pengawal Keselamatan">Pengawal Keselamatan</option>
                                            <option value="Sarjan">Sarjan</option>
                                            <option value="Sarjan Mejar">Sarjan Mejar</option>
                                            <option value="Senior Executive">Senior Executive</option>
                                            <option value="Senior General Manager">Senior General Manager</option>
                                            <option value="Senior Manager">Senior Manager</option>
                                            <option value="Senior Technician">Senior Technician</option>
                                            <option value="Supervisor - Firefighting">Supervisor - Firefighting</option>
                                            <option value="Supervisor - HSE">Supervisor - HSE</option>
                                            <option value="Technician">Technician</option>
                                            <option value="Warehouse Assistant">Warehouse Assistant</option>
                                            <option value="Yard/Vessel Planner">Yard/Vessel Planner</option>
                                        </select>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-primary add-user-btn">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content text-start">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="importForm">
                        <div class="card" style="box-shadow: none !important">
                            <div class="card-body py-0">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="import_file" class="form-label">Import File</label>
                                        <input id="import_file" type="file" name="import_file" class="form-control" accept=".xlsx, .xls, .csv">
                                    </div>
                                    <div class="col-12 importing-msg d-none">
                                        <span class="text-warning" style="font-size: 11px !important">Importing users. This may take a while. Please keep this page open.</span>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-primary import-btn">Import</button>
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
            $(document).on('click', '.add-user-btn', function () {
                let form = $('#createUserForm')[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "/system-user/create",
                    type: "POST",
                    data: form.serialize(),
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        form[0].reset();
                        $('#createModal').modal('hide');

                        console.log(response);
                        toastr.success('New user added successfully!', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.edit-user-btn', function () {
                let userId = $(this).data('id');
                let form = $('#editUserForm' + userId)[0];
                let formData = new FormData(form);

                $.ajax({
                    url: "/system-user/" + userId + "/edit",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#editModal' + userId).modal('hide');

                        console.log(response);
                        toastr.success('User detail updated successfully!', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.delete-user-btn', function () {
                let userId = $(this).data('id');

                $.ajax({
                    url: "/system-user/" + userId + "/delete",
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#deleteModal' + userId).modal('hide');

                        console.log(response);
                        toastr.success('User has been removed successfully!', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.import-btn', function () {
                let form = $('#importForm')[0];
                let formData = new FormData(form);

                $('.importing-msg').removeClass('d-none');
                $('.import-btn').attr('disabled', true);

                $.ajax({
                    url: "/system-user/import",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        $('#importModal').modal('hide');
                        $('.importing-msg').addClass('d-none');
                        $('.import-btn').attr('disabled', false);

                        console.log(response);
                        toastr.success('System users imported successfully!', '', { timeOut: 8000 });
                        $('#dataTableBuilder').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                        $('.importing-msg').addClass('d-none');
                        $('.import-btn').attr('disabled', false);
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
