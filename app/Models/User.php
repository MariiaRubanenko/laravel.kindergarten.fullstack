<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     //Массив атрибутов модели, которые могут быть заполнены массово(массивом) 
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
     //  атрибутов модели, которые должны быть скрыты при сериализации модели в массив или JSON.
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // Массив атрибутов модели, которые должны быть приведены к определенным типам
    // данных при получении их из базы данных или сохранении в нее.
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function family_accounts()
    {
        return $this->hasMany(Family_account::class);
    }

    public function staffs()
    {
        return $this->hasMany(Staff::class);
    }
}
