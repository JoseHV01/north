<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('product');

        return [
            'description' => ['required', 'string', 'min:5', 'max:150', $id ? Rule::unique('products')->ignore($id) : Rule::unique('products')],
            'category' => 'required|exists:categorys,id',
            // 'iva' => 'required|min:0|max:1',
            'minime' => 'nullable|numeric|min:0'
        ];
    }

    public function messages()
    {
        return [
            'description.required'=> 'La descripcion es requerida',
            'description.string'=> 'La descripcion debe contener letras',
            'description.min' => 'La descripcion debe tener minimo 5 caracteres de longitud',
            'description.max' => 'La descripcion debe tener maximo 150 caracteres de longitud',
            'description.unique' => 'La descripcion ingresada ya esta registrada',
            'category.required'=> 'La categoria es requerida',
            'category.exists'=> 'La categoria seleccionada no existe',
            'category.unique' => 'La descripcion ingresada ya esta registrada',
            // 'iva.required'=> 'Debe seleccionar si el producto esta excento o grabado',
            // 'iva.min' => 'Debe seleccionar si el producto esta excento o grabado',
            // 'iva.max' => 'Debe seleccionar si el producto esta excento o grabado',
            'minime.numeric' => 'La existencia minima solo debe contener numeros',
            'minime.min' => 'La existencia minima debe ser mayor o igual a 0 ',
        ];
    }
}
