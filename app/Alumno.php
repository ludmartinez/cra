<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $primaryKey = 'carnet';

    protected $keyType = 'string';

    protected $fillable = [
        'nie',
        'primerNombre',
        'segundoNombre',
        'tercerNombre',
        'apellidoPaterno',
        'apellidoMaterno',
        'sexo',
        'fechaNacimiento',
        'fechaIngreso',
        'solvencia',
        'estado',
    ];

    protected $cast = [
        'solvencia' => 'boolean',
        'estado' => 'boolean',
    ];

    public function fullName()
    {
        $name = $this->primerNombre . '-';
        $name .= $this->segundoNombre . '-';
        $name .= $this->tercerNombre . '-';
        $name .= $this->apellidoPaterno . '-';
        $name .= $this->apellidoMaterno;
        $name = title_case($name);
        $name = str_replace(['-', '   ', '  '], ' ', $name);

        return $name;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
