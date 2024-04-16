<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DayResource;
use Illuminate\Http\Response;
use App\Models\Day;

class DayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Day::all();
        return DayResource::collection(Day::all());
        // return DayResource::collection(Day::with('lessons')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Day $day)
    {
       
        return new DayResource($day);
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
    public function destroy(Day $day)
    {
        // $day->delete();
        // return response(null, Response::HTTP_NO_CONTENT);
    }
}
