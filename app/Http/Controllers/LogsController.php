<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogsController extends Controller
{
    protected $action;
    protected $data;
    protected $listModules = ['Productos', 'Ventas', 'Compras', 'Proveedores', 'Clientes', 'Base de datos', 'Perfil del Usuario', 'Autenticacion', 'Compania', 'Categorias', 'Formas de Pago', 'Tasas', 'Usuarios', 'Bitacora', 'Reportes y Graficas', ];

    public function index(){
        $users = DB::table('users')->select('id', 'name')->get();

    	$logs = DB::table('logs')
        ->join('users', 'users.id', 'logs.id_user')
        ->select('logs.*', 'users.name as user_name')
        ->orderBy('created_at', 'DESC')
        ->paginate(10);

        return view('pages/logs')->with('logs', $logs)->with('users', $users)->with('modules', $this->listModules);
    }

    public function store(Request $request, $module){
        $method = $request->method();
        $urlSegments = explode("/", str_replace('http://localhost/north_v2/public/', '', $request->url()));

        switch ($method) {
            case 'GET':
                switch ($module) {
                    case 'Base de datos':
                        $this->action = 'Respaldo de base de datos exitoso';
                        break;

                    case 'Perfil del Usuario':
                        $this->action = 'Visualizacion de los datos';
                        break;

                    case 'Autenticacion':
                        if($urlSegments[0] == 'logout') $this->action = 'Salio del sistema';
                        break;

                    default:
                        if(count($urlSegments) > 1 && $module != '') {
                            $this->action = 'Busqueda de registros';
                        }else{
                            $this->action = 'Visualizacion de registros';
                        }
                        break;
                }
                break;

            case 'POST':
                switch ($module) {
                    case 'Usuarios':
                        $this->action = 'Modificacion de permisos al usuario';
                        break;

                    case 'Compania':
                        $this->action = 'Modificacion de los datos de la compania';
                        break;

                    case 'Perfil del Usuario':
                        if($urlSegments[0] == 'change' && $urlSegments[1] == 'email') $this->action = 'Modificacion de correo';
                        if($urlSegments[0] == 'change' && $urlSegments[1] == 'password') $this->action = 'Modificacion de contrasena';
                        if($urlSegments[0] == 'change' && $urlSegments[1] == 'asks') $this->action = 'Modificacion de preguntas se seguridad';
                        break;

                    default:
                        $this->action = 'Insercion de registro';
                        break;
                }
                break;

            case 'PUT':
                $this->action = 'Edicion de registro';
                // $this->formatData($module, $request->all());
                break;

            case 'DELETE':
                $this->action = 'Eliminacion de registro';
                // $this->formatData($module, $request->all());
                break;

            default:
                dd('Route not found');
                break;
        }

        DB::beginTransaction();
        try {
            DB::table('logs')->insert([
                'id_user' => auth()->user()->id,
                'module' => $module,
                'action' =>  $this->action,
                'data' => json_encode($this->data)
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            return $th;
            DB::rollback();
            return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }

    public function formatModule($url){
        $urlFormat = explode("/", str_replace('http://localhost/north_v2/public/', '', $url));
        $segmentUrl = $urlFormat[0];

        if(count($urlFormat) == 2 && $urlFormat[1] == 'db') return 'Base de datos';

        switch ($segmentUrl) {
            case 'categorys':
                return 'Categorias';
                break;

            case 'shapes_payment':
                return 'Formas de Pago';
                break;

            case 'rates':
                return 'Tasas';
                break;

            case 'company':
                return 'Compania';
                break;

            case 'users':
                return 'Usuarios';
                break;

            case 'logs':
                return 'Bitacora';
                break;

            case 'reports':
                return 'Reportes y Graficas';
                break;

            case 'reports-table':
                return 'Reportes y Graficas (Productos mas vendidos)';
                break;

            case 'reports-operations':
                return 'Reportes y Graficas (Volumen de Ventas y Compras)';
                break;

            case 'reports-distribution':
                return 'Reportes y Graficas (Distribucion de formas de pago)';
                break;

            case 'profile':
                return 'Perfil del Usuario';
                break;

            case 'change':
                return 'Perfil del Usuario';
                break;

            default:
                if($segmentUrl == 'logout') return 'Autenticacion';
                break;
        }
    }

    public function searchLogs(Request $request){
        $users = DB::table('users')->select('id', 'name')->get();

    	$logs = DB::table('logs')
        ->join('users', 'users.id', 'logs.id_user')
        ->orderBy('created_at', 'DESC')
        ->select('logs.*', 'users.name as user_name');

        if($request->user_id){
            $logs = $logs->where('users.id', $request->user_id);
        }

        if($request->module){
            $logs = $logs->where('module', 'like', "%$request->module%");
        }

        if($request->start && $request->end){
            $logs = $logs->whereDate('logs.created_at', '>=', $request->start)->whereDate('logs.created_at', '<=', $request->end);
        }

        if($request->start){
            $logs = $logs->whereDate('logs.created_at', '>=', $request->start);
        }

        if($request->end){
            $logs = $logs->whereDate('logs.created_at', '<=', $request->end);
        }

        return view('pages/logs')->with('logs', $logs->paginate(10))->with('users', $users)->with('modules', $this->listModules);
    }

    public function insertLogOperations($module, $action){
        DB::beginTransaction();
        try {
            DB::table('logs')->insert([
                'id_user' => auth()->user()->id,
                'module' => $module,
                'action' =>  $action,
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            return $th;
            DB::rollback();
            return back()->withErrors(['error' => "Error al insertar el log"]);
        }
    }
}
