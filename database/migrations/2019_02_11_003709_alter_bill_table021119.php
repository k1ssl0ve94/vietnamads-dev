<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBillTable021119 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('bills', function (Blueprint $table){
            $table->integer('product_id')->nullable()->change();
            $table->integer('from')->nullable()->change();
            $table->integer('to')->nullable()->change();
            $table->integer('service_id')->nullable()->change();
            $table->integer('option_id')->nullable()->change();
            $table->text('note')->nullable();
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
        Schema::table('bills', function(Blueprint $table){
           $table->dropColumn('note');
        });
    }
}
