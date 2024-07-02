<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller {
    // public function processPayment(Request $request)
    // {
    //     $response = Http::post('https://api.paystack.co/transaction/initialize', [
    //         'amount_money' => [
    //             'amount' => 10,
    //             'currency' => 'USD'
    //         ],
    //         'source_id' => $request->googlePayToken,
    //     ])->withHeaders([
    //         'Authorization' => 'Bearer' . config('app.square_access_token'),
    //         'Content-Type' => 'application/json',
    //     ]);
    //     return response()->json($response->json());
    // }

    public function index() {
        return view('payment');
    }

    public function processPayment(Request $request) {
        $paymentData = $request->input('paymentData');

        // Validate and process the payment data
        // This is a simplified example, you would handle the response and possible errors properly

        $client   = new Client();
        $response = $client->post('https://payment-processor-url', [
            'headers' => [
                'Authorization' => 'Bearer ' . config('services.google_pay.api_key'),
                'Content-Type'  => 'application/json',
            ],
            'body'    => json_encode($paymentData),
        ]);

        return response()->json(json_decode($response->getBody(), true));
    }
}
