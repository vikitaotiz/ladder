<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class DarajaService
{
    public function generateAccessToken()
    {
        $ckey = config('services.daraja.consumer_key');
        $csec = config('services.daraja.consumer_secret');
        $ch = curl_init('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt_array(
            $ch,
            array(
                CURLOPT_HTTPHEADER => ['Content-Type: application/json; charset=utf8'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_USERPWD => $ckey . ':' . $csec
            )
        );
        $response = curl_exec($ch);

        // Check for cURL errors
        if ($response === false) {
            $error = curl_error($ch);
            echo "cURL Error: " . $error;
        } else {
            $data = json_decode($response);
            if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
                echo "Invalid JSON response";
            } else {
                $accessToken = $data->access_token;
                echo "Response received: " . $response;
            }
        }
        curl_close($ch);
        return $accessToken;
    }

   public function lipaNaMpesa($phonenumber, $amount, $account_number)
    {
        // Generate the access token
        $access_token = $this->generateAccessToken();
        $shortcode = config('services.daraja.shortcode');
        $passkey = config('services.daraja.passkey');
        // $callback = config('services.daraja.callback');
        $timestamp = now()->format('YmdHis');
        $callback = "https://0255-197-237-154-209.ngrok-free.app/api/v1/confirm_pay";

        $password = base64_encode($shortcode . $passkey . $timestamp);

        // Prepare STK Push parameters
        $stk_push_data = [
            "BusinessShortCode" => $account_number,
            'Password' => $password,
            "Timestamp" => $timestamp,
            "TransactionType" => "CustomerPayBillOnline",
            "Amount" => $amount,
            "PartyA" => $phonenumber,
            "PartyB" => $account_number,
            "PhoneNumber" => $phonenumber,
            "CallBackURL" => $callback,
            "AccountReference" => "CompanyXLTD",
            "TransactionDesc" => "Payment of X"
        ];

        // Convert data to JSON
        $payload = json_encode($stk_push_data);

        // Prepare cURL request
        $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $access_token,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Execute cURL request
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

}
