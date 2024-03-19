<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'contact_person',
        'city_id',
        'landmark_id',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function landmark()
    {
        return $this->belongsTo(AreaLandmark::class, 'landmark_id');
    }
}
