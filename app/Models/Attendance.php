<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable =['date','reason' ];

    public function child_profile()
    {
        return $this->belongsTo(Child_profile::class);
    }
    
}
