<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthGithubUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_github_users', function (Blueprint $table) {
            $table->integer('user_id')->default(0)->comment('');
            $table->string('login', 256)->default('')->comment('登录账号');
            $table->bigInteger('id')->default(0)->comment('github用户ID');
            $table->string('avatar_url', 256)->default('')->comment('头像');
            $table->string('gravatar_id', 256)->default('')->comment('');
            $table->string('url', 256)->default('')->comment('');
            $table->string('html_url', 256)->default('')->comment('');
            $table->string('followers_url', 256)->default('')->comment('');
            $table->string('following_url', 256)->default('')->comment('');
            $table->string('gists_url', 256)->default('')->comment('');
            $table->string('starred_url', 256)->default('')->comment('');
            $table->string('subscriptions_url', 256)->default('')->comment('');
            $table->string('organizations_url', 256)->default('')->comment('');
            $table->string('repos_url', 256)->default('')->comment('');
            $table->string('events_url', 256)->default('')->comment('');
            $table->string('received_events_url', 256)->default('')->comment('');
            $table->string('type', 32)->default('')->comment('');
            $table->string('site_admin', 256)->default('')->comment('站点管理员');
            $table->string('name', 64)->default('')->comment('用户名');
            $table->string('company', 64)->nullable()->comment('公司');
            $table->string('blog', 64)->nullable()->comment('博客地址');
            $table->string('location', 64)->nullable()->comment('所在地');
            $table->string('email', 64)->default('')->comment('邮箱');
            $table->string('hireable', 64)->nullable()->comment('');
            $table->string('bio', 256)->nullable()->comment('简介');
            $table->integer('public_repos')->default(0)->comment('公开仓库数量');
            $table->integer('public_gists')->default(0)->comment('');
            $table->integer('followers')->default(0)->comment('');
            $table->integer('following')->default(0)->comment('');
            $table->string('created_at', 64)->default('')->comment('github维护');
            $table->string('updated_at', 64)->default('')->comment('github维护');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oauth_github_users');
    }
}
