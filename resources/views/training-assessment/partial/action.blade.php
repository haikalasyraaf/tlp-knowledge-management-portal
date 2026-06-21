<div class="d-flex justify-content-center align-items-center gap-1">
    @if (auth()->user()->role == 'Staff' || (auth()->user()->role == 'Admin' && $trainingAssessmentGroup->forms->where('user_id', auth()->id())->first()))
        <a href="{{route('training-assessment.pre.show', [$trainingAssessmentGroup->id, auth()->user()->id])}}" class="btn btn-sm btn-secondary">Pre Form</a>
        <a href="{{route('training-assessment.post.show', [$trainingAssessmentGroup->id, auth()->user()->id])}}" class="btn btn-sm btn-warning">Post Form</a>
    @endif
    @if (auth()->user()->role == 'Admin')
        <a href="{{route('training-assessment.list', [$trainingAssessmentGroup->id])}}" class="btn btn-sm btn-primary">View</a>
        <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$trainingAssessmentGroup->id}}">Delete</a>
    @endif
</div>

<div class="modal fade" id="deleteModal{{$trainingAssessmentGroup->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-start">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        Are you sure you want to remove this assessment group? Any forms sent will no longer be accessible to users.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger delete-btn" data-id="{{ $trainingAssessmentGroup->id }}">Delete</button>
            </div>
        </div>
    </div>
</div>