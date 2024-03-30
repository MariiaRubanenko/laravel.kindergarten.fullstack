<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LessonRequest;
use App\Models\Lesson;
use App\Http\Helpers\Helper;
use Illuminate\Http\Response;
use Carbon\Carbon;
use App\Http\Resources\LessonResource;
use Illuminate\Database\QueryException;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Lesson::all();
        // $attendances = Attendance::all();
        // return AttendanceResource::collection($attendances);

        $lesson = Lesson::all();
        return LessonResource::collection($lesson);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LessonRequest $request)
    {
        //
        // dd($request->all());
        $data = $request->validated();

        if (!Helper::isValidLessonTime($data['start_time'], $data['end_time'])) {
            return response()->json(['message' => 'Start time must be after 08:00:00, end time must be before 18:00:00, and end time must be greater than start time.'], 400);
        }

        try{
            $lesson = Lesson::create($data);
            return response()->json(['message' => 'Lesson  created successfully', 'group_id' => $lesson->group_id], 201, [], JSON_UNESCAPED_UNICODE);


    } catch (\Exception $e) {

        if ($e instanceof \Illuminate\Database\QueryException && $e->errorInfo[1] === 1062) {
            return response()->json(['error' => 'A lesson with the same day, action, and group already exists.'], 400);
        }

        return response()->json(['error' => $e->getMessage()], 400);
        // abort(400, $e->getMessage());
    }
    }


//      function isAfterEightAM(string $startTime): bool
// {
//   // Перетворення start_time в об'єкт DateTime
//   $startDateTime = Carbon::parse($startTime);

//   // Створення об'єкта DateTime для 08:00:00
//   $eightAM = Carbon::parse('08:00:00');

//   // Порівняння start_time з 08:00:00
//   return $startDateTime->isAfter($eightAM);
// }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // return Lesson::findOrFail($id);

        $lesson =Lesson::findOrFail($id);
    return new LessonResource($lesson);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LessonRequest $request, Lesson $lesson)
    {
        //
        $data = $request->validated();

        try{
            $lesson->update($data);


        return new LessonResource($lesson);
    } catch (\Exception $e) {

        if ($e instanceof \Illuminate\Database\QueryException && $e->errorInfo[1] === 1062) {
            return response()->json(['error' => 'A lesson with the same day, action, and group already exists.'], 400);
        }

        return response()->json(['error' => $e->getMessage()], 400);
    }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        
        $lesson->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
