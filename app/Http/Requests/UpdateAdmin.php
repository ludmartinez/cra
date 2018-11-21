<?php

namespace App\Http\Requests;

use App\Admin;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdmin extends FormRequest
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
        $admin = Admin::find($this->carnet);
        $user = $admin->user;
        $rules = [
            'dui'               => "filled|digits:8|unique:admins,dui,$admin->carnet,carnet",
            'foto'              => "nullable|image",
            'primerNombre'      => "filled|alpha|max:45",
            'segundoNombre'     => "nullable|alpha|max:45",
            'tercerNombre'      => "nullable|alpha|max:45",
            'apellidoPaterno'   => "filled|alpha|max:45",
            'apellidoMaterno'   => "filled|alpha|max:45",
            'sexo'              => "filled|in:Femenino,Masculino",
            'fechaNacimiento'   => "filled|date",
            'fechaIngreso'      => "filled|date",
            'estado'            => "filled|boolean",
            'tipo'              => "filled|boolean",
            'usuario'           => "filled|alpha_num|unique:users,usuario,$user->id",
            'email'             => "filled|email|unique:users,email,$user->id",
            'password'          => "filled|alpha_num"
        ];

        return $rules;
    }
}
