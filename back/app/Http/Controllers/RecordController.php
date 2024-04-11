<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Http\Resources\Payments\PaymentResource;

class RecordController extends Controller
{
    // public function index(){
    //     return PaymentResource::collection(Payment::all());
    // }
    public function index(Request $request){
        $resultCode = $request->input('resultCode');

        // Filter payments based on the resultCode parameter
        $payments = Payment::query();

        if ($resultCode !== null) {
            $payments->where('result_code', $resultCode);
            return PaymentResource::collection($payments->get());

        }else{
        return PaymentResource::collection(Payment::all());

        }

    }
}
