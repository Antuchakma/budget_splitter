@extends('base')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h1>Create Room</h1>

        {{-- Open the form --}}
        <form action="{{ route('rooms.store') }}" method="POST">
            @csrf

            {{-- Room Name --}}
            <div class="form-group mb-3">
                <label for="name" class="form-label">Room Name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    class="form-control @error('name') is-invalid @enderror"
                    placeholder="Enter room name"
                    required
                >
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Description --}}
            <div class="form-group mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea
                    name="description"
                    id="description"
                    rows="3"
                    class="form-control @error('description') is-invalid @enderror"
                    placeholder="Enter room description"
                >{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-danger">
                Create Group
            </button>
        </form>
    </div>
</div>
@endsection
