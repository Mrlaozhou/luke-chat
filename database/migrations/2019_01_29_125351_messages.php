<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Messages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create( 'messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('say_fd')->default(0)->comment('来自:fd')->index();
            $table->unsignedInteger('say_pk')->default(0)->comment('来自:模型ID')->index();
            $table->string('say_role', 60)->default('member')->comment('来自:角色')->index();
            $table->unsignedInteger('listen_fd')->default(0)->comment('目标:fd')->index();
            $table->unsignedInteger('listen_pk')->default(0)->comment('目标:模型ID')->index();
            $table->string('listen_role', 60)->default('member')->comment('目标:角色')->index();
            $table->string('type', 60)->default('message')->comment('类型');
            $table->string('text', 1000)->default('')->comment('文本内容');
            $table->string('file', 300)->default('')->comment('文件')->index();
            $table->unsignedInteger('say_at')->default(0)->comment('来自:时间');
            $table->unsignedInteger('listen_at')->default(0)->comment('目标:时间');
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists( 'messages' );
    }
}
