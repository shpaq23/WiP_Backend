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
            $table->uuid('uuid');
            $table->string('name')->nullable();
            $table->string('first_name', 40)->nullable(false);
            $table->string('last_name', 40)->nullable(false);
            $table->string('email')->unique()->nullable(false);
            $table->text('description')->nullable();
            $table->string('specialization_field_1')->nullable(false);
            $table->string('specialization_field_2')->nullable(false);
            $table->boolean('checkbox')->nullable(false);
            $table->enum('position', ['tester', 'developer', 'project_manager'])->nullable(false);
            $table->boolean('is_admin')->nullable(false)->default(false);
            $table->boolean('active')->default(false);
            $table->boolean('deleted')->default(false);
            $table->timestamp('deleted_at')->nullable(true);
            $table->timestamp('email_verified_at')->nullable(true);
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
