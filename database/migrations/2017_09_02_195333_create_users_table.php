<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 32);
            $table->string('email', 64)->default('');
            $table->string('avatar', 255)->default('');
            $table->string('phone', 32)->default('');
            $table->string('password', 64)->comment('密码');
            $table->tinyInteger('gender')->unsigned()->default(3)->comment('1男，2女，3未知');
            $table->tinyInteger('status')->unsigned()->default(1)->comment('1启用，2禁用');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
