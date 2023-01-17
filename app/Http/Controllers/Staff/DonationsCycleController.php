<?php
declare(strict_types=1);

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\DonationCycle;
use App\Models\UserDonation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DonationsCycleController extends Controller {
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $openDonationCycle = DonationCycle::where('open', '=', true)->first();
        $donatedAmount = $openDonationCycle == null
            ? 0
            : UserDonation::where('transaction_status', '=', 'accepted')
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

    public function verifyDonation(Request $request): \Illuminate\Http\RedirectResponse
    {
        $v = validator($request->toArray(), [
            'amount' => 'required'
        ]);
        if ($v->fails()) {
            return back()->withErrors($v);
        }
        $donationId = $request->input('donation-id');
        $verifiedBy = auth()->user()->id;
        $remark = $request->input('remark') ?: 'Thank You!';
        $status = $request->input();
        $currentCycle = DonationCycle::where('open', '=', true)->first()->id;
        $status === 'rejected'
            ? UserDonation::where('id', $donationId)->update([
            'verified_by' => $verifiedBy,
            'verifier_remark' => $remark,
            'transaction_status' => 'rejected',
            'donation_cycle_id' => $currentCycle,
        ])
            : UserDonation::where('id', $donationId)->update([
            'verified_by' => $verifiedBy,
            'verifier_remark' => $remark,
            'transaction_status' => 'accepted',
            'transaction_amount_usd' => $request->input('amount'),
            'donation_cycle_id' => $currentCycle,
        ]);

        // TODO: page should not reload. 
        // instead using js the row should be removed on the page itself.
        return \to_route('staff.donations.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * Close the donation cycle
     */
    public function close(Request $request): \Illuminate\Http\RedirectResponse
    {
        $cycleId = $request->input('cycleId');
        DonationCycle::where('id', $cycleId)->first()->update(['open' => false]);
        return \to_route('staff.donations.index');
    }

}

