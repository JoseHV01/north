<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:50|unique:users,name',
            'email' => 'required|email|min:10|unique:users,email',
            'password' => 'required|min:8',
            'password_repeat' => 'required|same:password',
            'asks' => 'required|array',
            'asks.*' => 'min:5',
            'answers' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El Nombre es requerido',
            'name.unique' => 'El Nombre ingresado ya esta registrado',
            'name.string' => 'El Nombre debe contener solo letras',
            'name.max' => 'El Nombre debe tener maximo 50 caracteres de longitud',
            'email.required' => 'El correo es requerido',
            'email.email' => 'Debe ingresar un correo valido',
            'email.min' => 'El correo debe tener minimo 10 caracteres de longitud',
            'email.unique' => 'El correo ingresado ya esta registrado',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener minimo 8 caracteres de longitud',
            'password_repeat.required' => 'Debe repetir la contraseña',
            'password_repeat.same' => 'Ambas contraseñas deben coincidir',
            'asks.required' => 'Las preguntas de seguridad son requeridas',
            'asks.*' => 'Las preguntas de seguridad deben contener mas de 5 caracteres',
            'answers.required' => 'Las respuestas son requerida',
        ];
    }
}
