@extends('base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mysearchbar.css') }}">
<link rel="stylesheet" href="{{ asset('css/members_list.css') }}">
@endsection

@section('content')

<div class="add-member-page">
    <div class="row">
        <div class="col-lg-6">
            <div class="add-member-img-grid">
                <img src="{{ asset('images/undraw_team_ih79.svg') }}" alt="" class="add-member-img">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="container add-member-grid">
                <h2>Add Member:</h2>

                {{-- Search Form --}}
                <form method="GET" action="{{ route('list_members', ['pk' => $room->id]) }}" class="mb-3">
                    <div class="input-group">
                        <input type="search" name="q" class="form-control" placeholder="Search by name or email" value="{{ request('q') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Search</button>
                            @if(request('q'))
                                <a href="{{ route('list_members', ['pk' => $room->id]) }}" class="btn btn-secondary">Clear</a>
                            @endif
                        </div>
                    </div>
                </form>

                {{-- Members List --}}
                @forelse($members_list as $obj)
                    <div class="member-box">
                        <h5>
                            <b>{{ $obj->name }}</b>
                            <small class="text-muted d-block">{{ $obj->email }}</small>
                            <div class="add-button mt-2">
                                <form action="{{ route('add_member', ['pk' => $room->id, 'id' => $obj->id]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">Add</button>
                                </form>
                            </div>
                        </h5>
                    </div>
                    <hr>
                @empty
                    <div class="text-center py-4">
                        @if(request('q'))
                            <p class="text-muted">No users found matching "{{ request('q') }}"</p>
                            <p><small>Try a different search term or <a href="{{ route('list_members', ['pk' => $room->id]) }}">clear search</a></small></p>
                        @else
                            <p class="text-muted">No users available to add to this room.</p>
                            <p><small>All users are either already members of this room or there are no other registered users.</small></p>
                        @endif
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</div>

@endsection
