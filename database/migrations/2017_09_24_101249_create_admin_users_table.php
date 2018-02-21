<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 32)->comment('用户名');
            $table->string('email', 64)->default('')->comment('邮箱');
            $table->string('avatar', 255)->default('')->comment('头像');
            $table->string('phone', 32)->default('')->comment('手机号');
            $table->string('password', 64)->comment('密码')->comment('密码');
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
        Schema::dropIfExists('admin_users');
    }
}
