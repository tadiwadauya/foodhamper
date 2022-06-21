<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHumberSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('humber_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('food_available');
            $table->boolean('meat_available');
            $table->integer('food_record');
            $table->integer('meat_record');
            $table->string('last_agent');
            $table->softDeletes();
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
        Schema::dropIfExists('humber_settings');
    }
}
