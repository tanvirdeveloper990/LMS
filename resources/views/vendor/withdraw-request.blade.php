@extends('vendor.layouts.app')

@section('title', 'Request Withdrawal')

@section('content')
<section class="py-5 bg-light min-vh-100">
    <div class="container">
        <div class="bg-white rounded-3 shadow-lg overflow-hidden">

            <!-- Header -->
            <div class="px-4 py-3 d-flex justify-content-between align-items-center bg-gradient-purple text-white">
                <h2 class="h5 mb-0">Request Withdrawal</h2>
            </div>

            <!-- Withdrawal Form -->
            <div class="p-4 border border-light">
                <form action="{{ route('vendor.withdrawal.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">

                        <!-- Current Balance -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Current Balance ({{ currency() }})</label>
                            <input type="number" readonly step="0.01" name="balance" id="balance"
                                value="{{ $balance }}" class="form-control">
                        </div>

                        <!-- Requested Amount -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Requested Amount ({{ currency() }})</label>
                            <input type="number" step="0.01" name="request_amount" id="request_amount"
                                class="form-control" placeholder="Enter amount" required>
                        </div>

                        <!-- Commission -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Commission (%)</label>
                            <input type="number" step="0.01" readonly name="commission" id="commission"
                                value="{{ $commissions->vendor_commission }}" class="form-control">
                        </div>

                        <!-- Payable Amount -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Payable Amount ({{ currency() }})</label>
                            <input type="number" readonly step="0.01" name="payable_amount" id="payable_amount"
                                class="form-control">
                        </div>

                        <!-- Payment Method -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-select">
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
                        <div class="col-12">
                            <label class="form-label fw-semibold">Payment Information</label>
                            <textarea name="payment_info" id="payment_info" rows="3"
                                class="form-control" placeholder="Enter payment details" required></textarea>
                        </div>

                    </div>

                    <!-- Submit Button -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-success px-4 py-2">
                            Request Withdrawal
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</section>
@endsection


@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const balanceInput = document.getElementById('balance');
        const requestInput = document.getElementById('request_amount');
        const commissionInput = document.getElementById('commission');
        const payableInput = document.getElementById('payable_amount');

        function calculatePayable() {
            let balance = parseFloat(balanceInput.value) || 0;
            let requestAmount = parseFloat(requestInput.value) || 0;
            let commissionPercent = parseFloat(commissionInput.value) || 0;

            // Requested amount cannot exceed balance
            if (requestAmount > balance) {
                requestAmount = balance;
                requestInput.value = requestAmount.toFixed(2);
            }

            // Commission calculation
            let commissionAmount = (commissionPercent / 100) * requestAmount;

            // Payable amount
            let payable = requestAmount - commissionAmount;
            payableInput.value = payable.toFixed(2);
        }

        // Only calculate on blur (focusout)
        requestInput.addEventListener('blur', calculatePayable);

        // Optional: initialize on page load
        calculatePayable();
    });
</script>
@endsection