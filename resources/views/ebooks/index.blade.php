@extends('layouts.sec')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/ebooks/index.css') }}">
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

@endsection

@section('content')
    <div class="container mt-4">
        <h1 class="ebook-text text-center mb-4">📚 E-Resources Collection</h1>

        <div class="buttons mb-3 text-end">
            <a href="{{ route('ebooks.create') }}" class="btn-add">Add New E-Resource</a>
        </div>

        {{-- 🔽 Filter Form --}}
        <form method="GET" action="{{ route('ebooks.index') }}" class="row g-2 mb-3">
            <div class="col-md">
                <select name="title" class="form-select">
                    <option value="">All Titles</option>
                    @foreach ($allTitles as $title)
                    <option value="{{ $title }}" {{ request('title')==$title ? 'selected' : '' }}>{{ $title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md">
                <select name="author" class="form-select">
                    <option value="">All Authors</option>
                    @foreach ($allAuthors as $author)
                    <option value="{{ $author }}" {{ request('author')==$author ? 'selected' : '' }}>{{ $author }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md">
                <select name="year" class="form-select">
                    <option value="">All Years</option>
                    @foreach ($allYears as $year)
                    <option value="{{ $year }}" {{ request('year')==$year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md">
                <select name="publisher" class="form-select">
                    <option value="">All Publishers</option>
                    @foreach ($allPublishers as $publisher)
                    <option value="{{ $publisher }}" {{ request('publisher')==$publisher ? 'selected' : '' }}>{{
                        $publisher }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md">
                <select name="source" class="form-select">
                    <option value="">All Sources</option>
                    @foreach ($allSources as $source)
                    <option value="{{ $source }}" {{ request('source')==$source ? 'selected' : '' }}>{{ $source }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md">
                <select name="program_id" id="filterProgram" class="form-select">
                    <option value="">All Programs</option>
                    @foreach ($allPrograms as $program)
                        <option value="{{ $program->id }}" {{ request('program_id')==$program->id ? 'selected' : '' }}>
                            {{ $program->program_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md">
                <select name="course_id" id="filterCourse" class="form-select">
                    <option value="">All Subjects</option>
                    @foreach ($allCourses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id')==$course->id ? 'selected' : '' }}>
                            {{ $course->course_name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('ebooks.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
        {{-- 🔼 End Filter Form --}}

        <div class="card">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publication Year</th>
                        <th>Publisher</th>
                        <th>Source</th>
                        <th>Program</th>
                        <th>Course</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ebooks as $ebook)
                    <tr>
                        <td>{{ $ebook->title }}</td>
                        <td>{{ $ebook->author }}</td>
                        <td>{{ $ebook->publication_year ?? '—' }}</td>
                        <td>{{ $ebook->publisher ?? '—' }}</td>
                        <td>{{ $ebook->source ?? '—' }}</td>
                        <td>{{ $ebook->program->program_name ?? '—' }}</td>
                        <td>{{ $ebook->course->course_name ?? '—' }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('ebooks.edit', $ebook->id) }}">Edit</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('ebooks.destroy', $ebook->id) }}" method="POST"
                                            class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item"
                                                onclick="return confirm('Are you sure you want to delete this e-book?');">Delete</button>
                                        </form>
                                    </li>
                                    <li>
                                        @if ($ebook->link)
                                        <a class="dropdown-item" href="{{ $ebook->link }}" target="_blank">View</a>
                                        @else
                                        <span class="dropdown-item text-muted">N/A</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No e-resources found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination with filters --}}
        <div class="mt-3 d-flex justify-content-center">
            {{ $ebooks->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>

    </div>



    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const programSelect = document.getElementById("filterProgram");
            const courseSelect = document.getElementById("filterCourse");

            programSelect.addEventListener("change", function () {
                const programId = this.value || "all";

                fetch(`/ebooks/get-courses/${programId}`)
                    .then(response => response.json())
                    .then(courses => {
                        // Clear current options
                        courseSelect.innerHTML = '<option value="">All Courses</option>';

                        // Add new options
                        courses.forEach(course => {
                            const option = document.createElement("option");
                            option.value = course.id;
                            option.textContent = course.name;

                            // Preserve old selection on reload
                            if ("{{ request('course_id') }}" == course.id) {
                                option.selected = true;
                            }

                            courseSelect.appendChild(option);
                        });
                    })
                    .catch(err => console.error("Error fetching courses:", err));
            });

            // 🔹 Trigger once on page load (so that course list matches pre-selected program)
            if (programSelect.value) {
                programSelect.dispatchEvent(new Event("change"));
            }
        });
    </script>
    
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

@endsection