<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StatesOperationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('states_operation');
        return [
            'name' => ['required', 'string', 'min:1', 'max:50', $id ? Rule::unique('states_operation')->ignore($id) : Rule::unique('states_operation')],
        ];
    }

    public function messages()
    {
        return [
            'name.required'=> 'El nombre del estado es requerido',
            'name.string'=> 'El nombre del estado debe contener solo letras',
            'name.min'=> 'El nombre del estado debe tener minimo de 1 caracter de longitud',
            'name.max'=> 'El nombre del estado debe tener maximo de 50 caracter de longitud',
            'name.unique'=> 'Estado ya esta registrado',
        ];
    }
}
