<div class="bg-white border-end vh-100 py-3">
    <div class="d-flex justify-content-center">
        <a href="/">
            <img src="{{ asset(\App\Models\Setting::get('app_logo', 'images/default-logo.png')) }}" style="height: 80px; width: 80px;">
        </a>
    </div>
    <h5 class="text-center">{{ \App\Models\Setting::get('app_name', 'Learning Portal') }}</h5>
    <br>
    <ul class="nav flex-column">

        <li class="nav-item">
            <a class="nav-link w-100 {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2 sidebar-icon-md"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link w-100 {{ request()->routeIs('training-program.index') || request()->routeIs('sub-training-program.index') ? 'active' : '' }}" href="{{ route('training-program.index') }}">
                <i class="bi bi-journal-text sidebar-icon-md"></i> Training Program
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link w-100 {{ request()->routeIs('training-calendar.monthly.index') || request()->routeIs('training-calendar.monthly.list') || request()->routeIs('training-calendar.yearly.index') || request()->routeIs('training-calendar.yearly.list') ? 'active' : '' }}" href="{{ route('training-calendar.monthly.index') }}">
                <i class="bi bi-calendar-event sidebar-icon-md"></i> Training Calendar
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link w-100 {{ request()->routeIs('training-policy.index') ? 'active' : '' }}" href="{{ route('training-policy.index') }}">
                <i class="bi bi-file-earmark-text sidebar-icon-md"></i> Training Policy & Guideline
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link w-100 {{ request()->routeIs('training-form.index') ? 'active' : '' }}" href="{{ route('training-form.index') }}">
                <i class="bi bi-ui-checks sidebar-icon-md"></i> Training Form
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link w-100 {{ request()->routeIs('transfer-of-knowledge.index') ? 'active' : '' }}" href="{{ route('transfer-of-knowledge.index') }}">
                <i class="bi bi-arrow-left-right sidebar-icon-md"></i> Transfer of Knowledge
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link w-100 {{ request()->routeIs('training-needs.program.index') || request()->routeIs('training-needs.competency.index') || request()->routeIs('training-needs.course.index') ? 'active' : '' }}" href="{{ route('training-needs.program.index') }}">
                <i class="bi bi-search sidebar-icon-md"></i> Training Needs Identification
            </a>
        </li>

        @if (auth()->user()->role == 'Admin')
            <li class="nav-item">
                <a class="nav-link w-100 {{ request()->routeIs('internal-bulletin.index') ? 'active' : '' }}" href="{{ route('internal-bulletin.index') }}">
                    <i class="bi bi-newspaper sidebar-icon-md"></i> Internal Bulletin
                </a>
            </li>
        @endif

        @if (auth()->user()->role == 'Admin')
            <li class="nav-item">
                <a class="nav-link w-100 {{ request()->routeIs('system-user.index') ? 'active' : '' }}" href="{{ route('system-user.index') }}">
                    <i class="bi bi-people sidebar-icon-md"></i> System Users
                </a>
            </li>            
        @endif

        <!-- Collapsible submenu -->
        @php
            $settingsActive = request()->routeIs('settings.*');
        @endphp
        <li class="nav-item">
            <a class="nav-link w-100 d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#settingsSubmenu" role="button" aria-expanded="{{ $settingsActive ? 'true' : 'false' }}" aria-controls="settingsSubmenu">
                <span><i class="bi bi-gear sidebar-icon-md"></i> Settings</span>
                <i class="bi bi-chevron-right toggle-icon"></i>
            </a>
            <div class="collapse {{ $settingsActive ? 'show' : '' }}" id="settingsSubmenu">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
                    @if (auth()->user()->role == 'Admin')
                        <li>
                            <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.index') ? 'active' : '' }}" style="padding: 12px 14px 12px 40px !important;">
                                System
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('settings.login-image.index') }}" class="nav-link {{ request()->routeIs('settings.login-image.index') ? 'active' : '' }}" style="padding: 12px 14px 12px 40px !important;">
                                Login Image
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </li>

    </ul>
</div>
