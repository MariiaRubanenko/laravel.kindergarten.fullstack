<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Lesson;

class NoLessonOverlap implements Rule
{


    protected $group_id;
    protected $day_id;
    protected $start_time;
    protected $end_time;
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    // public function validate(string $attribute, mixed $value, Closure $fail): void
    // {
    //     //
    // }

//     public function validate($attribute, $value, $parameters, $validator)
// {
//     // Вы можете игнорировать параметры и валидатор, так как они не используются в вашем правиле
//     return $this->passes($attribute, $value);
// }

public function __construct($group_id, $day_id, $start_time, $end_time)
{
    $this->group_id = $group_id;
    $this->day_id = $day_id;
    $this->start_time = $start_time;
    $this->end_time = $end_time;
}


    public function passes($attribute, $value)
    {
        // Проверяем, есть ли перекрытия существующих уроков
        return !Lesson::where('group_id', $this->group_id)
            ->where('day_id', $this->day_id)
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('start_time', '>=', $this->start_time)
                        ->where('start_time', '<', $this->end_time);
                })->orWhere(function ($q) {
                    $q->where('end_time', '>', $this->start_time)
                        ->where('end_time', '<=', $this->end_time);
                });
            })
            ->exists();
    }

    public function message()
    {
        return 'Lesson time overlaps with an existing lesson.';
    }


}
