<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaLandmark extends Model
{
    protected $fillable = ['name','city_id','coordinates']; 

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}

