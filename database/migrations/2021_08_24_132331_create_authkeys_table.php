<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthkeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authkeys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_key')->nullable();
            $table->string('second_key')->nullable();
            $table->string('third_key')->nullable();
            $table->string('fourth_key')->nullable();
            $table->enum('type', ['1key', '2key' , '4key']);
            $table->unsignedBigInteger('account_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authkeys');
    }
}
