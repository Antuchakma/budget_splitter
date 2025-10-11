@extends('base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/transaction_history.css') }}">
@endsection

@section('content')

{{-- Page Header --}}
<div class="container-fluid bg-primary text-white py-4 mb-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0">
                    <i class="fas fa-history mr-2"></i>
                    Transaction History
                </h1>
                <p class="mb-0 mt-2">View all your transactions across all rooms</p>
            </div>
            <div class="col-md-4">
                {{-- Statistics Cards --}}
                <div class="row text-center">
                    <div class="col-4">
                        <div class="stat-card">
                            <h4>{{ $totalPaidTransactions }}</h4>
                            <small>Paid</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-card">
                            <h4>{{ $totalSplitTransactions }}</h4>
                            <small>Split</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-card">
                            <h4>{{ number_format($totalPaid) }}</h4>
                            <small>Total Paid</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    {{-- Back Button --}}
    <div class="mb-3">
        <button type="button" class="btn btn-outline-secondary" onclick="history.back()">
            <i class="fas fa-arrow-left"></i> Back
        </button>
    </div>

    {{-- Search Form --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <form method="GET" action="{{ route('transaction_history') }}">
                <div class="input-group">
                    <input type="search" name="q" class="form-control" 
                           placeholder="Search by reason, room, or payer..." 
                           value="{{ request('q') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        @if(request('q'))
                            <a href="{{ route('transaction_history') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Transactions List --}}
    <div class="row">
        @forelse($allTransactions as $transaction)
            <div class="col-lg-4 col-md-6 col-12 mb-4">
                <div class="card transaction-card h-100 
                    @if($transaction->payer_id == Auth::id()) 
                        border-success 
                    @else 
                        border-info 
                    @endif">
                    
                    {{-- Card Header --}}
                    <div class="card-header 
                        @if($transaction->payer_id == Auth::id()) 
                            bg-success text-white 
                        @else 
                            bg-info text-white 
                        @endif">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">
                                @if($transaction->payer_id == Auth::id())
                                    <i class="fas fa-credit-card mr-1"></i> You Paid
                                @else
                                    <i class="fas fa-users mr-1"></i> You Split
                                @endif
                            </h6>
                            <small>{{ $transaction->created_at->format('M d, Y') }}</small>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="card-body">
                        <h5 class="card-title">{{ $transaction->reason }}</h5>
                        
                        <div class="transaction-details">
                            <div class="detail-row">
                                <strong>Amount:</strong>
                                <span class="amount">{{ number_format($transaction->amount, 2) }}</span>
                            </div>
                            
                            <div class="detail-row">
                                <strong>Room:</strong>
                                <span>{{ $transaction->room->name }}</span>
                            </div>
                            
                            <div class="detail-row">
                                <strong>Paid by:</strong>
                                <span>
                                    @if($transaction->payer_id == Auth::id())
                                        You
                                    @else
                                        {{ $transaction->payer->name }}
                                    @endif
                                </span>
                            </div>
                            
                            <div class="detail-row">
                                <strong>Splitters:</strong>
                                <span>{{ $transaction->splitters->count() }} people</span>
                            </div>

                            @if($transaction->payer_id != Auth::id())
                                <div class="detail-row">
                                    <strong>Your share:</strong>
                                    <span class="text-warning">
                                        {{ number_format($transaction->amount / $transaction->splitters->count(), 2) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <small class="text-muted">
                            <i class="fas fa-clock mr-1"></i>
                            {{ $transaction->created_at->format('M d, Y - g:i A') }}
                        </small>
                    </div>

                    {{-- Card Footer --}}
                    <div class="card-footer">
                        <a href="{{ route('transaction_details', ['pk' => $transaction->id]) }}" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye mr-1"></i> View Details
                        </a>
                        <a href="{{ route('room_detail', ['pk' => $transaction->room->id]) }}" 
                           class="btn btn-outline-secondary btn-sm ml-2">
                            <i class="fas fa-home mr-1"></i> Go to Room
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                    @if(request('q'))
                        <h4>No transactions found matching "{{ request('q') }}"</h4>
                        <p class="text-muted">Try a different search term or <a href="{{ route('transaction_history') }}">view all transactions</a></p>
                    @else
                        <h4>No transaction history yet</h4>
                        <p class="text-muted">Start creating transactions in your rooms to see your history here</p>
                        <a href="{{ route('room_list') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i> Go to Rooms
                        </a>
                    @endif
                </div>
            </div>
        @endforelse
    </div>
</div>

@endsection