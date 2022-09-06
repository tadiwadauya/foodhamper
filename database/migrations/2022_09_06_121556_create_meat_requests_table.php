<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeatRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meat_requests', function (Blueprint $table) {
            $table->id();
            $table->string('paynumber');
            $table->string('department');
            $table->string('name');
            $table->string('allocation')->nullable();
            $table->string('done_by');
            $table->string('status')->default('not approved');
            $table->string('reason')->nullable();
            $table->boolean('trash')->default(0);
            $table->string('jobcard')->nullable();
            $table->string('type');
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
        Schema::dropIfExists('meat_requests');
    }
}
