<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStreamHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stream_history', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('date_start');
            $table->dateTime('date_end')->nullable();
            $table->integer('average_num_viewers')->nullable();
            $table->json('categories');
            $table->unsignedBigInteger('broadcaster_id');
            $table->foreign('broadcaster_id')
                ->references('id')
                ->on('broadcasters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stream_history');
    }
}
