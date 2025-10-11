@extends('base')

@section('content')

<div class="container">
    <div class="jumbotron">

        <form action="{{ route('update_transaction', ['pk' => $rooms->id, 'id' => $prev_transaction->id]) }}" method="POST">
            @csrf

            {{-- Reason --}}
            <input type="text" name="reason" class="form-control mb-2" value="{{ $prev_transaction->reason }}" required>

            {{-- Amount --}}
            <input type="number" name="amount" class="form-control mb-2" value="{{ $prev_transaction->amount }}" required>

            {{-- Splitters --}}
            @foreach($members as $member)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="splitter[]" value="{{ $member->username }}"
                        @if(in_array($member->username, $prev_splitters_usernames)) checked @endif>
                    <label class="form-check-label">{{ $member->username }}</label>
                </div>
            @endforeach

            {{-- Submit --}}
            <button type="submit" class="btn btn-primary mt-2">Submit</button>

        </form>

    </div>
</div>

@endsection
