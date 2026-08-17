@extends('layouts.aci-public')

@section('title', 'Agusan Colleges Inc. - Library OPAC')

@section('content')
<main class="hero-section">
    <div class="hero-container">

        <div class="hero-logo-wrapper">
            <img src="{{ asset('img/aci.jpg') }}" alt="Agusan Colleges Emblem" class="hero-logo">
        </div>

        <div class="search-card" id="opac">
            <span class="search-subtitle">ONLINE PUBLIC ACCESS CATALOG</span>
            <h1 class="search-title">Search the ACI Library Collection</h1>
            <p class="search-description">Find books by title, author, subject, ISBN, or keyword</p>

            <form class="search-form" id="opac-search-form" method="GET" action="{{ route('landing') }}">
                <div class="search-input-wrapper">
                    <i class="fa-solid fa-magnifying-glass search-icon"></i>
                    <input
                        type="text"
                        id="search-input"
                        name="search"
                        placeholder="Search..."
                        autocomplete="off"
                        value="{{ request('search') }}"
                    >
                    <button type="button" class="clear-btn" id="clear-btn" aria-label="Clear search">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                    <button type="submit" class="search-btn">Search OPAC</button>
                </div>
            </form>
        </div>

        <br>

        <section class="video-tutorial-section" id="zendy">
            <h2 class="video-section-title" hidden>Video Tutorials</h2>
            <div class="video-container">
                <video controls playsinline muted class="showcase-video" id="tutorial-video">
                    <source src="{{ asset('img/howToRegister-zendy.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </section>

        <br>

        <section class="programs-section scroll-reveal" id="programs">
            <h2 class="programs-title">PROGRAMS OFFERED</h2>

            <div class="programs-grid">
                <div class="program-card">
                    <div class="program-image-wrapper">
                        <img src="{{ asset('img/BSIT.jpg') }}" alt="BSIT Program" class="program-img">
                    </div>
                    <h3 class="program-name">BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY</h3>
                    <button class="program-arrow-btn" hidden aria-label="View BSIT Details">
                        <i class="fa-regular fa-circle-down"></i>
                    </button>
                </div>

                <div class="program-card">
                    <div class="program-image-wrapper">
                        <img src="{{ asset('img/BSBA.jpg') }}" alt="BSBA Program" class="program-img">
                    </div>
                    <h3 class="program-name">BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION MAJOR IN MARKETING MANAGEMENT</h3>
                    <button class="program-arrow-btn" hidden aria-label="View BSBA Details">
                        <i class="fa-regular fa-circle-down"></i>
                    </button>
                </div>

                <div class="program-card">
                    <div class="program-image-wrapper">
                        <img src="{{ asset('img/BSED.jpg') }}" alt="BSED Program" class="program-img">
                    </div>
                    <h3 class="program-name">BACHELOR OF SECONDARY EDUCATION (English / Filipino)</h3>
                    <button class="program-arrow-btn" hidden aria-label="View BSED Details">
                        <i class="fa-regular fa-circle-down"></i>
                    </button>
                </div>

                <div class="program-card">
                    <div class="program-image-wrapper">
                        <img src="{{ asset('img/BEE.jpg') }}" alt="BEEd Program" class="program-img">
                    </div>
                    <h3 class="program-name">BACHELOR OF ELEMENTARY EDUCATION</h3>
                    <button class="program-arrow-btn" hidden aria-label="View BEEd Details">
                        <i class="fa-regular fa-circle-down"></i>
                    </button>
                </div>

                <div class="program-card">
                    <div class="program-image-wrapper">
                        <img src="{{ asset('img/BSA.jpg') }}" alt="BSA Program" class="program-img">
                    </div>
                    <h3 class="program-name">BACHELOR OF SCIENCE IN ACCOUNTING INFORMATION SYSTEM</h3>
                    <button class="program-arrow-btn" hidden aria-label="View BSA Details">
                        <i class="fa-regular fa-circle-down"></i>
                    </button>
                </div>

                <div class="program-card">
                    <div class="program-image-wrapper">
                        <img src="{{ asset('img/GRAD.jpg') }}" alt="Graduate Programs" class="program-img">
                    </div>
                    <h3 class="program-name">GRADUATE PROGRAMS AND K-12 PROGRAMS</h3>
                    <button class="program-arrow-btn" hidden aria-label="View Graduate Program Details">
                        <i class="fa-regular fa-circle-down"></i>
                    </button>
                </div>
            </div>
        </section>

        <br>

        <section class="vm-section scroll-reveal" id="about">
            <div class="vm-grid">
                <div class="vm-card">
                    <h2>VISION</h2>
                    <p>A leading academic institution offering quality affordable education producing graduates who will become contributing and responsive members of the global community.</p>
                </div>

                <div class="vm-card">
                    <h2>MISSION</h2>
                    <p>To provide a high quality, comprehensive, and meaningful education for all students so that they become productive citizens empowered with knowledge and skills and untainted personal attributes.</p>
                </div>
            </div>

            <div class="vm-goals-card">
                <h2>GOALS</h2>
                <p class="goals-intro">As envisioned by the Founder, ACI's goals are based not only on a liberal learning education which encourages the molding and growth of productive professionals but also on the provision of opportunities:</p>
                <ol class="goals-list">
                    <li>To enable students to acquire a body of knowledge in a specific discipline.</li>
                    <li>To think critically.</li>
                    <li>To enhance student abilities to make significant contributions to the communities where they live.</li>
                    <li>To provide the pathway for students to continue the pursuit of life-long learning.</li>
                </ol>
            </div>
        </section>

    </div>
</main>
@endsection
