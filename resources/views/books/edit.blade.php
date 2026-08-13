<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/books/edit.css') }}">


</head>

<body>
    <div class="edit-container">
        <div class="edit-header">📝 Edit Book</div>

        <form method="POST" action="{{ route('book.update', $book->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                @include('books.partials.marc_editor', ['frameworkFields' => $frameworkFields, 'marcValues' => $marcValues])

                    <div class="form-section">
                        <label>Program (optional)</label>
                        <p class="text-muted small">Courses for 650 ‡a load from the Prospectus when program(s) are selected.</p>
                        <div id="program-container">
                            @if($book->programs->isNotEmpty())
                            @foreach($book->programs as $program)
                            <div class="program-row d-flex mb-2">
                                <select name="program_ids[]" class="form-control program-select">
                                    <option value="">-- Select Program --</option>
                                    @foreach($programs as $p)
                                    <option value="{{ $p->id }}" {{ $p->id == $program->id ? 'selected' : '' }}>
                                        {{ $p->program_name }}
                                    </option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-danger btn-sm ms-2 remove-program-btn">X</button>
                            </div>
                            @endforeach
                            @else
                            <div class="program-row d-flex mb-2">
                                <select name="program_ids[]" class="form-control program-select">
                                    <option value="">-- Select Program --</option>
                                    @foreach($programs as $p)
                                    <option value="{{ $p->id }}">{{ $p->program_name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-danger btn-sm ms-2 remove-program-btn">X</button>
                            </div>
                            @endif
                        </div>
                        <button type="button" id="add-program-btn" class="btn btn-sm btn-secondary mt-1">Add More
                            Program</button>
                    </div>

                    <div class="form-section">
                        <label for="year">996 ‡e</label>
                        <input type="text" name="year" id="year" class="form-control" value="{{ $book->year }}"
                            placeholder="Enter Year">
                    </div>

                    <div class="form-section">
                        <label for="book_course">650 ‡a Course</label>
                        <select name="course" id="book_course" class="form-control">
                            <option value="">-- Select program(s) first --</option>
                            @if($book->course)
                            <option value="{{ $book->course }}" selected>{{ $book->course }}</option>
                            @endif
                        </select>
                    </div>
                </div>


                <div class="form-section">
                    <label class="form-label">856:</label>
                    @if ($book->cover_image)
                    <div class="file-preview">

                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover Image"
                            style="height: 280px; width: 380px; border-radius: 20px; display: block; margin-bottom: 10px;">

                    </div>
                    @endif
                    <input type="file" name="cover_image" class="form-control" accept="image/*">
                </div>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('book.index') }}" class="btn btn-cancel">❌ Cancel</a>
                <button type="submit" class="btn btn-update">✅ Update Book</button>
            </div>
        </form>
    </div>



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

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const container = document.getElementById("program-container");
            const addBtn = document.getElementById("add-program-btn");

            // Add new program dropdown
            addBtn.addEventListener("click", function () {
                let selectedValues = Array.from(container.querySelectorAll("select"))
                    .map(sel => sel.value)
                    .filter(v => v !== "");

                let wrapper = document.createElement("div");
                wrapper.classList.add("program-row", "d-flex", "mb-2");

                let select = document.createElement("select");
                select.name = "program_ids[]";
                select.classList.add("form-control", "program-select");

                // Default option
                let defaultOpt = document.createElement("option");
                defaultOpt.value = "";
                defaultOpt.textContent = "-- Select Program --";
                select.appendChild(defaultOpt);

                // Populate options but exclude already selected
                @json($programs).forEach(p => {
                    if (!selectedValues.includes(p.id.toString())) {
                        let opt = document.createElement("option");
                        opt.value = p.id;
                        opt.textContent = p.program_name;
                        select.appendChild(opt);
                    }
                });

                let removeBtn = document.createElement("button");
                removeBtn.type = "button";
                removeBtn.textContent = "X";
                removeBtn.classList.add("btn", "btn-danger", "btn-sm", "ms-2", "remove-program-btn");
                removeBtn.addEventListener("click", () => wrapper.remove());

                wrapper.appendChild(select);
                wrapper.appendChild(removeBtn);
                container.appendChild(wrapper);
                if (typeof window.refreshBookCourseOptions === "function") {
                    window.refreshBookCourseOptions();
                }
            });

            // Remove button for existing rows
            container.querySelectorAll(".remove-program-btn").forEach(btn => {
                btn.addEventListener("click", function () {
                    this.closest(".program-row").remove();
                    if (typeof window.refreshBookCourseOptions === "function") {
                        window.refreshBookCourseOptions();
                    }
                });
            });
        });
    </script>

    @include('books.partials.catalog_courses_script')

    @stack('scripts')

</body>

</html>