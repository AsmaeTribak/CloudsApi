<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSSHkeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_s_hkeys', function (Blueprint $table) {
            
            $table->bigIncrements('id_sshkey');
            $table->integer('ref_sshkey');
            $table->string('private_key');
            $table->string('public_key');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_s_hkeys');
    }
}
