<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trusted_person extends Model
{
    use HasFactory;

    protected $table = "trusted_persons";
    protected $fillable = ['name', 'email', 'phone', 'image_name', 'image_data', 'family_account_id'];

    public function family_account()
    {
        return $this->belongsTo(Family_account::class);
    }
    

}
