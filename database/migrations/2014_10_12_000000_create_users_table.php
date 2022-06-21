<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('paynumber')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('activated')->default(0);
            $table->string('pin')->default('1234');
            $table->integer('fcount')->default(0);
            $table->integer('mcount')->default(0);

            // foreign keys
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments');

            $table->unsignedBigInteger('usertype_id');
            $table->foreign('usertype_id')->references('id')->on('usertypes');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
