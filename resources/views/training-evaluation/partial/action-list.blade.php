<div class="d-flex justify-content-center gap-1">
    <a href="{{route('training-evaluation.show', [$trainingEvaluation->form_group_id, $trainingEvaluation->user_id])}}" class="btn btn-sm btn-success">View</a>
    <a href="{{route('training-evaluation.export', [$trainingEvaluation->id])}}" class="btn btn-sm btn-warning">Export</a>
    <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$trainingEvaluation->id}}">Delete</a>
</div>

<div class="modal fade" id="deleteModal{{$trainingEvaluation->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-start">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        Are you sure you want to remove this evaluation group? Any forms sent will no longer be accessible to users.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger delete-btn" data-id="{{ $trainingEvaluation->id }}">Delete</button>
            </div>
        </div>
    </div>
</div>