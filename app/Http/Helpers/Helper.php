<?php
namespace App\Http\Helpers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Helper{


    public static function sendError($message, $errors=[], $code = 401){
        $response= ['success'=> false, 'message'=> $message];

        if(!empty($errors)){
            $response['data']= $errors;
        }

        throw new HttpResponseException(response()->json($response,$code));
    }


    public static function processImage(Request $request, &$data)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $originalName = $image->getClientOriginalName();
            $extension = $image->extension();
            $imageName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '.' . $extension;
            $imageData = $image->get();

            // Добавляем информацию об изображении к данным для сохранения
            $data['image_name'] = $imageName;
            $data['image_data'] = $imageData;
        }
    }

//     public static  function isAfterEightAM(string $startTime): bool
// {
//   // Перетворення start_time в об'єкт DateTime
//   $startDateTime = Carbon::parse($startTime);

//   // Створення об'єкта DateTime для 08:00:00
//   $eightAM = Carbon::parse('08:00:00');

//   // Порівняння start_time з 08:00:00
//   return $startDateTime->isAfter($eightAM);
// }

public static function isValidLessonTime(string $start_time, string $end_time): bool
{
    $startDateTime = Carbon::parse($start_time);
    $endDateTime = Carbon::parse($end_time);
    $eightAM = Carbon::parse('08:00:00');
    $sixPM = Carbon::parse('18:00:00');

    return $startDateTime->isAfter($eightAM)
        && $endDateTime->isBefore($sixPM)
        && $startDateTime->lt($endDateTime);
}


}

