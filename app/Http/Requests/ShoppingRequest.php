<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShoppingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'provider' => 'required|exists:providers,id',
            'shape_payment' => 'required|array',
            'shape_payment.*' => 'exists:shapes_payment,id',
            'states_operation' => 'required|exists:states_operation,id',
            'quantity' => 'required|array',
            'quantity.*' => 'numeric|min:1',
            'product_id' => 'required|array',
            'product_id.*' => "numeric|exists:products,id",
            'price' => 'required|array',
            'price.*' => "numeric|min:1",
            'percentaje' => 'required|array',
            'percentaje.*' => "numeric|min:1|max:99",
            'date' => "required|date",
            "totalShopping" => "required|numeric|min:1",
            "invoiceNumber" => "required|numeric|min:1",
            "controlNumber" => "required|numeric|min:1"
        ];
    }

    public function messages()
    {
        return [
            'provider.required'=> 'El proveedor es requerido',
            'provider.exists'=> 'El proveedor no existe en la base de datos',
            'shape_payment.required'=> 'La forma de pago es requerida',
            'shape_payment.array'=> 'Por favor selecciona un metodo de pago valido',
            'shape_payment.*'=> 'El metodo de pago seleccionado no existe',
            'states_operation.required'=> 'El estado de operacion es requerido',
            'states_operation.exists'=> 'El estado de operacion no existe en la base de datos',
            'product_id' => 'Para poder realizar su operacion agregue productos a su venta',
            'product_id.*' => 'Uno de los productos agregados es incorrecto',
            'quantity' => "Algunas de las cantidades insertadas son incorrectas",
            'quantity.*' => "Algunas de las cantidades insertadas son incorrectas",
            'price' => "Algunos de los precios insertados son incorrectos",
            'percentaje' => "Algunas de los porcentajes insertados son incorrectos",
            'percentaje.*' => "Algunas de los porcentajes insertados son incorrectos",
            'date.required' => "La fecha de compra es requerida",
            'date.date' => "Debe ingresar una fecha valida",
            'totalShopping.required'=> 'El total de la compra es requerido',
            'totalShopping.numeric'=> 'El total de la compra debe ser un numero',
            'totalShopping.min'=> 'El total de la compra debe ser por lo minimo 1',
            'invoiceNumber.required'=> 'El numero de la factura es requerido',
            'invoiceNumber.numeric'=> 'El numero de la factura debe ser un numero',
            'invoiceNumber.min'=> 'El numero de la factura debe ser por lo minimo 1',
            'controlNumber.required'=> 'El numero de control es requerido',
            'controlNumber.numeric'=> 'El numero de control debe ser un numero',
            'controlNumber.min'=> 'El numero de control debe ser por lo minimo 1',
        ];
    }
}
