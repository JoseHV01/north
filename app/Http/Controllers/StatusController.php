<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    public function update($type, $id){
        DB::beginTransaction();
        try {
            $currecyStatus = DB::table($type)->where('id', $id)->value('status');
            if($currecyStatus == 1){
                $newStatus = [0, 'Inhabilitado'];
            }else{
                $newStatus = [1, 'Habilitado'];
            }

            DB::table($type)->where('id', $id)->update([
                'status' => $newStatus[0]
            ]);

            DB::commit();
            return redirect()->back()->with('success', $newStatus[1]." con exito");
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }
}
