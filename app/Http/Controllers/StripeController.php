<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class StripeController extends Controller
{
    //
    public function checkout()
    {
        return view('checkout');
    }


    public function session(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.sk'));
        $monthlyPayment = $request->input('monthly_payment');
        // $name = $request->input('name');
        
        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'USD',
                        'product_data' => [
                            "name" => 'Monthly payment for kindergarten',
                        ],
                        'unit_amount'  => ($monthlyPayment * 100), // Перетворення суми у центах
                        // 'unit_amount'  => 1000,
                    ],
                    'quantity'   => 1,
                ],
                 
            ],
            'mode'        => 'payment',
            // 'success_url' => route('success'),
            'success_url' => route('success', $request->all()),
            'cancel_url'  => route('cancel'),
        ]);
 
        return redirect()->away($session->url);
    }
 
    // public function success()
    // {
    //     return "Thanks for you order You have just completed your payment. The seeler will reach out to you as soon as possible";
    // }

    // public function cancel()
    // {
    //     return "Thanks for you order You have just completed your payment. The seeler will reach out to you as soon as possible";
    // }
        public function success(Request $request)
    {
        $id = $request->input('id_payment');

            // Оновлення запису в базі даних
        Payment::where('id', $id)->update([
            'payment_status' => 'paid',
            'payment_date' => now(), // Поточна дата та час
        ]);

        return response()->json([
            'message' => "Thanks for your order. You have just completed your payment. The seller will reach out to you as soon as possible."
        ], 200); 
    }

    public function cancel()
    {
        return response()->json([
            'message' => "Your payment has been canceled."
        ], 200); 
    }

}
