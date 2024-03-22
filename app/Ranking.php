<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Technician;

class Ranking extends Model
{
    protected $fillable = ['technician_id', 'job_id', 'job_ranking'];


    public function technician()
    {
        return $this->belongsToMany(Technician::class);
    }

    public function job()
    {
        return $this->belongsToMany(Job::class);
    }
}
