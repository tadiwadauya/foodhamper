<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_collections', function (Blueprint $table) {
            $table->id();
            $table->string('paynumber');
            $table->string('jobcard');
            $table->date('issue_date');
            $table->string('allocation')->unique();
            $table->string('frequest')->unique();
            $table->string('done_by');
            $table->boolean('status');
            $table->string('collected_by')->nullable();
            $table->string('id_number')->nullable();
            $table->boolean('self')->default(1);
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
        Schema::dropIfExists('food_collections');
    }
}
