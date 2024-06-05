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
    public function rules(): array
    {

        return [
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
            'reason' => 'required|string', 
            'child_profile_id' => 'required|exists:child_profiles,id',
        ];
    }

    public function failedValidation(Validator $validator){

        Helper::sendError('validation error', $validator->errors());
    }
}
