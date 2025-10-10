@extends('base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/room_list.css') }}">
@endsection

@section('content')

<div class="room-list-page">
    {{-- Back Button --}}
    <div class="mb-3">
        <button type="button" class="btn btn-outline-secondary" onclick="history.back()">
            <i class="fas fa-arrow-left"></i> Back
        </button>
    </div>

    <div class="row">
        {{-- Image --}}
        <div class="col-lg-6 mb-3">
            <div class="room-list-img-grid">
                <img src="{{ asset('images/undraw_Group_chat_unwm.svg') }}" alt="" class="room_list_img img-fluid">
            </div>
        </div>

        {{-- Room List --}}
        <div class="col-lg-6 mb-3">
            <div class="container room-list-grid">
                @if($rooms->isEmpty())
                    <h1>No Rooms Created!!</h1>
                @else
                    <h1>Your Rooms:</h1>
                    @foreach($rooms as $room)
                        <a href="{{ route('room_detail', ['pk' => $room->id]) }}" class="text-decoration-none">
                            <div class="room_name mb-2 p-2 border rounded">
                                <p class="mb-0">{{ $room->name }}</p>
                            </div>
                        </a>
                    @endforeach
                @endif

                {{-- Create Room Button --}}
                <button type="button" class="btn btn-primary mt-3 create-room" data-toggle="modal" data-target="#RoomModalCreate">
                    Create Room
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Create Room Modal --}}
<div class="modal fade" id="RoomModalCreate" tabindex="-1" aria-labelledby="RoomModalCreateLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="RoomModalCreateLabel">Create Room</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('add_room') }}" method="POST">
                    @csrf
                    <input type="text" name="name" class="form-control mb-3" placeholder="Enter your room name" required>
                    <button type="submit" class="btn btn-primary">Create Room</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
