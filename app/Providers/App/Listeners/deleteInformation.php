<?php

namespace App\Providers\App\Listeners;

use App\Providers\App\Events\informationHasBeenRemoved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class deleteInformation
{
    public function handle(informationHasBeenRemoved $event)
    {
        if($event->resultQueryOperation == false){
            DB::table($event->table)->where('id', $event->id)->delete();
        }
    }
}
