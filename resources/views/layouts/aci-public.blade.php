<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Agusan Colleges Inc')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/aci-home.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/aci-icon.png') }}">
</head>
<body>
    <nav class="navbar-container" id="home">
        <div class="logo-section">
            <a href="{{ route('home') }}" class="logo-link">
                <img src="{{ asset('img/aci-logo.png') }}" alt="Agusan Colleges Logo" class="nav-logo">
                <div class="brand-text">
                    <h1 class="brand-main" hidden>AGUSAN</h1>
                    <h1 class="brand-sub" hidden>COLLEGES INC</h1>
                </div>
            </a>
        </div>

        <div class="nav-menu">
            <button type="button" class="nav-toggle" id="navToggle" aria-expanded="false" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <div class="nav-links">
                <a href="{{ route('home') }}" class="nav-link">HOME</a>
                <a href="{{ route('landing') }}" class="nav-link">OPAC</a>
                <a href="{{ route('contact') }}" class="nav-link">CONTACT US</a>
                <a href="{{ route('rooms.book') }}" class="nav-link">ROOM RESERVATIONS</a>
            </div>
            <a href="{{ route('login') }}" class="login-pill">LOGIN</a>
        </div>
    </nav>

    @yield('content')

    <footer class="main-footer" id="contact">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="{{ asset('img/aci-logo.png') }}" alt="Agusan Colleges Inc. Logo">
                <div class="footer-title" hidden>
                    <h2>AGUSAN</h2>
                    <h3>COLLEGES INC.</h3>
                </div>
            </div>

            <div class="footer-contact">
                <p>M.H. del Pilar Street, Butuan City, Philippines | agusan_colleges@yahoo.com.ph</p>
                <p>0916 915 2801 | (085) 225-2106</p>
            </div>

            <div class="footer-bottom">
                <p>Pantas &copy; {{ date('Y') }}. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/aci-home.js') }}"></script>
    @stack('scripts')
</body>
</html>
