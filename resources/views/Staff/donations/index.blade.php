@extends('layout.default')

@section('main')
@if ($openDonationCycle)
<section class="panelV2">
    <h2 class="panel__heading">Donation cycle details</h2>
    <div class="flex flex-col">
        <div class="flex flex-row justify-between">
            <label>Donated Amount</label>
            <strong>{{ $donatedAmount }}$</strong>
        </div>
        <div class="flex flex-row justify-between">
            <label>Expected Amount</label>
            <strong>{{ $openDonationCycle->amount_wanted_usd }}$</strong>
        </div>
    </div>
    <form class="form" action="{{ route('staff.donations.close') }}" method="post">
        @csrf
        <input type="hidden" name="cycleId" value="{{ $openDonationCycle->id }}">
        <input type="submit" value="Close Cycle" class="btn btn-primary">
    </form>
</section>
@else
<section class="panelV2">
    <header class="panel__header">
        <h2 class="panel__heading">Create new donation cycle</h2>
    </header>
    <form class="form" action="{{ route('staff.donations.create') }}" method="post">
        @csrf
        <p class="form__group">
            <label class="form__label">Amount wanted (USD)</label>
            <input type="number" class="form__text" name="amount_wanted_usd" required />
        </p>
        <input type="submit" value="Submit" />
    </form>
</section>
@endif
<section class="panelV2">
    <header class="panel__header">
        <h2 class="panel__heading">Pending transactions</h2>
    </header>
    <table class="data-table">
        <tr>
            <th>Donation Id</th>
            <th>User</th>
            <th>Transaction Id</th>
            <th>Donor Remark</th>
            <th>Currency</th>
            <th>Amount</th>
            <th>Verified Amount (USD)</th>
            <th>Verification Remark</th>
            <th>Verification Result</th>
            <th></th>
        </tr>
        @foreach ($pendingDonations as $donation)
        <tr>
            <td>{{ $donation->id }}</td>
            <td>{{ $donation->user->username }}</td>
            <td>{{ $donation->transaction_id }}</td>
            <td>{{ $donation->donor_remark }}</td>
            <td>{{ $donation->currency_type }}</td>
            <td>{{ $donation->transaction_amount }}</td>
            <td><input type="number" step="any" id="{{ $donation->id }}-amount"></td>
            <td><input type="text" id="{{ $donation->id }}-remark" /></td>
            <td>
                <select id="{{ $donation->id }}-status">
                    <option value="accepted">Accept</option>
                    <option value="rejected">Reject</option>
                </select>
            </td>
            <td>
                <form class="form" action="{{ route('staff.donations.verify-donation') }}" method="post">
                    @csrf
                    <input type="hidden" name="donation-id" value="{{ $donation->id }}" />
                    <input type="hidden" name="status" />
                    <input type="hidden" name="amount" />
                    <input type="hidden" name="remark" />
                    <input type="button" value="Submit" class="btn btn-primary submit-verification-button" />
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</section>
@endsection
@section('javascripts')
<script nonce="{{ HDVinnie\SecureHeaders\SecureHeaders::nonce() }}" crossorigin="anonymous">
    const elements = document.getElementsByClassName('submit-verification-button');
    for (let i = 0; i < elements.length; i++) {
        elements[i].addEventListener("click", setFormValues);
    }

    function setFormValues() {
        const donationId = this.form['donation-id'].value;
        this.form['amount'].value = document.getElementById(donationId + '-amount').value;
        this.form['remark'].value = document.getElementById(donationId + '-remark').value;
        this.form['status'].value = document.getElementById(donationId + '-status').value;
        this.form.submit();
    }
</script>
@endsection
