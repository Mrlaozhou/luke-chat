<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class User extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create( 'users', function (Blueprint $table) {
            $table->unsignedInteger('fd')->primary()->comment('主键');
            $table->string('role', 60)->default('student')->comment('类型');
            $table->unsignedInteger('pk')->default(0)->comment('用户主键')->index();

            $table->string('info', 1000)->default('')->comment('用户信息');
            $table->string('token', 1000)->default('')->comment('连接token');
            $table->timestamps();
            $table->engine          =   'Memory';
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
        Schema::dropIfExists( 'users' );
    }
}
