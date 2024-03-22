<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Technician_profession;
use App\Technician;

class Profession extends Model
{
    protected $fillable = ['name'];

    public function technicianProfession()
    {
        return $this->hasMany(Technician_profession::class);
    }

    public function job()
    {
        return $this->hasOne(Job::class);
    }

    public function technicians()
    {
        return $this->belongsToMany(Technician::class, 'technician_professions');
    }


}
