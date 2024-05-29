<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = "payments";

    protected $fillable =['monthly_payment', 'payment_status', 'daily_price_id', 'family_account_id'];

    public function daily_price()
    {
        return $this->belongsTo(Daily_price::class);
    }

    public function family_account()
    {
        return $this->belongsTo(Family_account::class);
    }
}
