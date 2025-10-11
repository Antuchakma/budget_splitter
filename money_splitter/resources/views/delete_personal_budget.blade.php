@extends('base')

@section('content')
<div class="container">
    <div class="jumbotron text-center">
        <h4>Are you sure you want to delete {{ $obj->description }}?</h4>

        <form action="{{ route('deleteBudget', $obj->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-primary">Yes</button>
        </form>

        <a href="{{ route('personal_budget') }}" class="btn btn-danger">Cancel</a>
    </div>
</div>
@endsection
