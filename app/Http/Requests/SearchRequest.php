<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'states_operation' => 'nullable|exists:states_operation',
            'number_bills' => 'nullable|number|min:0001',
            'start' => 'nullable|date',
            'end' => 'nullable|date|after_or_equal:start'
        ];
    }

    public function messages()
    {
        return [
            'number_bills.number'=> 'El codigo de la factura solo debe tener numeros',
            'states_operation.exists' => 'El estado de operacion no existe en la base de datos',
            'start.date'=> 'Debe ingresar fechas',
            'end.date'=> 'Debe ingresar fechas',
            'end.after_or_equal'=> 'La fecha de fin debe ser menor o igual a la fecha de inicio',
        ];
    }
}
