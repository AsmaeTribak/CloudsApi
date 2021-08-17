<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->timestamps();
            $table->bigIncrements('id_account');
            $table->string('name');
            $table->string('proxy')->nullable();
            $table->unsignedBigInteger('provider_id');
             $table->unsignedBigInteger('sshkey_id');
            $table->boolean('is_active')->default(true);
        });

    }
/**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
