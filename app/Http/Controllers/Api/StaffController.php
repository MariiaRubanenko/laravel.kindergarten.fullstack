<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StaffResource;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Http\Requests\StaffRequest;
use Illuminate\Http\Response;
use App\Http\Helpers\Helper;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return GroupResource::collection(Group::all());
        return StaffResource::collection(Staff::all());
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
    public function show(Staff $staff)
    {
        //
        return new StaffResource($staff);
    }

    /**
     * Update the specified resource in storage.
     * 
     * 
     */

    public function update(StaffRequest $request, Staff $staff)
    {
        //


        $data = $request->validated();
        try{

            Helper::processImage($request, $data);

        $staff->update($request->validated());

        return new StaffResource($staff);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        // 
        $staff->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
} 