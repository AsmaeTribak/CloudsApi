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
  
            $table->bigIncrements('id_user');
            $table->integer('ref_user');
            $table->string('name');
            $table->string('email')->unique();
            $table->boolean('is_active')->default(true);
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->enum('role', ['agent', 'leader' , 'admin'])->default('agent');
            $table->timestamps();
            $table->unsignedBigInteger('entity_id');

            $table->foreign('entity_id')->references('id_entity')->on('entities');

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
