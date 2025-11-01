<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\LogsController;
use Closure;

class Customers
{
    protected $controller;

    public function __construct(LogsController $controller)
    {
        $this->controller = $controller;
    }

    public function handle($request, Closure $next)
    {
        $permission = Cache::get('permissions');
        if(in_array('Clientes', $permission)){
            $this->controller->store($request, 'Clientes');
            return $next($request);
        }else{
			return back()->withErrors(['error' => "Ruta no autorizada"]);
        }
    }
}
