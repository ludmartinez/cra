<?php

namespace App\Http\Requests;

use App\Matricula;
use Illuminate\Foundation\Http\FormRequest;

class StoreMatricula extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // $matricula = Matricula::where('periodo_id', $this->periodo_id)->where('alumno_carnet', $this->alumno_carnet)->count();
        // if ($matricula > 0) {
        //     return false;
        // } else {
        //     return true;
        // }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'periodo_id' => 'required|integer',
            'alumno_carnet' => "required|string|max:8",
            'grado_id' => "required|integer",
        ];
    }
}
