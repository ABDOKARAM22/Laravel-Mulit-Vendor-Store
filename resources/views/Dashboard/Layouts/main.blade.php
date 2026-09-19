<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('page_title', 'Dashboard') | Multi Vendor Store
    </title>

    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        @include('Dashboard.Layouts.header')

        @include('Dashboard.Layouts.sidebar')

        <div class="content-wrapper">

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h1 class="m-0">
                                @yield('page_title', 'Dashboard')
                            </h1>
                        </div>

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard.index') }}">
                                        Dashboard
                                    </a>
                                </li>

                                @hasSection('breadcrumb')
                                    <li class="breadcrumb-item active">
                                        @yield('breadcrumb')
                                    </li>
                                @else
                                    <li class="breadcrumb-item active">
                                        @yield('page_title', 'Dashboard')
                                    </li>
                                @endif
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}

                            <button type="button"
                                    class="close"
                                    data-dismiss="alert"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ session('error') }}

                            <button type="button"
                                    class="close"
                                    data-dismiss="alert"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @yield('content')

                </div>
            </section>

        </div>

        @include('Dashboard.Layouts.footer')

    </div>

    @stack('scripts')

</body>

</html>