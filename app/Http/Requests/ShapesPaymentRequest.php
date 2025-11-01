<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShapesPaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('shapes_payment');
        return [
            'name' => ['required', 'string', 'min:1', 'max:50', $id ? Rule::unique('shapes_payment')->ignore($id) : Rule::unique('shapes_payment')],
        ];
    }

    public function messages()
    {
        return [
            'name.required'=> 'El nombre de la forma de pago es requerido',
            'name.string'=> 'El nombre de la forma de pago debe contener solo letras',
            'name.min'=> 'El nombre de la forma de pago debe tener minimo de 1 caracter de longitud',
            'name.max'=> 'El nombre de la forma de pago debe tener maximo de 50 caracter de longitud',
            'name.unique'=> 'Forma de pago ya esta registrada',
        ];
    }
}
