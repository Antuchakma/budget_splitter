@extends('base')

@section('content')
<div class="container">
    <div class="jumbotron text-center">
        <h4>Are you sure you want to settle the debt?</h4>

        <form action="{{ route('settleDebt') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-primary">Yes</button>
        </form>

        <a href="{{ route('splitter.my_debts') }}" class="btn btn-danger">Cancel</a>
    </div>
</div>
@endsection
