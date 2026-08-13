@extends('layouts.sec')

@section('title', 'Registered Faculty')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/students/students.css') }}">
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header text-center">
            <h4>Registered Faculty</h4>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Search + Buttons -->
            <div class="mb-3">
                <div class="d-flex mb-2" style="max-width: 350px;">
                    <form action="{{ route('employees.index') }}" method="GET" class="d-flex w-100">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search faculty..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary btn-sm ms-2">Search</button>
                    </form>
                </div>

                <div class="d-flex align-items-center justify-content-between">
                    <a href="" class="btn btn-add">+ Register Faculty</a>
                    <a href="{{ route('pending.index') }}" class="btn btn-warning">View Pending Registrations</a>
                </div>
                
                <div class="mb-3 text-center">
                    <a href="{{ route('students.index') }}" class="btn btn-outline-primary btn-sm ">Students</a>
                    <a href="{{ route('employees.index') }}" class="btn btn-outline-primary btn-sm active">Faculty</a>
                </div>
            </div>

            <!-- Faculty Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>QR Code</th>
                            <th>Actions</th>
                            <th>Generate ID</th> <!-- ✅ Added column -->
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($faculty as $employee)
                            <tr>
                                <td>
                                    @if($employee->formal_picture)
                                        <img src="{{ asset($employee->formal_picture) }}" width="80" class="rounded">
                                    @else
                                        No Image
                                    @endif
                                </td>
                                <td>{{ $employee->firstname }} {{ $employee->lastname }}</td>
                                <td>{{ $employee->department }}</td>
                                <td>{{ $employee->position }}</td>
                                <td>{{ $employee->qrcode }}</td>

                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            Options
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('employees.edit', $employee->id) }}">Edit</a></li>
                                            <li>
                                                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dropdown-item" type="submit">Delete</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>

                                <!-- ✅ New Generate ID dropdown -->
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            Generate
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('employees.id.front', $employee->id) }}" target="_blank">Front</a></li>
                                            <li><a class="dropdown-item" href="{{ route('employees.id.back', $employee->id) }}" target="_blank">Back</a></li>
                                            <li><a class="dropdown-item" href="{{ route('employees.id.download', $employee->id) }}">Download ZIP</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7">No faculty found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $faculty->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>

            <a href="{{ route('books.index') }}" class="btn btn-back mt-3">← Back to Books</a>
        </div>
    </div>
</div>
@endsection
