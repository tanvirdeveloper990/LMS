@extends('user.layouts.app')

@section('title', 'Request Withdrawal')

@section('content')
<div class="py-6 px-3 min-h-screen bg-gray-100">

    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-3xl overflow-hidden">

        <!-- Header -->
        <div class="flex justify-between items-center bg-green-50 p-4 border-b border-green-200">
            <h5 class="text-lg font-semibold text-green-700">Request Withdrawal</h5>
        </div>

        <!-- Card Body -->
        <div class="p-6">
            <form action="{{ route('withdraw-level.store') }}" method="POST">
                @csrf

                <input type="hidden" name="affiliate_id" value="{{ $referalCode }}">

                <!-- Current Balance -->
                <div class="mb-4">
                    <label for="balance" class="block text-gray-700 font-semibold mb-1">Current Balance ({{ currency() }})</label>
                    <input type="text" id="balance" name="balance" 
                        value="{{ number_format($balance, 2) }}" 
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 cursor-not-allowed" readonly>
                </div>

                <!-- Amount -->
                <div class="mb-4">
                    <label for="amount" class="block text-gray-700 font-semibold mb-1">Amount ({{ currency() }})</label>
                    <input type="number" 
                           name="amount" 
                           id="amount" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none @error('amount') border-red-500 @enderror" 
                           placeholder="Enter amount" required>

                    @error('amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Method -->
                <div class="mb-4">
                    <label for="payment_method" class="block text-gray-700 font-semibold mb-1">Payment Method</label>
                    <select name="payment_method" id="payment_method" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" required>
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
                <div class="mb-4">
                    <label for="payment_info" class="block text-gray-700 font-semibold mb-1">Payment Information</label>
                    <textarea name="payment_info" 
                              id="payment_info" 
                              rows="3" 
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none @error('payment_info') border-red-500 @enderror" 
                              placeholder="Enter payment details" required></textarea>

                    @error('payment_info')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="text-right">
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">Request Withdrawal</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('amount').addEventListener('input', function () {
        let balance = parseFloat(document.getElementById('balance').value.replace(/,/g, ''));
        let amount = parseFloat(this.value);

        if (amount > balance) {
            alert("❌ Amount cannot be greater than your balance!");
            this.value = '';
        }
    });
</script>
@endsection
