<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    public function sectors()
    {
        return $this->belongsTo(Sector::class, 'id');
    }
}
