<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'password' => 'required',
            'new_password' => 'required|min:8',
            'repeat_new_password' => 'required|same:new_password'
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'La contraseña actual es requerida',
            'new_password.required' => 'La nueva contraseña es requerida',
            'new_password.min' => 'La nueva contraseña debe tener minimo 8 caracteres de longitud',
            'repeat_new_password.required' => 'Debe repetir la nueva contraseña',
            'repeat_new_password.same' => 'Ambas contraseñas deben coincidir',
        ];
    }
}
