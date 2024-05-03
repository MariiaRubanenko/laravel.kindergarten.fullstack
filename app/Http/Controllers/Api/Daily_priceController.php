<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Daily_priceResource;
use App\Models\Daily_price;
use App\Http\Requests\Daily_priceRequest;

use App\Models\Family_account;
use App\Models\Attendance;
use Illuminate\Support\Carbon;
use App\Models\Payment;

class Daily_priceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Daily_priceResource::collection(Daily_price::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Daily_priceRequest $request)
    {
        $data = $request->validated();

        try{
        $created_daily_price = Daily_price::create($data);


        $id = $created_daily_price->id;
        $price = $created_daily_price->price;
        $month_id = $created_daily_price->month_id;
    
        // $totalPayment = $this->calculatePayment($id, $price, $month_id);
        $this->calculatePayment($id, $price, $month_id);

    return new Daily_priceResource($created_daily_price);

            } catch (\Exception $e) {

                if ($e instanceof \Illuminate\Database\QueryException && $e->errorInfo[1] === 1062) {
                    return response()->json(['error' => 'Payment for this year and month has already been calculated.'], 400);
                }

                return response()->json(['error' => $e->getMessage()], 400);
            }


    }

//     public function calculatePayment($price, $month_id)
// {
//     $families = Family_account::all();
//     $totalPayment = 0;

//     foreach ($families as $family) {
//         $familyPayment = 0;
//         $children = $family->childProfiles;

//         foreach ($children as $child) {
//             $absencesCount = Attendance::where('child_id', $child->id)
//                 ->whereMonth('date', $month_id) // Шукаємо відсутності за певний місяць
//                 ->count();

//             // Розрахунок оплати за дитину
//             $childPayment = $price * ($daysInMonth - $absencesCount);
//             $familyPayment += $childPayment;
//         }

//         $totalPayment += $familyPayment;
//     }

//     return $totalPayment;
// }



public function calculatePayment($id_daily_price, $price, $month_id)
{
    $year = Carbon::now()->year; // Поточний рік
    $daysInMonth = Carbon::create($year, $month_id)->daysInMonth;

    $families = Family_account::all();
    // $totalPayment = 0;

    foreach ($families as $family) {
        $familyPayment = 0;
        $children = $family->child_profiles;

        foreach ($children as $child) {
            $absencesCount = Attendance::where('child_profile_id', $child->id)
                ->whereMonth('date', $month_id)
                ->whereYear('date', $year)
                ->count();

            $childPayment = $price * ($daysInMonth - $absencesCount);
            $familyPayment += $childPayment;
        }

         // Створення запису у таблиці payments
         Payment::create([
            'monthly_payment' => $familyPayment,
            'daily_price_id' => $id_daily_price,
            'family_account_id' => $family->id,
        ]);

        // $totalPayment += $familyPayment;
    }

    // return $totalPayment;
}



    /**
     * Display the specified resource.
     */
    public function show(Daily_price $daily_price)
    {
        return new Daily_priceResource($daily_price);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
