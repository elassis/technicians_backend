<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['user_id','technician_id','profession_id','status','text','comments', 'begin_date','end_date'];

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    public function ranking()
    {
        return $this->hasOne(Ranking::class);
    }
    
}
