<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->default(0)->comment('用户ID');
            $table->integer('category_id')->unsigned()->default(0)->comment('栏目ID');
            $table->string('title', 255)->default('')->comment('标题');
            $table->string('cover', 255)->nullable()->comment('封面图');
            $table->string('summary', 1024)->default('')->comment('摘要');
            $table->text('content_md')->comment('内容');
            $table->text('content_html')->comment('内容');
            $table->tinyInteger('publish_status')->unsigned()->default(1)->comment('状态(1已发布，2草稿)');
            $table->tinyInteger('recommend')->unsigned()->default(1)->comment('是否推荐（1不推荐，2推荐）');
            $table->integer('page_views')->unsigned()->default(0)->comment('浏览量');
            $table->integer('content_length')->unsigned()->default(0)->comment('字数');
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
        Schema::dropIfExists('articles');
    }
}
