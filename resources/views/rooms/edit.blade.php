@extends('layouts.sec')

@section('title', 'Edit Room')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Room</h2>

    <form action="{{ route('rooms.update', $room->id) }}" method="POST" class="card p-4 shadow-sm bg-white">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Room Name</label>
            <input type="text" name="name" class="form-control" value="{{ $room->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ $room->description }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Capacity</label>
            <input type="number" name="capacity" class="form-control" value="{{ $room->capacity }}" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </form>
</div>
@endsection
