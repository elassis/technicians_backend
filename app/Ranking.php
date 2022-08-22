<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    protected $fillable = ['technician_id', 'job_id','job_ranking'];
    
    public function technicians()
    {
        return $this->hasOne(Technician::class, 'id');
    }
    
    public function jobs()
    {
        return $this->hasOne(Job::class, 'id');
    }
}
