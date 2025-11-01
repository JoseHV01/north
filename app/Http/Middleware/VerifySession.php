<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\LogsController;
use Closure;

class VerifySession
{
    protected $controller;

    public function __construct(LogsController $controller)
    {
        $this->controller = $controller;
    }

    public function handle($request, Closure $next)
    {
        // if(date('Y-m-d H:i:s') > auth()->user()->expires_session){
        //     Auth::logout();
        //     session()->flush();
        //     Cache::flush();
        //     return redirect('/')->withErrors(['error' => "Session expirada"]);
        // }else{
            $urlFormat = explode("/", str_replace('http://localhost/north_v2/public/', '', $request->url()));
            $segmentUrl = $urlFormat[0];
            if($segmentUrl == 'profile' || $segmentUrl == 'change' || $segmentUrl == 'logout'){
                $module = $this->controller->formatModule($request->url());
                $this->controller->store($request, $module);
            }

            DB::table('users')->where('id', auth()->user()->id)->update([
                'expires_session' => date('Y-m-d H:i:s', strtotime('+5 minutes'))
            ]);

            return $next($request);
        // }
    }
}
