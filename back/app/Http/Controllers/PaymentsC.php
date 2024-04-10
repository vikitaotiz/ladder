<?php

namespace App\Http\Controllers;

use App\Services\DarajaService;
use Illuminate\Http\Request;
use App\Mpesa\STKPush;
use App\Models\Payment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PaymentsC extends Controller
{
    protected $darajaService;
    public $result_code = 1;
    public $result_desc = 'An error occured';


    public function __construct(DarajaService $darajaService)
    {
        $this->darajaService = $darajaService;
    }

    public function initiatePayment(Request $request)
    {
        $amount = $request->input('amount');
        $phonenumber = $request->input('phonenumber');
        $account_number = $request->input('account_number');


        try {
            /***********************************************************/
            DB::beginTransaction(); // Begining of a laravel transaction
            /***********************************************************/
            $response = $this->darajaService->lipaNaMpesa($phonenumber, $amount, $account_number);
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

        }
        catch(\Exception $exp) {

            /*****************************************/
            DB::rollBack(); // Rollback
            /*****************************************/

            return response([
                'message' => $exp->getMessage(),
                'status' => 'error'
            ], 400);
        }

    }


    // public function STKConfirm(Request $request)
    // {
    //     $stk_push_confirm = (new STKPush())->confirm($request);
    //            
    //     Storage::disk('public')->put('test_me.json', $request->getContent());

    //     if ($stk_push_confirm) {
    //         $this->result_code = 0;
    //         $this->result_desc = 'Success';
    //     }

    //     return response()->json([
    //         'ResultCode' => $this->result_code,
    //         'ResultDesc' => $this->result_desc
    //     ]);
    // }

    public function STKConfirm(Request $request)
{
    $stk_push_confirm = (new STKPush())->confirm($request);
    
    // Get the raw request body
    $data = $request->getContent();
    
    // Store the raw request body in a file for reference
    Storage::disk('public')->put('stk.txt', $data);
    
    // Decode the JSON data
    $payload = json_decode($data, true);
    
    // Check if the payload contains callback metadata
    if (isset($payload['Body']) && isset($payload['Body']['stkCallback'])) {
        $callback_metadata = $payload['Body']['stkCallback']['CallbackMetadata'];
        
        // Store the callback metadata in a file for reference
        Storage::disk('public')->put('callback_metadata.json', json_encode($callback_metadata));
    }
    else{
        echo "not found";
    }
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
