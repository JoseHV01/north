<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CheckEmailRequest;
use App\Http\Requests\RecoverAccessRequest;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Http\Controllers\UsersController;

class RecoverAccessController extends Controller
{
    public function checkEmail(CheckEmailRequest $request){
        try {
            Cache::flush();
            $this->selectionAsk($request->email);
            return redirect('ask');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => "Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    public function askForm(){
        return view('pages/recover_access')->with('success', "Correo Verificado")->with('ask', Cache::get('ask'));
    }

    public function recoverAccess(RecoverAccessRequest $request){
        DB::beginTransaction();
        try {
            $answer = DB::table('asks_security')
            ->where('id', $request->id)
            ->value('answer');

            if(decrypt($answer) == $request->answer){
                $messageAlert = '';

                if(preg_match_all('!\d+!', $request->password) == 0) $messageAlert = 'La contraseña ingresada debe de tener por lo menos un numero';

                if(preg_match('/[A-Z]/', $request->password) == 0) $messageAlert = 'La contraseña ingresada debe de tener por lo menos una letra Mayuscula';

                if(preg_match('/[a-z]/', $request->password) == 0) $messageAlert = 'La contraseña ingresada debe de tener por lo menos una letra Minuscula';

                if($messageAlert != ''){
                    return back()->withErrors(["error" => $messageAlert]);
                }else{
                    DB::table('users')->where('email', Cache::get('user_email'))->update([
                        'status' => 1,
                        'password' => Hash::make($request->password)
                    ]);

                    DB::commit();
                    return redirect('/')->with('success', "Acceso Recuperado");
                }
            }else{
                return back()->withErrors(['error' => "Respuesta incorrecta"]);
            }
        } catch (\Throwable $th) {
            DB::rollback();
			return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    public function selectionAsk($email){

        DB::beginTransaction();
        try {
            $asks = DB::table('users')
            ->join('asks_security', 'asks_security.id_user', '=', 'users.id')
            ->select('asks_security.id', 'asks_security.ask', 'users.email as email')
            ->where('email', $email)
            ->get();

            Cache::forever('ask', $asks->random(1)[0]);
            Cache::forever('user_email', $email);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
			return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }
}
