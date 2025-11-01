<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Cache;

use Closure;

class Shoppings
{
    public function handle($request, Closure $next)
    {
        $permission = Cache::get('permissions');
        if(in_array('Compras', $permission)){
            return $next($request);
        }else{
			return back()->withErrors(['error' => "Ruta no autorizada"]);
        }
    }
}
