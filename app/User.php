<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function alumno()
    {
        return $this->hasOne('App\Alumno');
    }

    public function docente()
    {
        return $this->hasOne('App\Docente');
    }

    public function admin()
    {
        return $this->hasOne('App\Admin');
    }

    public function usuario()
    {
        switch ($this->tipo) {
            case 'Alumno':
                return $this->alumno;
                break;
            case 'Docente':
                return $this->docente;
                break;
            case 'Admin':
                return $this->admin;
                break;
        }
    }
}
