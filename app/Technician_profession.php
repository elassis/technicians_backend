<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Technician;
use App\Profession;

class Technician_profession extends Model
{

  protected $fillable = ['technician_id', 'profession_id', 'price_hour'];

  public function technician()
  {
    return $this->belongsTo(Technician::class);
  }

  public function profession()
  {
    return $this->belongsTo(Profession::class);
  }
}
