@extends('base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/room_detail.css') }}">
<link rel="stylesheet" href="{{ asset('css/custom_split.css') }}">
@endsection

@section('content')

{{-- Room Header Section --}}
<div class="room-header bg-primary text-white py-5">
    <div class="container text-center">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="{{ asset('images/undraw_group_selfie_ijc6.svg') }}" alt="" class="img-fluid" style="max-height: 300px;">
            </div>
            <div class="col-md-6">
                <h1 class="display-4 mb-3">{{ $room->name }}</h1>
                <h4 class="mb-2">Created by: {{ $room->creater->name }}</h4>
                <p class="mb-4"><strong>{{ $members_count }} members</strong></p>

                {{-- Add Transaction Button --}}
                <button type="button" class="btn btn-light btn-lg mb-2" data-toggle="modal" data-target="#ModalCreateTransaction">
                    Add transactions
                </button>

                {{-- Add Members Button (only for creator) --}}
                @if($creator)
                    <a href="{{ route('list_members', ['pk' => $room->id]) }}" class="btn btn-outline-light btn-lg mb-2 ml-2">
                        Add Members
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Transactions Section --}}
<div class="container my-5">
    <h2 class="mb-4">Transaction:</h2>
    
    @if($transactions->count() > 0)
        <div class="row">
            @foreach($transactions as $transaction)
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card bg-info text-white h-100">
                        <div class="card-body text-center d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h4 class="card-title mb-0">{{ $transaction->reason }}</h4>
                                @if($transaction->split_type === 'custom')
                                    <span class="badge badge-light text-info" title="Custom Split">
                                        <i class="fas fa-percentage"></i>
                                    </span>
                                @else
                                    <span class="badge badge-light text-info" title="Equal Split">
                                        <i class="fas fa-equals"></i>
                                    </span>
                                @endif
                            </div>
                            <h2 class="mb-3">{{ number_format($transaction->amount) }}</h2>
                            <p class="mb-2">Paid by {{ $transaction->payer->name }}</p>
                            <p class="small mb-2">{{ $transaction->created_at->format('M d, Y, g:i a') }}</p>
                            <p class="small mb-3">
                                Split {{ $transaction->split_type === 'custom' ? 'with custom %' : 'equally' }} 
                                among {{ $transaction->splitters->count() }} member(s)
                            </p>
                            <a href="{{ route('transaction_details', ['pk' => $transaction->id]) }}" class="btn btn-light mt-auto">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <p class="text-muted">No transactions yet. Click "Add transactions" to create your first transaction.</p>
        </div>
    @endif
</div>

{{-- Create Transaction Modal --}}
<div class="modal fade" id="ModalCreateTransaction" tabindex="-1" aria-labelledby="ModalCreateTransactionLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalCreateTransactionLabel">Create Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="transactionForm" action="{{ route('create_transaction', $room->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="reason"><i class="fal fa-money-check-edit-alt"></i> Reason:</label>
                        <input type="text" name="reason" id="reason" class="form-control" placeholder="Enter transaction reason" required>
                    </div>

                    <div class="form-group">
                        <label for="amount"><i class="fas fa-money-check-alt"></i> Amount:</label>
                        <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter amount" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label><i class="far fa-users"></i> Split Type:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="split_type" value="equal" id="splitEqual" checked onchange="toggleSplitType()">
                            <label class="form-check-label" for="splitEqual">
                                Equal Split
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="split_type" value="custom" id="splitCustom" onchange="toggleSplitType()">
                            <label class="form-check-label" for="splitCustom">
                                Custom Percentages
                            </label>
                        </div>
                    </div>

                    <div class="form-group" id="splitterSelection">
                        <label><i class="far fa-users"></i> Select Splitters:</label>
                        
                        {{-- Current User (always included) --}}
                        <div class="splitter-item mb-2" data-user-id="{{ Auth::id() }}">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input splitter-checkbox" type="checkbox" name="splitters[]" value="{{ Auth::id() }}" id="splitter{{ Auth::id() }}" checked>
                                        <label class="form-check-label" for="splitter{{ Auth::id() }}">
                                            {{ Auth::user()->name }} (You)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group custom-percentage" style="display: none;">
                                        <input type="number" class="form-control form-control-sm percentage-input" 
                                               name="percentages[{{ Auth::id() }}]" placeholder="%" min="0" max="100" step="0.01">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- All other room participants --}}
                        @foreach($all_participants as $participant)
                            <div class="splitter-item mb-2" data-user-id="{{ $participant->id }}">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input splitter-checkbox" type="checkbox" name="splitters[]" value="{{ $participant->id }}" id="splitter{{ $participant->id }}">
                                            <label class="form-check-label" for="splitter{{ $participant->id }}">
                                                {{ $participant->name }}
                                                @if($participant->id == $room->creater_id)
                                                    (Creator)
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group custom-percentage" style="display: none;">
                                            <input type="number" class="form-control form-control-sm percentage-input" 
                                                   name="percentages[{{ $participant->id }}]" placeholder="%" min="0" max="100" step="0.01">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        @if($all_participants->isEmpty())
                            <p class="text-muted small mt-2">
                                <i class="fas fa-info-circle"></i> 
                                No other members in this room yet. 
                                <a href="{{ route('list_members', ['pk' => $room->id]) }}">Add members</a> to split expenses with them.
                            </p>
                        @endif

                        {{-- Custom Split Helper --}}
                        <div id="customSplitHelper" style="display: none;" class="mt-3">
                            <div class="alert alert-info">
                                <small>
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Custom Split:</strong> Enter percentage for each selected member. Total should equal 100%.
                                    <span id="totalPercentage" class="badge badge-primary ml-2">0%</span>
                                </small>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="distributeEqually()">
                                <i class="fas fa-equals"></i> Distribute Equally
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Create Transaction</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleSplitType() {
    const splitType = document.querySelector('input[name="split_type"]:checked').value;
    const customPercentages = document.querySelectorAll('.custom-percentage');
    const customHelper = document.getElementById('customSplitHelper');
    
    if (splitType === 'custom') {
        customPercentages.forEach(el => el.style.display = 'block');
        customHelper.style.display = 'block';
        // Enable only checked splitters' percentage inputs
        updatePercentageInputs();
    } else {
        customPercentages.forEach(el => el.style.display = 'none');
        customHelper.style.display = 'none';
        // Clear percentage values
        document.querySelectorAll('.percentage-input').forEach(input => input.value = '');
    }
    calculateTotalPercentage();
}

function updatePercentageInputs() {
    const checkboxes = document.querySelectorAll('.splitter-checkbox');
    checkboxes.forEach(checkbox => {
        const splitterItem = checkbox.closest('.splitter-item');
        const percentageInput = splitterItem.querySelector('.percentage-input');
        
        if (checkbox.checked) {
            percentageInput.disabled = false;
            percentageInput.required = document.querySelector('input[name="split_type"]:checked').value === 'custom';
        } else {
            percentageInput.disabled = true;
            percentageInput.required = false;
            percentageInput.value = '';
        }
    });
    calculateTotalPercentage();
}

function calculateTotalPercentage() {
    const percentageInputs = document.querySelectorAll('.percentage-input:not(:disabled)');
    let total = 0;
    
    percentageInputs.forEach(input => {
        const value = parseFloat(input.value) || 0;
        total += value;
    });
    
    const totalSpan = document.getElementById('totalPercentage');
    if (totalSpan) {
        totalSpan.textContent = total.toFixed(2) + '%';
        totalSpan.className = 'badge ml-2 ' + (total === 100 ? 'badge-success' : total > 100 ? 'badge-danger' : 'badge-primary');
    }
}

function distributeEqually() {
    const enabledInputs = document.querySelectorAll('.percentage-input:not(:disabled)');
    const count = enabledInputs.length;
    
    if (count > 0) {
        const equalPercentage = (100 / count).toFixed(2);
        enabledInputs.forEach(input => {
            input.value = equalPercentage;
        });
        calculateTotalPercentage();
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Add change listeners to splitter checkboxes
    document.querySelectorAll('.splitter-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updatePercentageInputs();
        });
    });
    
    // Add input listeners to percentage inputs
    document.querySelectorAll('.percentage-input').forEach(input => {
        input.addEventListener('input', calculateTotalPercentage);
    });
    
    // Form validation
    document.getElementById('transactionForm').addEventListener('submit', function(e) {
        const splitType = document.querySelector('input[name="split_type"]:checked').value;
        
        if (splitType === 'custom') {
            const total = document.querySelectorAll('.percentage-input:not(:disabled)')
                .reduce((sum, input) => sum + (parseFloat(input.value) || 0), 0);
            
            if (Math.abs(total - 100) > 0.01) {
                e.preventDefault();
                alert('Custom percentages must total exactly 100%. Current total: ' + total.toFixed(2) + '%');
                return false;
            }
        }
    });
});
</script>

@endsection
