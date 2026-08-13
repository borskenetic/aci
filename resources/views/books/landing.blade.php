<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Library catalog — OPAC</title>
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/books/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('css/site-responsive.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/qz-tray/qz-tray.js"></script>
</head>

<body class="opac-body">
    <header class="opac-public-header opac-header-bar">
        <div class="logo opac-logo-wrap">
            <a href="{{ route('landing') }}" class="text-decoration-none text-dark d-inline-flex align-items-center">
                <img src="{{ asset('images/pantasLogo.png') }}" alt="Library Logo">
            </a>
        </div>
        <nav class="opac-top-nav" aria-label="Quick links">
            <a href="{{ route('home') }}" class="opac-nav-link">Home</a>
            <a href="{{ route('kiosk.scan') }}" class="opac-nav-link">Student lookup</a>
            <a href="{{ route('landing') }}" class="opac-nav-link fw-semibold">Catalog</a>
        </nav>
        <form action="{{ route('logout') }}" method="POST" class="mb-0" hidden>
            @csrf
            <button type="submit" class="logout-btn" onclick="logout()" style="margin-right: 60px;">Logout</button>
        </form>
    </header>

    <div class="opac-page-fill flex-grow-1">
    <section class="hero-text">
        <img src="{{ asset('images/Bannernew.jpg') }}" alt="Banner" class="banner-img">
    </section>

    <section class="opac-new-arrivals-block px-3 pb-2">
        <h1 id="nab" class="opac-new-arrivals-title text-center my-3">New arrival books</h1>

        <div class="carousel">
            <div class="carousel-container">
                <div class="arrow left" onclick="slide(-1)" role="button" tabindex="0" aria-label="Previous"
                    onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();slide(-1);}">
                    <svg viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M12.5 3L5 10l7.5 7" stroke="#5b5e64" stroke-width="2.5" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>

                <div class="carousel-track" id="carouselTrack">
                    @foreach ($carouselBooks as $book)
                    @php
                        $cMeta = $carouselMeta[$book->id] ?? ['copies' => 1, 'is_available' => $book->availability === 'Available'];
                        $cAvail = ($cMeta['is_available'] ?? false) ? 'Available' : 'Not Available';
                    @endphp
                    <div class="carosel"
                        data-img="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/defaultBook.png') }}"
                        data-title="{{ $book->title_statement }}"
                        data-author="{{ $book->main_author }}"
                        data-note="{{ $book->general_note }}"
                        data-call="{{ $book->call_number }}"
                        data-id="{{ $book->id }}"
                        data-year="{{ $book->pub_year }}"
                        data-availability="{{ $cAvail }}"
                        data-copies="{{ $cMeta['copies'] }}"
                        data-content="{{ $book->content_type }}"
                        data-fixed="{{ $book->fixed_length_data }}"
                        data-library="{{ $book->library_name }}"
                        data-course="{{ $book->course ?? '' }}"
                        onclick="openBookCard(this)">

                        <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/defaultBook.png') }}"
                            alt="{{ $book->title_statement }}">
                        <p>{{ $book->title_statement }}</p>
                    </div>
                    @endforeach
                </div>

                <div class="arrow right" onclick="slide(1)" role="button" tabindex="0" aria-label="Next"
                    onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();slide(1);}">
                    <svg viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M7.5 3L15 10l-7.5 7" stroke="#5b5e64" stroke-width="2.5" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <section class="opac-search-block px-3 px-md-4 py-4" aria-labelledby="opac-search-heading">
        <h2 id="opac-search-heading" class="h5 text-center mb-3">Search the catalog</h2>
        <form method="GET" action="{{ route('landing') }}" class="opac-search-form mx-auto">
            <div class="input-group input-group-lg mb-2">
                <input id="searchBar" type="search" name="search" value="{{ request('search') }}"
                    class="form-control"
                    placeholder="Title, author, or keywords…"
                    autocomplete="off"
                    aria-label="Search catalog">
                <button type="submit" id="search" class="btn btn-success">Search</button>
            </div>

            @if($searchActive)
                <input type="hidden" name="course" value="{{ request('course', 'all') }}">
                <div class="d-flex flex-wrap gap-2 justify-content-center align-items-center lahi opac-refine-filters">
                    <select name="content_type" class="form-select form-select-sm opac-refine-select" onchange="this.form.submit()" aria-label="Resource type">
                        <option value="All" selected>All resources</option>
                        @foreach ($content_type as $ct)
                        <option value="{{ $ct }}" {{ request('content_type') == $ct ? 'selected' : '' }}>
                            {{ $ct }}
                        </option>
                        @endforeach
                    </select>

                    <select name="section" class="form-select form-select-sm opac-refine-select" onchange="this.form.submit()" aria-label="Section">
                        <option selected value="All">All sections</option>
                        @foreach ($sections as $section)
                        <option value="{{ $section }}" {{ request('section') == $section ? 'selected' : '' }}>
                            {{ $section }}
                        </option>
                        @endforeach
                    </select>

                    <select name="subject_topic" class="form-select form-select-sm opac-refine-select" onchange="this.form.submit()" aria-label="Subject topic">
                        <option value="All" selected>All subject topics</option>
                        @foreach ($subjectTopics as $topic)
                        <option value="{{ $topic }}" {{ request('subject_topic') == $topic ? 'selected' : '' }}>
                            {{ \Illuminate\Support\Str::limit($topic, 25, '...') }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <p class="text-center small mt-2 mb-0">
                    <a href="{{ route('landing') }}">Clear search</a> and show new arrivals only.
                </p>
            @endif
        </form>

        @unless($searchActive)
            <p class="text-center text-muted small mt-3 mb-0 mx-auto opac-search-hint">
                Catalog results and filters appear after you search. New arrivals are above.
            </p>
        @endunless
    </section>

    @if($searchActive)
    <div class="layout opac-results-layout">
        <aside class="sidebar">
            <h3>Courses</h3>

            <div class="courses-list">
                <a href="{{ route('landing', array_merge(request()->except('page'), ['course' => 'all'])) }}" class="{{ request('course', 'all') === 'all' ? 'active' : '' }}">
                    View all
                </a>

                @foreach ($courses as $course)
                <a href="{{ route('landing', array_merge(request()->except('page'), ['course' => $course])) }}" class="{{ request('course') === $course ? 'active' : '' }}">
                    {{ $course }}
                </a>
                @endforeach
            </div>

            <button id="search" type="button" onclick="goToEBookPage()">E-Books</button>
        </aside>

        <main class="main-content">
            <p class="small text-muted mb-2">Showing grouped titles for your search. Tap a card for details.</p>

            @if($books->total() === 0)
                <p class="text-center text-muted py-5">No titles matched your search. Try different keywords.</p>
            @endif

            <div class="book-grid" id="bookGrid">
                @foreach ($books as $book)
                <div class="book-card"
                    data-img="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/defaultBook.png') }}"
                    data-title="{{ $book->title_statement }}"
                    data-author="{{ $book->main_author }}"
                    data-note="{{ $book->general_note }}"
                    data-call="{{ $book->call_number }}"
                    data-id="{{ $book->id }}"
                    data-year="{{ $book->pub_year }}"
                    data-copies="{{ $book->copies }}"
                    data-availability="{{ $book->is_available == 1 ? 'Available' : 'Not Available' }}"
                    data-content="{{ $book->content_type }}"
                    data-fixed="{{ $book->fixed_length_data }}"
                    data-library="{{ $book->library_name }}"
                    data-course="{{ $book->course ?? '' }}"
                    onclick="openBookCard(this)">

                    <p class="{{ $book->is_available == 1 ? 'text-success' : 'text-danger' }}">
                        {{ $book->is_available == 1 ? 'Available' : 'Not Available' }}
                    </p>

                    <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/defaultBook.png') }}" alt="">

                    <p>{{ $book->title_statement }}</p>
                    <small>{{ $book->copies }} copies</small>
                </div>
                @endforeach
            </div>

            @if($books->total() > 0)
            <div class="d-flex justify-content-center mt-4">
                {{ $books->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </main>
    </div>
    @endif

    <div class="modal" id="bookModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal-content modal-wide opac-record-modal">
            <span class="close" onclick="closeModal()" aria-label="Close">&times;</span>

            <div id="opacDetailLoading" class="opac-detail-loading py-5 text-center text-muted">Loading record…</div>

            <div id="opacDetailContent" class="opac-detail-content" style="display: none;">
                <p id="opacBreadcrumb" class="opac-breadcrumb small mb-2" aria-label="Context"></p>

                <div class="opac-detail-body modal-body-flex">
                    <div class="modal-left opac-detail-cover-col">
                        <img id="modalImg" src="" alt="Book cover">
                    </div>
                    <div class="modal-right opac-detail-main">
                        <h2 id="modalTitle" class="h4 mb-1"></h2>
                        <p id="modalAuthor" class="text-muted mb-3"></p>
                        <table class="table table-sm table-borderless opac-bib-table mb-0">
                            <tbody id="opacBibSummary"></tbody>
                        </table>
                    </div>
                </div>

                <div class="opac-tabs" role="tablist">
                    <button type="button" class="opac-tab is-active" data-tab="holdings" role="tab" aria-selected="true">Holdings</button>
                    <button type="button" class="opac-tab" data-tab="description" role="tab" aria-selected="false">Description</button>
                    <button type="button" class="opac-tab" data-tab="marc" role="tab" aria-selected="false">MARC View</button>
                </div>

                <div class="opac-tab-panels border-top">
                    <div id="opacTabHoldings" class="opac-tab-panel is-active pt-3" role="tabpanel">
                        <p class="opac-library-location small mb-2" id="opacHoldingsLibraryLine"></p>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm opac-holdings-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Accession #</th>
                                        <th>Call #</th>
                                        <th>Volume / Part #</th>
                                        <th>Copy #</th>
                                        <th>Collection</th>
                                        <th>Shelving location</th>
                                        <th>Circulation type</th>
                                        <th>Circulation status</th>
                                        <th>Barcode</th>
                                        <th>RFID</th>
                                        <th>Add to cart</th>
                                    </tr>
                                </thead>
                                <tbody id="holdingsTableBody"></tbody>
                            </table>
                        </div>
                    </div>
                    <div id="opacTabDescription" class="opac-tab-panel pt-3" role="tabpanel">
                        <dl class="opac-desc-dl mb-0" id="descriptionDl"></dl>
                    </div>
                    <div id="opacTabMarc" class="opac-tab-panel pt-3" role="tabpanel">
                        <p class="small text-muted mb-2">Same layout as staff book view; only tags with a value that matches on every copy of this title are shown. Use <strong>Holdings</strong> when values differ by copy.</p>
                        <div class="table-responsive opac-marc-view-wrap">
                            <table class="table table-sm table-borderless opac-marc-view-table mb-0">
                                <tbody id="marcViewTableBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="studentModal">
        <div class="modal-content">
            <span class="close" onclick="closeStudentModal()">&times;</span>

            <h4>Self Check-Out</h4>

            <div class="mb-3">
                <label for="studentIdInput" class="form-label"><strong>Student ID</strong></label>
                <input type="text" id="studentIdInput" class="form-control" placeholder="Enter your Student ID">
            </div>

            <button type="button" class="btn btn-primary mt-3" onclick="confirmCheckout()">
                Confirm Checkout
            </button>

            <p id="studentError" class="text-danger mt-2" style="display:none;"></p>
        </div>
    </div>

    <button id="cartButton" type="button" onclick="openCartModal()" style="position:fixed; bottom:30px; right:30px; z-index:999;
                       padding:12px 20px; border-radius:50px;" class="btn btn-dark">
        Cart (<span id="cartCount">0</span>)
    </button>

    <div class="modal" id="cartModal">
        <div class="modal-content cart-modal-clean">
            <span class="close" onclick="closeCartModal()">&times;</span>

            <div class="cart-header">
                <h2>Borrow Cart</h2>
                <p>Maximum of 5 books allowed</p>
            </div>

            <div id="cartBody" class="cart-body">
                <ul id="cartList" class="cart-list"></ul>

                <div id="emptyCart" class="empty-cart" style="display:none;">
                    Your cart is empty.
                </div>
            </div>

            <div class="cart-footer">
                <div class="cart-count">
                    Total Books: <strong id="cartTotal">0</strong>
                </div>

                <button type="button" class="btn btn-dark px-5" onclick="openStudentModalFromCart()">
                    Proceed to Checkout
                </button>
            </div>
        </div>
    </div>

    <div id="toastContainer" class="toast-container"></div>
    </div>

    <script>
        window.CHECKOUT_URL = "{{ route('checkout.process') }}";
        window.CSRF_TOKEN = "{{ csrf_token() }}";
        window.OPAC_BOOK_DETAIL_BASE = @json(url('/opac/api/book').'/');

        function logout() {
            document.querySelector('header form[action*="logout"]')?.submit();
        }
    </script>
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/landings.js') }}"></script>
</body>

</html>
