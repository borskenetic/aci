<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>View Book</title>
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/books/show.css') }}">
</head>

<body>
    <div class="container-fluid px-3 px-md-5 mt-5">
        <h1 class="book-heading">
            <span class="text ms-2">Book Details</span>
        </h1>

        <div class="row g-4 align-items-start">
            <div class="col-12 col-md-4 text-center">
                @if (filled($book->cover_image))
                <p><strong>856 (Cover Image):</strong></p>
                <a href="{{ asset('storage/' . $book->cover_image) }}" target="_blank" rel="noopener noreferrer">
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover Image"
                        class="img-thumbnail" style="height: 4in; width: 3.5in;">
                </a>
                @endif
            </div>

            <div class="col-12 col-md-8">
                <div style="display: inline-block;">
                    <h3 style="font-family: 'Rubik', sans-serif; font-weight: 700; margin-bottom: 5px;">{{ $book->title_statement ?? $book->title ?? '—' }}</h3>
                    <div
                        style="height: 3px; width: 100%; background-color: #121e24; border-radius: 2px; margin-bottom: 30px;">
                    </div>
                </div>

                <table class="table table-borderless">
                    <tbody>
                        @if(filled($book->control_no))
                        <tr>
                            <th>001 (Control No.):</th>
                            <td>{{ $book->control_no }}</td>
                        </tr>
                        @endif
                        @if(filled($book->date_time_stamp))
                        <tr>
                            <th>005 (Date &amp; Time Stamp):</th>
                            <td>{{ $book->date_time_stamp }}</td>
                        </tr>
                        @endif
                        @if(filled($book->fixed_length_data))
                        <tr>
                            <th>008 (Fixed-Length Data):</th>
                            <td>{{ $book->fixed_length_data }}</td>
                        </tr>
                        @endif
                        @if(filled($book->isbn))
                        <tr>
                            <th>020 ‡a (ISBN):</th>
                            <td>{{ $book->isbn }}</td>
                        </tr>
                        @endif
                        @if(filled($book->price))
                        <tr>
                            <th>020 ‡c (Price):</th>
                            <td>{{ $book->price }}</td>
                        </tr>
                        @endif
                        @if(filled($book->cataloging_source_a))
                        <tr>
                            <th>040 ‡a (Cataloging Source):</th>
                            <td>{{ $book->cataloging_source_a }}</td>
                        </tr>
                        @endif
                        @if(filled($book->cataloging_source_b))
                        <tr>
                            <th>040 ‡b (Language):</th>
                            <td>{{ $book->cataloging_source_b }}</td>
                        </tr>
                        @endif
                        @if(filled($book->cataloging_source_e))
                        <tr>
                            <th>040 ‡e (Description Conventions)</th>
                            <td>{{ $book->cataloging_source_e }}</td>
                        </tr>
                        @endif
                        @if(filled($book->main_author))
                        <tr>
                            <th>100 ‡a (Main Author)</th>
                            <td>{{ $book->main_author }}</td>
                        </tr>
                        @endif
                        @if(filled($book->title_statement))
                        <tr>
                            <th>245 ‡a (Title)</th>
                            <td>{{ $book->title_statement }}</td>
                        </tr>
                        @endif
                        @if(filled($book->title_author))
                        <tr>
                            <th>245 ‡c (Title Responsibility)</th>
                            <td>{{ $book->title_author }}</td>
                        </tr>
                        @endif
                        @if(filled($book->edition))
                        <tr>
                            <th>250 ‡a (Edition)</th>
                            <td>{{ $book->edition }}</td>
                        </tr>
                        @endif
                        @if(filled($book->pub_place))
                        <tr>
                            <th>264 ‡a (Publication Place)</th>
                            <td>{{ $book->pub_place }}</td>
                        </tr>
                        @endif
                        @if(filled($book->publisher))
                        <tr>
                            <th>264 ‡b (Publisher)</th>
                            <td>{{ $book->publisher }}</td>
                        </tr>
                        @endif
                        @if(filled($book->pub_year))
                        <tr>
                            <th>264 ‡c (Publication Year)</th>
                            <td>{{ $book->pub_year }}</td>
                        </tr>
                        @endif
                        @if(filled($book->pages))
                        <tr>
                            <th>300 ‡a (Pages)</th>
                            <td>{{ $book->pages }}</td>
                        </tr>
                        @endif
                        @if(filled($book->illustrations))
                        <tr>
                            <th>300 ‡b (Illustrations)</th>
                            <td>{{ $book->illustrations }}</td>
                        </tr>
                        @endif
                        @if(filled($book->size))
                        <tr>
                            <th>300 ‡c (Size)</th>
                            <td>{{ $book->size }}</td>
                        </tr>
                        @endif
                        @if(filled($book->volume))
                        <tr>
                            <th>300 ‡f (Type of unit)</th>
                            <td>{{ $book->volume }}</td>
                        </tr>
                        @endif
                        @if(filled($book->content_type))
                        <tr>
                            <th>336 ‡a (Content Type)</th>
                            <td>{{ $book->content_type }}</td>
                        </tr>
                        @endif
                        @if(filled($book->media_type))
                        <tr>
                            <th>337 ‡a (Media Type)</th>
                            <td>{{ $book->media_type }}</td>
                        </tr>
                        @endif
                        @if(filled($book->carrier_type))
                        <tr>
                            <th>338 ‡a (Carrier Type)</th>
                            <td>{{ $book->carrier_type }}</td>
                        </tr>
                        @endif
                        @if(filled($book->series_title))
                        <tr>
                            <th>490 ‡a (Series Title)</th>
                            <td>{{ $book->series_title }}</td>
                        </tr>
                        @endif
                        @if(filled($book->general_note))
                        <tr>
                            <th>500 ‡a (General Note)</th>
                            <td>{{ $book->general_note }}</td>
                        </tr>
                        @endif
                        @if(filled($book->bibliography_note))
                        <tr>
                            <th>504 ‡a (Bibliography Note)</th>
                            <td>{{ $book->bibliography_note }}</td>
                        </tr>
                        @endif
                        @if(filled($book->source_vendor))
                        <tr>
                            <th>541 ‡a (Immediate source of acquisition)</th>
                            <td>{{ $book->source_vendor }}</td>
                        </tr>
                        @endif
                        @if(filled($book->source_date))
                        <tr>
                            <th>541 ‡d (Date of acquisition)</th>
                            <td>{{ $book->source_date }}</td>
                        </tr>
                        @endif
                        @if(filled($book->subject_topic))
                        <tr>
                            <th>650 ‡a (Subject)</th>
                            <td>{{ $book->subject_topic }}</td>
                        </tr>
                        @endif
                        @if(filled($book->subject_form))
                        <tr>
                            <th>650 ‡v (Form)</th>
                            <td>{{ $book->subject_form }}</td>
                        </tr>
                        @endif
                        @if(filled($book->genre))
                        <tr>
                            <th>655 ‡a (Genre)</th>
                            <td>{{ $book->genre }}</td>
                        </tr>
                        @endif
                        @if(filled($book->library_name))
                        <tr>
                            <th>852 ‡b (Library Name)</th>
                            <td>{{ $book->library_name }}</td>
                        </tr>
                        @endif
                        @if(filled($book->section))
                        <tr>
                            <th>852 ‡c (Sublocation / shelving)</th>
                            <td>{{ $book->section }}</td>
                        </tr>
                        @endif
                        @if(filled($book->call_number))
                        <tr>
                            <th>852 ‡h (Call Number)</th>
                            <td>{{ $book->call_number }}</td>
                        </tr>
                        @endif
                        @if(filled($book->accession_no))
                        <tr>
                            <th>949 (Accession No.)</th>
                            <td>{{ $book->accession_no }}</td>
                        </tr>
                        @endif
                        @if(filled($book->barcode))
                        <tr>
                            <th>876 ‡p (Barcode)</th>
                            <td>{{ $book->barcode }}</td>
                        </tr>
                        @endif
                        @if(filled($book->rfid))
                        <tr>
                            <th>999 ‡r (RFID, local)</th>
                            <td>{{ $book->rfid }}</td>
                        </tr>
                        @endif
                        @if(filled($book->year))
                        <tr>
                            <th>996 ‡e (Year)</th>
                            <td>{{ $book->year }}</td>
                        </tr>
                        @endif
                        @if(filled($book->course))
                        <tr>
                            <th>650 ‡a (Course)</th>
                            <td>{{ $book->course }}</td>
                        </tr>
                        @endif
                        @if($book->programs && $book->programs->count() > 0)
                        <tr>
                            <th>996 ‡f (Program)</th>
                            <td>
                                @foreach($book->programs as $program)
                                <span class="badge bg-primary me-1">{{ $program->program_name }}</span>
                                @endforeach
                            </td>
                        </tr>
                        @endif


                        {{-- Status --}}
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($book->availability === 'Available')
                                <span class="text-success">Available</span>
                                @else
                                <span class="text-danger">Borrowed</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Last Borrower --}}
                        @php
                        $lastTransaction = $book->logs()->where('status', 'Checked Out')->latest()->first();
                        @endphp
                        @if($book->availability === 'Borrowed' && $lastTransaction)
                        <tr>
                            <th>Last Borrower:</th>
                            <td>{{ $lastTransaction->patron_name }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>

                {{-- Buttons --}}
                <div class="mt-4 d-flex flex-wrap gap-2">
                    <a href="{{ route('book.index') }}" class="btn"
                        style="background-color: black; color: white; font-family: 'Rubik', sans-serif; font-weight: bold; transition: 0.3s;"
                        onmouseover="this.style.backgroundColor='#ffb845'; this.style.color='#22333b';"
                        onmouseout="this.style.backgroundColor='black'; this.style.color='white';">
                        ⬅ Back to List
                    </a>

                    @if($book->availability === 'Available')
                    <style>
                        .btn-hover-white:hover {
                            background-color: #3E5F44 !important;
                            color: white !important;
                        }
                    </style>
                    <a href="{{ route('logs.index', ['rfid' => $book->rfid, 'status' => 'checked_out']) }}"
                        class="btn btn-hover-white"
                        style="font-family: 'Rubik', sans-serif; font-weight: bold; color:white; background-color: #5E936C;">
                        Check Out
                    </a>
                    @else
                    <a href="{{ route('logs.index', [
              'rfid' => $book->rfid,
              'status' => 'checked_in',
              'patron_name' => $lastTransaction?->patron_name ?? ''
            ]) }}" class="btn btn-success">
                        🔄 Check In
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>

</html>