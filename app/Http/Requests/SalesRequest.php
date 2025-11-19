<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class SalesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer' => 'required|exists:customers,id',
            'shape_payment' => 'required|array',
            'shape_payment.*' => 'exists:shapes_payment,id',
            'states_operation' => 'sometimes|exists:states_operation,id',
            'quantity' => 'required|array',
            'quantity.*' => 'numeric|min:0.5',
            'product_id' => 'required|array',
            'product_id.*' => "numeric|exists:products,id",
            "totalSale" => "required|numeric|min:0.1",
            "taxBase" => "required|numeric|min:0",
            'amounts' => 'required|array',
            'amounts.*' => 'numeric|min:0.01'
        ];
    }

    public function messages()
    {
        return [
            'customer.required'=> 'El cliente es requerido',
            'customer.exists'=> 'El cliente no existe en la base de datos',
            'shape_payment.required'=> 'La forma de pago es requerida',
            'shape_payment.array'=> 'Por favor selecciona un metodo de pago valido',
            'shape_payment.*'=> 'El metodo de pago seleccionado no existe',
            'states_operation.required'=> 'El estado de operacion es requerido',
            'states_operation.exists'=> 'El estado de operacion no existe en la base de datos',
            'product_id.required' => 'Para poder realizar su operacion agregue productos a su venta',
            'product_id.array' => 'Los productos deben enviarse en un arreglo',
            'product_id.*' => 'Uno de los productos agregados es incorrecto',
            'quantity.required' => "Algunas de las cantidades insertadas son incorrectas",
            'quantity.*' => "Cada cantidad debe ser un numero y al menos 0.5",
            'totalSale.required' => 'El total de la venta es requerido',
            'totalSale.numeric' => 'El total de la venta debe ser un numero',
            'totalSale.min' => 'El total de la venta debe ser por lo minimo 0.1',
            'taxBase.required' => 'La base imponible es requerida',
            'taxBase.numeric' => 'La base imponible debe ser un numero',
            'amounts.required' => 'Debe indicar los montos para las formas de pago seleccionadas',
            'amounts.array' => 'Los montos de pago deben enviarse en un arreglo',
            'amounts.*.numeric' => 'Cada monto de pago debe ser un numero valido',
            'amounts.*.min' => 'Cada monto de pago debe ser al menos 0.01',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $shapePayments = $this->input('shape_payment', []);
            $amounts = $this->input('amounts', []);

            // validate product/quantity arrays
            $productIds = $this->input('product_id', []);
            $quantities = $this->input('quantity', []);

            if (!is_array($productIds) || count($productIds) === 0) {
                $validator->errors()->add('product_id', 'Debe agregar al menos un producto a la venta.');
            }

            if (!is_array($quantities) || count($quantities) === 0) {
                $validator->errors()->add('quantity', 'Debe especificar las cantidades de los productos.');
            }

            if (is_array($productIds) && is_array($quantities) && count($productIds) !== count($quantities)) {
                $validator->errors()->add('quantity', 'El numero de cantidades no coincide con el numero de productos.');
            }

            // ensure each quantity at least 0.5
            foreach ($quantities as $index => $q) {
                if (floatval($q) < 0.5) {
                    $validator->errors()->add('quantity.' . $index, "La cantidad minima por producto es 0.5 (fila: " . ($index+1) . ").");
                }
            }

            foreach ($shapePayments as $sp) {
                if (!isset($amounts[$sp]) && !isset($amounts[(string)$sp])) {
                    $validator->errors()->add('amounts', "Debe ingresar un monto para la forma de pago seleccionada (ID: {$sp}).");
                }
            }

            // get BCV rate
            $rate = DB::table('rates')->where('name', 'BCV')->value('value');
            $rate = $rate ? floatval($rate) : 0;

            if ($rate <= 0) {
                $validator->errors()->add('amounts', 'No hay tasa BCV disponible para convertir montos a USD.');
                return;
            }

            // get shapes names
            $shapes = DB::table('shapes_payment')->whereIn('id', $shapePayments)->pluck('name', 'id');

            $sumUSD = 0.0;
            foreach ($amounts as $shapeId => $amount) {
                $sid = intval($shapeId);
                $am = floatval($amount);
                $shapeName = strtolower(trim((string)($shapes->get($sid) ?? '')));
                if ($shapeName !== 'divisas') {
                    $sumUSD += $am / $rate;
                } else {
                    $sumUSD += $am;
                }
            }

            $totalSale = floatval($this->input('totalSale', 0));

            if (abs($sumUSD - $totalSale) > 0.01) {
                $validator->errors()->add('amounts', 'La suma (en USD) de los montos de pago no coincide con el total de la venta.');
            }
        });
    }
}