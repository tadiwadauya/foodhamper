<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeatAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meat_allocations', function (Blueprint $table) {
            $table->id();
            $table->string('meatallocation')->unique();
            $table->string('paynumber');
            $table->integer('meat_allocation');
            $table->string('meat_a');
            $table->string('meat_b');
            $table->string('status')->default("not collected");
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
        Schema::dropIfExists('meat_allocations');
    }
}
