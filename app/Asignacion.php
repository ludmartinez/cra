<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Asignacion extends Pivot
{
    protected $table = 'asignaciones';

    protected $fillable = [
        'periodo_id',
        'docente_carnet',
        'grado_id',
        'materia_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s', strtotime($value));
    }

    public function docente()
    {
        return $this->belongsTo('App\Docente', 'docente_carnet', 'carnet');
    }

    public function periodo()
    {
        return $this->belongsTo('App\Periodo');
    }

    public function grado()
    {
        return $this->belongsTo('App\Grado');
    }

    public function materia()
    {
        return $this->belongsTo('App\Materia');
    }
}
