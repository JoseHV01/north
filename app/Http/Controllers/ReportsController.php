<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use stdClass;

class ReportsController extends Controller
{
    public function index()
    {
        return view('pages/reports')->with('valueTotalProducts', $this->calculateValueTotalProducts())->with('valueTotalGanance', $this->calculateValueGanance())->with('totalTransaction', $this->calculateTransactionsTotal())->with('queryDates', $this->queryDateTable())->with('queryDatesDistribution', $this->queryDistributionTransaction())->with('queryDatesOperations', $this->queryDistributionTransaction());
    }

    public function queryDateTable(){
        $months = DB::table('stock_register')
            ->selectRaw("DATE_FORMAT(created_at, '%m') as month")
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get();

        $years = DB::table('stock_register')
            ->selectRaw("DATE_FORMAT(created_at, '%Y') as year")
            ->groupBy('year')
            ->orderBy('year', 'ASC')
            ->get();

        return [$months, $years];
    }

    public function productMoreSale($year, $month){
        $productsSales = DB::table('products')
        ->join('stock', 'stock.id_product', '=', 'products.id')
        ->join('stock_register', 'stock_register.id_stock', '=', 'stock.id')
        ->whereMonth('stock_register.created_at', $month)
        ->whereYear('stock_register.created_at', $year)
        ->selectRaw('products.id, SUM(quantity_sale) as total')
        ->groupBy('products.id')
        ->orderBy('total', 'DESC')
        ->take(5)
        ->get();

        return $productsSales->each(function ($product) {
            $nameProduct = DB::table('products')->where('id', $product->id)->value('description');
            $product->name = $nameProduct;
        });
    }

    public function selectDatesRegister($year = null){
        if(!$year) $year = date('Y');

        $months = DB::table('stock_register')
        ->selectRaw("DATE_FORMAT(created_at, '%m-%M') as month")
        ->orderBy('created_at', 'ASC')
        ->groupBy('month')
        ->whereYear('created_at', $year)
        ->get();

        $years = DB::table('stock_register')
        ->selectRaw("DATE_FORMAT(created_at, '%Y') as year")
        ->orderBy('created_at', 'ASC')
        ->groupBy('year')
        ->get();

        return json_encode([$months, $years]);
    }

    public function calculateValueTotalProducts(){
        $totalValue = 0;
        $stock = DB::table('products')->where('existence', '!=', 0)->get();
        foreach ($stock as $item) {
            $totalValue += ($item->price * $item->existence);
            return $totalValue;
        }
    }

    public function calculateValueGanance(){
        // evaluar si se implementa correctamente la funcion
        $totalGanance = 0;
        $productDetails = DB::table('purchases_invoice_details')->select('id_product', 'id_purchase_invoice', 'price', 'percentaje')->get();
        foreach ($productDetails as $item) {
            $percentajeProduct = 100 - $item->percentaje;
            $priceSale = ($item->price / $percentajeProduct) * 100;
            $gananceProduct = $priceSale - $item->price;

            $quantityProduct = DB::table('stock')
            ->where('id_purchase_invoice', $item->id_purchase_invoice)
            ->where('id_product', $item->id_product)
            ->value('quantity');

            if($quantityProduct >= 1) $totalGanance += ($gananceProduct * $quantityProduct);
        }

        return $totalGanance;
    }

    public function calculateTransactionsTotal(){
        $totalSales = DB::table('sales_invoices')->count();
        $totalPurchases = DB::table('purchases_invoices')->count();
        return [$totalSales, $totalPurchases];
    }

    public function queryOperations($year){
        $totalPurchases = DB::table('purchases_invoices')
        ->join('purchases_invoice_details', 'purchases_invoice_details.id_purchase_invoice', 'purchases_invoices.id')
        ->join('products', 'products.id', 'purchases_invoice_details.id_product')
        ->select(
            DB::raw("count(products.id) as total"),
            DB::raw("DATE_FORMAT(purchases_invoices.created_at, '%m') as month"),
        )
        ->orderBy('purchases_invoices.created_at', 'ASC')
        ->groupBy('month')
        ->where('purchases_invoices.status', 0)
        ->whereYear('purchases_invoices.created_at', $year)
        ->get();

        $totalSales = DB::table('sales_invoices')
        ->join('sales_invoice_details', 'sales_invoice_details.id_sales_invoice', 'sales_invoices.id')
        ->join('products', 'products.id', 'sales_invoice_details.id_product')
        ->select(
            DB::raw("count(products.id) as total"),
            DB::raw("DATE_FORMAT(sales_invoices.created_at, '%m') as month"),
        )
        ->orderBy('sales_invoices.created_at', 'ASC')
        ->groupBy('month')
        ->where('sales_invoices.status', 0)
        ->whereYear('sales_invoices.created_at', $year)
        ->get();

        return json_encode([$totalPurchases, $totalSales]);
    }

    public function queryDistributionTransaction(){
        $months = [];
        $years = [];

        $monthsSales = DB::table('sales_invoices')
            ->selectRaw("DATE_FORMAT(created_at, '%m') as month")
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get();

        foreach ($monthsSales as $value) {
            array_push($months, intval($value->month));
        }

        $yearsSales = DB::table('sales_invoices')
            ->selectRaw("DATE_FORMAT(created_at, '%Y') as year")
            ->groupBy('year')
            ->orderBy('year', 'ASC')
            ->get();

        foreach ($yearsSales as $value) {
            array_push($years, intval($value->year));
        }

        $monthsPurchases = DB::table('purchases_invoices')
            ->selectRaw("DATE_FORMAT(created_at, '%m') as month")
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get();

        foreach ($monthsPurchases as $value) {
            if(!in_array($value->month, $months)) array_push($months, intval($value->month));
        }

        $yearsPurchases = DB::table('purchases_invoices')
            ->selectRaw("DATE_FORMAT(created_at, '%Y') as year")
            ->groupBy('year')
            ->orderBy('year', 'ASC')
            ->get();

        foreach ($yearsPurchases as $value) {
            if(!in_array($value->year, $years)) array_push($years, intval($value->year));
        }

        sort($months);
        sort($years);

        return [$months, $years];
    }

    public function distributionTransaction($year, $month){
        $array = [];
        $totalSales = $this->queryDistributionTransactionAll('sales_invoices', 'id_shapes_payment', $year, $month);
        $totalShopping = $this->queryDistributionTransactionAll('purchases_invoices', 'id_shape_payment', $year, $month);
        $total = $totalSales->concat($totalShopping)->groupBy('name');

        foreach ($total as $item) {
            $register = new stdClass();
            $register->name = '';
            $register->total = 0;

            $item->each(function($element) use ($register) {
                $register->name = $element->name;
                $register->total = $register->total + $element->total;
                return $register;
            });

            array_push($array, $register);
        }

        return json_encode($array);
    }

    public function queryDistributionTransactionAll($table_name, $column_name, $year, $month){
        return DB::table('shapes_payment')
        ->join($table_name, "$table_name.$column_name", 'shapes_payment.id')
        ->select(
            DB::raw("count(shapes_payment.id) as total"),
            'name'
        )
        ->orderBy('name', 'ASC')
        ->groupBy('name')
        ->whereMonth("$table_name.created_at", $month)
        ->whereYear("$table_name.created_at", $year)
        ->get();
    }
}
