<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Providers\App\Events\informationHasBeenRemoved;
use App\Http\Requests\ProductsRequest;

class ProductsController extends Controller
{
    public function index()
    {
        $products = DB::table('products')
        ->join('categorys', 'categorys.id', '=', 'products.id_category')
        ->orderBy('status', 'DESC')
        ->orderBy('description', 'ASC')
        ->select('products.*', 'categorys.id as category')
        ->paginate(10);

        $products->each(function($product) {
            $stockProducts = DB::table('stock')
            ->where('id_product', $product->id)
            ->orderBy('created_at', 'ASC')
            ->select('quantity', 'exists', 'created_at')
            ->get();

            $product->stocks = $stockProducts;
        });

        $categories = DB::table('categorys')->where('status', 1)->orderBy('name', 'ASC')->select('id', 'name')->get();

        $rates = DB::table('rates')->where('status', 1)->get();
        $ganance = $rates->firstWhere('name', "like", '%anancia%')->value ?? 0;
        $bcv = $rates->firstWhere('name', 'BCV')->value ?? 0;

        return view('pages/products')->with('products', $products)->with('categories', $categories)->with('ganance', $ganance)->with('bcv', $bcv);
    }

    public function store(ProductsRequest $request)
    {
        DB::beginTransaction();
        try {

            DB::table('products')->insert([
                'description' => $request->description,
                'id_category' => $request->category,
                'iva' => 1,
                'existence_minime' => $request->minime
            ]);

            $refreshProductsList = new AuthenticateController();
            $refreshProductsList->queryProductsOutOfStock();

            DB::commit();
            return redirect()->back()->with('success', "Producto agregado");

        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    public function update(ProductsRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            DB::table('products')->where('id', $id)->update([
                'description' => $request->description,
                'id_category' => $request->category,
                'iva' => 1,
                'existence_minime' => $request->minime
            ]);

            DB::commit();
            return redirect()->back()->with('success', "Producto editado");
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            event(new informationHasBeenRemoved($id, 'products', $this->queryOperationsProduct($id)));

            DB::commit();
            return redirect()->back()->with('success', "Producto eliminado");
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    private function queryOperationsProduct($idProduct){
        $operationsSales = DB::table('sales_invoice_details')->where('id_product',$idProduct)->exists();

        if($operationsSales || $operationsSales){
            return true;
        }else{
            return false;
        }
    }

    public function searchProduct(Request $request){
        $products = DB::table('products')
        ->join('categorys', 'categorys.id', '=', 'products.id_category')
        ->where('description', 'like', "%$request->product%")
        ->orderBy('description', 'ASC')
        ->select('products.*', 'categorys.id as category')
        ->paginate(10);

        $products->each(function($product) {
            $stockProducts = DB::table('stock')
            ->where('id_product', $product->id)
            ->orderBy('created_at', 'ASC')
            ->select('quantity', 'exists', 'created_at')
            ->get();

            $product->stocks = $stockProducts;
        });

        $categories = DB::table('categorys')->where('status', 1)->orderBy('name', 'ASC')->select('id', 'name')->get();
        $ganance = DB::table('rates')->where('name', "like", '%anancia%')->where('status', 1)->value('value');

        return view('pages/products')->with('products', $products)->with('categories', $categories)->with('ganance', $ganance);
    }
}
