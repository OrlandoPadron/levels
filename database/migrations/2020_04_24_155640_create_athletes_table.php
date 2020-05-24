<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAthletesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('athletes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('trainer_id')->nullable();
            // $table->unsignedBigInteger('subscription_plan_id')->nullable();
            // $table->foreign('subscription_plan_id')->references('id')->on('subscriptions');
            $table->boolean('monthPaid')->default(false);
            $table->string('payment_date')->nullable();
            $table->string('subscription_description')->nullable();
            $table->double('subscription_price')->nullable();
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
        Schema::dropIfExists('athletes');
    }
}
