<nav class="navbar navbar-expand-md navbar-light bg-white border-bottom bg-gradient-blue">
    <div class="container-fluid">

        <!-- Left side (empty for now) -->
        <div class="navbar-brand">
            {{-- Add logo or site title here if needed --}}
        </div>

        <!-- Toggle button for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse px-4" id="mainNavbar">

            <!-- Right side: User Dropdown -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    {{-- Bell icon --}}
                    <a class="nav-link position-relative text-white" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell-fill icon-13"></i>

                        {{-- Unread count badge --}}
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>

                    {{-- Dropdown list --}}
                    <ul class="dropdown-menu dropdown-menu-end p-0 shadow border-0"
                        aria-labelledby="notificationDropdown"
                        style="width: 360px; max-height: 400px;">

                        {{-- Header --}}
                        <li class="dropdown-header bg-light fw-bold p-3 border-bottom">Notifications</li>

                        {{-- Notification items --}}
                        @forelse(auth()->user()->notifications->take(10) as $notification)
                            @php
                                $sender = App\Models\User::find($notification->data['sender'] ?? null);
                                if ($sender) {
                                    $profileImage = $sender->profile_photo_path
                                        ? asset('storage/' . $sender->profile_photo_path)
                                        : asset('images/default-profile-photo.png');
                                    $name = $sender->name;
                                } else {
                                    $profileImage = asset('images/default-profile-photo.png');
                                    $name = 'System';
                                }
                            @endphp

                            <li>
                                <a href="{{ route('notifications.read', $notification->id) }}"
                                    class="dropdown-item py-2 px-3 d-flex align-items-start {{ is_null($notification->read_at) ? 'bg-info-subtle' : '' }}"
                                    style="transition: background-color 0.2s;">
                                    {{-- Profile photo --}}
                                    <img src="{{ $profileImage }}" class="rounded-circle flex-shrink-0 me-2" style="width: 42px; height: 42px; object-fit: cover;">

                                    {{-- Notification text --}}
                                    <div class="flex-grow-1 text-wrap" style="min-width: 0;">
                                        <div class="fw-semibold">{{ $notification->data['title'] ?? 'Notification' }}</div>
                                        <small class="text-muted d-block">{{ $notification->data['message'] ?? '' }}</small>
                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li>
                                <div class="dropdown-item text-center text-muted py-4">
                                    No notifications yet
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="me-2">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('settings.profile.edit') }}">
                                <i class="bi bi-key-fill me-2"></i> {{ __('Change Password') }}
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right me-2"></i> {{ __('Log Out') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </div>
</nav>
