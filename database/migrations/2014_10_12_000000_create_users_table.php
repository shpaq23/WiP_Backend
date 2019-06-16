<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('first_name', 40)->nullable(false);
            $table->string('last_name', 40)->nullable(false);
            $table->string('email')->unique()->nullable(false);
            $table->text('description')->nullable();
            $table->string('specialization_field_1')->nullable(true);
            $table->string('specialization_field_2')->nullable(true);
            $table->boolean('checkbox')->nullable(true);
            $table->enum('position', ['admin', 'tester', 'developer', 'project_manager'])->nullable(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable(false);
            $table->string('token', 32)->nullable(true);

            $table->timestamp('last_activity')->nullable();
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
