@php
    $admin = auth('admin')->user();

    $canManageCategories =
        $admin->isAdmin() ||
        $admin->isSuperAdmin();

    $canViewProducts =
        $admin->can('viewAny', \App\Models\Product::class);

    $canCreateProducts =
        $admin->can('create', \App\Models\Product::class);
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand -->
    <a href="{{ route('dashboard.index') }}"
       class="brand-link">

        <span class="brand-text font-weight-light">
            Multi Vendor Store
        </span>

    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Admin Profile -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

            <div class="image">
                <div class="img-circle elevation-2 d-flex align-items-center justify-content-center bg-secondary"
                     style="width: 34px; height: 34px;">

                    <i class="fas fa-user text-white"></i>

                </div>
            </div>

            <div class="info">
                <a href="{{ route('dashboard.profile.edit') }}"
                   class="d-block">

                    {{ $admin->name }}

                </a>

                <small class="text-muted">
                    {{ $admin->role }}
                </small>
            </div>

        </div>

        <!-- Navigation -->
        <nav class="mt-2">

            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">

                    <a href="{{ route('dashboard.index') }}"
                       class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">

                        <i class="nav-icon fas fa-tachometer-alt"></i>

                        <p>
                            Dashboard
                        </p>

                    </a>

                </li>

                <!-- Products -->
                @if ($canViewProducts)

                    <li class="nav-item {{ request()->routeIs('dashboard.products.*') ? 'menu-open' : '' }}">

                        <a href="#"
                           class="nav-link {{ request()->routeIs('dashboard.products.*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-box"></i>

                            <p>
                                Products
                                <i class="right fas fa-angle-left"></i>
                            </p>

                        </a>

                        <ul class="nav nav-treeview">

                            <!-- All Products -->
                            <li class="nav-item">

                                <a href="{{ route('dashboard.products.index') }}"
                                   class="nav-link {{ request()->routeIs('dashboard.products.index') ? 'active' : '' }}">

                                    <i class="far fa-circle nav-icon"></i>

                                    <p>
                                        All Products
                                    </p>

                                </a>

                            </li>

                            <!-- Add Product -->
                            @if ($canCreateProducts)

                                <li class="nav-item">

                                    <a href="{{ route('dashboard.products.create') }}"
                                       class="nav-link {{ request()->routeIs('dashboard.products.create') ? 'active' : '' }}">

                                        <i class="far fa-circle nav-icon"></i>

                                        <p>
                                            Add Product
                                        </p>

                                    </a>

                                </li>

                            @endif

                            <!-- Trashed Products -->
                            <li class="nav-item">

                                <a href="{{ route('dashboard.products.trash') }}"
                                   class="nav-link {{ request()->routeIs('dashboard.products.trash') ? 'active' : '' }}">

                                    <i class="far fa-circle nav-icon"></i>

                                    <p>
                                        Trash
                                    </p>

                                </a>

                            </li>

                        </ul>

                    </li>

                @endif

                <!-- Categories -->
                @if ($canManageCategories)

                    <li class="nav-item {{ request()->routeIs('dashboard.categories.*') ? 'menu-open' : '' }}">

                        <a href="#"
                           class="nav-link {{ request()->routeIs('dashboard.categories.*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-tags"></i>

                            <p>
                                Categories
                                <i class="right fas fa-angle-left"></i>
                            </p>

                        </a>

                        <ul class="nav nav-treeview">

                            <!-- All Categories -->
                            <li class="nav-item">

                                <a href="{{ route('dashboard.categories.index') }}"
                                   class="nav-link {{ request()->routeIs('dashboard.categories.index') ? 'active' : '' }}">

                                    <i class="far fa-circle nav-icon"></i>

                                    <p>
                                        All Categories
                                    </p>

                                </a>

                            </li>

                            <!-- Add Category -->
                            <li class="nav-item">

                                <a href="{{ route('dashboard.categories.create') }}"
                                   class="nav-link {{ request()->routeIs('dashboard.categories.create') ? 'active' : '' }}">

                                    <i class="far fa-circle nav-icon"></i>

                                    <p>
                                        Add Category
                                    </p>

                                </a>

                            </li>

                            <!-- Trashed Categories -->
                            <li class="nav-item">

                                <a href="{{ route('dashboard.categories.trash') }}"
                                   class="nav-link {{ request()->routeIs('dashboard.categories.trash') ? 'active' : '' }}">

                                    <i class="far fa-circle nav-icon"></i>

                                    <p>
                                        Trash
                                    </p>

                                </a>

                            </li>

                        </ul>

                    </li>

                @endif

                <!-- Orders -->
                <li class="nav-item">

                    <a href="{{ route('dashboard.orders.index') }}"
                       class="nav-link {{ request()->routeIs('dashboard.orders.*') ? 'active' : '' }}">

                        <i class="nav-icon fas fa-shopping-cart"></i>

                        <p>
                            Orders
                        </p>

                    </a>

                </li>

                <!-- Profile -->
                <li class="nav-item">

                    <a href="{{ route('dashboard.profile.edit') }}"
                       class="nav-link {{ request()->routeIs('dashboard.profile.*') ? 'active' : '' }}">

                        <i class="nav-icon fas fa-user"></i>

                        <p>
                            Profile
                        </p>

                    </a>

                </li>

            </ul>

        </nav>

    </div>

</aside>