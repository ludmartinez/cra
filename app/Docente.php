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

    public function fullName(){
        $name = $this->primerNombre . '-';
        $name .= $this->segundoNombre . '-';
        $name .= $this->tercerNombre . '-';
        $name .= $this->apellidoPaterno . '-';
        $name .= $this->apellidoMaterno;
        $name = title_case($name);
        $name = str_replace(['-', '   ', '  '], ' ', $name);

        return $name;
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function asignaciones(){
        return $this->hasMany('App\Asignacion', 'docente_carnet', 'carnet');
    }
}
