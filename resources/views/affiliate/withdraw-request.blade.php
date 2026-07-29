@extends('affiliate.layouts.app')

@section('title', 'Request Withdrawal')

@section('content')
<div class="container py-2 min-vh-100">

    <div class="card shadow-lg rounded-3 mx-auto" style="max-width: 800px;">
        
        <div class="card-header d-flex justify-content-between align-items-center text-success">
            <h5 class="mb-0">Request Withdrawal</h5>
        </div>

        <div class="card-body">

            {{-- Show Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Success Message --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('affiliate.withdraw.store') }}" method="POST" id="withdrawForm">
                @csrf

                <!-- Current Balance -->
                <div class="mb-3">
                    <label for="balance" class="form-label">Current Balance ({{ currency() }})</label>
                    <input type="text" id="balance" name="balance" value="{{ $balance }}" class="form-control" readonly>
                </div>

                <!-- Amount -->
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount ({{ currency() }})</label>
                    <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter amount" required>
                    <small id="amountError" class="text-danger d-none">Amount cannot be greater than your balance!</small>
                </div>

                <!-- Payment Method -->
                <div class="mb-3">
                    <label class="form-label">Payment Method</label>
                    <select name="payment_method" class="form-select" required>
                        <option value="">Select one</option>
                        <option value="bank">Bank Transfer</option>
                        <option value="paypal">PayPal</option>
                        <option value="bkash">Bkash</option>
                        <option value="nagad">Nagad</option>
                        <option value="rocket">Rocket</option>
                        <option value="ssl">SSL</option>
                        <option value="upay">Upay</option>
                        <option value="city_bank">City Bank</option>
                        <option value="prime_bank">Prime Bank</option>
                    </select>
                </div>

                <!-- Payment Info -->
                <div class="mb-3">
                    <label class="form-label">Payment Information</label>
                    <textarea name="payment_info" rows="3" class="form-control" required></textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success text-light">
                        Request Withdrawal
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

{{-- JS Validation for amount --}}
<script>
    document.getElementById('withdrawForm').addEventListener('submit', function(event) {
        let balance = parseFloat(document.getElementById('balance').value);
        let amount  = parseFloat(document.getElementById('amount').value);
        let error   = document.getElementById('amountError');

        if (amount > balance) {
            error.classList.remove('d-none');
            event.preventDefault();
        } else {
            error.classList.add('d-none');
        }
    });
</script>

@endsection
