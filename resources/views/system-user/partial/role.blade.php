@if ($user->role == 'Admin')
    <span class="badge text-bg-warning">Admin</span>
@else
    <span class="badge text-bg-info">Staff</span>
@endif