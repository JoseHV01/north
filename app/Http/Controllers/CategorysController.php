<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Providers\App\Events\informationHasBeenRemoved;
use App\Http\Requests\CategorysRequest;

class CategorysController extends Controller
{
    public function index()
    {
        $categorys = DB::table('categorys')->orderBy('status', 'DESC')->orderBy('name', 'ASC')->paginate(10);
        return view('pages/categorys')->with('categorys', $categorys);
    }

    public function store(CategorysRequest $request)
    {
        DB::beginTransaction();
        try {

            DB::table('categorys')->insert([
                'name' => $request->name
            ]);

            DB::commit();
            return redirect()->back()->with('success', "Categoria agregada");
        } catch (\Throwable $th) {
            DB::rollback();
			return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    public function update(CategorysRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            DB::table('categorys')->where('id', $id)->update([
                'name' => $request->name
            ]);

            DB::commit();
            return redirect()->back()->with('success', "Categoria editada");
        } catch (\Throwable $th) {
            DB::rollback();
			return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            event(new informationHasBeenRemoved($id, 'categorys', $this->queryOperationsCategory($id)));
            DB::commit();
            return redirect()->back()->with('success', "Categoria eliminada");
        } catch (\Throwable $th) {
            DB::rollback();
			return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    private function queryOperationsCategory($idCategory){
        return DB::table('products')->where('id_category', $idCategory)->exists();
    }
}
