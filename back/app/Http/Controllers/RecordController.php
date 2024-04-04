<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Http\Resources\Payments\PaymentResource;

class RecordController extends Controller
{
    public function index(){
        return PaymentResource::collection(Payment::all());
    }
}
