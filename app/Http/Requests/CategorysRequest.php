<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategorysRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

  public function rules()
    {
        $id = $this->route('category');
        return [
            'name' => ['required', 'string', 'min:5', 'max:50', $id ? Rule::unique('categorys')->ignore($id) : Rule::unique('categorys')]
        ];
    }

    public function messages()
    {
        return [
            'name.required'=> 'Debe ingresar el nombre de la categoria',
            'name.string'=> 'El nombre de la categoria debe contener solo letras',
            'name.min'=> 'El nombre de la categoria debe contener minimo 5 letras',
            'name.max'=> 'El nombre de la categoria debe contener maximo 50 letras',
            'name.unique'=> 'La categoria ingresada ya existe',
        ];
    }
}
