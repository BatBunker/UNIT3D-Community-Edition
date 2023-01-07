<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\DonationCycle;
use App\Models\UserDonation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;

class DonationsCycleController extends Controller {
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $openDonationCycle = DonationCycle::where('open', true)->first();
        $donatedAmount = $openDonationCycle == null 
            ? 0 
            : UserDonation::where('transaction_status', 'accepted')
                ->where('donation_cycle_id', $openDonationCycle->id)
                ->sum('transaction_amount_usd');
        $pendingDonations = UserDonation::where('transaction_status', 'pending')
            ->with('user')
            ->get();
        return \view('Staff.donations.index', [
            'openDonationCycle' => $openDonationCycle,
            'pendingDonations' => $pendingDonations,
            'donatedAmount' => $donatedAmount,
        ]);
    }

    public function create(Request $request)
    {
        $donationCycle = new DonationCycle();
        $donationCycle->open = true;
        $donationCycle->start_date = Carbon::now();
        $donationCycle->amount_wanted_usd = $request->input('amount_wanted_usd');
        $donationCycle->save();

        return \to_route('staff.donations.index');
    }

    public function verifyDonation(Request $request) 
    {
        $donationId = $request->input('donation-id');
        $verifiedBy = auth()->user()->id;
        $remark = $request->input('remark') ?: 'Thank You!';
        $status = $request->input();
        $currentCycle = DonationCycle::where('open', true)->first()->id;
        if ($status === 'rejected') {
            UserDonation::where('id', $donationId)->update([
                'verified_by' => $verifiedBy,
                'verifier_remark' => $remark,
                'transaction_status' => 'rejected',
                'donation_cycle_id' => $currentCycle,
            ]);
        } else {
            UserDonation::where('id', $donationId)->update([
                'verified_by' => $verifiedBy,
                'verifier_remark' => $remark,
                'transaction_status' => 'accepted',
                'transaction_amount_usd' => $request->input('amount'),
                'donation_cycle_id' => $currentCycle,
            ]);
        }

        // TODO: page should not reload. 
        // instead using js the row should be removed on the page itself.
        return \to_route('staff.donations.index');
    }

    public function close(Request $request)
    {
        $cycleId = $request->input('cycleId');
        DonationCycle::where('id', $cycleId)->first()->update(['open' => false]);
        return \to_route('staff.donations.index');
    }

    /**
     * Returns ratio of (donation made)/(donation expected).
     * If there is no cycle open, then null is returned.
     */
    public static function donationCycleRatio() {
        $openDonationCycle = DonationCycle::where('open', true)->first();
        if ($openDonationCycle == null) {
            return null;
        }
        $donatedAmount = UserDonation::where('transaction_status', 'accepted')
                ->where('donation_cycle_id', $openDonationCycle->id)
                ->sum('transaction_amount_usd');
        $expectedAmount = $openDonationCycle->amount_wanted_usd;
        return $donatedAmount/$expectedAmount;
    }
}

