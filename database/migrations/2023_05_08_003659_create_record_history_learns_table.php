<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_history_learns', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->integer('number_card_learn');
            $table->boolean('status');
            $table->float('time_avg');
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
        Schema::dropIfExists('record_history_learns');
    }
};
