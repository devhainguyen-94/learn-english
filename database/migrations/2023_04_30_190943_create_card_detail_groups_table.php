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
        Schema::create('card_detail_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('card_detail_id');
            $table->unsignedInteger('group_id');
            $table->integer('time_to_complete');
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
        Schema::dropIfExists('card_detail_groups');
    }
};
