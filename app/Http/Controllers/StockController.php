<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        $stock = DB::table('purchases_invoices')
        ->orderBy('created_at')
        ->get();

        $stock->each(function($item){
            $lotes = DB::table('stock')
            ->join('products', 'products.id', '=', 'stock.id_product')
            ->join('purchases_invoice_details', 'purchases_invoice_details.id_purchase_invoice', '=', 'stock.id_purchase_invoice')
            ->where('stock.id_purchase_invoice', $item->id)
            ->select('stock.*', 'products.description', 'purchases_invoice_details.amount')
            ->get();

            // dd($lotes);
            $item->lotes = json_decode($lotes);
            // dd($item);
        });

        dd($stock);
        return view('pages/stock');
    }
}
