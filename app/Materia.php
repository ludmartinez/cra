<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $fillable = [
        'materia',
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s',
    ];
}
