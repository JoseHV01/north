<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Providers\App\Events\informationHasBeenRemoved;
use App\Http\Requests\RatesRequest;
use Illuminate\Support\Facades\Cache;

class RatesController extends Controller
{

    private $tax = ['Aplicar subtotal', 'Aplicar a base imponible'];
    
    public function index()
    {
        $rates = DB::table('rates')->orderBy('status', 'DESC')->orderBy('name', 'ASC')->paginate(10);
        return view('pages/rates')->with('rates', $rates);
    }

    public function store(RatesRequest $request)
    {
        DB::beginTransaction();
        try {

            DB::table('rates')->insert([
                'name' => $request->name,
                'value' => $request->value,
                'tax' => $this->tax[$request->tax]
            ]);

            DB::commit();
            return redirect()->back()->with('success', "Tasa agregada");
        } catch (\Throwable $th) {
            DB::rollback();
			return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    public function update(RatesRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            DB::table('rates')->where('id', $id)->update([
                'name' => $request->name,
                'value' => $request->value,
                'tax' => $this->tax[$request->tax]
            ]);

            DB::commit();
            return redirect()->back()->with('success', "Tasa editada");
        } catch (\Throwable $th) {
            DB::rollback();
			return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            event(new informationHasBeenRemoved($id, 'rates', false));
            DB::commit();
            return redirect()->back()->with('success', "Categoria eliminada");
        } catch (\Throwable $th) {
            return $th;
            DB::rollback();
            return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    public function changeBCV(Request $request){
        // if(!is_numeric($request->value)) return back()->withErrors(['error' => "Debe ingresar solo numeros"]);
        
        // DB::beginTransaction();
        // try {

        //     DB::table('rates')->where('id', $id)->update([
        //         'name' => $request->name,
        //         'value' => $request->value,
        //         'tax' => $request->tax
        //     ]);

        //     Cache::forever('bcv', $request->value);

        //     DB::commit();
        //     return redirect()->back()->with('success', "Tasa BCV actualizada");
        // } catch (\Throwable $th) {
        //     DB::rollback();
		// 	return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        // }
    }

    public function changeStatus($id)
    {
        DB::beginTransaction();
        try {
            $rate = DB::table('rates')->where('id', $id)->first();
            $status = $rate->status == 1 ? 0 : 1;

            DB::table('rates')->where('id', $id)->update([
                'status' => $status
            ]);

            DB::commit();
            return redirect()->back()->with('success', "Tasa ".($status == 1 ? 'habilitada' : 'inhabilitada'));
        } catch (\Throwable $th) {
            DB::rollback();
			return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }
}
