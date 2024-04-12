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
        $resultCode = $request->query('resultCode');
   
        if ((int)$resultCode === 2) {
            // Fetch all records if $resultCode is 2
            $payments = Payment::all();
        } else if ($resultCode === "null")
         {
            // Fetch records based on the provided $resultCode
            $payments = Payment::where('result_code', null)->get();
        }
        else {
            // Fetch records based on the provided $resultCode
            $payments = Payment::where('result_code', $resultCode)->get();
        }
        // Return the collection using PaymentResource
        return PaymentResource::collection($payments);
    }
}
