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
            $table->string('first_key');
            $table->string('second_key');
            $table->string('third_key');
            $table->string('fourth_key');
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
