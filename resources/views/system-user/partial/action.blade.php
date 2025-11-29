<div class="d-flex justify-content-center gap-1">
    @if (auth()->user()->role == 'Admin')
        <a href="#" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal{{$user->id}}">Edit</a>
        <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$user->id}}">Delete</a>
    @endif
</div>

<div class="modal fade" id="editModal{{$user->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-start">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit System User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm{{$user->id}}" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div class="mb-2 d-flex justify-content-center">
                                        <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('images/default-profile-photo.png') }}" 
                                            alt="Profile Photo" class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                                    </div>
                                    <label for="user_profile_photo_{{ $user->id }}" class="form-label">Profile Photo</label>
                                    <input id="user_profile_photo_{{ $user->id }}" type="file" name="profile_photo" class="form-control" accept="image/*">
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="user_employee_id" class="form-label">Employee ID</label>
                                    <input id="user_employee_id" type="text" name="employee_id" class="form-control"
                                        placeholder="employee ID" value="{{$user->employee_id}}">                        
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="user_name" class="form-label">Name</label>
                                    <input id="user_name" type="text" name="name" class="form-control"
                                        placeholder="Name" value="{{$user->name}}">
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="user_email" class="form-label">Email</label>
                                    <input id="user_email" type="email" name="email" class="form-control"
                                        placeholder="Email" value="{{$user->email}}">
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="user_password" class="form-label">Password</label>
                                    <input id="user_password" type="text" name="password" class="form-control" placeholder="Password">
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="user_role" class="form-label">Role</label>
                                    <select id="user_role" name="role" class="form-select">
                                        <option value="" selected disabled>Please select</option>
                                        <option value="Admin" {{$user->role == 'Admin' ? 'selected' : ''}}>Admin</option>
                                        <option value="Staff" {{$user->role == 'Staff' ? 'selected' : ''}}>Staff</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="user_department" class="form-label">Department</label>
                                    <select id="user_department" name="department" class="form-select">
                                        <option value="" selected disabled>Please select</option>
                                        <option value="Auxiliary Police" {{ $user->department == 'Auxiliary Police' ? 'selected' : '' }}>Auxiliary Police</option>
                                        <option value="Breakbulk & Customer Service" {{ $user->department == 'Breakbulk & Customer Service' ? 'selected' : '' }}>Breakbulk & Customer Service</option>
                                        <option value="Business Development & Commercial" {{ $user->department == 'Business Development & Commercial' ? 'selected' : '' }}>Business Development & Commercial</option>
                                        <option value="Corporate Planning & Strategic Transformation" {{ $user->department == 'Corporate Planning & Strategic Transformation' ? 'selected' : '' }}>Corporate Planning & Strategic Transformation</option>
                                        <option value="Corporate Strategic Planning" {{ $user->department == 'Corporate Strategic Planning' ? 'selected' : '' }}>Corporate Strategic Planning</option>
                                        <option value="Corporate_Services" {{ $user->department == 'Corporate_Services' ? 'selected' : '' }}>Corporate_Services</option>
                                        <option value="Environment, Safety & Health" {{ $user->department == 'Environment, Safety & Health' ? 'selected' : '' }}>Environment, Safety & Health</option>
                                        <option value="Finance" {{ $user->department == 'Finance' ? 'selected' : '' }}>Finance</option>
                                        <option value="Governance , Risk & Compliance" {{ $user->department == 'Governance , Risk & Compliance' ? 'selected' : '' }}>Governance , Risk & Compliance</option>
                                        <option value="Human Resource & Administration" {{ $user->department == 'Human Resource & Administration' ? 'selected' : '' }}>Human Resource & Administration</option>
                                        <option value="IT" {{ $user->department == 'IT' ? 'selected' : '' }}>IT</option>
                                        <option value="Marine & Liquid Operations" {{ $user->department == 'Marine & Liquid Operations' ? 'selected' : '' }}>Marine & Liquid Operations</option>
                                        <option value="Office of Executive Director & Chief Executive" {{ $user->department == 'Office of Executive Director & Chief Executive' ? 'selected' : '' }}>Office of Executive Director & Chief Executive</option>
                                        <option value="Technical Engineering & Facility Management" {{ $user->department == 'Technical Engineering & Facility Management' ? 'selected' : '' }}>Technical Engineering & Facility Management</option>
                                        <option value="Terminal & Free Zone Operation" {{ $user->department == 'Terminal & Free Zone Operation' ? 'selected' : '' }}>Terminal & Free Zone Operation</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="user_designation" class="form-label">Designation</label>
                                    <select id="user_designation" name="designation" class="form-select">
                                        <option value="" selected disabled>Please select</option>
                                        <option value="Assistant Executive" {{ $user->designation == 'Assistant Executive' ? 'selected' : '' }}>Assistant Executive</option>
                                        <option value="Assistant Operation Officer" {{ $user->designation == 'Assistant Operation Officer' ? 'selected' : '' }}>Assistant Operation Officer</option>
                                        <option value="Assistant Superintendent of Police (ASP)" {{ $user->designation == 'Assistant Superintendent of Police (ASP)' ? 'selected' : '' }}>Assistant Superintendent of Police (ASP)</option>
                                        <option value="Associate Executive" {{ $user->designation == 'Associate Executive' ? 'selected' : '' }}>Associate Executive</option>
                                        <option value="Billing Executive" {{ $user->designation == 'Billing Executive' ? 'selected' : '' }}>Billing Executive</option>
                                        <option value="Chief Financial Officer" {{ $user->designation == 'Chief Financial Officer' ? 'selected' : '' }}>Chief Financial Officer</option>
                                        <option value="Deputy General Manager" {{ $user->designation == 'Deputy General Manager' ? 'selected' : '' }}>Deputy General Manager</option>
                                        <option value="Deputy Manager" {{ $user->designation == 'Deputy Manager' ? 'selected' : '' }}>Deputy Manager</option>
                                        <option value="Driver cum Dispatch" {{ $user->designation == 'Driver cum Dispatch' ? 'selected' : '' }}>Driver cum Dispatch</option>
                                        <option value="Executive" {{ $user->designation == 'Executive' ? 'selected' : '' }}>Executive</option>
                                        <option value="Executive Director" {{ $user->designation == 'Executive Director' ? 'selected' : '' }}>Executive Director</option>
                                        <option value="General Manager" {{ $user->designation == 'General Manager' ? 'selected' : '' }}>General Manager</option>
                                        <option value="Handyman" {{ $user->designation == 'Handyman' ? 'selected' : '' }}>Handyman</option>
                                        <option value="Head of Breakbulk & Customer Service" {{ $user->designation == 'Head of Breakbulk & Customer Service' ? 'selected' : '' }}>Head of Breakbulk & Customer Service</option>
                                        <option value="Head of Commercial" {{ $user->designation == 'Head of Commercial' ? 'selected' : '' }}>Head of Commercial</option>
                                        <option value="Konstabel" {{ $user->designation == 'Konstabel' ? 'selected' : '' }}>Konstabel</option>
                                        <option value="Koperal" {{ $user->designation == 'Koperal' ? 'selected' : '' }}>Koperal</option>
                                        <option value="Lans Koperal" {{ $user->designation == 'Lans Koperal' ? 'selected' : '' }}>Lans Koperal</option>
                                        <option value="Manager" {{ $user->designation == 'Manager' ? 'selected' : '' }}>Manager</option>
                                        <option value="Marine Assistant" {{ $user->designation == 'Marine Assistant' ? 'selected' : '' }}>Marine Assistant</option>
                                        <option value="Operation Assistant" {{ $user->designation == 'Operation Assistant' ? 'selected' : '' }}>Operation Assistant</option>
                                        <option value="Operation Officer" {{ $user->designation == 'Operation Officer' ? 'selected' : '' }}>Operation Officer</option>
                                        <option value="Pengawal Keselamatan" {{ $user->designation == 'Pengawal Keselamatan' ? 'selected' : '' }}>Pengawal Keselamatan</option>
                                        <option value="Sarjan" {{ $user->designation == 'Sarjan' ? 'selected' : '' }}>Sarjan</option>
                                        <option value="Sarjan Mejar" {{ $user->designation == 'Sarjan Mejar' ? 'selected' : '' }}>Sarjan Mejar</option>
                                        <option value="Senior Executive" {{ $user->designation == 'Senior Executive' ? 'selected' : '' }}>Senior Executive</option>
                                        <option value="Senior General Manager" {{ $user->designation == 'Senior General Manager' ? 'selected' : '' }}>Senior General Manager</option>
                                        <option value="Senior Manager" {{ $user->designation == 'Senior Manager' ? 'selected' : '' }}>Senior Manager</option>
                                        <option value="Senior Technician" {{ $user->designation == 'Senior Technician' ? 'selected' : '' }}>Senior Technician</option>
                                        <option value="Sub Inspector" {{ $user->designation == 'Sub Inspector' ? 'selected' : '' }}>Sub Inspector</option>
                                        <option value="Supervisor - Firefighting" {{ $user->designation == 'Supervisor - Firefighting' ? 'selected' : '' }}>Supervisor - Firefighting</option>
                                        <option value="Supervisor - HSE" {{ $user->designation == 'Supervisor - HSE' ? 'selected' : '' }}>Supervisor - HSE</option>
                                        <option value="Technician" {{ $user->designation == 'Technician' ? 'selected' : '' }}>Technician</option>
                                        <option value="Warehouse Assistant" {{ $user->designation == 'Warehouse Assistant' ? 'selected' : '' }}>Warehouse Assistant</option>
                                        <option value="Yard/Vessel Planner" {{ $user->designation == 'Yard/Vessel Planner' ? 'selected' : '' }}>Yard/Vessel Planner</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="user_status" class="form-label">Status</label>
                                    <select id="user_status" name="status" class="form-select">
                                        <option value="1" {{$user->status == '1' ? 'selected' : ''}}>Active</option>
                                        <option value="2" {{$user->status == '2' ? 'selected' : ''}}>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-check">
                                        <input type="hidden" name="is_reviewer" class="form-check-input" value="2">
                                        <input id="reviewerCheckChecked" type="checkbox" name="is_reviewer" class="form-check-input" value="1" {{$user->is_reviewer == "1" ? 'checked' : ''}}>
                                        <label class="form-check-label" for="reviewerCheckChecked">Reviewer</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="hidden" name="is_approver" class="form-check-input" value="2">
                                        <input id="approverCheckChecked" type="checkbox" name="is_approver" class="form-check-input" value="1" {{$user->is_approver == "1" ? 'checked' : ''}}>
                                        <label class="form-check-label" for="approverCheckChecked">Approver</label>
                                    </div>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-primary edit-user-btn" data-id="{{ $user->id }}">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal{{$user->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-start">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        Are you sure want to delete this system user?
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger delete-user-btn" data-id="{{ $user->id }}">Delete</button>
            </div>
        </div>
    </div>
</div>