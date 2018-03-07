<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('times', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('user_id')->unsigned();
        //     $table->integer('address_id')->unsigned();
        //     $table->string('time');
        //     $table->foreign('address_id')
        //           ->references('id')
        //           ->on('addresses')
        //           ->onDelete('cascade');
        //     $table->foreign('user_id')
        //           ->references('id')
        //           ->on('users')
        //           ->onDelete('cascade');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('times');
    }
}
