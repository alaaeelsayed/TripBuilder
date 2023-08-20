<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    protected $fillable = [
        'code', 'name', 'latitude', 'longitude', 'city_code', 'city', 'country_code', 'timezone'
    ];
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;
}
