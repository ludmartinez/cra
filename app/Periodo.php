<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $fillable = [
        'periodo',
        'fechaInicio',
        'fechaFin'
    ];

    protected $casts = [
        'fechaInicio' => 'date:d-m-Y',
        'fechaFin' => 'date:d-m-Y',
    ];

    public function getFechaInicioAttribute($value){
        return date('d-m-Y', strtotime($value));
    }

    public function getFechaFinAttribute($value){
        return date('d-m-Y', strtotime($value));
    }
}
