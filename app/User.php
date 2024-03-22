<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Technician;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'identification', 'address_id', 'cellphone', 'email' , 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function techinician()
    {
        return $this->hasOne(Technician::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function getAddress()
    {
      return [
        "city"   => $this->address->city->name,
        "street" => $this->address->street,
        "sector" => $this->address->sector,
        "number" => $this->address->number,
      ];
    }
}
