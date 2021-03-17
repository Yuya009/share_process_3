<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('followed_user_id');
            $table->unsignedBigInteger('following_user_id');
            $table->foreign('followed_user_id')->references('id')->on('users')->onDelete('cascade'); //外部キー参照
            $table->foreign('following_user_id')->references('id')->on('users')->onDelete('cascade'); //外部キー参照
            $table->unique(['followed_user_id', 'following_user_id'],'uq_follow'); //Laravelは複合主キーが扱いにくいのでユニークで代用＆第二引数はキーの名前
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follow_user');
    }
}
