<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    public $timestamps = false;

    protected $fillable = ['municipio', 'id_departamento'];

    public function departamento(){
        return $this->belongsTo('App\Departamento', 'id_departamento');
    }
}
