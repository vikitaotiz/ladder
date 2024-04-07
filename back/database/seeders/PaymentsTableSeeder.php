<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsTableSeeder extends Seeder
{
   
    public function run(): void
    {
        // Generate dummy data for payments table
        for ($i = 0; $i < 10; $i++) {
            DB::table('payments')->insert([
                'result_desc' => 'Result Description ' . ($i + 1),
                'result_code' => 'Result Code ' . ($i + 1),
                'merchant_request_id' => 'Merchant Request ID ' . ($i + 1),
                'checkout_request_id' => 'Checkout Request ID ' . ($i + 1),
                'amount' => rand(100, 1000),
                'mpesa_receipt_number' => 'Mpesa Receipt Number ' . ($i + 1),
                'transaction_date' => now()->subDays($i),
                'phonenumber' => 'Phone Number ' . ($i + 1),
                'account_number' => 'Account Number ' . ($i + 1),
                'created_at' => now()->subDays($i),
                'updated_at' => now()->subDays($i),
            ]);
        }
    }
}


