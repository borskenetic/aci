@extends('layouts.sec')
<link rel="stylesheet" href="{{ asset('css/books/index.css') }}">

@section('content')
<div class="container mt-5">
    <h2>Copy Cataloging (ISBN)</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('catalog.copy.openlibrary.search') }}">
        @csrf

        <div class="mb-3">
            <label>ISBN</label>
            <input type="text" name="isbn" class="form-control" placeholder="Enter ISBN" required
                value="{{ old('isbn', $prefillIsbn ?? '') }}">
        </div>

        <button id="search" class="btn btn-primary">Search</button>
    </form>
</div>
@endsection
