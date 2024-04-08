<?php

namespace App\Http\Controllers;

use App\Services\DarajaService;
use Illuminate\Http\Request;

class PaymentsC extends Controller
{
    protected $darajaService;

    public function __construct(DarajaService $darajaService)
    {
        $this->darajaService = $darajaService;
    }

    public function initiatePayment(Request $request)
    {
        $amount = $request->input('amount');
        $phoneNumber = $request->input('phone_number');

        $response = $this->darajaService->lipaNaMpesa($amount, $phoneNumber);

        return response()->json(['response' => $response]);
    }
}
