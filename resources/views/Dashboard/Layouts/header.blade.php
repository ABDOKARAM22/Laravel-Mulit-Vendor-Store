@php
    $admin = auth('admin')->user();
@endphp

<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- Sidebar Toggle -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link"
               data-widget="pushmenu"
               href="#"
               role="button"
               aria-label="Toggle sidebar">
                <i class="fas fa-bars"></i>
            </a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard.index') }}" class="nav-link">
                Dashboard
            </a>
        </li>
    </ul>

    <!-- Right Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Notifications -->
        <x-dashboard.notifications-menu />

        <!-- Admin Profile -->
        <li class="nav-item dropdown">
            <a class="nav-link"
               data-toggle="dropdown"
               href="#"
               aria-label="Admin menu">

                <i class="fas fa-user-circle mr-1"></i>

                <span class="d-none d-md-inline">
                    {{ $admin->name }}
                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-right">

                <div class="dropdown-header text-left">
                    <strong>{{ $admin->name }}</strong>

                    <small class="d-block text-muted">
                        {{ $admin->role }}
                    </small>
                </div>

                <div class="dropdown-divider"></div>

                <a href="{{ route('dashboard.profile.edit') }}"
                   class="dropdown-item">
                    <i class="fas fa-user-edit mr-2"></i>
                    Profile
                </a>

                <div class="dropdown-divider"></div>

                <form action="{{ route('dashboard.logout') }}"
                      method="POST">
                    @csrf

                    <button type="submit"
                            class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </button>
                </form>

            </div>
        </li>

    </ul>

</nav>