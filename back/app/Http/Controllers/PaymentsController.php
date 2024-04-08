<?php

namespace App\Http\Controllers;

use App\Mpesa\STKPush;
use App\Models\Payment;
use Iankumu\Mpesa\Facades\Mpesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{
    public $result_code = 1;
    public $result_desc = 'An error occured';

    // Initiate  Stk Push Request
    public function STKPush(Request $request)
    {
        $amount = $request->input('amount');
        $phonenumber = $request->input('phonenumber');
        $account_number = $request->input('account_number');

        try {
            /***********************************************************/
            DB::beginTransaction(); // Begining of a laravel transaction
            /***********************************************************/

            $response = Mpesa::stkpush($phonenumber, $amount, $account_number);
            $result = json_decode((string)$response, true);


    if (!empty($result)) {
            // Output a message indicating that payload is received
            echo "JSON Payload Received:\n";
            echo json_encode($result, JSON_PRETTY_PRINT) . "\n";
        }


            Payment::create([
                'merchant_request_id' =>  $result['MerchantRequestID'],
                'checkout_request_id' =>  $result['CheckoutRequestID'],
                'result_desc' =>  $result['ResponseDescription'],
                'phonenumber' => $phonenumber,
                'amount' => $amount,
                'account_number' => $account_number
            ]);

            /******************************************/
            DB::commit(); // End of database transactions (Success)
            /******************************************/

            return $result;

        } catch(\Exception $exp) {

            /*****************************************/
            DB::rollBack(); // Rollback
            /*****************************************/

            return response([
                'message' => $exp->getMessage(),
                'status' => 'error'
            ], 400);
        }
    }


    // This function is used to review the response from Safaricom once a transaction is complete
    public function STKConfirm(Request $request)
    {
        $stk_push_confirm = (new STKPush())->confirm($request);

        Storage::disk('public')->put('test_me.json', $request->getContent());

        if ($stk_push_confirm) {
            $this->result_code = 0;
            $this->result_desc = 'Success';
        }

        return response()->json([
            'ResultCode' => $this->result_code,
            'ResultDesc' => $this->result_desc
        ]);
    }
}
