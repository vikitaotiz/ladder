<?php

namespace App\Mpesa;

use App\Models\Payment;
use Illuminate\Http\Request;

// This Class is responsible for getting a response from Safaricom and Storing the Transaction Details to the Database
class STKPush
{
    public $failed = false;
    public $response = 'An Unkown Error Occured';

    public function confirm(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        if (isset($payload['Body']) && $payload['Body']['stkCallback']['ResultCode'] == '0') {
            $merchant_request_id = $payload['Body']['stkCallback']['MerchantRequestID'];
            $checkout_request_id = $payload['Body']['stkCallback']['CheckoutRequestID'];
            $result_desc = $payload['Body']['stkCallback']['ResultDesc'];
            $result_code = $payload['Body']['stkCallback']['ResultCode'];

            $items = collect($payload['Body']['stkCallback']['CallbackMetadata']['Item']);

            $amount = $items->firstWhere('Name', 'Amount')['Value'];
            $mpesa_receipt_number = $items->firstWhere('Name', 'MpesaReceiptNumber')['Value'];
            $transaction_date = $items->firstWhere('Name', 'TransactionDate')['Value'];
            $phonenumber = $items->firstWhere('Name', 'PhoneNumber')['Value'];

            $stkPush = Payment::where('merchant_request_id', $merchant_request_id)
                ->where('checkout_request_id', $checkout_request_id)->first();

            $data = [
                'result_desc' => $result_desc,
                'result_code' => $result_code,
                'merchant_request_id' => $merchant_request_id,
                'checkout_request_id' => $checkout_request_id,
                'amount' => $amount,
                'mpesa_receipt_number' => $mpesa_receipt_number,
                'transaction_date' => $transaction_date,
                'phonenumber' => $phonenumber,
            ];

            if ($stkPush) {
                $stkPush->fill($data)->save();
            } else {
                Payment::create($data);
            }
        } else {
            $this->failed = true;
        }
        return $this;
    }
}