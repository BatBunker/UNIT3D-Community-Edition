<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\UserDonation;
use Illuminate\Http\Request;

class DonationsController extends Controller {
    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $user = $request->user();
        $donations = $user->donations()->get();
        return \view('donations.index', [
            'donations' => $donations,
        ]);
    }

    public function newBTCDonation(Request $request): \Illuminate\Http\RedirectResponse
    {
        $user = $request->user();
        $userDonation = new UserDonation();
        $userDonation->transaction_id = $request->input('transaction-id');
        $userDonation->user_id = $user->id;
        $userDonation->currency_type = 'btc';
        $userDonation->receiving_account_details = '';
        $userDonation->transaction_amount = $request->input('amount');
        $userDonation->donor_remark = $request->input('remark');
        $userDonation->save();

        return \to_route('donation.index');
    }
}
