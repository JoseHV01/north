<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Providers\App\Events\informationHasBeenRemoved;
use App\Http\Requests\StatesOperationRequest;

class StatesOperationController extends Controller
{
    
    public function index()
    {
        $states_operation = DB::table('states_operation')->orderBy('name', 'ASC')->paginate(10);

        return view('pages/states_operation')->with('states_operation', $states_operation);
    }

    
     public function store(StatesOperationRequest $request)
    {
        DB::beginTransaction();
        try {

            DB::table('states_operation')->insert([
                'name' => $request->name
            ]);

            DB::commit();
            return redirect()->back()->with('success', "Estado agregado");
        } catch (\Throwable $th) {
            return $th;
            DB::rollback();
            return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    public function update(StatesOperationRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            DB::table('states_operation')->where('id', $id)->update([
                'name' => $request->name
            ]);

            DB::commit();
            return redirect()->back()->with('success', "Estado editado");
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            event(new informationHasBeenRemoved($id, 'states_operation', $this->queryOperationsStatesOperation($id)));
            DB::commit();
            return redirect()->back()->with('success', "Estado eliminado");
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    private function queryOperationsStatesOperation($idStatesOperation){
        if(DB::table('sales_invoices')->where('id_state_operation', $idStatesOperation)->exists() || DB::table('purchases_invoices')->where('id_state_operation', $idStatesOperation)->exists()){
            return true;
        }else{
            return false;
        }
    }
}
