<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

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
            'price.*' => "numeric|min:0.1",
            'percentaje' => 'required|array',
            'percentaje.*' => "numeric|min:1|max:99",
            'date' => "required|date",
            "totalShopping" => "required|numeric|min:0.1",
            'amounts' => 'required|array',
            'amounts.*' => 'numeric|min:0.01',
            "invoiceNumber" => "required|numeric|min:1",
            "controlNumber" => "required|numeric|min:1",
            "dollarRate" => "required|numeric|min:0.01"
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // ensure amounts exist for each selected shape_payment
            $shapePayments = $this->input('shape_payment', []);
            $amounts = $this->input('amounts', []);

            foreach ($shapePayments as $sp) {
                if (!isset($amounts[$sp]) && !isset($amounts[(string)$sp])) {
                    $validator->errors()->add('amounts', "Debe ingresar un monto para la forma de pago seleccionada (ID: {$sp}).");
                }
            }

            // fetch shapes names
            $shapes = collect([]);
            if (!empty($shapePayments)) {
                $shapes = collect(DB::table('shapes_payment')->whereIn('id', $shapePayments)->pluck('name', 'id'));
            }

            // get dollar rate from form input
            $rate = floatval($this->input('dollarRate', 0));

            $sumUSD = 0.0;
            $hasNonDivisas = false;

            foreach ($amounts as $shapeId => $amount) {
                $sid = intval($shapeId);
                $amount = floatval($amount);
                $shapeName = strtolower(trim((string)($shapes->get($sid) ?? '')));
                if ($shapeName !== 'divisas') {
                    $hasNonDivisas = true;
                    if ($rate <= 0) {
                        $validator->errors()->add('amounts', 'No hay tasa de cambio disponible para convertir montos a USD.');
                        // stop further processing
                        return;
                    }
                    // convert local currency to USD
                    $sumUSD += $amount / $rate;
                } else {
                    // already USD
                    $sumUSD += $amount;
                }
            }

            $total = floatval($this->input('totalShopping', 0));
            if (abs($sumUSD - $total) > 0.01) {
                $validator->errors()->add('amounts', 'La suma (en USD) de los montos de pago no coincide con el total de la compra.');
            }
        });
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
            'totalShopping.min'=> 'El total de la compra debe ser por lo minimo 0.1',
            'amounts.required' => 'Debe indicar los montos para las formas de pago seleccionadas',
            'amounts.array' => 'Los montos de pago deben enviarse en un arreglo',
            'amounts.*.numeric' => 'Cada monto de pago debe ser un numero valido',
            'amounts.*.min' => 'Cada monto de pago debe ser al menos 0.01',
            'invoiceNumber.required'=> 'El numero de la factura es requerido',
            'invoiceNumber.numeric'=> 'El numero de la factura debe ser un numero',
            'invoiceNumber.min'=> 'El numero de la factura debe ser por lo minimo 1',
            'controlNumber.required'=> 'El numero de control es requerido',
            'controlNumber.numeric'=> 'El numero de control debe ser un numero',
            'controlNumber.min'=> 'El numero de control debe ser por lo minimo 1',
            'dollarRate.required'=> 'El precio del dólar es requerido',
            'dollarRate.numeric'=> 'El precio del dólar debe ser un numero',
            'dollarRate.min'=> 'El precio del dólar debe ser por lo minimo 0.01',
        ];
    }
}
