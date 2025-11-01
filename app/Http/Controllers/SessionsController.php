<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionsController extends Controller
{
    public function generateSession(){
    	try {
            DB::table('users')->where('id', auth()->user()->id)->update([
                'expires_session' => date('Y-m-d H:i:s', strtotime('+5 minutes'))
            ]);

            DB::commit();
            return redirect()->back()->with('success', "Session extendida con exito");
    	} catch (\Throwable $th) {
			return back()->withErrors(['error' => "Session no generada"]);
    	}
    }

    public function destroySession(){
        try {
            DB::table('users')->where('id', auth()->user()->id)->update([
                'expires_session' => null
            ]);

            DB::commit();
    	} catch (\Throwable $th) {
			return back()->withErrors(['error' => "Session no destruida"]);
    	}
    }
}
