<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Technician_profession extends Model
{

    protected $fillable = ['technician_id','profession_id'];
    public function technicians()
    {
        return $this->hasOne(Technician::class, 'id');
    }
    
    public function professions()
    {
        return $this->hasOne(Profession::class, 'id');
    }
}
