<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $primaryKey = 'carnet';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'carnet',
        'dui',
        'primerNombre',
        'segundoNombre',
        'tercerNombre',
        'apellidoPaterno',
        'apellidoMaterno',
        'sexo',
        'fechaNacimiento',
        'fechaIngreso',
        'estado'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
