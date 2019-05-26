<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    public $timestamps = false;
    protected $fillable = ['departamento'];

    public function municipio(){
        return $this->hasMany('App\Municipio');
    }
}
