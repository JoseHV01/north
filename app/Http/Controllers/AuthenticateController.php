<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AuthenticateController extends Controller
{
    public function login(LoginRequest $request){
        $extendLogsController = new LogsController();

    	try {
            $getUser = DB::table('users')->where('email', $request->userName);

            if($getUser->value('status') == 0){
                return back()->withErrors(['error'=>"Usuario inhabilitado"]);
			}

	    	if (Auth::attempt(["email" => $request->userName, "password" => $request->userPassword])) {
				$getUser->update([
                    'entry_intention' => 0,
                    'expires_session' => date('Y-m-d H:i:s', strtotime('+5 minutes'))
                ]);

                $this->queryDollar();
				$this->queryProductsOutOfStock();
                $this->getPermissions();

                if(count(Cache::get('permissions')) == 0){
                    $this->logout();
                    $extendLogsController->insertLogOperations('Autenticacion', 'Usuario no tiene permisos asignados');
                    return back()->withErrors(['error' => "Usuario sin permisos asignados, debes solicitar permisos"]);
                }

                $extendLogsController->insertLogOperations('Autenticacion', 'Ingreso al sistema');
                return redirect('dashboard');
	    	}else{
                $this->changeStatus($request->userName);

                if($getUser->value('status') == -1){
                    return back()->withErrors(['error' => "Usuario bloqueado. Cambie la contraseña"]);
                }else{
                    return back()->with('warning', "Datos incorrectos, vuelve a intentar");
                }
	    	}
    	} catch (\Throwable $th) {
            return $th;
			return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
    	}
    }

	public function queryProductsOutOfStock(){
		$productsOut = DB::table('products')->where('existence', '<=', 'existence_minime')->orderBy('existence_minime', 'ASC')->get();
		return Cache::forever('productsOut', $productsOut);
	}

	public function queryDollar(){
		$bcv = DB::table('rates')->where('name', 'like', '%BCV')->value('value');
		return Cache::forever('bcv', $bcv);
	}

    private function changeStatus($email){
        $getUser = DB::table('users')->where('email', $email);
        $getUser->increment('entry_intention');

        if($getUser->value('entry_intention') == 3) {
            $getUser->update([ 'status' => -1 ]);
        }
    }

    public function getPermissions(){
        if (auth()->user()->id_rol == 2) {
            $permissions = DB::table('users_permissions')
            ->where('id_user', auth()->user()->id)
            ->select('permission')
            ->get()
            ->toArray();

            $arrayPermission = [];

            foreach ($permissions as $item) {
                array_push($arrayPermission, $item->permission);
            }
        } else {
            $arrayPermission = ['Ventas', 'Compras', 'Productos', 'Proveedores', 'Clientes'];
        }

		return Cache::forever('permissions', $arrayPermission);
    }

    public function logout(){
        $controllerSession = new SessionsController();
        $controllerSession->destroySession();

        Auth::logout();
        session()->flush();
        Cache::flush();
        return redirect('/');
    }
}
