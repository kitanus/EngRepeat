<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeighKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eng_to_rus', function (Blueprint $table)
        {
            $table->foreign('dictionary_id')->references('id')->on('dictionary');
        });

        Schema::table('rus_to_eng', function (Blueprint $table)
        {
            $table->foreign('dictionary_id')->references('id')->on('dictionary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
