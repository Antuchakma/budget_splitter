@extends('base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/final_settlements.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="final-debt-info">

        {{-- Income / Renumeration Section --}}
        <div class="final-debt-income">
            <h1>Renumeration:</h1>
            <div class="row">
                @if($noincome)
                    <h4>Oops! Looks like no remuneration is pending.</h4>
                @else
                    @foreach($user_receiver_positive as $obj)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                            <div class="incomes-debts-info p-3 border rounded">
                                <h3>Receive from:</h3>
                                <h3>{{ $obj->sender->name }}</h3>
                                <h4>Amount: {{ number_format($obj->final_amount, 2) }}</h4>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- Expenses / Debts Section --}}
        <div class="final-debt-expense">
            <h1>Debts:</h1>
            <div class="row">
                @if($noexpense)
                    <h4>Hurray! No debts pending.</h4>
                @else
                    @foreach($user_sender_negative as $obj)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                            <div class="expense-debts-info p-3 border rounded">
                                <h2>Pay to:</h2>
                                <h3>{{ $obj->receiver->name }}</h3>
                                <h4>Amount: {{ number_format($obj->final_amount, 2) }}</h4>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

    </div>
</div>
@endsection

