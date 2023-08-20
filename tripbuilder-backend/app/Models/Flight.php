<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $fillable = [
        'airline',
        'number',
        'departure_airport',
        'departure_time',
        'arrival_airport',
        'duration',
        'price'
    ];

    public $timestamps = false;
    protected $primaryKey = ['airline', 'number'];
    public $incrementing = false;

    public function airline()
    {
        return $this->belongsTo(Airline::class, 'airline', 'code');
    }

    public function departureAirport()
    {
        return $this->belongsTo(Airport::class, 'departure_airport', 'code');
    }

    public function arrivalAirport()
    {
        return $this->belongsTo(Airport::class, 'arrival_airport', 'code');
    }
}
