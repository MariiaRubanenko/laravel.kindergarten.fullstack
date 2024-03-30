<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Helpers\Helper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;


class AttendanceRequest extends FormRequest
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


    //  Validator::extend('allowed_date', function ($attribute, $value, $parameters, $validator) {
    //     $value = \Illuminate\Support\Carbon::parse($value); // Перетворюємо значення на Carbon
    
    //     $allowedTime = now()->startOfDay()->addHours(10);
    //     return now()->lt($allowedTime) ? $value->lt($allowedTime) : $value->lte($allowedTime->addDay());
    // });

    public function rules(): array
    {
    //     $yesterday = now()->subDay()->startOfDay();
    // $today = now()->startOfDay()->addHours(10);
    // $tomorrow = now()->addDay()->startOfDay();

    //     ValidatorFacade::extend('valid_date', function ($attribute, $value, $parameters, $validator) use ($yesterday, $today, $tomorrow) {
    //     if ($value == $yesterday) {
    //         return false; // Вчерашняя дата, выдаем ошибку
    //     }

    //     if ($value == $today && now()->format('H:i') >= '10:00') {
    //         return false; // Сегодняшняя дата и время после 10:00, выдаем ошибку
    //     }

    //     return true; // Завтрашняя дата или сегодняшняя до 10:00, все ок
    // });

        return [
            
            // 'date' => [
            //     'required',
            //     'date',
            //     function ($attribute, $value, $fail) use ($yesterday, $today, $tomorrow) {
            //         if ($value < $yesterday) {
            //             $fail('The :attribute must be today or tomorrow.');
            //         }
    
            //         if ($value == $yesterday) {
            //             $fail('The :attribute cannot be yesterday.');
            //         }
    
            //         if ($value == $today && now()->format('H:i') >= '10:00') {
            //             $fail('The :attribute cannot be today after 10:00.');
            //         }
            //     },
            // ],
            'date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $date = Carbon::parse($value);
                    $today = Carbon::today();
                    $yesterday = Carbon::yesterday();
                    $current_time = Carbon::now()->hour;
                    
                    $tomorrow = Carbon::tomorrow();
                $dayAfterTomorrow = Carbon::tomorrow()->addDay();


                    if ($date->equalTo($yesterday)) {
                        $fail('Yesterday date is not allowed.');
                    }
    
                    if ($date->equalTo($today) && $current_time > 10) {
                        $fail('Today date, but the time is after 10 AM.');
                    }

                    if ($date->lessThan($tomorrow) || $date->greaterThanOrEqualTo($dayAfterTomorrow)) {
                        $fail('Only tomorrow\'s date is allowed.');
                    }
                },
            ],
            'reason' => 'required|string', // Причина повинна бути рядком
            'child_profile_id' => 'required|exists:child_profiles,id',
        ];
    }

    public function failedValidation(Validator $validator){

        // send error message
        Helper::sendError('validation error', $validator->errors());
    }
}
