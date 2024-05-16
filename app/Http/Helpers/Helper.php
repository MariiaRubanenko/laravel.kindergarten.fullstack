<?php
namespace App\Http\Helpers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Helper{


    public static function sendError($message, $errors=[], $code = 422){
        // $response= ['success'=> false, 'error'=> $message];

        if(!empty($errors)){
            $response['data']= $errors;
        }

        throw new HttpResponseException(response()->json($response,$code));
    }


    public static function processImage(Request $request, &$data)
    {
        // $image = $request->file('image');
        // dd($image);

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


         else {
        // Если изображение не было загружено, добавляем поля с null значениями
        $data['image_name'] = null;
        $data['image_data'] = null;
    }
    }

    public static function processBase64Image(Request $request, &$data)
{

    if ($request->hasFile('image')) {
    // Розбиваємо рядок base64 на дві частини: тип даних і саме зображення
    $base64Image = $request->input('image');

    $imageParts = explode(";base64,", $base64Image);
    $imageTypeAux = explode("image/", $imageParts[0]);
    $imageType = $imageTypeAux[1];
    $imageData = base64_decode($imageParts[1]);

    // Генеруємо унікальне ім'я файлу
    $imageName = 'image_' . time() . '.' . $imageType;

    // Зберігаємо ім'я файлу та дані зображення в масиві даних для збереження
    $data['image_name'] = $imageName;
    $data['image_data'] = $imageData;
    }else {
        // Если изображение не было загружено, добавляем поля с null значениями
        $data['image_name'] = null;
        $data['image_data'] = null;
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

