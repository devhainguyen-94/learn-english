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
        Schema::create('user_learn_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('group_id');
            $table->unsignedInteger('card_detail_id');
            $table->dateTimeTz('time_remind');
            $table->integer('const_q');
            $table->integer('times_learn_again');
            $table->integer('time_learn');
            $table->integer('const_relearn_type')->default(1);
            $table->integer('const_easy_type')->default(4);
            $table->integer('const_good_type')->default(10);
            $table->integer('const_hard_type')->default(4);
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
        Schema::dropIfExists('user_learn_cards');
    }
};
