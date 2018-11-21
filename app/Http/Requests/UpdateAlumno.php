<?php

namespace App\Http\Requests;

use App\Alumno;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAlumno extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $alumno = Alumno::find($this->carnet);
        $user = $alumno->user;
        $rules = [
            'nie'               => "filled|digits:8|unique:alumnos,nie,$alumno->carnet,carnet",
            'foto'              => "nullable|image",
            'primerNombre'      => "filled|alpha|max:45",
            'segundoNombre'     => "nullable|alpha|max:45",
            'tercerNombre'      => "nullable|alpha|max:45",
            'apellidoPaterno'   => "filled|alpha|max:45",
            'apellidoMaterno'   => "filled|alpha|max:45",
            'sexo'              => "filled|in:Femenino,Masculino",
            'fechaNacimiento'   => "filled|date",
            'fechaIngreso'      => "filled|date",
            'solvencia'         => "filled|boolean",
            'estado'            => "filled|boolean",
            'usuario'           => "filled|alpha_num|unique:users,usuario,$user->id",
            'email'             => "filled|email|unique:users,email,$user->id",
            'password'          => "filled|alpha_num"
        ];

        return $rules;
    }
}
