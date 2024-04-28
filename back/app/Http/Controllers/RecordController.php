<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Http\Resources\Payments\PaymentResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RecordController extends Controller
{
    public function index()
    {

        $sevenDaysAgo = Carbon::now()->subDays(7);
        $currentDate = Carbon::today();


        $all = PaymentResource::collection(Payment::all());
        $pendingPayments = PaymentResource::collection(Payment::where('result_code', null)->get());
        $succPayments = PaymentResource::collection(Payment::where('result_code', '0')->get());
        $unsuccPayments = PaymentResource::collection(Payment::where('result_code', '1')->get());


        $nullCodeToday = Payment::whereNull('result_code')
            ->whereDate('created_at', $currentDate)
            ->count();
        $code1Today = Payment::where('result_code', 1)
            ->whereDate('created_at', $currentDate)
            ->count();
        $code423Today = Payment::where('result_code', 423)
            ->whereDate('created_at', $currentDate)
            ->count();
        $code0Today = Payment::where('result_code', 0)
            ->whereDate('created_at', $currentDate)
            ->count();

            $codeResponse = [
              
                [
                    'code' => 'Successful',
                    'count' => $code0Today,
                ],
                [
                    'code' => 'Processing',
                    'count' => $nullCodeToday,
                ],
                [
                    'code' => 'Cancelled',
                    'count' => $code1Today,
                ],
                [
                    'code' => 'Failed',
                    'count' => $code423Today,
                ],
            ];
        $resultCodes = json_encode($codeResponse);

        $sevenDaypayments =  Payment::where('result_code', '0')->whereDate('created_at', '>=', Carbon::today()->subDays(7))->selectRaw('DATE(created_at) as date, SUM(amount) as total_amount')->groupBy('date')->orderBy('date')->get();






        return [
            
            'resultCodes' => $codeResponse,
            'sevenDaypayments' => $sevenDaypayments,
            'all' =>  $all,
            'unsuccPayments' => $unsuccPayments,
            'succPayments' => $succPayments,
            'pendingPayments' => $pendingPayments
        ];
    }
}
