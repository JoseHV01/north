<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeAsksRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'password' => 'required',
            'asks' => 'required|array',
            'asks.*' => 'string|min:5',
            'answers' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'La contraseña es requerida',
            'asks.required' => 'Las preguntas de seguridad son requeridas',
            'asks.string' => 'Las preguntas de seguridad deben contener letras',
            'asks.min' => 'Las preguntas de seguridad deben tener minimo 5 caracteres de longitud',
            'answers.required' => 'Las respuestas son requerida',
        ];
    }
}
