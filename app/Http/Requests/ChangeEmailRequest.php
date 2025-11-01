<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeEmailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => ['required', 'email', 'min:10', Rule::unique('users')->ignore(auth()->user()->id)],
            'password' => ['required', 'min:8'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'El correo es requerido',
            'email.email' => 'Debe ingresar un correo valido',
            'email.min' => 'El correo debe tener minimo 10 caracteres de longitud',
            'email.unique' => 'El correo ingresado ya esta registrado',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener minimo 8 caracteres de longitud',
        ];
    }
}
