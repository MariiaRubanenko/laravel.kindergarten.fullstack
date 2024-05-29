<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceRequest;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Models\Child_profile;

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
        }catch (\Exception $e) {

            if ($e instanceof \Illuminate\Database\QueryException && $e->errorInfo[1] === 1062) {

                return response()->json(['error' => 'The child\'s absence on this day has already been noted.'], 400);
            }

            return response()->json(['error' => $e->getMessage()], 400);
        }
        
    }
 
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       
        $attendance = Attendance::findOrFail($id);
    return new AttendanceResource($attendance);
    }

    public function absentChildrenByGroupAndDate($group_id, $date)
{

    
    $absentChildren = Attendance::where('date', $date)
        ->whereHas('child_profile', function ($query) use ($group_id) {
            $query->where('group_id', $group_id);
        })
        ->with('child_profile') 
        ->get();

   
    $absentChildrenData = $absentChildren->map(function ($attendance) {
        return [
            'name' => $attendance->child_profile->name,
            'reason' => $attendance->reason,
        ];
    });

    return response()->json($absentChildrenData);

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
