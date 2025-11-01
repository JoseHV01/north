<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CompanyRequest;
// use Spatie\Backup\Tasks\Backup\BackupJob;

class CompanyController extends Controller
{
    public function index()
    {
        return view('pages/company')->with('data_company', DB::table('company')->orderBy('created_at', 'DESC')->first());
    }

    public function store(CompanyRequest $request)
    {
        DB::beginTransaction();
        try {

            DB::table('company')->insert([
                'name' => $request->name,
                'rif' => $request->rif,
                'direction' => $request->direction,
                'phone' => $request->phone,
                'email' => $request->email
            ]);

            DB::commit();
            return redirect()->back()->with('success', "Datos editados");
        } catch (\Throwable $th) {
            return $th;
            DB::rollback();
            return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    public function backUpDB() {
        return "por probar";
        // try {
        //     $backUpJob = app(BackupJob::class);
        //     $backUpJob->run();

        //     if($backUpJob->wasSuccessful()){
        //         return redirect()->back()->with('success', "Respaldo de bd exitoso");
        //     }

        //     return back()->withErrors(['error'=>"Respaldo de bd no ejecutado"]);

        // } catch (\Throwable $th) {
        //     return $th;
        //     return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        // }
    }
}
