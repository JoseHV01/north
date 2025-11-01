<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecoverAccessRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

     public function rules()
    {
        return [
            'answer' => 'required',
            'password' => 'required|min:8',
            'repeat_password' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'answer.required' => 'Debe ingresar la respuesta de la pregunta',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener minimo 8 caracteres de longitud',
            'repeat_password.required' => 'Debe repetir la contraseña',
            'repeat_password.same' => 'Ambas contraseñas deben coincidir',
        ];
    }
}
