@extends('affiliate.layouts.app')

@section('title', 'Request Withdrawal')

@section('content')
<div class="container py-2 min-vh-100">

    <div class="card shadow-lg rounded-3 mx-auto" style="max-width: 800px;">
        
        <div class="card-header d-flex justify-content-between align-items-center text-success">
            <h5 class="mb-0">Request Withdrawal</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('affiliate.withdraw-level.store') }}" method="POST">
                @csrf

                <input type="hidden" name="affiliate_id" value="{{ $referalCode }}">

                <!-- Current Balance -->
                <div class="mb-3">
                    <label for="balance" class="form-label">Current Balance ({{ currency() }})</label>
                    <input type="text" id="balance" name="balance" 
                        value="{{ number_format($balance, 2) }}" 
                        class="form-control" readonly>
                </div>

                <!-- Amount -->
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount ({{ currency() }})</label>
                    <input type="number" 
                           name="amount" 
                           id="amount" 
                           class="form-control @error('amount') is-invalid @enderror" 
                           placeholder="Enter amount" required>

                    @error('amount')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Payment Method -->
                <div class="mb-3">
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <select name="payment_method" id="payment_method" class="form-select" required>
                        <option value="">Select Method</option>
                        <option value="bank">Bank Transfer</option>
                        <option value="paypal">PayPal</option>
                        <option value="stripe">Stripe</option>
                        <option value="bkash">Bkash</option>
                        <option value="rocket">Rocket</option>
                        <option value="nagad">Nagad</option>
                        <option value="ssl">SSL</option>
                        <option value="upay">Upay</option>
                        <option value="brac_bank">BRAC Bank</option>
                        <option value="dbbl">Dutch-Bangla Bank (DBBL)</option>
                        <option value="scb">Standard Chartered Bank (SCB)</option>
                        <option value="commercial_bank">Commercial Bank</option>
                        <option value="city_bank">City Bank</option>
                        <option value="exim_bank">EXIM Bank</option>
                        <option value="islami_bank">Islami Bank Bangladesh</option>
                        <option value="mutual_trust_bank">Mutual Trust Bank (MTB)</option>
                        <option value="prime_bank">Prime Bank</option>
                        <option value="southeast_bank">Southeast Bank</option>
                    </select>
                </div>

                <!-- Payment Information -->
                <div class="mb-3">
                    <label for="payment_info" class="form-label">Payment Information</label>
                    <textarea name="payment_info" 
                              id="payment_info" 
                              rows="3" 
                              class="form-control @error('payment_info') is-invalid @enderror" 
                              placeholder="Enter payment details" required></textarea>

                    @error('payment_info')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success text-light">Request Withdrawal</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $('#amount').on('input', function () {
        let balance = parseFloat($('#balance').val().replace(/,/g, ''));
        let amount = parseFloat($(this).val());

        if (amount > balance) {
            alert("❌ Amount cannot be greater than your balance!");
            $(this).val('');
        }
    });
</script>
@endsection
