<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAskSecurityTable extends Migration
{
    
    public function up()
    {
        Schema::create('asks_security', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->string('ask');
            $table->string('answer');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asks_security');
    }
}
