<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $table = "lessons";

    protected $fillable =['start_time', 'end_time', 'day_id', 'action_id', 'group_id' ];

    public function day()
    {
        return $this->belongsTo(Day::class);
    }

    public function action()
    {
        return $this->belongsTo(Action::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
