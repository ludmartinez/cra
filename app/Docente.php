<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $primaryKey = 'carnet';

    protected $keyType = 'string';

    protected $fillable = [
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
