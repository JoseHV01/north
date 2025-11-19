<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProvidersRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('provider');
        // dd($this);
        // OJO:
        // buscar forma de validar una longitud maxima de un numero en laravel

        return [
            'type_document' => 'required|exists:document_types,id',
            'document' => ['required', 'numeric', 'digits_between:8,12', $id ? Rule::unique('providers')->where('id_document_type', $this->type_document)->ignore($id) : Rule::unique('providers')->where('id_document_type', $this->type_document)],
            'business_name' => ['required', 'min:1', 'max:200', $id ? Rule::unique('providers')->ignore($id) : Rule::unique('providers')],
            'phone' => ['nullable', 'numeric', 'digits_between:10,12', /*'max:12',*/ $id ? Rule::unique('providers')->ignore($id) : Rule::unique('providers')],
            'email' => ['nullable', 'email', 'min:10', 'max:100', $id ? Rule::unique('providers')->ignore($id) : Rule::unique('providers')],
            'phone_secondary' => ['nullable', 'numeric', 'digits_between:10,12', /*'max:12',*/ $id ? Rule::unique('providers')->ignore($id) : Rule::unique('providers')],
            'direction' => ['nullable', 'max:300', $id ? Rule::unique('providers')->ignore($id) : Rule::unique('providers')],
        ];
    }

    public function messages()
    {
        return [
            'type_document.required'=> 'El tipo de documento es requerido',
            'type_document.exists'=> 'El tipo de documento seleccionado no existe',
            'document.required' => 'El documento es requerido',
            'document.unique' => 'El documento ingresado ya esta registrado',
            'document.numeric' => 'El documento solo puede contener numeros',
            'document.min' => 'El documento debe tener minimo 8 caracteres de longitud',
            'document.max' => 'El documento debe tener maximo 12 caracteres de longitud',
            'document.digits_between' => 'El documento debe tener entre 8 y 12 digitos',
            'business_name.required' => 'La razon social es requerida',
            'business_name.unique' => 'La razon social ingresada ya esta registrada',
            'business_name.min' => 'La razon social debe tener minimo 1 caracter de longitud',
            'business_name.max' => 'La razon social debe tener maximo 200 caracteres de longitud',
            'phone.numeric' => 'El telefono principal solo puede contener numeros',
            'phone.unique' => 'El telefono principal ingresado ya esta registrado',
            'phone.min' => 'El telefono principal debe tener minimo 10 caracteres de longitud',
            'phone.max' => 'El telefono principal debe tener maximo 12 caracteres de longitud',
            'phone.digits_between' => 'El telefono principal debe tener entre 10 y 12 digitos',
            'email.email' => 'El correo debe tener un formato valido',
            'email.min' => 'El correo debe tener minimo 10 caracteres de longitud',
            'email.unique' => 'El correo ingresado ya esta registrado',
            'phone_secondary.numeric' => 'El telefono secundario solo puede contener numeros',
            'phone_secondary.unique' => 'El telefono secundario ingresado ya esta registrado',
            'phone_secondary.min' => 'El telefono secundario debe tener minimo 10 caracteres de longitud',
            'phone_secondary.max' => 'El telefono secundario debe tener maximo 12 caracteres de longitud',
            'phone_secondary.digits_between' => 'El telefono secundario debe tener entre 10 y 12 digitos',
            'direction.unique' => 'Domicilio fiscal ya registrado'
        ];
    }
}
