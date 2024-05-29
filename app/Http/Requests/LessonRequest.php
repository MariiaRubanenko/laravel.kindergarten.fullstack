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
            ],
            'end_time' => [
                'required',
            'date_format:H:i:s',
            'before:18:00:00', 
            ],

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
            'start_time' => ['required', new NoLessonOverlap($this->group_id, $this->day_id, $this->start_time, $this->end_time)],
            'end_time' => ['required', new NoLessonOverlap($this->group_id, $this->day_id, $this->start_time, $this->end_time)],
            
        ];

        


    }

    public function failedValidation(Validator $validator){

        // send error message
        Helper::sendError('validation error', $validator->errors());
    }
}
