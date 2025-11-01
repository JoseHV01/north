<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentTypesSeeder extends Seeder
{

    public function run()
    {
        DB::table('document_types')->insert([
        	[
                'name' => 'E -'
            ],
            [
                'name' => 'G -'
            ],
            [
                'name' => 'J -'
            ],
            [
                'name' => 'V -'
            ]
        ]);
    }
}
