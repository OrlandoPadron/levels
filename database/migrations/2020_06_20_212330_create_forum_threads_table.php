<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_threads', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('author')->nullable();
            $table->boolean('pinned')->default(false);
            $table->unsignedBigInteger('user_associated')->nullable();
            $table->foreign('user_associated')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('group_associated')->nullable();
            $table->foreign('group_associated')->references('id')->on('groups')->onDelete('cascade');
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
        Schema::dropIfExists('forum_threads');
    }
}
