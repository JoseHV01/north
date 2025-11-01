<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShoppingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShoppingController extends Controller
{
    public function index()
    {
        $shopping = DB::table('purchases_invoices')
        ->join("providers", "providers.id", "id_provider")
        ->leftJoin('document_types', 'document_types.id', '=', 'providers.id_document_type')
        ->select("purchases_invoices.*", "providers.business_name", "providers.document", "document_types.name as document_type")
        ->orderBy('date', 'DESC')
        ->paginate(10);

        return view('pages/shopping')->with("shopping", $shopping);
    }

    public function create()
    {
        $providers = DB::table('providers')
        ->leftJoin('document_types', 'document_types.id', '=', 'providers.id_document_type')
        ->where('status', 1)
        ->orderBy('providers.business_name', 'ASC')
        ->select('providers.id', 'providers.business_name', 'providers.document', 'document_types.name as document_type')
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

        $salesController = new SalesController();

        if($providers->count() == 0){

            return back()->withErrors(['error' => "Debe tener registrados proveedores para poder agregar compras"]);
        }

        if($salesController->validationsQuery([[1], $shapes_payments, $states_operation, $rates, $products])[0]){

            return back()->withErrors(['error' => "Debe tener registrados ".$salesController->validationsQuery([[1], $shapes_payments, $states_operation, $rates, $products])[1]." para poder agregar compras"]);
        }

        return view('pages/shopping_create')->with('providers', $providers)->with('shapes_payments', $shapes_payments)->with('states_operation', $states_operation)->with('rates', $rates)->with('categorys', $categorys)->with('products', $products);
    }

    public function store(ShoppingRequest $request)
    {
        $totalBs = $request->input('totalShopping');
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
        
        DB::beginTransaction();
        try {

            $id_transaction = DB::table('purchases_invoices')->insertGetId([
                'id_provider' => $request->provider,
                'id_state_operation' => $request->states_operation,
                'total' => $request->totalShopping,
                'invoice_number' => $request->invoiceNumber,
                'control_number' => $request->controlNumber,
                'date' => $request->date,
                'created_at' => $request->date
            ]);

            foreach ($amounts as $id => $amount) {
                DB::table('purchases_invoice_shapes_payment')->insert([
                    'id_purchase_invoice' => $id_transaction,
                    'id_shape_payment' => $id,
                    'amount' => $amount,
                    'price_BCV' => $rate,
                ]);
            }

            foreach ($request->product_id as $key => $id) {

                $quantity_product = $request->quantity[$key];
                $priceProduct = $request->price[$key];
                $percentajeProduct = 100 - $request->percentaje[$key];
                $priceSale = ($priceProduct / $percentajeProduct) * 100;

                DB::table('purchases_invoice_details')->insert([
                    'id_purchase_invoice' => $id_transaction,
                    'id_product' => $id,
                    'amount' => $quantity_product,
                    'price' => $priceProduct,
                    'percentaje' => $request->percentaje[$key],
                ]);

                DB::table('stock')->insert([
                    'id_purchase_invoice' => $id_transaction,
                    'id_product' => $id,
                    'quantity' => $quantity_product,
                    'price_sale' => $priceSale
                ]);

                DB::table('products')
                ->where('id', $id)
                ->increment('existence', $quantity_product);

                $count = 0;
                $stockPrices = DB::table('stock')->where('id_product', $id)->where('exists', 1)->get();

                if(count($stockPrices) >= 2){
                    for ($i=0; $i < count($stockPrices); $i++) {
                        $count = ($count + $stockPrices[$i]->price_sale);
                    }

                    $aproximate = $count / count($stockPrices);
                }else{
                    $aproximate = $stockPrices[0]->price_sale;
                }

                DB::table('products')->where('id', $id)->update([
                    'price' => floor($aproximate * pow(10, 2)) / pow(10, 2)
                ]);
            }

            $extendController = new AuthenticateController();
            $extendController->queryProductsOutOfStock();

            $extendLogsController = new LogsController();
            $extendLogsController->insertLogOperations('Compras', 'Registro de compra');

            DB::commit();
            return redirect("bills/shopping/$id_transaction")->with('success', "Compra agregada");
        } catch (\Throwable $th) {
            return $th;
            DB::rollback();
            return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"])->withInput();
        }
    }

    public function show($id)
    {
        $result = $this->getBill($id);
        return view('pages/shopping_details')->with("shopping", $result[0])->with("products", $result[1]);
    }

    public function getBill($id)
    {
        $shopping = DB::table('purchases_invoices')
        ->join('providers', 'providers.id', '=', 'purchases_invoices.id_provider')
        ->leftJoin('document_types', 'document_types.id', '=', 'providers.id_document_type')
        ->join('states_operation', 'states_operation.id', '=', 'purchases_invoices.id_state_operation')
        ->where('purchases_invoices.id', $id)
        ->select(
            'purchases_invoices.*',
            'providers.business_name',
            'providers.document',
            'providers.phone',
            'document_types.name as document_type',
            'states_operation.name as state_operation',
            'providers.direction'
        )
        ->first();

        $shopping->payments = DB::table('purchases_invoice_shapes_payment')
        ->join('shapes_payment', 'shapes_payment.id', '=', 'purchases_invoice_shapes_payment.id_shape_payment')
        ->where('id_purchase_invoice', $id)
        ->select('shapes_payment.name as shape_payment', 'amount', 'price_BCV')
        ->get();

        $products = DB::table("purchases_invoice_details")->where("id_purchase_invoice", $id)
        ->join("products","products.id", "id_product")
        ->select("products.description", "purchases_invoice_details.*")
        ->get();

        return [$shopping, $products];
    }

    public function search(){
        $products = DB::table('products')
        ->where('products.status', 1)
        ->orderBy('description', 'ASC')
        ->select('products.*')
        ->get();

        $rates = DB::table('rates')->where('status', 1)->get();

        return json_encode([$products, $rates]);
    }
}
