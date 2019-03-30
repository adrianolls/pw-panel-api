<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPendingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panel_user_pendings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 32);
            $table->string('nickname', 16);
            $table->string('login', 12);
            $table->string('email');
            $table->string('password', 64);
            $table->string('code', 40);
            $table->integer('resend_times')->default(0);
            $table->boolean('enable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('panel_user_pendings');
    }
}
