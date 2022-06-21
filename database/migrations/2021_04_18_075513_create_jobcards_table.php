<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobcardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobcards', function (Blueprint $table) {
            $table->id();
            $table->string('card_number')->unique();
            $table->date('date_opened');
            $table->string('card_month');
            $table->string('card_type');
            $table->integer('quantity');
            $table->integer('issued')->default(0);
            $table->integer('remaining')->default(0);
            $table->integer('extras_previous')->default(0);
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
        Schema::dropIfExists('jobcards');
    }
}
