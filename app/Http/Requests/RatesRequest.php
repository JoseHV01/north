<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RatesRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('rate');
        return [
            'name' => ['required', 'string', 'min:1', 'max:50', $id ? Rule::unique('rates')->where('status', 1)->ignore($id) : Rule::unique('rates')->where('status', 1)],
            'value' => 'required|numeric|min:0|max:100',
            'tax' => 'required|in:0,1'
        ];
    }

    public function messages()
    {
        return [
            'name.required'=> 'El nombre de la tasa es requerido',
            'name.string'=> 'El nombre de la tasa debe contener solo letras',
            'name.min'=> 'El nombre de la tasa debe tener minimo de 1 caracter de longitud',
            'name.max'=> 'El nombre de la tasa debe tener maximo de 50 caracter de longitud',
            'name.unique'=> 'Tasa ya esta registrada',
            'value.required'=> 'Debe agregar el valor porcentual de la tasa',
            'value.numeric'=> 'El valor de la tasa debe contener solo numeros',
            'value.min'=> 'El valor de la tasa debe ser mayor o igual a 0',
            'value.max'=> 'El valor de la tasa debe ser menor o igual a 100',
            'tax.required'=> 'Debe seleccionar un impuesto para la tasa',
            'tax.in'=> 'El impuesto seleccionada no es valido'
        ];
    }
}
