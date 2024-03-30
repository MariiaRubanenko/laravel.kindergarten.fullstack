<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NoLessonOverlap;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Helpers\Helper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

use Carbon\Carbon;

class LessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'start_time' => [
                'required',
                'date_format:H:i:s',
                // function ($attribute, $value, $fail) {
                //     if (!$this->isAfterEightAM($value)) {
                //         $fail('The ' . $attribute . ' must be a time after 08:00:00.');
                //     }
                // },
                // 'after:08:00:00',
                 //'after_or_equal:08:00:00', // Не раньше 8 утра
                // function ($attribute, $value, $fail) {
                //     if (strtotime($value) < strtotime('08:00:00')) {
                //         $fail('Start time must be after or equal to 08:00:00.');
                //     }
                // },
                // function ($attribute, $value, $fail) {
                //     // Проверяем, что переданное время больше или равно указанному времени
                //     if ($value < '08:00:00') {
                //         $fail('The ' . $attribute . ' must be a time after or equal to 08:00:00.');
                //     }
                // },
                // function ($attribute, $value, $fail) {
                //     $startTime = Carbon::createFromFormat('H:i:s', $value);
                //     $eightAM = Carbon::createFromTime(8, 0, 0);
                //     // Проверяем, что переданное время больше или равно указанному времени
                //     if ($startTime->lessThan($eightAM)) {
                //         $fail('The ' . $attribute . ' must be a time after or equal to 08:00:00.');
                //     }
                // },
                // function ($attribute, $value, $fail) {
                //     $dateTime = date('Y-m-d H:i:s', strtotime($value));
                //     $eightAM = date('Y-m-d H:i:s', strtotime('08:00:00'));
                //     // Проверяем, что переданное время больше или равно указанному времени
                //     if ($dateTime < $eightAM) {
                //         $fail('The ' . $attribute . ' must be a time after or equal to 08:00:00.');
                //     }
                // },
            ],
            'end_time' => [
                'required',
            'date_format:H:i:s',
            'before:18:00:00', 
                // function ($attribute, $value, $fail) {
                //     // Проверяем, что переданное время больше start_time и меньше 18:00:00
                //     if (strtotime($value) <= strtotime($this->start_time)) {
                //         $fail('The ' . $attribute . ' must be a time after the start_time.');
                //     }
                //     if (strtotime($value) >= strtotime('18:00:00')) {
                //         $fail('The ' . $attribute . ' must be a time before 18:00:00.');
                //     }
                // },
               
            ],
            // 'start_time' => ['before:end_time'],

            'group_id' => [
                'required',
                'exists:groups,id',
            ],
            'day_id' => [
                'required',
                'exists:days,id',
            ],
            'action_id' => [
                'required',
                'exists:actions,id',
            ],
          
            // Проверка на отсутствие перекрытия существующих уроков
            'start_time' => ['required', new NoLessonOverlap($this->group_id, $this->day_id, $this->start_time, $this->end_time)],
            'end_time' => ['required', new NoLessonOverlap($this->group_id, $this->day_id, $this->start_time, $this->end_time)],
            
        ];

        


    }

//     protected function isAfterEightAM(string $startTime): bool
// {
//   // Перетворення start_time в об'єкт DateTime
//   $startDateTime = Carbon::parse($startTime);

//   // Створення об'єкта DateTime для 08:00:00
//   $eightAM = Carbon::parse('08:00:00');

//   // Порівняння start_time з 08:00:00
//   return $startDateTime->isAfter($eightAM);
// }

    public function failedValidation(Validator $validator){

        // send error message
        Helper::sendError('validation error', $validator->errors());
    }
}
