<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family_account extends Model
{
    use HasFactory;

    // protected $fillable = ['user_id'];
    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function child_profiles()
    {
        return $this->hasMany(Child_profile::class);
    }

    public function trusted_persons(){

        return $this->hasMany(Trusted_person::class);
    }
}
