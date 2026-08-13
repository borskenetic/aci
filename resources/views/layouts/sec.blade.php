<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', '📚 Book Kiosk')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset(config('branding.css_path')) }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/books/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/site-responsive.css') }}">
    @php
        $adminSidebarCssPath = public_path('css/layout/admin-sidebar.css');
        $adminSidebarCssVer = is_file($adminSidebarCssPath) ? filemtime($adminSidebarCssPath) : time();
    @endphp
    <link rel="stylesheet" href="{{ asset('css/layout/admin-sidebar.css') }}?v={{ $adminSidebarCssVer }}">

    @stack('styles')
    @yield('styles')

    <style>
        html, body { height: 100%; }
    </style>
</head>

<body class="admin-shell-body">
    @include('layouts.partials.admin-sidebar')

    <main class="admin-main">
        <div class="admin-sidebar-trigger-bar">
            <button class="admin-sidebar-trigger" id="sidebarCollapseBtn" type="button" aria-label="Toggle sidebar" title="Toggle sidebar">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <path d="M9 3v18"/>
                </svg>
            </button>
        </div>

        <div class="container py-3">
            @yield('content')
        </div>
    </main>

    @yield('footer')

    @stack('scripts')
    @yield('scripts')
</body>
</html>
