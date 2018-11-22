<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePeriodo extends FormRequest
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
        return [
            'periodo' => "filled|digits:4|unique:periodos,periodo,$this->id",
            'fechaInicio' => "filled|date|after_or_equal:" . date('d-m-Y', strtotime('01-01-' . $this->periodo))."|before_or_equal:". date('d-m-Y', strtotime('31-12-' . $this->periodo)),
            'fechaFin' => "filled|date|after:fechaInicio|before_or_equal:". date('d-m-Y', strtotime('31-12-' . $this->periodo)),
        ];
    }
}
