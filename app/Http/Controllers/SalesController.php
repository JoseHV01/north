<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SalesRequest;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\LogsController;

class SalesController extends Controller
{
    public function index()
    {
        $sales = DB::table('sales_invoices')
        ->join('customers', 'customers.id', '=', 'sales_invoices.id_customer')
        ->leftJoin('document_types', 'document_types.id', '=', 'customers.id_document_type')
        ->select('sales_invoices.*', 'document_types.name as document_type', 'customers.document', 'customers.business_name', 'states_operation.name as state')
        ->orderBy('sales_invoices.created_at', 'DESC')
        ->paginate(10);
        dd($sales);

        // $sales->payments = DB::table('purchases_invoice_shapes_payment')
        // ->join('shapes_payment', 'shapes_payment.id', '=', 'purchases_invoice_shapes_payment.id_shape_payment')
        // ->where('id_purchase_invoice', $id)
        // ->select('shapes_payment.name as shape_payment', 'amount', 'price_BCV')
        // ->get();

        return view('pages/sales')->with('sales', $sales);
    }

    public function create(){
        $customers = DB::table('customers')
        ->leftJoin('document_types', 'document_types.id', '=', 'customers.id_document_type')
        ->where('status', 1)
        ->orderBy('customers.business_name', 'ASC')
        ->select('customers.id', 'customers.business_name','customers.document', 'document_types.name as document_type')
        ->get();

        $shapes_payments = DB::table('shapes_payment')
        ->where('status', 1)
        ->select('id', 'name')
        ->orderBy('name', 'ASC')
        ->get();

        $states_operation = DB::table('states_operation')
        ->where('status', 1)
        ->select('id', 'name')
        ->orderBy('name', 'ASC')
        ->get();

        $rates = DB::table('rates')->where('status', 1)->get();

        $categorys = DB::table('categorys')->where('status', 1)->orderBy('name', 'ASC')->get();

        $products = DB::table('products')
        ->where('products.status', 1)
        ->orderBy('description', 'ASC')
        ->select('products.*')
        ->get();

        if($this->validationsQuery([$customers, $shapes_payments, $states_operation, $rates, $products])[0]){
            return back()->withErrors(['error' => "Debe tener registrados ".$this->validationsQuery([$customers, $shapes_payments, $states_operation, $rates, $products])[1]." para poder agregar ventas"]);
        }

        return view('pages/sales_create')->with('customers', $customers)->with('shapes_payments', $shapes_payments)->with('states_operation', $states_operation)->with('rates', $rates)->with('categorys', $categorys)->with('products', $products);
    }

    public function search(){
        $products = DB::table('products')
        ->where('products.status', 1)
        ->where('existence', '>', 0)
        ->orderBy('description', 'ASC')
        ->select('products.*')
        ->get();

        $rates = DB::table('rates')->where('status', 1)->get();

        return json_encode([$products, $rates]);
    }

    public function store(SalesRequest $request)
    {
        

        $totalBs = $request->input('totalSale');
        $amounts = $request->input('amounts', []);
        $rate = DB::table('rates')->where('name', 'BCV')->first()->value ?? 0;

        if(count($amounts) > 1){

            $sum = 0;
            foreach ($amounts as $id => $amount) {
                $shape = DB::table('shapes_payment')->where('id', $id)->first();

                if (str_contains(strtolower($shape->name), 'divisas') || str_contains(strtolower($shape->name), 'dolares') || str_contains(strtolower($shape->name), 'usd')) {
                    $sum += $amount * $rate;
                } else {
                    $sum += $amount;
                }
            }
            
            if (abs($sum - $totalBs) > 0.01) {
                return back()->withErrors(['totalShopping' => 'La suma de los montos no coincide con el total.']);
            }
        }
       

        foreach ($request->product_id as $key => $id) {
            $productExistence = DB::table('products')->where('id', $id)->value('existence');
            if($request->quantity[$key] > $productExistence) return back()->withErrors(['error' => "Error: Alguna de las cantidades de los productos de la venta supera su existencia"]);
        }

        DB::beginTransaction();
        try {
            $rates = DB::table('rates')->where('status', 1)->get();
            $headerCompany = DB::table('company')->orderBy('created_at', 'DESC')->value('id');

            $id_transaction = DB::table('sales_invoices')->insertGetId([
                'id_customer' => $request->customer,
                'tax_base' => $request->taxBase,
                'total' => $request->totalSale,
                'iva' => $rates[0]->value,
                'igtf' => in_array($amounts, array_keys($request->input('amounts', []))) == 2 ? $rates[2]->value : 0,
                'bcv' => in_array($amounts, array_keys($request->input('amounts', []))) ? $rates[3]->value : 0,
                'ganance' => $rates[1]->value,
                'id_state_operation' => $request->states_operation,
                'id_header' => $headerCompany
            ]);

            foreach ($amounts as $id => $amount) {
                DB::table('sales_invoices_shapes_payment')->insert([
                    'id_sales_invoice' => $id_transaction,
                    'id_shape_payment' => $id,
                    'amount' => $amount,
                    'price_BCV' => $rate,
                ]);
            }

            foreach ($request->product_id as $key => $id) {
                $product = DB::table('products')
                ->where('id', $id)
                ->select('price', 'iva')
                ->first('price');

                $price_total = (($product->price * $rates[1]->value) / 100) + $product->price;
                $quantity_product = $request->quantity[$key];

                DB::table('sales_invoice_details')->insert([
                    'id_sales_invoice' => $id_transaction,
                    'id_product' => $id,
                    'amount' => $quantity_product,
                    'price' => $price_total,
                ]);

                DB::table('products')
                ->where('id', $id)
                ->decrement('existence', $quantity_product);

                $stockProduct = DB::table('stock')->where('id_product', $id)->where('exists', 1)->get();

                foreach($stockProduct as $productDetail){
                    if($quantity_product > 0){
                        $quantity_stock = $productDetail->quantity;

                        if($quantity_product >= $quantity_stock){
                            DB::table('stock')->where('id', $productDetail->id)->update([
                                'exists' => 0
                            ]);

                            DB::table('stock_register')->insert([
                                'id_stock' => $productDetail->id,
                                'quantity_sale' => $quantity_stock,
                                'id_sales_invoices' => $id_transaction,
                            ]);

                            $quantity_product = $quantity_product - $quantity_stock;
                            DB::table('stock')->where('id', $productDetail->id)->decrement('quantity', $quantity_stock);
                        }else{
                            DB::table('stock')->where('id', $productDetail->id)->decrement('quantity', $quantity_product);

                            DB::table('stock_register')->insert([
                                'id_stock' => $productDetail->id,
                                'quantity_sale' => $quantity_product,
                                'id_sales_invoices' => $id_transaction,
                            ]);

                            $quantity_product = 0;
                        }
                    }else{
                        break;
                    }
                }
            }

            $code = 0;

            if($id_transaction <= 9){
                $code = "000$id_transaction";
            }elseif($id_transaction >= 10 && $id_transaction <= 99){
                $code = "00$id_transaction";
            }elseif($id_transaction >= 100 && $id_transaction <= 999){
                $code = "0$id_transaction";
            }else{
                $code = $id_transaction;
            }

            DB::table('sales_invoices')->where('id', $id_transaction)->update([
                'number_bill' => $code
            ]);

            $extendController = new AuthenticateController();
            $extendController->queryProductsOutOfStock();

            $extendLogsController = new LogsController();
            $extendLogsController->insertLogOperations('Ventas', 'Registro de venta');

            DB::commit();
            return redirect("bills/sales/$id_transaction")->with('success', "Venta agregada");
        } catch (\Throwable $th) {
            return $th;
            DB::rollback();
            return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"])->withInput();
        }
    }

    public function validationsQuery($querys){
        foreach ($querys as $key => $query) {
            if(count($query) == 0){
                switch ($key) {
                    case 0:
                        return [true, 'clientes'];
                        break;

                    case 1:
                        return [true, 'formas de pago'];
                        break;

                    case 2:
                        return [true, 'estados de operacion'];
                        break;

                    case 3:
                        return [true, 'tasas'];
                        break;

                    case 4:
                        return [true, 'productos'];
                        break;

                    default:
                        return [false, ''];
                        break;
                }
            } else{
                return [false, ''];
            }
        }
    }
}
