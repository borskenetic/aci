<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Agusan Colleges Inc. - Library OPAC')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/aci-home.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/aci-icon.png') }}">
    @stack('styles')
</head>
<body>
    <header class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}#top" class="brand" id="brand-home">
                <img src="{{ asset('img/ACI.png') }}" alt="Agusan Colleges Inc. Logo" class="brand-logo">
            </a>

            <button class="mobile-toggle" id="mobile-toggle" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars"></i>
            </button>

            <nav class="nav-links" id="nav-links">
                <a href="{{ route('home') }}#about" class="nav-link">ABOUT</a>
                <a href="{{ route('landing') }}" class="nav-link {{ request()->routeIs('landing') ? 'active' : '' }}">OPAC</a>
                <a href="https://zendy.io" class="nav-link" target="_blank" rel="noopener noreferrer">ZENDY</a>
                <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">CONTACT US</a>
                <a href="{{ route('rooms.book') }}" class="nav-link {{ request()->routeIs('rooms.book') ? 'active' : '' }}">ROOM RESERVATIONS</a>
                <a href="{{ route('feedback.create') }}" class="nav-link {{ request()->routeIs('feedback.create') ? 'active' : '' }}">FEEDBACK</a>
                <a href="{{ route('login') }}" class="login-btn">LOGIN</a>
            </nav>
        </div>
    </header>

    @yield('content')

    <footer class="site-footer" id="contact">
        <div class="footer-container">
            <div class="footer-logo-wrapper">
                <img src="{{ asset('img/aci.jpg') }}" alt="Agusan Colleges Inc. Emblem" class="footer-logo">
            </div>
            <h2 class="footer-title">AGUSAN COLLEGES INC.</h2>
            <p class="footer-motto">“The Culture of Excellence Lives On”</p>
            <p class="footer-info">
                M.H. del Pilar Street, Butuan City, Philippines
                <span class="divider">|</span>
                <a href="mailto:agusan_colleges@yahoo.com.ph">agusan_colleges@yahoo.com.ph</a>
                <span class="divider">|</span>
                (085) 225-2106
            </p>
            <hr class="footer-line">
            <p class="footer-copyright">Pantas &copy; {{ date('Y') }}. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="{{ asset('js/aci-home.js') }}"></script>
    @stack('scripts')
</body>
</html>
