<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Daily_price extends Model
{
    use HasFactory;

    protected $table = "daily_prices";

    // protected $fillable =['price', 'year', 'month_id'];
    protected $fillable =['price', 'month_id'];

    public function month()
    {
        return $this->belongsTo(Month::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->year = Carbon::now()->year;
        });
    }
}
