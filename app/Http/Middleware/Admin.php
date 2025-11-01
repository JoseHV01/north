<?php

namespace App\Http\Middleware;
use App\Http\Controllers\LogsController;
use Closure;

class Admin
{
    protected $controller;

    public function __construct(LogsController $controller)
    {
        $this->controller = $controller;
    }

    public function handle($request, Closure $next)
    {
        if(auth()->user()->id_rol == 1){
            $module = $this->controller->formatModule($request->url());
            $this->controller->store($request, $module);
            return $next($request);
        }else{
			return back()->withErrors(['error' => "Ruta no autorizada"]);
        }
    }
}
