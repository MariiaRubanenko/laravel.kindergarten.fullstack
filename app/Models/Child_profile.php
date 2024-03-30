<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child_profile extends Model
{
    use HasFactory;
    protected $table = "child_profiles";
    protected $fillable = ['name', 'gender', 'birthday', 'allergies', 'illnesses', 'image_name', 'image_data', 'family_account_id', 'group_id'];

    public function family_account()
    {
        return $this->belongsTo(Family_account::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

}
