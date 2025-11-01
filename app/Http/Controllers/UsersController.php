<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\ChangeEmailRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ChangeAsksRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Encryption\DecryptException;

class UsersController extends Controller
{
    public function index(){
        $users = DB::table('users')
        ->join('roles', 'roles.id', '=', 'users.id_rol')
        ->where('users.id', '!=', 2)
        ->orderBy('users.status', 'DESC')
        ->orderBy('users.id', 'ASC')
        ->select('users.*', 'roles.role')
        ->get();

        $users->each(function($user) {
            $usersPermissions = DB::table('users_permissions')
            ->where('id_user', $user->id)
            ->select('permission')
            ->get()
            ->toArray();

            $user->permissions = $usersPermissions;
        });

        $modules = ['Ventas', 'Compras', 'Productos', 'Proveedores', 'Clientes'];

        return view('pages/users')->with('users', $users)->with('modules', $modules);
    }

    public function store(StoreUserRequest $request){
        DB::beginTransaction();
        try {
            $messageAlert = '';

            if(preg_match_all('!\d+!', $request->password) == 0) $messageAlert = 'La contraseña ingresada debe de tener por lo menos un numero';

            if(preg_match('/[A-Z]/', $request->password) == 0) $messageAlert = 'La contraseña ingresada debe de tener por lo menos una letra Mayuscula';

            if(preg_match('/[a-z]/', $request->password) == 0) $messageAlert = 'La contraseña ingresada debe de tener por lo menos una letra Minuscula';

            if($messageAlert != ''){
                return back()->withErrors(["error" => $messageAlert]);
            }else{
                $idUser = DB::table('users')->insertGetId([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                $this->saveAsksSecurity($idUser, $request);

                DB::commit();
                return redirect()->back()->with('success', "Usuario agregado");
            }
        } catch (\Throwable $th) {
            return $th;
            DB::rollback();
			return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    public function changeStatus($id){
        DB::beginTransaction();
        try {

            $statusUser = DB::table('users')->where('id', $id)->value('status');
            if($statusUser == 1){
                DB::table('users')->where('id', $id)->update([
                    'status' => 0
                ]);
            }else{
                DB::table('users')->where('id', $id)->update([
                    'status' => 1
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', $statusUser == 1 ? "Usuario Inhabilitado" : "Usuario Habilitado");
        } catch (\Throwable $th) {
            DB::rollback();
			return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    public function changePermissions(Request $request, $id){
        $this->validate($request, [
            'permissions.*' => 'required|string'
        ], [
            'permissions.required' => 'Debe seleccionar al menos un permiso',
            'permissions.string' => 'Los permisos deben contener solo letras',
        ]);

        $validModules = ['Ventas', 'Compras', 'Productos', 'Proveedores', 'Clientes'];

        foreach ($request->permissions as $item) {
            if(!in_array($item, $validModules)) return back()->withErrors(['error' => "Permiso no encontrado"]);
        }

        $existUser = DB::table('users')->where('id', $id)->exists();
        if(!$existUser) return back()->withErrors(['error' => "Usuario no encontrado"]);

        DB::beginTransaction();
        try {
            DB::table('users_permissions')->where('id_user', $id)->delete();

            foreach ($request->permissions as $item) {
                DB::table('users_permissions')->insert([
                    'id_user' => $id,
                    'permission' => $item
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', "Permisos gestionados con exito");
        } catch (\Throwable $th) {
            DB::rollback();
			return back()->withErrors(['error' => "Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    public function loadProfile(){
        $asks_security = DB::table('asks_security')->where('id_user', auth()->user()->id)->get();
        return view('pages/profile')->with('asks_security', $asks_security);
    }

    public function changeEmail(ChangeEmailRequest $request){

        DB::beginTransaction();
        try {

            $currentPassword = DB::table('users')->where('id', auth()->user()->id)->value('password');

            if(!Hash::check($request->password, $currentPassword)){
    			return back()->withErrors(['error' => "Contraseña Incorrecta"]);
            }else{
                DB::table('users')->where('id', auth()->user()->id)->update([
                    'email' => $request->email
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', "Correo cambiado con exito");
        } catch (\Throwable $th) {
            return $th;
            DB::rollback();
			return back()->withErrors(['error' => "Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    public function changePassword(ChangePasswordRequest $request){
        DB::beginTransaction();
        try {

            $currentPassword = DB::table('users')->where('id', auth()->user()->id)->value('password');

            if(!Hash::check($request->password, $currentPassword)){
                return back()->withErrors(['error' => "Contraseña Incorrecta"]);
            }else{
                $messageAlert = '';

                if(preg_match_all('!\d+!', $request->password) == 0) $messageAlert = 'La contraseña ingresada debe de tener por lo menos un numero';

                if(preg_match('/[A-Z]/', $request->password) == 0) $messageAlert = 'La contraseña ingresada debe de tener por lo menos una letra Mayuscula';

                if(preg_match('/[a-z]/', $request->password) == 0) $messageAlert = 'La contraseña ingresada debe de tener por lo menos una letra Minuscula';

                if($messageAlert != ''){
                    return back()->withErrors(["error" => $messageAlert]);
                }else{
                    DB::table('users')->where('id', auth()->user()->id)->update([
                        'password' => Hash::make($request->new_password)
                    ]);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', "Contraseña cambiada con exito");
        } catch (\Throwable $th) {
            return $th;
            DB::rollback();
			return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    public function changeAsks(ChangeAsksRequest $request){

        DB::beginTransaction();
        try {

            $currentPassword = DB::table('users')->where('id', auth()->user()->id)->value('password');

            if(!Hash::check($request->password, $currentPassword)){
    			return back()->withErrors(['error' => "Contraseña Incorrecta"]);
            }else{
                $this->saveAsksSecurity(auth()->user()->id, $request);
            }

            DB::commit();
            return redirect()->back()->with('success', "Preguntas de seguridad cambiadas con exito");
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
			return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    private function saveAsksSecurity($idUser, $request){
        DB::table('asks_security')->where('id_user', $idUser)->delete();
        for ($i=0; $i <= 2; $i++) {
            DB::table('asks_security')->insert([
                'id_user' => $idUser,
                'ask' => $request->asks[$i],
                'answer' => encrypt($request->answers[$i])
            ]);
        }
    }
}
