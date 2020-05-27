<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutorships', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('goal')->nullable();
            $table->string('date');
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('athlete_associated');
            $table->foreign('athlete_associated')->references('id')->on('athletes')->onDelete('cascade');
            $table->boolean('bookmarked')->default(false);
            $table->integer('tutorship_number')->nullable();
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
        Schema::dropIfExists('tutorships');
    }
}
