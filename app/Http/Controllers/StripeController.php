<?php

/* namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class StripeController extends Controller
{
    
    public function session(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.sk'));
        $monthlyPayment = $request->input('monthly_payment');
        $family_account_id= $request->input('family_account_id');
        
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
            'mode' => 'payment',
            'success_url' => route('success', $request->all()),
            'cancel_url'  => route('cancel', $request->all()),
        ]);
 
        return response()->json(['url' => $session->url]);
    }
 
        public function success(Request $request)
    {
        $id = $request->input('id_payment');

        Payment::where('id', $id)->update([
            'payment_status' => 'paid',
            'payment_date' => now(),
        ]);

    $sessionId = Auth::id();

    $family_account_id= $request->input('family_account_id');
    $frontendSuccessUrl = 'https://1e18-178-150-111-49.ngrok-free.app/payment/'.$family_account_id;

    $queryParams = http_build_query([
        'message' => "Thanks for your order. You have just completed your payment. The seller will reach out to you as soon as possible.",
        'session_id' => $sessionId, 
        'family_account_id' => $family_account_id,
    ]);

    return redirect()->away($frontendSuccessUrl . '?' . $queryParams);
    }

    public function cancel(Request $request)
    {
        $sessionId = Auth::id();
        $family_account_id= $request->input('family_account_id');

        $frontendCancelUrl = 'https://1e18-178-150-111-49.ngrok-free.app/payment/'.$family_account_id;
        $queryParams = http_build_query([
            'message' => "Your payment has been canceled.",
            'session_id' => $sessionId, 
            'family_account_id' => $family_account_id,
        ]);
    
        return redirect()->away($frontendCancelUrl . '?' . $queryParams);
    }

}
 */

 namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class StripeController extends Controller
{
    
    public function session(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.sk'));
        $monthlyPayment = $request->input('monthly_payment');
        $family_account_id= $request->input('family_account_id');
        
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
            'mode' => 'payment',
            'success_url' => route('success', $request->all()),
            'cancel_url'  => route('cancel', $request->all()),
        ]);
 
        return response()->json(['url' => $session->url]);
    }
 
        public function success(Request $request)
    {
        $id = $request->input('id_payment');

        Payment::where('id', $id)->update([
            'payment_status' => 'paid',
            'payment_date' => now(),
        ]);

    // $sessionId = Auth::id();

    $family_account_id= $request->input('family_account_id');
    $frontendSuccessUrl = env('APP_URl')."/".'payment/'.$family_account_id;

    // $queryParams = http_build_query([
    //     'message' => "Thanks for your order. You have just completed your payment. The seller will reach out to you as soon as possible.",
    //     'session_id' => $sessionId, 
    //     'family_account_id' => $family_account_id,
    // ]);

    // return redirect()->away($frontendSuccessUrl . '?' . $queryParams);

    return redirect($frontendSuccessUrl);
    }

    public function cancel(Request $request)
    {
        // $sessionId = Auth::id();
        $family_account_id= $request->input('family_account_id');

        $frontendCancelUrl = env('APP_URl')."/".'payment/'.$family_account_id;
        // $queryParams = http_build_query([
        //     'message' => "Your payment has been canceled.",
        //     'session_id' => $sessionId, 
        //     'family_account_id' => $family_account_id,
        // ]);
    
        // return redirect()->away($frontendCancelUrl . '?' . $queryParams);

        return redirect($frontendCancelUrl);
    }

}
