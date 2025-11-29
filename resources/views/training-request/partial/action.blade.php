@php
    $reviewStatus = $trainingRequest->reviewStatus;
    $approveStatus = $trainingRequest->approveStatus;

    $isReviewer = auth()->user()->is_reviewer == 1;
    $isApprover = auth()->user()->is_approver == 1;
@endphp

<div class="d-flex justify-content-center gap-1">
    <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#statusModal{{$trainingRequest->id}}">Status Overview</a>
    @if (((auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by)) && !$reviewStatus) && !$reviewStatus)
        <a href="#" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal{{$trainingRequest->id}}">Edit</a>
        <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$trainingRequest->id}}">Delete</a>
    @else
        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{$trainingRequest->id}}">View</a>
    @endif
</div>

<div class="modal fade" id="editModal{{$trainingRequest->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-start">
            <div class="modal-header pb-0">
                @if (((auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by)) && !$reviewStatus) && !$reviewStatus)
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Training Request</h1>
                @else
                    <h1 class="modal-title fs-5" id="editModalLabel">View Training Request</h1>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="edit-wrapper">
                    <div class="card" style="box-shadow: none !important">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <a class="w-100 btn btn-primary detail-btn active" href="#">Detail</a>
                                </div>
                                <div class="col-6">
                                    <a class="w-100 btn btn-secondary attachment-btn" href="#">Attachment</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form id="editForm{{$trainingRequest->id}}">
                        <div class="card card-detail" style="box-shadow: none !important">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label for="create_requestor_name{{$trainingRequest->id}}" class="form-label">Requestor Name<span style="color: red"> *</span></label>
                                        <input id="create_requestor_name{{$trainingRequest->id}}" type="text" name="requestor_name" class="form-control" value="{{$trainingRequest->requestor_name}}" placeholder="Requestor Name" 
                                            {{ (auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by)) && !$reviewStatus ? '' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="create_deparment_name{{$trainingRequest->id}}" class="form-label">Department<span style="color: red"> *</span></label>
                                        <select id="create_deparment_name{{$trainingRequest->id}}" name="deparment_name" class="form-select"
                                            {{ (auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by)) && !$reviewStatus ? '' : 'disabled' }}>
                                            <option value="" selected disabled>Please select</option>
                                            <option value="Auxiliary Police" {{ $trainingRequest->deparment_name == 'Auxiliary Police' ? 'selected' : '' }}>Auxiliary Police</option>
                                            <option value="Breakbulk & Customer Service" {{ $trainingRequest->deparment_name == 'Breakbulk & Customer Service' ? 'selected' : '' }}>Breakbulk & Customer Service</option>
                                            <option value="Business Development & Commercial" {{ $trainingRequest->deparment_name == 'Business Development & Commercial' ? 'selected' : '' }}>Business Development & Commercial</option>
                                            <option value="Corporate Planning & Strategic Transformation" {{ $trainingRequest->deparment_name == 'Corporate Planning & Strategic Transformation' ? 'selected' : '' }}>Corporate Planning & Strategic Transformation</option>
                                            <option value="Corporate Strategic Planning" {{ $trainingRequest->deparment_name == 'Corporate Strategic Planning' ? 'selected' : '' }}>Corporate Strategic Planning</option>
                                            <option value="Corporate_Services" {{ $trainingRequest->deparment_name == 'Corporate_Services' ? 'selected' : '' }}>Corporate_Services</option>
                                            <option value="Environment, Safety & Health" {{ $trainingRequest->deparment_name == 'Environment, Safety & Health' ? 'selected' : '' }}>Environment, Safety & Health</option>
                                            <option value="Finance" {{ $trainingRequest->deparment_name == 'Finance' ? 'selected' : '' }}>Finance</option>
                                            <option value="Governance , Risk & Compliance" {{ $trainingRequest->deparment_name == 'Governance , Risk & Compliance' ? 'selected' : '' }}>Governance , Risk & Compliance</option>
                                            <option value="Human Resource & Administration" {{ $trainingRequest->deparment_name == 'Human Resource & Administration' ? 'selected' : '' }}>Human Resource & Administration</option>
                                            <option value="IT" {{ $trainingRequest->deparment_name == 'IT' ? 'selected' : '' }}>IT</option>
                                            <option value="Marine & Liquid Operations" {{ $trainingRequest->deparment_name == 'Marine & Liquid Operations' ? 'selected' : '' }}>Marine & Liquid Operations</option>
                                            <option value="Office of Executive Director & Chief Executive" {{ $trainingRequest->deparment_name == 'Office of Executive Director & Chief Executive' ? 'selected' : '' }}>Office of Executive Director & Chief Executive</option>
                                            <option value="Technical Engineering & Facility Management" {{ $trainingRequest->deparment_name == 'Technical Engineering & Facility Management' ? 'selected' : '' }}>Technical Engineering & Facility Management</option>
                                            <option value="Terminal & Free Zone Operation" {{ $trainingRequest->deparment_name == 'Terminal & Free Zone Operation' ? 'selected' : '' }}>Terminal & Free Zone Operation</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="create_training_title{{$trainingRequest->id}}" class="form-label">Training Title<span style="color: red"> *</span></label>
                                        <input id="create_training_title{{$trainingRequest->id}}" type="text" name="training_title" class="form-control" value="{{$trainingRequest->training_title}}" placeholder="Training Title"
                                            {{ (auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by)) && !$reviewStatus ? '' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="create_training_organiser{{$trainingRequest->id}}" class="form-label">Training Organiser<span style="color: red"> *</span></label>
                                        <input id="create_training_organiser{{$trainingRequest->id}}" type="text" name="training_organiser" class="form-control" value="{{$trainingRequest->training_organiser}}" placeholder="Training Organiser"
                                            {{ (auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by)) && !$reviewStatus ? '' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="create_training_venue{{$trainingRequest->id}}" class="form-label">Training Venue<span style="color: red"> *</span></label>
                                        <input id="create_training_venue{{$trainingRequest->id}}" type="text" name="training_venue" class="form-control" value="{{$trainingRequest->training_venue}}" placeholder="Training Venue"
                                            {{ (auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by)) && !$reviewStatus ? '' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="create_training_cost{{$trainingRequest->id}}" class="form-label">Training Cost<span style="color: red"> *</span></label>
                                        <input id="create_training_cost{{$trainingRequest->id}}" type="text" name="training_cost" class="form-control" value="{{$trainingRequest->training_cost}}" placeholder="Training Cost"
                                            {{ (auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by)) && !$reviewStatus ? '' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="create_training_start_date{{$trainingRequest->id}}" class="form-label">Training Start Date<span style="color: red"> *</span></label>
                                        <input id="create_training_start_date{{$trainingRequest->id}}" type="date" name="training_start_date" class="form-control" value="{{$trainingRequest->training_start_date}}" placeholder="Training Start Date"
                                            {{ (auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by)) && !$reviewStatus ? '' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="create_title{{$trainingRequest->id}}" class="form-label">Training End Date<span style="color: red"> *</span></label>
                                        <input id="create_title{{$trainingRequest->id}}" type="date" name="training_end_date" class="form-control" value="{{$trainingRequest->training_end_date}}" placeholder="Training End Date"
                                            {{ (auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by)) && !$reviewStatus ? '' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="create_employees_recommended{{$trainingRequest->id}}" class="form-label">Employee Recommended<span style="color: red"> *</span></label>
                                        <input id="create_employees_recommended{{$trainingRequest->id}}" type="text" name="employees_recommended" class="form-control" value="{{$trainingRequest->employees_recommended}}" placeholder="Employee Recommended"
                                            {{ (auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by)) && !$reviewStatus ? '' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="create_remarks{{$trainingRequest->id}}" class="form-label">Remark</label>
                                        <input id="create_remarks{{$trainingRequest->id}}" type="text" name="remarks" class="form-control" value="{{$trainingRequest->remarks}}" placeholder="Remark"
                                            {{ (auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by)) && !$reviewStatus ? '' : 'disabled' }}>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label for="create_training_objective{{$trainingRequest->id}}" class="form-label">Training Objective<span style="color: red"> *</span></label>
                                        <textarea id="create_training_objective{{$trainingRequest->id}}" name="training_objective" class="form-control" rows="4"
                                            placeholder="Enter training objective..."
                                            {{ (auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by)) && !$reviewStatus ? '' : 'disabled' }}>{!! $trainingRequest->training_objective !!}</textarea>
                                    </div>

                                    @if ((auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by)) && !$reviewStatus)
                                        <div class="col-12 text-end">
                                            <button type="button" class="btn btn-primary edit-btn" data-id="{{ $trainingRequest->id }}">Save</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>

                    <form id="documentForm{{$trainingRequest->id}}" enctype="multipart/form-data">
                        <div class="card card-attachment mt-3 d-none" style="box-shadow: none !important">
                            <div class="card-body">
                                <div class="row">
                                    @if ((auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by)) && !$reviewStatus)
                                        <div class="col-lg-12 mb-3">
                                            <label for="document_path{{$trainingRequest->id}}" class="form-label">Document</label>
                                            <input id="document_path{{$trainingRequest->id}}" type="file" name="document_path" class="form-control">
                                        </div>
                                        <div class="col-12 mb-3 text-end">
                                            <button type="button" class="btn btn-primary upload-document-btn" data-id="{{ $trainingRequest->id }}">Upload</button>
                                        </div>
                                    @endif

                                    <div class="col-12 mb-2">
                                        List of Attachment(s)
                                    </div>

                                    <div class="attachments-container" id="document-container-{{ $trainingRequest->id }}">
                                        @forelse ($trainingRequest->documents as $document)
                                            <div class="col-12 mb-2" id="document-{{ $document->id }}">
                                                <div class="card">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>{{ $document->document_name }}</div>
                                                            <div>
                                                                <a href="#" class="btn btn-sm btn-info text-white view-doc-btn" data-bs-toggle="modal" data-bs-target="#viewModal{{ $document->id }}" data-file="{{ asset('storage/' . $document->document_path) }}">View</a>
                                                                <a href="{{ asset('storage/'.$document->document_path) }}" class="btn btn-sm btn-primary" class="text-primary" download="{{ Str::slug(pathinfo($document->document_name, PATHINFO_FILENAME)) }}">Download</a>
                                                                @if ((auth()->user()->role == 'Admin' || (auth()->user()->role == 'Staff' && auth()->user()->id == $trainingRequest->created_by)) && !$reviewStatus)
                                                                    <a href="#" class="btn btn-sm btn-danger delete-document-btn" data-training-request-id="{{ $trainingRequest->id }}" data-id="{{ $document->id }}">Delete</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="viewModal{{ $document->id }}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="btn-close" onclick="$('#viewModal{{ $document->id }}').modal('hide');"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            {{-- Default iframe preview --}}
                                                            <iframe id="previewFrame{{ $document->id }}" src="" width="100%" height="600" style="border:none;display:none;"></iframe>

                                                            {{-- Fallback message --}}
                                                            <div id="downloadContainer{{ $document->id }}" style="display:none;">
                                                                <div class="d-flex justify-content-center align-items-center" style="height: 600px">
                                                                    <div>
                                                                        <p>File type not support for preview. You can download the file below:</p>
                                                                        <a id="downloadBtn{{ $document->id }}" href="#" class="btn btn-primary" download>Download File</a>                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12 mb-2" id="empty-document-message">
                                                <div class="card">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            <div class="text-center">No document uploaded</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse
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

<div class="modal fade" id="statusModal{{ $trainingRequest->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-start">

            <div class="modal-header pb-0">
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                {{-- ======================================================
                     REVIEWER SECTION
                ======================================================= --}}
                <div class="card" style="box-shadow: none !important">
                    <div class="card-body">
                        <h5 class="mb-2">First Review</h5>
                        @if(!$reviewStatus && $isReviewer)
                            <form id="reviewerForm{{ $trainingRequest->id }}">
                                <div class="mb-2">
                                    <label class="form-label">Transport To Venue</label>
                                    <select name="transport_to_venue" class="form-select">
                                        <option hidden>Please select</option>
                                        <option value="1">Self Drive</option>
                                        <option value="2">Company Car</option>
                                        <option value="3">Flight</option>
                                        <option value="4">Others</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Approved Training Cost</label>
                                    <input name="approved_training_cost" class="form-control">
                                </div>
                                <div class="mb-2">
                                    <div class="form-check">
                                        <input type="hidden" name="is_accomodation_required" value="2">
                                        <input type="checkbox" class="form-check-input" name="is_accomodation_required" value="1">
                                        <label class="form-check-label">Accommodation Required</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="hidden" name="is_hdrc_claimable" value="2">
                                        <input type="checkbox" class="form-check-input" name="is_hdrc_claimable" value="1">
                                        <label class="form-check-label">HDRC Claimable</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="hidden" name="is_budget_under_atp" value="2">
                                        <input type="checkbox" class="form-check-input" name="is_budget_under_atp" value="1">
                                        <label class="form-check-label">Annual Training Plan Budgeted</label>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Remarks</label>
                                    <textarea name="remarks" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="text-end">
                                    <button type="button" class="btn btn-primary btn-sm reviewer-submit-btn" data-id="{{ $trainingRequest->id }}">
                                        Submit to Approver
                                    </button>
                                </div>
                            </form>
                        @elseif($reviewStatus)
                            <div class="p-2 border rounded bg-light">
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <th style="width: 25%">Transport To Venue</th>
                                        <td style="border-bottom: none !important; padding: 8px !important; width: 1%;">:</td>
                                        <td style="border-bottom: none !important; padding: 8px !important;">{{ $reviewStatus->transport_to_venue_text }}</td>
                                    </tr>
                                    <tr>
                                        <th>Approved Cost</th>
                                        <td style="border-bottom: none !important; padding: 8px !important;">:</td>
                                        <td style="border-bottom: none !important; padding: 8px !important;">RM {{ number_format($reviewStatus->approved_training_cost, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Accommodation</th>
                                        <td style="border-bottom: none !important; padding: 8px !important;">:</td>
                                        <td style="border-bottom: none !important; padding: 8px !important;">{{ $reviewStatus->is_accomodation_required == 1 ? 'Yes' : 'No' }}</td>
                                    </tr>
                                    <tr>
                                        <th>HDRC Claimable</th>
                                        <td style="border-bottom: none !important; padding: 8px !important;">:</td>
                                        <td style="border-bottom: none !important; padding: 8px !important;">{{ $reviewStatus->is_hdrc_claimable == 1 ? 'Yes' : 'No' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Budget Under ATP</th>
                                        <td style="border-bottom: none !important; padding: 8px !important;">:</td>
                                        <td style="border-bottom: none !important; padding: 8px !important;">{{ $reviewStatus->is_budget_under_atp == 1 ? 'Yes' : 'No' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Remarks</th>
                                        <td style="border-bottom: none !important; padding: 8px !important;">:</td>
                                        <td style="border-bottom: none !important; padding: 8px !important;">{!! nl2br($reviewStatus->remarks) !!}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="text-end">
                                <small style="font-style: italic">Reviewed by {{ $reviewStatus->reviewBy->name }} on {{$reviewStatus->created_at->format('d/m/Y H:i:s')}}</small>
                            </div>
                        @else
                            <div class="p-2 border rounded bg-light">
                                Pending Review
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ======================================================
                     APPROVER SECTION (only show if reviewer exists)
                ======================================================= --}}
                @if($reviewStatus)
                    <div class="card" style="box-shadow: none !important">
                        <div class="card-body">
                            <h5 class="mb-2">Second Review</h5>
                            @if(!$approveStatus && $isApprover)
                                <form id="approverForm{{ $trainingRequest->id }}">
                                    <div class="mb-2">
                                        <label class="form-label">Decision</label>
                                        <select name="approval_decision" class="form-select">
                                            <option hidden>Please select</option>
                                            <option value="1">Approved</option>
                                            <option value="2">Rejected</option>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Remarks</label>
                                        <textarea name="remarks" class="form-control" rows="3"></textarea>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-primary btn-sm approver-submit-btn" data-id="{{ $trainingRequest->id }}">
                                            Save
                                        </button>
                                    </div>
                                </form>
                            @elseif($approveStatus)
                                <div class="p-2 border rounded bg-light">
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <th style="width: 25%">Decision</th>
                                            <td style="border-bottom: none !important; padding: 8px !important; width: 1%;">:</td>
                                            <td style="border-bottom: none !important; padding: 8px !important;">{{ $approveStatus->approval_decision == 1 ? 'Approved' : 'Rejected' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Remarks</th>
                                            <td style="border-bottom: none !important; padding: 8px !important;">:</td>
                                            <td style="border-bottom: none !important; padding: 8px !important;">{!! nl2br($approveStatus->remarks) !!}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="text-end">
                                    <small style="font-style: italic">Reviewed by {{ $approveStatus->reviewBy->name }} on {{$approveStatus->created_at->format('d/m/Y H:i:s')}}</small>
                                </div>
                            @else
                                <div class="p-2 border rounded bg-light">
                                    Pending Review
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal{{$trainingRequest->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-start">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        Are you sure want to delete this training request? This action cannot be undone
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger delete-btn" data-id="{{ $trainingRequest->id }}">Delete</button>
            </div>
        </div>
    </div>
</div>