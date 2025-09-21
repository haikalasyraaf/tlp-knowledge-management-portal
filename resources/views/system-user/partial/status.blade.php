@if ($user->status == 1)
    <span class="badge text-bg-success">Active</span>
@else
    <span class="badge text-bg-danger">Inactive</span>
@endif