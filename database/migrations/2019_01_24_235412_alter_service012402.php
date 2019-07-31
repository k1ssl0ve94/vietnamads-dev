<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterService012402 extends Migration
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
            $table->integer('display_in_trend')->default(0)->after('min_days');
            $table->integer('display_in_search')->default(0)->after('min_days');
            $table->integer('display_in_tags')->default(0)->after('min_days');
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
            $table->dropColumn('display_in_trend');
            $table->dropColumn('display_in_search');
            $table->dropColumn('display_in_tags');
        });
    }
}
