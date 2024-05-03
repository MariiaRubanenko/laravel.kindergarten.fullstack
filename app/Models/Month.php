<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    use HasFactory;

    protected $table = "months";

    protected $fillable =["name"];


    public function daily_prices()
    {
        return $this->hasMany(Daily_price::class);
    }

}
