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
            $table->string('image',150)->nullable();
            $table->string('nik')->unique();
            $table->string('member_id')->unique();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone', 15)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('re_email')->nullable();
            $table->string('re_token')->nullable();
            $table->integer('re_expired')->nullable();
            $table->string('password')->nullable();
            $table->string('level',50);
            $table->rememberToken();
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