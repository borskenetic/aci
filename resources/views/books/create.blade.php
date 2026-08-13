@extends('layouts.sec')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/books/create.css') }}">
    <link href="{{ asset('vendor/fontsource/martel-sans/latin-900.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="edit-container">
        <div class="text-center">
            <div class="edit-header"> Add New Book</div>
        </div>

        <form id="addBookForm" method="POST" action="{{ route('book.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                @php $marcValues = []; @endphp
                @include('books.partials.marc_editor', ['frameworkFields' => $frameworkFields])
                <div class="col-md-12">
                    <label>Program (optional)</label>
                    <p class="text-muted small mb-1">If you attach programs, courses load from the Prospectus (program years → courses).</p>
                    <div id="program-container">
                        <div class="program-row">
                            <select name="program_ids[]" class="form-control mb-2 program-select">
                                <option value="">-- Select Program --</option>
                                @foreach($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->program_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="button" id="add-program-btn" class="btn btn-sm btn-secondary mt-1">Add More
                        Program</button>
                </div>
                <div class="col-md-6">
                    <label for="year">996 ‡e</label>
                    <input type="text" name="year" id="year" class="form-control" placeholder="Enter Year">
                </div>
                <div class="col-md-6">
                    <label for="book_course">650 ‡a Course</label>
                    <select name="course" id="book_course" class="form-control" disabled>
                        <option value="">-- Select program(s) first --</option>
                        @if(old('course'))
                        <option value="{{ old('course') }}" selected>{{ old('course') }}</option>
                        @endif
                    </select>
                </div>


                <div class="col-md-12">
                    <label for="cover_image">856</label>
                    <input type="file" name="cover_image" class="form-control" placeholder="Enter Cover Image">
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('book.index') }}" class="btn btn-back"> Go Back</a>
                    <button type="submit" class="btn btn-save"> Save Book</button>
                </div>
            </div>


        </form>

        @if ($errors->any())
        <div class="alert alert-danger mt-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>

    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('addBookForm');
            form.addEventListener('keydown', e => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const inputs = [...form.querySelectorAll('input')];
                    const index = inputs.indexOf(document.activeElement);
                    if (inputs[index + 1]) inputs[index + 1].focus();
                }
            });
        });
    </script>

    @include('books.partials.catalog_courses_script')

    <script>
        const programs = @json($programs);
        const container = document.getElementById('program-container');
        const addBtn = document.getElementById('add-program-btn');
    
        function refreshOptions() {
            const selectedValues = Array.from(document.querySelectorAll('.program-select'))
                .map(sel => sel.value)
                .filter(v => v);
    
            document.querySelectorAll('.program-select').forEach(select => {
                const currentVal = select.value;
                Array.from(select.options).forEach(opt => {
                    if (opt.value && selectedValues.includes(opt.value) && opt.value !== currentVal) {
                        opt.hidden = true;
                    } else {
                        opt.hidden = false;
                    }
                });
            });
        }
    
        addBtn.addEventListener('click', () => {
            const row = document.createElement('div');
            row.classList.add('program-row', 'd-flex', 'align-items-center', 'mb-2');
    
            const select = document.createElement('select');
            select.name = "program_ids[]";
            select.classList.add('form-control', 'program-select', 'me-2');
    
            const defaultOption = document.createElement('option');
            defaultOption.value = "";
            defaultOption.textContent = "-- Select Program --";
            select.appendChild(defaultOption);
    
            programs.forEach(program => {
                const option = document.createElement('option');
                option.value = program.id;
                option.textContent = program.program_name;
                select.appendChild(option);
            });
    
            const removeBtn = document.createElement('button');
            removeBtn.type = "button";
            removeBtn.textContent = "Remove";
            removeBtn.classList.add('btn', 'btn-sm', 'btn-danger', 'remove-program');
    
            row.appendChild(select);
            row.appendChild(removeBtn);
            container.appendChild(row);
    
            refreshOptions();
            if (typeof window.refreshBookCourseOptions === 'function') {
                window.refreshBookCourseOptions();
            }
        });
    
        container.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-program')) {
                e.target.closest('.program-row').remove();
                refreshOptions();
                if (typeof window.refreshBookCourseOptions === 'function') {
                    window.refreshBookCourseOptions();
                }
            }
        });
    
        container.addEventListener('change', (e) => {
            if (e.target.classList.contains('program-select')) {
                refreshOptions();
            }
        });
    
        refreshOptions();
    </script>
@endsection