@extends('base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mysearchbar.css') }}">
<link rel="stylesheet" href="{{ asset('css/my_debts.css') }}">
@endsection

@section('content')

<div class="container my-5">
    {{-- Back Button --}}
    <div class="mb-3">
        <button type="button" class="btn btn-outline-secondary" onclick="history.back()">
            <i class="fas fa-arrow-left"></i> Back
        </button>
    </div>

    <div class="my-debts-info">

        {{-- Search Form --}}
        <form method="GET" action="{{ route('my_debts') }}" class="mb-4">
            <div class="input-group">
                <input type="search" name="q" class="form-control" placeholder="Search User..." value="{{ request('q') }}">
                <button type="submit" class="btn btn-outline-primary">Search</button>
            </div>
        </form>

        {{-- Payments to Receive --}}
        <div class="my-debts-income mb-5">
            <h1 class="mb-3">Payments to receive:</h1>
            <div class="row">
                @forelse($incomes as $income)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                        <div class="my-debts-income-info p-3 border rounded h-100">
                            <h4>{{ $income->amount }}</h4>
                            <p>From: {{ $income->sender->name }}</p>
                            <p>For: {{ $income->transaction->reason }}</p>
                            <p>Room: {{ $income->room->name }}</p>
                            <p>{{ $income->transaction->created_at->format('d M Y H:i') }}</p>
                            <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#settleDebtModal{{ $income->id }}">
                                Settle Debt
                            </button>
                        </div>
                    </div>

                    {{-- Modal --}}
                    <div class="modal fade" id="settleDebtModal{{ $income->id }}" tabindex="-1" aria-labelledby="settleDebtLabel{{ $income->id }}" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="settleDebtLabel{{ $income->id }}">
                                        Settle Debt of {{ $income->sender->name }} for {{ $income->transaction->reason }}
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <form action="{{ route('delete_debt', $income->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-primary">Yes</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-12">
                        <h4 class="text-muted">No payments to receive!!!</h4>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Amounts to Pay --}}
        <div class="my-debts-expense mb-5">
            <h1 class="mb-3">Amounts to pay:</h1>
            <div class="row">
                @forelse($expenses as $expense)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                        <div class="my-debts-expense-info p-3 border rounded h-100">
                            <h4>{{ $expense->amount }}</h4>
                            <p>Give to: {{ $expense->receiver->name }}</p>
                            <p>For: {{ $expense->transaction->reason }}</p>
                            <p>Room: {{ $expense->room->name }}</p>
                            <p>{{ $expense->transaction->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <h4 class="text-muted">No amounts to pay!!!</h4>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('final_settlements') }}" class="btn btn-primary final-debts-button">Show Final Debts</a>
        </div>

    </div>
</div>

@endsection
