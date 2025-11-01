<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Providers\App\Events\informationHasBeenRemoved;
use App\Http\Requests\ShapesPaymentRequest;

class ShapesPaymentController extends Controller
{
     public function index()
    {
        $shapes_payment = DB::table('shapes_payment')->orderBy('status', 'DESC')->orderBy('name', 'ASC')->paginate(10);
        return view('pages/shapes_payment')->with('shapes_payment', $shapes_payment);
    }

    public function store(ShapesPaymentRequest $request)
    {
        DB::beginTransaction();
        try {

            DB::table('shapes_payment')->insert([
                'name' => $request->name,
            ]);

            DB::commit();
            return redirect()->back()->with('success', "Forma de pago agregada");
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    public function update(ShapesPaymentRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            DB::table('shapes_payment')->where('id', $id)->update([
                'name' => $request->name,
            ]);

            DB::commit();
            return redirect()->back()->with('success', "Forma de pago editada");
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            event(new informationHasBeenRemoved($id, 'shapes_payment', false));
            DB::commit();
            return redirect()->back()->with('success', "Forma de pago eliminada");
        } catch (\Throwable $th) {
            return $th;
            DB::rollback();
            return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }
}
