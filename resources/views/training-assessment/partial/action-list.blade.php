<div class="d-flex justify-content-center align-items-center gap-1">
    <a href="{{route('training-assessment.pre.show', [$trainingAssessment->form_group_id, $trainingAssessment->user_id])}}" class="btn btn-sm btn-secondary">Pre Form</a>
    <a href="{{route('training-assessment.post.show', [$trainingAssessment->form_group_id, $trainingAssessment->user_id])}}" class="btn btn-sm btn-warning">Post Form</a>
    {{-- <a href="{{route('training-assessment.export', [$trainingAssessment->id])}}" class="btn btn-sm btn-warning">Export</a> --}}
    <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$trainingAssessment->id}}">Delete</a>
</div>

<div class="modal fade" id="deleteModal{{$trainingAssessment->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
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
                <button type="button" class="btn btn-danger delete-btn" data-id="{{ $trainingAssessment->id }}">Delete</button>
            </div>
        </div>
    </div>
</div>