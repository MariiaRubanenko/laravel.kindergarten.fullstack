<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child_profile extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'gender', 'birthday', 'allergies', 'illnesses'];

    public function family_account()
    {
        return $this->belongsTo(Family_account::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
