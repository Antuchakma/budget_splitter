@extends('base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/personal_budget.css') }}">
@endsection

@section('content')

{{-- Flash / Messages --}}
@if(session('messages'))
<div class="container my-3">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        @foreach(session('messages') as $message)
            <div class="alert @if(isset($message['tags'])) alert-{{ $message['tags'] }} @endif">{!! $message['message'] !!}</div>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif

{{-- Back Button --}}
<div class="container mb-3">
    <button type="button" class="btn btn-outline-secondary" onclick="history.back()">
        <i class="fas fa-arrow-left"></i> Back
    </button>
</div>

{{-- Budget Top --}}
<div class="budget-top mb-4 position-relative">
    <img class="budget-top-background img-fluid" src="{{ asset('images/personal_budget_background.PNG') }}" alt="Budget Background">
    <div class="show-budget position-absolute top-50 start-50 translate-middle text-center">
        <h1>Final Budget</h1>
        <h2>{{ $total_bud }}</h2>
        <div class="income-box">
            <p>Total Income</p>
            <p>{{ $total_income }}</p>
        </div>
        <div class="expense-box">
            <p>Total Expense</p>
            <p>{{ $total_expenses }}</p>
        </div>
    </div>
</div>

{{-- Add Budget Form --}}
<div class="budget-form mb-5">
    <form action="{{ route('add_personal_budget') }}" method="POST" class="d-flex gap-2 flex-wrap">
        @csrf
        <select id="type" name="type" class="form-select w-auto">
            <option value="inc">+</option>
            <option value="exp">-</option>
        </select>
        <input type="text" name="description" placeholder="Description" class="form-control w-auto">
        <input type="number" step="0.01" name="amount" placeholder="Amount" class="form-control w-auto">
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
</div>

{{-- Budget Bottom: Income & Expense Lists --}}
<div class="budget-bottom">
    <div class="row">

        {{-- Income --}}
        <div class="col-md-6 col-sm-12 mb-4">
            <h2>Income</h2>
            <div class="budget-info-list income">
                @forelse($incomes as $income)
                    <div class="item clearfix d-flex justify-content-between align-items-center p-2 border rounded mb-2">
                        <div>{{ $income->description }}</div>
                        <div class="d-flex align-items-center gap-2">
                            <div>{{ $income->amount }}</div>
                            <button type="button" class="btn btn-link text-danger p-0" data-toggle="modal" data-target="#deleteIncomeModal{{ $income->id }}">
                                <i class="fal fa-times-circle"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Delete Income Modal --}}
                    <div class="modal fade" id="deleteIncomeModal{{ $income->id }}" tabindex="-1" aria-labelledby="deleteIncomeLabel{{ $income->id }}" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteIncomeLabel{{ $income->id }}">Delete {{ $income->description }} Income</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <form action="{{ route('delete_personal_income', $income->id) }}" method="POST">
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
                    <p class="text-muted">No income records found.</p>
                @endforelse
            </div>
        </div>

        {{-- Expense --}}
        <div class="col-md-6 col-sm-12 mb-4">
            <h2>Expense</h2>
            <div class="budget-info-list expenses">
                @forelse($expenses as $expense)
                    <div class="item clearfix d-flex justify-content-between align-items-center p-2 border rounded mb-2">
                        <div>{{ $expense->description }}</div>
                        <div class="d-flex align-items-center gap-2">
                            <div>{{ $expense->amount }}</div>
                            <button type="button" class="btn btn-link text-danger p-0" data-toggle="modal" data-target="#deleteExpenseModal{{ $expense->id }}">
                                <i class="fal fa-times-circle"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Delete Expense Modal --}}
                    <div class="modal fade" id="deleteExpenseModal{{ $expense->id }}" tabindex="-1" aria-labelledby="deleteExpenseLabel{{ $expense->id }}" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteExpenseLabel{{ $expense->id }}">Delete {{ $expense->description }} Expense</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <form action="{{ route('delete_personal_expense', $expense->id) }}" method="POST">
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
                    <p class="text-muted">No expense records found.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>

@endsection
