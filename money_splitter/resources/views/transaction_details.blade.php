@extends('base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/transaction_detail.css') }}">
@endsection

@section('content')

<div class="transaction-detail-page">
    <div class="row">

        {{-- Transaction Image --}}
        <div class="col-lg-6 mb-3">
            <div class="transaction-detail-img-grid">
                <img src="{{ asset('images/undraw_wallet_aym5.svg') }}" alt="" class="transaction-detail-img img-fluid">
            </div>
        </div>

        {{-- Transaction Info --}}
        <div class="col-lg-6 mb-3">
            <div class="container transaction-detail-grid">
                <h2>Transaction details:</h2>

                <div class="transaction-detail-box">
                    <p><i class="fal fa-money-check-edit-alt"></i> Reason:</p>
                    <h3>{{ $transaction->reason }}</h3>
                </div>

                <div class="transaction-detail-box">
                    <p><i class="fas fa-money-check-alt"></i> Amount: </p>
                    <h3>{{ $transaction->amount }}</h3>
                </div>

                <div class="transaction-detail-box">
                    <p><i class="far fa-user-plus"></i> Paid By: </p>
                    <h3>{{ $transaction->payer->name }}</h3>
                </div>

                <div class="transaction-detail-box">
                    <p><i class="far fa-users"></i> Split Type:</p>
                    <h3 class="badge {{ $transaction->split_type === 'custom' ? 'badge-info' : 'badge-secondary' }}">
                        {{ $transaction->split_type === 'custom' ? 'Custom Percentages' : 'Equal Split' }}
                    </h3>
                </div>

                <div class="transaction-detail-box">
                    <p><i class="far fa-users"></i> Splitters & Amounts:</p>
                    @if($transaction->split_type === 'custom' && $transaction->shares)
                        @foreach($transaction->splitters as $splitter)
                            @php
                                $shareAmount = $transaction->getShareAmount($splitter->id);
                                $sharePercentage = $transaction->shares[$splitter->id] ?? 0;
                            @endphp
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h3 class="mb-0">{{ $splitter->name }}</h3>
                                <span class="badge badge-light">
                                    {{ number_format($sharePercentage, 1) }}% - ${{ number_format($shareAmount, 2) }}
                                </span>
                            </div>
                        @endforeach
                    @else
                        @foreach($transaction_splitters_username as $splitter)
                            @php
                                $equalAmount = $transaction->amount / count($transaction->splitters);
                            @endphp
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h3 class="mb-0">{{ $splitter }}</h3>
                                <span class="badge badge-light">
                                    {{ number_format(100 / count($transaction->splitters), 1) }}% - ${{ number_format($equalAmount, 2) }}
                                </span>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="transaction-detail-box">
                    <p><i class="fal fa-calendar-alt"></i> Created at:</p>
                    <h3>{{ $transaction->created_at }}</h3>
                </div>

                {{-- Update Button --}}
                <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#ModalUpdateTransaction">
                    Update
                </button>

            </div>
        </div>
    </div>
</div>

{{-- Update Transaction Modal --}}
<div class="modal fade" id="ModalUpdateTransaction" tabindex="-1" aria-labelledby="ModalUpdateTransactionLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalUpdateTransactionLabel">Update Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('update_transaction', ['pk' => $transaction->room->id, 'id' => $transaction->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="reason">Reason:</label>
                        <input type="text" name="reason" id="reason" class="form-control" value="{{ $transaction->reason }}" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount:</label>
                        <input type="number" name="amount" id="amount" class="form-control" value="{{ $transaction->amount }}" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Select Splitters:</label>
                        @foreach($members_list as $member)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="splitters[]" value="{{ $member->id }}" 
                                    @if(in_array($member->name, $transaction_splitters_username)) checked @endif
                                    id="member{{ $member->id }}">
                                <label class="form-check-label" for="member{{ $member->id }}">
                                    {{ $member->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Update Transaction</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
