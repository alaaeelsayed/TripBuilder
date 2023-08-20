<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    public $fillable = ['code', 'name'];

    public $timestamps = false;

    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';
}
