<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
   public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'name' => 'required|string',
            'rif' => 'required',
            'direction' => 'required|string',
            'phone' => 'required|numeric',
            'email' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El Nombre de la compañia es requerido',
            'name.string' => 'El Nombre de la compañia debe contener solo letras',
            'rif.required' => 'El RIF es requerido',
            'direction.required' => 'La direccion es requerida',
            'direction.string' => 'La direccion debe contener solo letras',
            'phone.required' => 'El telefono es requerido',
            'phone.numeric' => 'El telefono debe contener solo numeros',
            'email.required' => 'El correo es requerido',
            'email.email' => 'El correo debe tener un formato valido',
        ];
    }
}
