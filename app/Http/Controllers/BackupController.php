<?php

namespace App\Http\Controllers;

use Spatie\Backup\Tasks\Backup\BackupJob;

class BackupController extends Controller
{
    public function index(){
        try {
            $ubicacionArchivoTemporal = getcwd() . DIRECTORY_SEPARATOR . "respaldo-north-" . date("Y-m-d") . ".sql";

            $salida = "";
            $codigoSalida = 0;
            $comando = sprintf("%s --user=\"%s\" --password=\"%s\" %s > %s", env("DB_MYSQLDUMP"), env("DB_USERNAME"), env("DB_PASSWORD"), env("DB_DATABASE"), $ubicacionArchivoTemporal);
            exec($comando, $salida, $codigoSalida);

            if ($codigoSalida !== 0) {
                return "Código de salida distinto de 0, se obtuvo código (" . $codigoSalida . "). Revise los ajustes e intente de nuevo";
            }

            return response()->download($ubicacionArchivoTemporal)->deleteFileAfterSend(true);
        } catch (\Throwable $th) {
			return back()->withErrors(['error'=>"Ha ocurrido un error, vuelve a intentar"]);
        }
    }
}
