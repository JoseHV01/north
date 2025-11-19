<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Cache;
// use App\Http\Controllers\LogsController;
use Closure;

class Sales
{
    // protected $controller;

    // public function __construct(LogsController $controller)
    // {
    //     $this->controller = $controller;
    // }

    public function handle($request, Closure $next)
    {
        $permission = Cache::get('permissions');
        if(!empty($permission)){
            if(in_array('Ventas', $permission)){
                // $this->controller->store($request, 'Ventas');
                return $next($request);
            }else{
                return back()->withErrors(['error' => "Ruta no autorizada"]);
            }
        } else {
            return back()->withErrors(['error' => "Ruta no autorizada"]);   
        }
    }
}
