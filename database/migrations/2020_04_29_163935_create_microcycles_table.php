<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMicrocyclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('microcycles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('mesocycle_associated');
            $table->foreign('mesocycle_associated')->references('id')->on('mesocycles')->onDelete('cascade');
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
        Schema::dropIfExists('microcycles');
    }
}
