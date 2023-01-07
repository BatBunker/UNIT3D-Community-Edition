@extends('layout.default')

@section('main')
@if (config('donation.enabled'))
@if (config('donation.ad_hoc_donations_enabled'))
<section class="panelV2">
    <h2 class="panel__heading">Ad-Hoc Donation</h2>
    <div>Please contact the staff to donate if you are facing difficulty.</div>
</section>
@endif
@if (config('donation.btc_enabled'))
<section class="panelV2">
    <h2 class="panel__heading">Bitcoin Donation</h2>
    <div>
        Please send the amount to BTC Address: <strong>{{ config('donation.btc_address') }}</strong>
        and then submit the transaction details here.
    </div>
    <form class="form" action="{{ route('donation.new-btc-donation') }}" method="post">
        @csrf
        <p class="form__group">
            <label class="form__label">Transaction Id</label>
            <input type="text" class="form__text" name="transaction-id" required>
        </p>
        <p class="form__group">
            <label class="form__label">Amount</label>
            <input type="number" class="form__text" name="amount" required>
        </p>
        <p class="form__group">
            <label class="form__label">Remark</label>
            <input type="text" class="form__text" name="remark">
        </p>
        <input type="submit" name="new-btc-donation" value="Submit" class="btn btn-primary">
    </form>
</section>
@endif
@else
<div>Donations are not enabled.</div>
@endif
<section class="panelV2">
    <h2 class="panel__heading">Donation History</h2>
    <table class="data-table">
        <tr>
            <th>Date</th>
            <th>Transaction Id</th>
            <th>Amount</th>
            <th>Currency</th>
            <th>Donotion Remark</th>
            <th>Status</th>
            <th>Verification Remark</th>
        </tr>
        @foreach ($donations as $donation)
        <tr>
            <td>{{ $donation->created_at }}</td>
            <td>{{ $donation->transaction_id }}</td>
            <td>{{ $donation->transaction_amount }}</td>
            <td>{{ $donation->currency_type }}</td>
            <td>{{ $donation->donor_remark }}</td>
            <td>{{ $donation->transaction_status }}</td>
            <td>{{ $donation->verifier_remark }}</td>
        </tr>
        @endforeach
    </table>
</section>
@endsection
