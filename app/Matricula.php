<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Matricula extends Pivot
{
    protected $table = 'matriculas';

    protected $fillable = [
        'periodo_id',
        'alumno_carnet',
        'grado_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    public function getCreatedAtAttribute($value){
        return date('d-m-Y H:i:s', strtotime($value));
    }

    public function getUpdatedAtAttribute($value){
        return date('d-m-Y H:i:s', strtotime($value));
    }

    public function alumno()
    {
        return $this->belongsTo('App\Alumno', 'alumno_carnet', 'carnet');
    }

    public function periodo()
    {
        return $this->belongsTo('App\Periodo');
    }

    public function grado()
    {
        return $this->belongsTo('App\Grado');
    }

}
