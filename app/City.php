<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
  protected $fillable = ['name'];

  public function address()
  {
    return $this->hasMany(Address::class);
  }
}
