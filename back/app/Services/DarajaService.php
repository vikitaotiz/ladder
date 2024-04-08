<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class DarajaService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://sandbox.safaricom.co.ke/',
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->generateAccessToken(),
            ],
        ]);
    }

    public function generateAccessToken()
    {
// $ch = curl_init('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
// curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer cFJZcjZ6anEwaThMMXp6d1FETUxwWkIzeVBDa2hNc2M6UmYyMkJmWm9nMHFRR2xWOQ==']);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// $response = curl_exec($ch);
// curl_close($ch);
// echo $response;
$ch = curl_init('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
curl_setopt_array(
    $ch,
    array(
        CURLOPT_HTTPHEADER => ['Content-Type: application/json; charset=utf8'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_USERPWD => 'AmYRXBx9pATxdK824n0XFlZ6pnzjtC0QEZr1NEabiEdGaRM0'. ':' . 'POxJOctMwX2MHo65M8VfQJvUxitKopHAIA3kRp5Yvw0JhMc2h6gyPMHmSG5ZorG3'
    )
    );
    $response = json_decode(curl_exec($ch));
    curl_close($ch);

// $response = Http::post('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials', [
//             'json' => [
//                 'grant_type' => 'client_credentials',
//                 'client_id' => 'AmYRXBx9pATxdK824n0XFlZ6pnzjtC0QEZr1NEabiEdGaRM0',
//                 'client_secret' => 'POxJOctMwX2MHo65M8VfQJvUxitKopHAIA3kRp5Yvw0JhMc2h6gyPMHmSG5ZorG3',
//             ],
//         ]);

        if (!empty($response)) {
            // Output a message indicating that payload is received
            echo "JSON Payload Received:\n";
            echo json_encode($response, JSON_PRETTY_PRINT) . "\n";
        }
        $access_token = $response->access_token;
        return $access_token ;
    }
// public function STKPush(Request $request)
public function lipaNaMpesa($amount, $phoneNumber)

{

    // Generate the access token
    $access_token = $this->generateAccessToken();

    // // Extract request data
    // $amount = $request->input('amount');
    // $phonenumber = $request->input('phonenumber');
    // $account_number = $request->input('account_number');
$shortcode = 174379;
        $passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $timestamp = now()->format('YmdHis');
$password = base64_encode($shortcode . $passkey . $timestamp);

    // Prepare STK Push parameters
    $stk_push_data = [
        "BusinessShortCode" => 174379,
'Password' => $password,
        "Timestamp" => $timestamp,
        "TransactionType" => "CustomerPayBillOnline",
        "Amount" => 1,
        "PartyA" => 254701581799,
        "PartyB" => 174379,
        "PhoneNumber" => 254701581799,
        "CallBackURL" => "https://pusher.gorvic.co.ke/public",
        "AccountReference" => "CompanyXLTD",
        "TransactionDesc" => "Payment of X"
    ];

    // Convert data to JSON
    $payload = json_encode($stk_push_data);

    // Prepare cURL request
    $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
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

    // Return the response
    return $response;
}

//     public function lipaNaMpesa($amount, $phoneNumber)
//     {

//          $access_token = $this->generateAccessToken();



//         $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
//         curl_setopt($ch, CURLOPT_HTTPHEADER, [
//         'Authorization: Bearer ' . $access_token,
//         'Content-Type: application/json'
//     ]);
//         curl_setopt($ch, CURLOPT_POST, 1);
// $data = json_encode(array(
//     "BusinessShortCode" => 174379,
//     "Password" => "MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMjQwNDA4MTQxNjE3",
//     "Timestamp" => "20240408141617",
//     "TransactionType" => "CustomerPayBillOnline",
//     "Amount" => 1,
//     "PartyA" => 254708374149,
//     "PartyB" => 174379,
//     "PhoneNumber" => 254708374149,
//     "CallBackURL" => "https://mydomain.com/path",
//     "AccountReference" => "CompanyXLTD",
//     "TransactionDesc" => "Payment of X" 
// ));
// curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//         $response     = curl_exec($ch);
//         curl_close($ch);
//         echo $response;

// if (!empty($response)) {
//             // Output a message indicating that payload is received
//             echo "JSON Payload Received:\n";
//             echo json_encode($response, JSON_PRETTY_PRINT) . "\n";
//         }


//         // $shortcode = config('services.daraja.shortcode');
//         // $passkey = config('services.daraja.passkey');
//         // $timestamp = now()->format('YmdHis');
//         // $password = base64_encode($shortcode . $passkey . $timestamp);

//         // $response = $this->client->post('mpesa/stkpush/v1/processrequest', [
//         //     'json' => [
//         //         'BusinessShortCode' => $shortcode,
//         //         'Password' => $password,
//         //         'Timestamp' => $timestamp,
//         //         'TransactionType' => 'CustomerPayBillOnline',
//         //         'Amount' => $amount,
//         //         'PartyA' => $phoneNumber,
//         //         'PartyB' => $shortcode,
//         //         'PhoneNumber' => $phoneNumber,
//         //         'CallBackURL' => 'your_callback_url',
//         //         'AccountReference' => 'your_account_reference',
//         //         'TransactionDesc' => 'Payment description',
//         //     ],
//         // ]);

//         return $response->getBody()->getContents();
//     }
}
