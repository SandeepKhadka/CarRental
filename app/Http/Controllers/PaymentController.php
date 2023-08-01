<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function paymentResponse(Request $request)
    {
        $url = "https://uat.esewa.com.np/epay/transrec";
        $data = [
            'amt' => 100,
            'pdc' => 0,
            'psc' => 0,
            'txAmt' => 0,
            'tAmt' => 100,
            'pid' => 'ee2c3ca1-696b-4cc5-a6be-2c40d929d453',
            'scd' => 'EPAYTEST',
            'su' => 'http://merchant.com.np/page/esewa_payment_success?q=su',
            'fu' => 'http://merchant.com.np/page/esewa_payment_failed?q=fu'
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        curl_close($curl);
        dd($response);
        if ($response === false) {
            // handle cURL error
            $error_message = curl_error($curl);
            curl_close($curl);
            echo "cURL error occurred: " . $error_message;
        } else {
            // handle response
            curl_close($curl);
            echo "Response: " . $response;
        }
    }
}
