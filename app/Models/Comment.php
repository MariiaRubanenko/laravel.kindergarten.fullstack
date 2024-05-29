<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = "comments";
    protected $fillable =['family_account_id', 'text'];

    public function family_account()
    {
        return $this->belongsTo(Family_account::class);
    }
}
