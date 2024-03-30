<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceRequest;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $attendances = Attendance::all();
        return AttendanceResource::collection($attendances);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttendanceRequest $request)
    {

        $data = $request->validated();

        try{


        $attendance= Attendance::create($data);
        return response()->json(['message' => 'Absence noted: ', 'date' => $attendance->date], 201, [], JSON_UNESCAPED_UNICODE);
        //$trusted_person=Trusted_person::create($data);
        }catch (\Exception $e) {

            if ($e instanceof \Illuminate\Database\QueryException && $e->errorInfo[1] === 1062) {
                return response()->json(['error' => 'The child\'s absence on this day has already been noted.'], 400);
            }

            return response()->json(['error' => $e->getMessage()], 400);
        }
        // $created_attendance = Attendance::create($request->all());
        // return new AttendanceResource($created_attendance); 
    }
 
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // return Attendance::findOrFail($id);
        $attendance = Attendance::findOrFail($id);
    return new AttendanceResource($attendance);
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
    public function destroy(Attendance $attendance)
    {
        //
        $attendance->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    
}
