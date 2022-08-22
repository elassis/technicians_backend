<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
   protected $fillable =['user_id','available','price_hour'];
}
