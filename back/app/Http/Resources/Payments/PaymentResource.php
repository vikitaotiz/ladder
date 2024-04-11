<?php

namespace App\Http\Resources\Payments;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        console.log("rs");

        return [
            "result_desc" => $this->result_desc,
            "result_code" => $this->result_code,
            "merchant_request_id" => $this->merchant_request_id,
            "checkout_request_id" => $this->checkout_request_id,
            "amount" => $this->amount,
            "mpesa_receipt_number" => $this->mpesa_receipt_number,
            "transaction_date" => $this->transaction_date,
            "phonenumber" => $this->phonenumber,
            "account_number" => $this->account_number,
            "created_at" => $this->created_at->format('h:i:s A, jS D M Y')
        ];
    }
}
