<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_files', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('extension');
            $table->double('size');
            $table->longText('url');
            $table->unsignedBigInteger('owned_by');
            $table->foreign('owned_by')->references('id')->on('users')->onDelete('cascade');
            $table->text('shared_with')->nullable();
            $table->bigInteger('file_type')->default(0);
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
        Schema::dropIfExists('user_files');
    }
}
