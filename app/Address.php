<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
   protected $fillable = ['city_id','user_id','street','sector','number'];
}
