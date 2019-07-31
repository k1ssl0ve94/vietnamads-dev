<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('services', function (Blueprint $table){
            $table->integer('manual_refresh');
            $table->integer('auto_refresh');
        });
        Schema::table('bills', function (Blueprint $table){
            $table->integer('status');
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
        Schema::table('services', function (Blueprint $table){
            $table->dropColumn('manual_refresh');
            $table->dropColumn('auto_refresh');
        });
        Schema::table('bills', function (Blueprint $table){
            $table->dropColumn('status');
        });
    }
}
