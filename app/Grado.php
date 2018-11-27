<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    protected $fillable = [
        'grado',
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s',
    ];

    public function alumnos()
    {
        return $this->belongsToMany('App\Alumno', 'matriculas', 'grado_id', 'alumno_carnet')
            ->using('App\Matricula')
            ->withPivot([
                'periodo_id'
            ]);
    }
}
