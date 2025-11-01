<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomersRequest extends FormRequest
{
     public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('customer');

        // OJO:
        // buscar forma de validar una longitud maxima de un numero en laravel

        return [
            'type_document' => 'required|exists:document_types,id',
            'document' => ['required', 'numeric', 'min:1', /*'max:10',*/ $id ? Rule::unique('customers')->where('id_document_type', $this->type_document)->ignore($id) : Rule::unique('customers')->where('id_document_type', $this->type_document)],
            'business_name' => ['required', 'min:1', /*'max:50',*/ $id ? Rule::unique('customers')->ignore($id) : Rule::unique('customers')],
            'email' => ['nullable', 'email', 'min:10', $id ? Rule::unique('customers')->ignore($id) : Rule::unique('customers')],
            'phone' => ['nullable', 'numeric', 'min:10', /*'max:12',*/ $id ? Rule::unique('customers')->ignore($id) : Rule::unique('customers')],
            'phone_secondary' => ['nullable', 'numeric', 'min:10', /*'max:12',*/ $id ? Rule::unique('customers')->ignore($id) : Rule::unique('customers')],
            'retention_agent' => 'sometimes|boolean'
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
            'document.min' => 'El documento debe tener minimo 7 caracteres de longitud',
            'document.max' => 'El documento debe tener maximo 10 caracteres de longitud',
            'business_name.required' => 'La razon social es requerida',
            'business_name.unique' => 'La razon social ingresada ya esta registrada',
            'business_name.min' => 'La razon social es requerida',
            'email.email' => 'El correo debe tener un formato valido',
            'email.min' => 'El correo debe tener minimo 10 caracteres de longitud',
            'email.unique' => 'El correo ingresado ya esta registrado',
            'phone.numeric' => 'El telefono principal solo puede contener numeros',
            'phone.unique' => 'El telefono principal ingresado ya esta registrado',
            'phone.min' => 'El telefono principal debe tener minimo 10 caracteres de longitud',
            'phone.max' => 'El telefono principal debe tener maximo 12 caracteres de longitud',
            'phone_secondary.numeric' => 'El telefono secundario solo puede contener numeros',
            'phone_secondary.unique' => 'El telefono secundario ingresado ya esta registrado',
            'phone_secondary.min' => 'El telefono secundario debe tener minimo 10 caracteres de longitud',
            'phone_secondary.max' => 'El telefono secundario debe tener maximo 12 caracteres de longitud',
            'retention_agent.boolean' => 'El valor del agente de retencion es incorrecto',
            'retention_agent.sometimes' => 'El valor del agente de retencion es incorrecto'
        ];
    }
}
