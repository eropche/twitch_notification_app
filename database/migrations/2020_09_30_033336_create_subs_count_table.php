<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubsCountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subs_count', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('count');
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
        Schema::dropIfExists('subs_count');
    }
}
