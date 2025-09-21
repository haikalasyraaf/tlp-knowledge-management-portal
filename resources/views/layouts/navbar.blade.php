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
                    <a class="nav-link d-flex align-items-center text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span><i class="bi bi-bell-fill icon-13"></i></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="userDropdown">
                        <li class="p-2">
                            <p class="mb-0" style="font-size: 13px !important">Notifications</p>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="p-2">
                            <p class="mb-0" style="font-size: 13px !important">No new notification at the moment</p>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="me-2">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('settings.profile.edit') }}">
                                <i class="bi bi-person-badge me-2"></i> {{ __('Profile') }}
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
