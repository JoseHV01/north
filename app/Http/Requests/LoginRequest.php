<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'userName' => 'required|email|max:50',
            'userPassword' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'userName.required' => 'Debe ingresar su usuario',
            'userName.email' => 'Su usuario debe ser un correo electronico',
            'userName.max' => 'Su usuario debe tener menos de 50 caracteres de longitud',
            'userName.required' => 'Debe ingresar su usuario',
            'userPassword.required' => 'Debe ingresar su contraseña',
            'userPassword.min' => 'Su contraseña debe tener minimo 8 caracteres de longitud'
        ];
    }
}
