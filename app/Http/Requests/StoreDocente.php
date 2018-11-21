<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocente extends FormRequest
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
        $rules = [
            'dui'               => "required|string|size:9|unique:docentes",
            'foto'              => "nullable|image",
            'primerNombre'      => "required|alpha|max:45",
            'segundoNombre'     => "nullable|alpha|max:45",
            'tercerNombre'      => "nullable|alpha|max:45",
            'apellidoPaterno'   => "required|alpha|max:45",
            'apellidoMaterno'   => "required|alpha|max:45",
            'sexo'              => "required|in:Femenino,Masculino",
            'fechaNacimiento'   => "required|date",
            'fechaIngreso'      => "required|date",
        ];

        return $rules;
    }
}
